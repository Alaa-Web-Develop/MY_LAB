<?php

namespace App\Http\Controllers\Apis;

use App\Models\Action;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\LabOrder;
use ReturnTypeWillChange;
use App\Models\PatientCase;
use Illuminate\Http\Request;
use App\Http\Helpers\ApiTrait;
use Illuminate\Support\Carbon;
use App\Models\Lab_Branch_Test;

use App\Models\PointTransaction;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use function Laravel\Prompts\select;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;
use App\Http\Resources\PatientCaseResource;
use Illuminate\Support\Facades\DB as FacadesDB;

class PatientCasesController extends Controller
{


    use ApiTrait;

//'patient_id','doctor_id', 'pathology_report_image', 'diagnose_id', 'comment'

    //Get all cases belongs to authenticated doctor
    public function index(Request $request)
    {
        $user=Auth::guard('sanctum')->user();
        $doctor_id=$user->doctor->id;

         try {
            $visits =PatientCase::join('patients', 'patient_cases.patient_id', '=', 'patients.id')
            ->join('lab_orders', 'patient_cases.id', '=', 'lab_orders.patient_case_id')
            ->join('tests', 'lab_orders.test_id', '=', 'tests.id')
            ->where('patient_cases.doctor_id','=', $doctor_id)
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
//dd( $visits);
            // $sql = $visits->toSql();
            // dd($sql);

            return response()->json([
                'message' =>'cases with orders..done!',
                'data' => $visits
            ],200);
         //return PatientCaseResource::collection($visits);
        } catch (\Throwable $th) {
            return $this->errorResonse($th->getMessage());
        }  
    }


    //Get_cases_belongsTo_specific_Patient
    public function show(Request $request,$id)
    {
        $user=Auth::guard('sanctum')->user();
        $doctor_id=$user->doctor->id;

         try {
            $visits =PatientCase::join('patients', 'patient_cases.patient_id', '=', 'patients.id')
            ->join('lab_orders', 'patient_cases.id', '=', 'lab_orders.patient_case_id')
            ->join('tests', 'lab_orders.test_id', '=', 'tests.id')
            ->where('patient_cases.doctor_id','=', $doctor_id)
            ->where('patient_cases.patient_id','=', $id)

            ->get()
//             test_name
// lab_branch_name
            ->map(function($patientCase){
                return[
                    //'patient_id' => $patientCase->patient_id,
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
                    'lab_branch_id'=>$labOrder->lab_branch_id,
                    'lab_id'=>$labOrder->lab_id,
                   

                                ];
                            })
                        ];
            });

            return response()->json([
                'message' =>'patient cases with orders..done!',
                'data' => $visits
            ],200);
        
        } catch (\Throwable $th) {
            return $this->errorResonse($th->getMessage());
        }  

        
    }

//Add new case
    public function store(Request $request)
    {
        
        //====Auth doctor
        $user=Auth::guard('sanctum')->user();
        $doctor_id=$user->doctor->id;
        $doctor = Doctor::where('id', $doctor_id)->first();

        //validation:
        $request->validate([
            'patient_id' => 'required|integer|exists:patients,id',
            // 'doctor_id' => 'required|integer|exists:doctors,id',
            'pathology_report_image' => 'nullable|file',
            'comment' => 'nullable|string',
            'diagnose_id' => 'nullable|integer|exists:diagnoses,id',


          
            //Lab orders validation 
            'lab_orders' => 'nullable|array',
            'lab_orders.*.test_id' =>'nullable|integer|exists:tests,id',
            'lab_orders.*.lab_branche_id'=>'nullable|integer|exists:lab_branches,id',
            'lab_orders.*.lab_id'=>'nullable|integer|exists:labs,id',

            //discounts points
            'lab_orders.*.discount_points' => 'nullable|integer|min:0',

            //will receive it as json:
            // "lab_orders":[
            //     {
            //         "test_id":1,
            //         "lab_branch_id":1
            //     },
            //     {
            //         "test_id":3,
            //         "lab_branch_id":1
            //     },
            //     {
            //         "test_id":3,
            //         "lab_branch_id":1
            //     }
            // ]
    
        ]);

        $redeemPoints = $request->post('discount_points');


//dd($request->all());

    $data = $request->except(['pathology_report_image','doctor_id','lab_orders']);
    if ($request->has('pathology_report_image')) {
        $file = $request->file('pathology_report_image');
        $ext = $file->getClientOriginalExtension();
        $file_name = time() . '.' . $ext;
        $path = 'uploads/patient_Pathology_report/';
        $file->move($path, $file_name);
        $data['pathology_report_image'] = $path . $file_name;
    }

    $data['doctor_id']=$doctor_id;

    

        // Begin a database transaction to ensure atomicity
        //DB::beginTransaction();

        try {
            // Create a new patient
            $created_case = PatientCase::create($data);
        
            $labOrders=$request->input('lab_orders', []); // [] input second param is default

            //dd($labOrders);

            $labOrdersArr = [];
            $totalDiscountPoints = 0;


             foreach ($labOrders as $order) {
               
                $labOrdersArr[] = [
                    'patient_id' => $created_case->patient_id,
                    'doctor_id' => $doctor_id,
                    'test_id' =>$order['test_id'],
                   'patient_case_id'=>$created_case->id,
                    'lab_branche_id' => $order['lab_branche_id'],
                    'lab_id' => $order['lab_id'],

                    'discount_points' =>$order['discount_points']?? 0, // Use null coalescing operator

                    //dd($order['lab_branche_id']),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];

                $lab_test = Lab_Branch_Test::where('test_id', '=',  $order['test_id'])->where('lab_id', '=', $order['lab_id'])->first();
                $points = $lab_test->points;
                $doctor = Doctor::where('id', $doctor_id)->first();
                $doctor->total_points += $points;
                $doctor->save();
                //update points_transaction
                // Add entry to PointsTransaction table
                PointTransaction::create([
                    'doctor_id' => $doctor->id,
                    'points' => $points,
                    'type' => 'earned',
                ]);

                Action::create([
                    'action' => "Doctor:  $doctor->name - add anew lab_order",
                    'type' => 'lab_orders',
                    'action_date' => now()
                ]);
                
                Action::create([
                    'action' => "Doctor:  $doctor->name - Earned :$points points",
                    'type' => 'points',
                    'action_date' => now()
                ]);

                $discounts=$order['discount_points'];

                if (isset($order['discount_points']) && $doctor->total_points >= $order['discount_points'] && $order['discount_points']>0 ) {
                    $doctor->total_points -= $order['discount_points'];
                    $doctor->save();

                    $p_trans = PointTransaction::create([
                        'doctor_id' => $doctor->id,
                        'patient_id' => $created_case->patient_id,
                        'points' => $order['discount_points'],
                        'type' => 'redeemed',
                    ]);

                    $totalDiscountPoints += $order['discount_points'];

                    Action::create([
                        'action' => "Doctor:  $doctor->name - Grant :$discounts points",
                        'type' => 'points',
                        'action_date' => now()
                    ]);

                }






                 } //foreach
            //  }
             LabOrder::insert($labOrdersArr);


           
$DRPoints=$doctor->total_points;


             $token=$request->bearerToken(); // Get the bearer token from the request headers


            return response()->json([
                'message' => 'created case done successfully',
                'data' => $created_case,
                'lab_orders' =>$labOrdersArr,
                'token' =>$token,
                'doctor_available_points'=>(int) $DRPoints,
                'total_discount_points' => $totalDiscountPoints,

            ],200);

        } catch (\Exception $e) {
    
            return response()->json(['error' => 'Something went wrong'], 500);
        }

   
    }
}
