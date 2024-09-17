<?php

namespace App\Http\Controllers\Apis;

use App\Models\Courier;
use App\Models\LabOrder;
use Illuminate\Http\Request;
use App\Models\Lab_Branch_Test;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LabOrdersController extends Controller
{
    //======Auth doctor


    //track_lab_tests:patient_id  doctor_id test_id  lab_branche_id  expected_delivery_date  status01 delivered_at  	result  notes

    //lab_orders : patient_id   patient_case_id  doctor_id  test_id  lab_branche_id
    public function index()
    {
        $user = Auth::guard('sanctum')->user();
        $doctor_id = $user->doctor->id;

        if (!$user || !$user->doctor) {
            return response()->json(['message' => 'Doctor not found'], 200);
        }

        $labsorders = LabOrder::where('doctor_id',$doctor_id)->with(['patient', 'doctor', 'patient_case', 'labBranch','test','lab','labTest','labTrack'])
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

            return response()->json([
                'message' => 'Lab_orders Done By Doctor...!',
                'data'=> $labsorders
            ],200);
    }

    public function store(Request $request)
    {
        // 'patient_id', 'doctor_id', 'test_id', 'lab_branche_id','patient_case_id'
        $user = Auth::guard('sanctum')->user();
        $doctor_id = $user->doctor->id;

        $request->validate([

            'patient_id' => 'required|integer|exists:patients,id',
            'test_id' => 'required|integer|exists:tests,id',
            'lab_branche_id' => 'required|integer|exists:lab_branches,id',
            'lab_id' => 'required|integer|exists:labs,id',
        ]);
        $data = $request->except(['doctor_id']);
        $data['doctor_id'] = $doctor_id;

        $labOrder = LabOrder::create($data);

        return response()->json([
            'message' => 'new Lab Order has been added..',
            'data' => $labOrder,
        ]);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    //Couriers=======================================================
    public function checkCourierStatus(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'test_id' => 'required|integer',
            'lab_id'  => 'required|integer',
        ]);

        // Get the test_id and lab_id from the request
        $testId = $request->input('test_id');
        $labId = $request->input('lab_id');

       // Fetch the lab test based on test_id and lab_id
       $labTest = Lab_Branch_Test::where('test_id', $testId)
       ->where('lab_id', $labId)
       ->first();

      
        // If lab_test not found, return a 404 response
        if (!$labTest) {
            return response()->json(['error' => 'Lab test not found'], 404);
        }

        /// Check if the lab test has a courier assigned
        $hasCourier = $labTest->has_courier;

        // Return the result
        return response()->json([
            'message'=>'data return successfully..',
            'lab_test_id'  => $labTest->test_id,
            'lab_id'       => $labId,
            'has_courier'  => $hasCourier ? true : false,
            'courier_id'   => $hasCourier ? $labTest->courier_id : null,
        ],200);
    }

    public function getCouriersWithAreas()
    {
        // Retrieve all couriers with their related areas
        $couriers = Courier::with('areas')->get();

        // Return the result as a JSON response
        return response()->json([
            'message'=>'couriers returned successfully..!',
            'data'=>$couriers
        ],200);
    }

    public function getCourierWithAreas($id)
{
    // Find the courier with their areas
    $courier = Courier::with('areas')->find($id);

      // If lab_test not found, return a 404 response
      if (!$courier) {
        return response()->json(['error' => 'courier not found'], 404);
    }
    // Return the result as JSON
    return response()->json([
        'message'=>'courier returned successfully..!',
        'data'=>$courier
    ],200);
}
}
