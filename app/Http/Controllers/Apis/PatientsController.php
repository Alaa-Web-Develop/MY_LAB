<?php

namespace App\Http\Controllers\Apis;


use App\Models\Lab;
use App\Models\Test;
use App\Models\Action;
use App\Models\Doctor;
use App\Models\Courier;
use App\Models\Patient;
use Twilio\Rest\Client;
use App\Models\LabOrder;
use App\Models\LabBranch;
use App\Services\SMSService;
use Illuminate\Http\Request;
use App\Http\Helpers\ApiTrait;
use Illuminate\Support\Carbon;
use App\Models\Lab_Branch_Test;
use App\Models\PointTransaction;
use App\Http\Controllers\Controller;
use App\Models\CourierCollectedTest;
use App\Models\LabOrderTestQuestion;
use App\Models\SponsoredTestRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use App\Notifications\SendSmsNotification;
use Illuminate\Support\Facades\Notification;
use App\Http\Helpers\convertToInternationalFormat;

class PatientsController extends Controller
{
    use ApiTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::guard('sanctum')->user(); // Get authenticated user
        $doctor = $user->doctor; // Get the related doctor

        // Apply filters from request
        $filters = $request->query();

        // Fetch patients and their cases with lab orders
        $patients = Patient::where('doctor_id', $doctor->id)
            ->filter($filters) // Apply the filter scope
            ->with(['cases' => function ($caseQuery) {
                $caseQuery->select('id', 'patient_id', 'diagnose_id', 'created_at', 'updated_at')
                    ->with(['diagnose' => function ($diagnoseQuery) {
                        $diagnoseQuery->select('id', 'name'); // Retrieve the diagnose name
                    }, 'labOrders' => function ($orderQuery) {
                        $orderQuery->select('id', 'patient_case_id', 'lab_id', 'test_id', 'lab_branche_id', 'created_at', 'updated_at', 'discount_points')
                            ->with(['lab' => function ($labQuery) {
                                $labQuery->select('id', 'name');
                            }, 'test' => function ($testQuery) {
                                $testQuery->select('id', 'name');
                            }, 'labBranch' => function ($branchQuery) {
                                $branchQuery->select('id', 'name');
                            }]);
                    }]);
            }])
            ->select('id', 'firstname', 'lastname', 'doctor_id', 'pathology_report_image', 'diagnose_id', 'phone', 'email', 'age', 'created_at', 'updated_at')
            ->with('diagnose:id,name')
            ->get();

        // Format the response
        $response = $patients->map(function ($patient) {
            return [
                'id' => $patient->id,
                'firstname' => $patient->firstname,
                'lastname' => $patient->lastname,
                'doctor_id' => $patient->doctor_id,
                'pathology_report_image' => $patient->pathology_report_image,
                'diagnose_id' => $patient->diagnose_id,
                'diagnose_name' => optional($patient->diagnose)->name, // Tumor name if exists
                'phone' => $patient->phone,
                'email' => $patient->email,
                'age' => $patient->age,
                'created_at' => $patient->created_at,
                'updated_at' => $patient->updated_at,
                'full_name' => "{$patient->firstname} {$patient->lastname}", // Full name as concatenation
                'cases' => $patient->cases->map(function ($case) {
                    return [
                        'case_id' => $case->id,
                        'diagnose' => optional($case->diagnose)->name, // Retrieve diagnose name
                        'lab_orders' => $case->labOrders->map(function ($order) {
                            return [
                                'date' => $order->created_at->format('Y-m-d'), // Format date
                                'test_type' => $order->test->name, // Assuming test name as test type
                                'test_name' => $order->test->name,
                                'lab' => $order->lab->name,
                                'lab_branch' => $order->labBranch->name,
                                'comments' => $order->comments ?? 'raw json' // Replace with actual comments field if exists
                            ];
                        })
                    ];
                })
            ];
        });

