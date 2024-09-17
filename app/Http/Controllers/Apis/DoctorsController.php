<?php

namespace App\Http\Controllers\Apis;

use App\Models\Lab;
use App\Models\Test;
use App\Models\User;
use App\Models\Action;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\LabOrder;
use App\Models\DoctorDoc;
use App\Models\PatientCase;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Helpers\DoctorLoginDetails;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rules\Password;
use App\Notifications\DoctorStatusChanged;
use Illuminate\Support\Facades\Notification;

class DoctorsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //        //=======================get auth doctor info=======================================Auth doctor

        $user_id = Auth::guard('sanctum')->user()->id;
        //dd($user_id);
        try {
            $doctor = Doctor::with('speciality:id,name', 'institution:id,name', 'governorate:id,governorate_name_ar', 'city:id,city_name_ar', 'doctorDocs:doctor_id,docs')->where('user_id', '=', $user_id)->first();

            return response()->json([
                'data' => $doctor
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        //dd($request->all());
        $request->validate([
            'name' => ['required', 'string', 'max:256'],
            'speciality_id' => ['required', 'int', 'exists:specialities,id'],
            'institution_id' => ['required', 'int', 'exists:institutions,id'],
            'governorate_id' => ['required', 'int', 'exists:governorates,id'],
            'city_id' => ['required', 'integer', 'exists:cities,id'],
            'docs' => ['required', 'array'], // Ensures docs is an array of files
            'docs.*' => [
                'file',
                'mimes:pdf,jpeg,png,jpg,gif', // Accepts PDF and image files
                'max:20480', // Maximum file size of 20MB (20 * 1024 KB)
            ],
            'doctor_notes' => ['string'],

            'phone' => ['required', 'unique:doctors,phone', 'string', 'regex:/^01[0-2,5,9]{1}[0-9]{8}$/'],
            'email' => ['required', 'unique:doctors,email', 'email:rfc,dns', 'unique:users,email'],
            'password' => [
                'required',
                'string',
                //'confirmed', // Ensures password confirmation matches
                Password::min(6) // Sets minimum length , Illuminate\Validation\Rules\Password
                    ->mixedCase() // Requires at least one uppercase and one lowercase letter
                    ->letters() // Requires at least one letter
                    ->numbers() // Requires at least one number
                    //->symbols() // Requires at least one special character
                   // ->uncompromised(), // Checks the password against the Have I Been Pwned database to avoid compromised passwords
            ],

        ]);

        //dd($request->docs);
        $data = $request->except(['docs','password']);
        $data['source']='mobile';

        //Generate Random number
        //$data['random_number'] = $this->GenerateRandomNumber();
        $data['random_number'] =$request->post('password');
        // dd($data['user_id']);
        DB::beginTransaction();
        try {
            //code if commit
            $created_doctor = Doctor::create($data);


            //upload Docs:
            $imgsData = [];
            if ($files = $request->file('docs')) {
                foreach ($files as $key => $file) {
                    $extension = $file->getClientOriginalExtension();
                    $filename = $key . '-' . time() . '.' . $extension;
                    $path = 'uploads/doctorDocs/';
                    $file->move($path, $filename);



                    $imgsData[] = [
                        'doctor_id' => $created_doctor->id,
                        'docs' => $path . $filename,

                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),

                    ];
                }
            }
            DoctorDoc::insert($imgsData);
            DB::commit();

            $created_doctor->load(['doctorDocs' => function ($query) {
                $query->select('id', 'doctor_id', 'docs'); // must pk id with fk doctor_id
            }]);

            
            // Send an email to the doctor with their login credentials
            // Mail::to($created_doctor->email)->send(new DoctorLoginDetails($created_doctor));

           
            Action::create([
                'action' => "Doctor:  $created_doctor->name add his profile",
                'type' => 'doctors',
                'action_date' => now()
            ]);

            return response()->json([
                'message' => 'new doctor profile has been added',
                'data' => $created_doctor,
                // 'docs' =>$created_doctor->doctorDocs->pluck('docs'),

            ]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()],422);
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       // dd('Update method called', $request->all());
    // Find the doctor by ID
    $doctor = Doctor::findOrFail($id);
    // dd($request->name);
     
 //dd($doctor);
     // Validate the request data
     $request->validate([
         'name' => ['sometimes', 'string', 'max:256'],
         'phone' => ['sometimes', 'string', 'regex:/^01[0-2,5,9]{1}[0-9]{8}$/'],
         'email' => ['sometimes', 'email:rfc,dns'],
         'speciality_id' => ['sometimes', 'integer', 'exists:specialities,id'],
         'institution_id' => ['sometimes', 'integer', 'exists:institutions,id'],
         'user_id' => ['sometimes', 'integer', 'exists:users,id'],
         'Approval_Status' => ['sometimes', 'string'], // adjust as per your requirements
         'source' => ['sometimes', 'string'],
         'governorate_id' => ['sometimes', 'integer', 'exists:governorates,id'],
         'city_id' => ['sometimes', 'integer', 'exists:cities,id'],
         'random_number' => ['sometimes', 'string'], // add validation as needed
         'total_points' => ['sometimes', 'integer'], // add validation as needed
         'docs.*' => [
             'sometimes',
             'file',
             'mimes:pdf,jpeg,png,jpg,gif',
             'max:20480',
         ],
         'doctor_notes' => ['sometimes', 'string'],
         'password' => [
             'sometimes',
             'string',
             Password::min(6)
                 ->mixedCase()
                 ->letters()
                 ->numbers(),
         ],
     ]);
 
     // Update the doctor model with only provided data
     $doctor->update($request->only([
         'name',
         'phone',
         'email',
         'speciality_id',
         'institution_id',
         'user_id',
         'Approval_Status',
         'source',
         'governorate_id',
         'city_id',
         'random_number',
         'total_points',
         'doctor_notes',
         'password',
     ]));
 
     // Handle file uploads
     if ($request->hasFile('docs')) {
         $imgsData = [];
         foreach ($request->file('docs') as $key => $file) {
             $extension = $file->getClientOriginalExtension();
             $filename = $key . '-' . time() . '.' . $extension;
             $path = 'uploads/doctorDocs/';
             $file->move($path, $filename);
 
             $imgsData[] = [
                 'doctor_id' => $doctor->id,
                 'docs' => $path . $filename,
                 'created_at' => Carbon::now(),
                 'updated_at' => Carbon::now(),
             ];
         }
         DoctorDoc::insert($imgsData);
     }
 
     // Save any additional changes if necessary
     $doctor->save();
 
   // Retrieve the updated doctor with related documents
    $doctor->load('doctorDocs'); // Assuming the relation is named 'documents'
 
     return response()->json([
         'message' => 'Doctor profile updated successfully',
         'data' => $doctor,
     ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    //Generate Random number
    public function GenerateRandomNumber()
    {
        do {
            $randomNumber = strtoupper(Str::random(10));
        } while (Doctor::where('random_number', $randomNumber)->exists());

        //do...while loop continues generating a new random number until it finds one that does not already exist in the Doctor table. This ensures that the generated randomNumber is unique for each Doctor record

        return $randomNumber;
    }

    //check profile status by random number   "random_number": "YOXILD8IJO",
    public function checkPofileStatusByDoctorNumber($randomNumber)
    {
        $doctor = Doctor::where('random_number', '=', $randomNumber)->first();
        if (!$doctor) {

            return response()->json(['message' => 'Profile not found.', 'Is_Approved' => 0], 200);
        }
        if ($doctor->Approval_Status == 'pending') {
            return response()->json(['message' => 'Your account has not been approved yet.', 'Is_Approved' => 0], 200);
        }

        Action::create([
            'action' => "Doctor:  $doctor->name check his profile status",
            'type' => 'doctors',
            'action_date' => now()
        ]);

        // Send notification to the doctor
        //Notification::route('mail', $doctor) //route('channel)
        //$doctor->notify(new DoctorStatusChanged($doctor));

        // Create the corresponding user record
        // $user = User::create([
        //     'name' => $doctor->name,
        //     'email' => $doctor->email,
        //     'password' => $doctor->random_number,
        //     'type' => 'doctor',
        // ]);

        // Update the doctor record with the user ID
        // $doctor->user_id = $user->id;
        // $doctor->save();


        return response()->json(['message' => 'Profile approved.', 'Is_Approved' => 1, 'Doctor_details' => $doctor], 200);
    }



    //Get Data by type
    public function getDataByType(Request $request)
    {
        $type = $request->query('type');
        $search = $request->query('search', '');


        $user = Auth::guard('sanctum')->user();
        $doctor_id = $user->doctor->id;
        //Patient: firstname , PatientCase:phone,firstname,Test:name,LabOrder:phone,firstname,Lab:name
        switch ($type) {
            case 0:
                $data = Patient::where('doctor_id', $doctor_id)->where('firstname', 'like', "%$search%")->get();
                $message = 'Patients retrieved successfully!';
                break;

            case 1:
                         $data =PatientCase::with(['patient', 'diagnose', 'labOrders'])
            ->where('patient_cases.doctor_id','=', $doctor_id)
            ->whereHas('patient', function ($query) use ($search) {
                    $query->where('phone', 'like', "%$search%")
                          ->orWhere('firstname', 'like', "%$search%");
                })
            ->get()
            
            ->map(function($patientCase){
                return[
                    //'patient_id' => $patientCase->patient_id,diagnose
                            'case_name' => $patientCase->patient->firstname,
                            'visitCase_id' => $patientCase->id,
                            'visit_diagnose_id'=>$patientCase->diagnose->id,
                            'visit_diagnose'=>$patientCase->diagnose->name,
                            'visit_case_date' => $patientCase->created_at,
                            'visit_comment' => $patientCase->comment,
                            'lab_orders'=>$patientCase->labOrders->map(function($labOrder){
                                return[
                                    'patient_case_id' => $labOrder->patient_case_id,
                    'test_name' => $labOrder->test->name,
                    'test_id' => $labOrder->test_id,
                    'lab_branch_name'=>$labOrder->lab_branch_name,
                    'lab_branch_id'=>$labOrder->lab_branch_id
                                ];
                            })
                        ];
            });
            
                // $data = PatientCase::with('patient')
                // ->whereHas('patient', function ($query) use ($search) {
                //     $query->where('phone', 'like', "%$search%")
                //           ->orWhere('firstname', 'like', "%$search%");
                // })->where('doctor_id', $doctor_id)
                // ->get();
                $message = 'Cases retrieved successfully!';
                break;

            case 2:
                $data = Test::where('name', 'like', "%$search%")->get();
                $message = 'Tests retrieved successfully!';
                break;

            case 3:
                 $data = LabOrder::where('doctor_id',$doctor_id)->with(['patient', 'doctor', 'patient_case', 'labBranch','test','lab','labTest','labTrack'])
                 ->whereHas('patient', function ($query) use ($search) {
                    $query->where('phone', 'like', "%$search%")
                          ->orWhere('firstname', 'like', "%$search%");
                })
            ->get()

            //dd($labsorders);

            ->map(function ($order) {
                return [
                    'lab_order_id'=>$order->id,
                    'patient_id' => $order->patient ? $order->patient->id : '',
                    'patient_name' => $order->patient ? $order->patient->firstname : '',
                    'doctor_id' => $order->doctor ? $order->doctor->id : '',
                    'doctor_name' => $order->doctor ? $order->doctor->name : '',
                    'patient_case_id' => $order->patient_case ? $order->patient_case->id : '',
                    'lab_branch_id' => $order->labBranch ? $order->labBranch->id : '',
                    'lab_branch_name' => $order->labBranch ? $order->labBranch->name : '',
                    'test_id' => $order->test ? $order->test->id : '',
                    'test_name' => $order->test ? $order->test->name : '',

                    'lab-id'=>$order->lab ? $order->lab->id : '',
                    'lab-name'=>$order->lab ? $order->lab->name :'',

                    'price'=>$order->labTest?$order->labTest->price:'',
                    'expected_delivery_date'=>$order->labTrack? $order->labTrack->expected_delivery_date:'',
                    'status' => $order->labTrack ? ($order->labTrack->status === 'delivered' ? 1 : 0) : 0,
                    'delivered_at'=>$order->labTrack? $order->labTrack->delivered_at:'',
                    'result'=>$order->labTrack? $order->labTrack->result:'',
                    'notes'=>$order->labTrack? $order->labTrack->notes:''
                ];
            });

                // $data = LabOrder::where('doctor_id', $doctor_id)->with('patient')
                // ->whereHas('patient', function ($query) use ($search) {
                //     $query->where('phone', 'like', "%$search%")
                //           ->orWhere('firstname', 'like', "%$search%");
                // })->get();
                $message = 'Lab orders retrieved successfully!';
                break;

            case 4:
                $data = Lab::where('name', 'like', "%$search%")->get();
                $message = 'Labs retrieved successfully!';
                break;

                default:
                $data = Patient::where('doctor_id', $doctor_id)->get(); // Default to patients if no type or invalid type
                $message = 'Patients retrieved successfully (default).';
                break;
        }

        return response()->json([
            'message' => $message,
            'data' => $data
        ], 200);
    }

}