        return response()->json([
            'message' => 'Doctor with his cases and lab orders returned successfully!',
            'data' => [
                'doctor_name' => $doctor->name, // Doctor's name
                'patients' => $response // All patient data with cases and lab orders
            ]
        ]);
    }

    /**
     * add new patient with new case with his labOrders
     */
    public function store(Request $request, SMSService $smsService)
    {

        //======Auth doctor
        $user = Auth::guard('sanctum')->user();
        $doctor_id = $user->doctor->id;
        $doctor = Doctor::where('id', $doctor_id)->first();

        //validation:
        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            // 'doctor_id' => 'required|integer|exists:doctors,id',
            'pathology_report_image' => 'nullable|file',
            'phone' => ['required', 'string', 'regex:/^(\+201[0-9]{9})|(01[0-2,5,9]{1}[0-9]{8})$/', "unique:patients,phone"],
            'email' => ['required', 'email:rfc,dns', "unique:patients,email"],
            'age' => 'required|numeric',
            'comment' => 'nullable|string',
            'diagnose_id' => 'nullable|integer|exists:diagnoses,id',

            //case with lab_order
            //'patient_id' => 'required|integer|exists:patients,id',
            // 'doctor_id' => 'required|integer|exists:doctors,id',
            //'diagnose_id' => 'nullable|integer|exists:diagnoses,id',

            //lab_order lab_orders[0][lab_id] |lab_orders[1][test_id]|lab_orders[1][lab_branche_id ]
            'lab_orders' => 'nullable|array',
            'lab_orders.*.test_id' => 'nullable|integer|exists:tests,id',
            'lab_orders.*.lab_id' => 'nullable|integer|exists:labs,id',
            'lab_orders.*.lab_branche_id' => 'nullable|integer|exists:lab_branches,id',
            'lab_orders.*.discount_points' => 'nullable|integer|min:0',

            //has_courier
            'lab_orders.*.has_courier' => 'nullable|boolean',
            // 'lab_orders.*.courier_id' => 'nullable|int|exists:couriers,id',
            // Sponsored checkbox
            'lab_orders.*.sponsored' => 'nullable|boolean',
            'lab_orders.*.sponser_id' => 'nullable|int|exists:sponsers,id',

            'lab_orders.*.questions' => 'nullable|array',
            'lab_orders.*.questions.*.question' => 'required|string',  // The actual question text
            'lab_orders.*.questions.*.answer' => 'required|string',

        ]);

        //$redeemPoints = $request->post('discount_points');

        //dd($request()->get('test_id'));
        //dd($request->all());

        try {
            //$data = $request->except(['pathology_report_image', 'doctor_id']);
            if ($request->has('pathology_report_image')) {
                $file = $request->file('pathology_report_image');
                $ext = $file->getClientOriginalExtension();
                $file_name = time() . '.' . $ext;
                $path = 'uploads/patient_Pathology_report/';
                $file->move($path, $file_name);  // Move the file to the target directory
                $validatedData['pathology_report_image'] = $path . $file_name;
            }

            $validatedData['doctor_id'] = $doctor_id;
            //dd( $data['doctor_id']);
            //dd($data);

            $phone = convertToInternationalFormat::ConvertToInternationalFormat($request->phone);

            //Generate a tracking number and store it in patients table
            $trackingNum = strtoupper(uniqid('TRK-')); //Make a string uppercase,uniqid Generate a unique ID
            $created_patint = Patient::create([
                'firstname' =>  $validatedData['firstname'],
                'lastname' => $validatedData['lastname'],
                'doctor_id' => $doctor_id,
                'pathology_report_image' => $validatedData['pathology_report_image'],
                'phone' =>  $phone,
                'email' => $validatedData['email'],
                'age' => $validatedData['age'],
                'diagnose_id' => $validatedData['diagnose_id'],
                'tracking_number' => $trackingNum,
            ]);


            Action::create([
                'action' => "Doctor:  $doctor->name - add patient:  $created_patint->full_name , phone: $created_patint->phone ",
                'type' => 'patients',
                'action_date' => now()
            ]);

            // dd($created_patint);

            // Create the case related to the patient
            $case = $created_patint->cases()->create([
                'patient_id' => $created_patint->id,
                'doctor_id' =>  $doctor_id,
                // 'diagnose_id' => $validatedData['diagnose_id'],
                'comment' => $validatedData['comment'],
            ]);

            //dd($case);

            Action::create([
                'action' => "Doctor:  $doctor->name - add case:  $created_patint->full_name , phone: $created_patint->phone ",
                'type' => 'patients',
                'action_date' => now()
            ]);


            // Add the lab orders for the case
            $totalDiscountPoints = 0;
            $labOrders = [];
            $labOrderDetails = []; //for sms content
            if ($request->has('lab_orders') && !empty($request->lab_orders)) {

                foreach ($validatedData['lab_orders'] as $labOrder) {
                    $newLabOrder = $case->labOrders()->create([
                        'patient_id' => $created_patint->id,
                        'patient_case_id' => $case->id,
                        'doctor_id' => $doctor_id,
                        'lab_id' => $labOrder['lab_id'],
                        'test_id' => $labOrder['test_id'],
                        'lab_branche_id' => $labOrder['lab_branche_id'],
                        'discount_points' => $labOrder['discount_points'] ?? 0, // Use null coalescing operator
                        'has_courier' => $labOrder['has_courier'] ?? false,
                        'courier_id' => $labOrder['courier_id'] ?? null,
                    ]);

                    $labOrders[] = $newLabOrder;

                    // Add courier logic
                    if (isset($labOrder['has_courier']) && $labOrder['has_courier']) {

                        // Create courier_collected_tests entry
                        CourierCollectedTest::create([
                            // 'courier_id' => $courier->id,
                            'lab_order_id' => $newLabOrder->id,
                            'status' => 'new',
                            'collected_at' => null,  // To be updated when courier collects
                        ]);
                    }


                    Action::create([
                        'action' => "Doctor:  $doctor->name - add anew lab_order",
                        'type' => 'lab_orders',
                        'action_date' => now()
                    ]);

                    //add assigned lab_order_Points_to_doctorPints
                    //update doctor_total points
                    $lab_test = Lab_Branch_Test::where('test_id', '=', $labOrder['test_id'])->where('lab_id', '=', $labOrder['lab_id'])->first();

                    if ($lab_test) {
                        $points = $lab_test->points;
                        $doctor = Doctor::where('id', $doctor_id)->first();
                        $doctor->total_points += $points;
                        $doctor->save();

                        Action::create([
                            'action' => "Doctor:  $doctor->name - Earned :$points points",
                            'type' => 'points',
                            'action_date' => now()
                        ]);
                    }


                    //update points_transaction
                    // Add entry to PointsTransaction table
                    PointTransaction::create([
                        'doctor_id' => $doctor->id,
                        'points' => $points,
                        'type' => 'earned',
                    ]);

                    $discounts = $labOrder['discount_points'];
                    if (isset($labOrder['discount_points']) && $doctor->total_points >= $labOrder['discount_points'] && $labOrder['discount_points'] > 0) {
                        $doctor->total_points -= $labOrder['discount_points'];
                        $doctor->save();

                        $p_trans = PointTransaction::create([
                            'doctor_id' => $doctor->id,
                            'patient_id' => $created_patint->id,
                            'points' => $labOrder['discount_points'],
                            'type' => 'redeemed',
                        ]);

                        $totalDiscountPoints += $labOrder['discount_points'];

                        Action::create([
                            'action' => "Doctor:  $doctor->name - Grant :$discounts points",
                            'type' => 'points',
                            'action_date' => now()
                        ]);
                    }

                    //Handle sponsored lab orders
                    if (isset($labOrder['sponsored']) && $labOrder['sponsored']) {
                        // Log the sponsorship request to a separate table
                        SponsoredTestRequest::create([
                            'doctor_id' => $doctor_id,
                            'patient_id' => $created_patint->id,
                            'lab_order_id' => $newLabOrder->id,
                            'sponser_id' => $labOrder['sponser_id'],
                            'status' => 'pending', // Admin approval pending
                        ]);
                    }

                    // Store the questions and answers related to the lab order
                    if (isset($labOrder['questions']) && !empty($labOrder['questions'])) {
                        foreach ($labOrder['questions'] as $question) {
                            LabOrderTestQuestion::create([
                                'lab_order_id' => $newLabOrder->id,
                                'question' => $question['question'],   // Save the question text
                                'answer' => $question['answer'],       // Save the answer text
                            ]);
                        }
                    }


                    //i am still in loop to collect $labOrderDetails for sms content
                    $test = Test::find($labOrder['test_id']);
                    $lab = Lab::find($labOrder['lab_id']);
                    $branch = LabBranch::find($labOrder['lab_branche_id']);
                    //collect in $labOrderDetails
                    $labOrderDetails[] = [
                        'test_name' => $test->name,
                        'lab_name' => $lab->name,
                        'branch_name' => $branch->name,
                        'branch_phone' => $branch->phone,
                        'branch_address' => $branch->address
                    ];
                } //foreach
            }

            //prepare for send twilio sms
            $trackingLink = url('/patient-order' . '?tracking=' . $trackingNum);
            $patinetName = $created_patint->firstname . ' ' . $created_patint->lastname;
            //sms content by loop orderDetails
            $messageContent = "مرحبا أستاذ $patinetName,لقد تم طلب التحاليل الآتية :";
            foreach ($labOrderDetails as $details) {
                $messageContent .= "\n-تحليل:" . $details['test_name'] . "  : من معمل" . $details['lab_name'] . " : فرع " .
                    $details['branch_name'] . "  ،هاتف " . $details['branch_phone'] . " ، العنوان: " . $details['branch_address'] . ".";
            }
            $messageContent .= "\n لمتابعة حالة التحاليل استخدم الرقم $trackingNum";
            $messageContent .= "\n عبر الرابط: $trackingLink";

            $smsService->sendSMS($created_patint->phone,$messageContent);
           // Notification::send($created_patint, new SendSmsNotification($messageContent, $created_patint->phone));
           //$this->sendSms($messageContent,$created_patint->phone);

            $token = $request->bearerToken();
            $doctor = Doctor::where('id', $doctor_id)->first();
            $DRPoints = $doctor->total_points;


            //to return in response
            $mappedOrders = collect($labOrders)->map(function ($order) {
                // Fetch the questions related to the lab order
                $questions = LabOrderTestQuestion::where('lab_order_id', $order->id)->get();

                return [
                    "patient_id" => $order['patient_id'],
                    "patient_case_id" => $order['patient_case_id'],
                    "doctor_id" => $order['doctor_id'],
                    'lab_id' => $order['lab_id'],
                    'test_id' => $order['test_id'],
                    "lab_branche_id" => $order['lab_branche_id'],
                    "discount_points" => $order['discount_points'],
                    "has_courier" => $order['has_courier'],
                    "courier_id" => $order['courier_id'],
                    "updated_at" => $order['updated_at'],
                    "created_at" => $order['created_at'],
                    'id' => $order['id'],
                    //add questions
                    'questions' => $questions
                ];
            });

            // Return a response
            return response()->json([
                'message' => 'Patient, case, and lab orders created successfully',
                'patient' => $created_patint,
                'case' => $case,
                'lab_orders' => $mappedOrders,


                'token' => $token,
                'doctor_available_points' => $DRPoints,
                'total_discount_points' => $totalDiscountPoints,

            ], 201);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //===========Auth doctor
        //validation:
        $request->validate([
            'firstname' => 'sometimes|required|string|max:255',
            'lastname' => 'sometimes|required|string|max:255',
            'doctor_id' => 'sometimes|required|integer|exists:doctors,id',
            'pathology_report_image' => 'nullable|file',
            'phone' => "sometimes|required|string|regex:/^01[0-2,5,9]{1}[0-9]{8}$/|unique:patients,phone",
            'email' => "sometimes|required|email:rfc,dns|unique:patients,email",
            'age' => 'sometimes|required|numeric',
            'comment' => 'nullable|string',
            'diagnose_id' => 'sometimes|required|integer|exists:diagnoses,id',

            'test_id' => 'sometimes|required|array|exists:tests,id',
            'lab_branche_id' => 'sometimes|required|integer|exists:lab_branches,id',
        ]);

        $patient = Patient::findOrFail($id);

        $data = $request->except(['pathology_report_image']);
        if ($request->has('pathology_report_image')) {

            if (File::exists($patient->pathology_report_image)) {
                File::delete($patient->pathology_report_image);
            }
            //upload new pathology report
            $file = $request->file('pathology_report_image');

            $ext = $file->getClientOriginalExtension();
            $file_name = time() . '.' . $ext;
            $path = 'uploads/patient_Pathology_report/';
            $file->move($path, $file_name);
            $data['pathology_report_image'] = $path . $file_name;
        }

        $patient->update($request->all());

        //update lab_order
        $labOrders = LabOrder::where('patient_id', $id)->get();
        if ($request->post('test_id')) {
            foreach ($labOrders as $laborder) {
                foreach ($request->post('test_id') as $test) {
                    if ($laborder->test_id != $test) {
                        $laborder->update([
                            'patient_id' => $id,
                            'doctor_id' => $request->post('doctor_id'),
                            'test_id' => $test,
                            'lab_branche_id' => $request->post('lab_branche_id')
                        ]);
                    }
                }
            }
        }

        return $this->Data(compact('patient'), "patient with id : $patient->id has been edited.. ");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    //Get discount test value by lab_id && test_id
    public function getDiscountValueByLabidTestid(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        $doctor_id = $user->doctor->id;
        $doctor = Doctor::where('id', $doctor_id)->first();
        $doc_points = $doctor->total_points;

        $request->validate([
            'test_id' => 'required|int|exists:tests,id',
            'lab_id' => 'required|int|exists:labs,id',
        ]);

        try {
            // Find the Lab_Branch_Test record
            $labBranchTest = Lab_Branch_Test::where('test_id', $request->post('test_id'))
                ->where('lab_id', $request->post('lab_id'))
                ->first();

            // Check if the record exists
            if (!$labBranchTest) {
                return response()->json([
                    'message' => 'No discount for this test..!!',
                    'doctor_points' => (int)$doc_points,
                ], 200);
            }

            // Get the discount value
            $discountValue = $labBranchTest->discount_points;

            if ($discountValue == 0) {
                return response()->json([
                    'message' => 'No discount for this test..!!',
                    'doctor_points' => (int)$doc_points,
                ], 200);
            }

            return response()->json([
                'message' => 'Done..!',
                '1% test discount equal to ' => (int)$discountValue,
                'doctor_points' => (int)$doc_points,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'An error occurred while retrieving the discount value.',
                'doctor_points' => (int)$doc_points,
            ], 500);
        }
    }


    public function sendSms($message,$phone_number)
    {
        $sid = getenv('TWILIO_ACCOUNT_SID');
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio = new Client($sid, $token);

        $message = $twilio->messages->create(
            $phone_number, // To
            [
                "body" =>$message,
               
                "from" => getenv('TWILIO_FROM'),
            ]
        );
    }
}
