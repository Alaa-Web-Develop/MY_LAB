<?php

namespace App\Http\Controllers\Apis;

use App\Models\LabOrder;
use App\Models\TrackLabTest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LabOrdersTrackingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $doctor = $user->doctor;
        // Retrieve the lab order with related models
        try {
            $labOrders  = LabOrder::where('doctor_id', $doctor->id)->with([
                'patient',
                'doctor',
                'labTrack',
                'labTest',
                'labBranch',
                'courierCollectedTest.courier',
                'test'
            ])->get();

            // Check if there are no lab orders
            if ($labOrders->isEmpty()) {
                return response()->json([
                    'message' => 'No lab orders found.'
                ], 404);
            }
            // Format the necessary data to return for each lab order
            $labOrderData = $labOrders->map(function ($labOrder) {
                //dd($labOrder);
                return [
                   'Lab Order Number' => $labOrder->id,
                'Prescription Date' => $labOrder->created_at->format('Y-m-d'),
                'Patient Name' => $labOrder->patient->firstname ?? '',
                'Doctor Name' => $labOrder->doctor->name ?? '',
                'Lab Received Date' => $labOrder->labTrack ? ($labOrder->labTrack->lab_received_at ? $labOrder->labTrack->lab_received_at->format('Y-m-d') : '') : '',
                'Test Name' => $labOrder->test->name ?? '',
                'Branch Name' => $labOrder->labBranch->name ?? '',
                'Branch Address' => $labOrder->labBranch->address ?? '',
                'Branch Number' => $labOrder->labBranch->phone ?? '',
                'Collected Date' => $labOrder->courierCollectedTest ? ($labOrder->courierCollectedTest->collected_at ? $labOrder->courierCollectedTest->collected_at->format('Y-m-d') : '') : '',
                'Courier Name' => $labOrder->courierCollectedTest ? ($labOrder->courierCollectedTest->courier->name ?? '') : '',
                'Result Released Date' => $labOrder->labTrack ? ($labOrder->labTrack->result_released_at ? $labOrder->labTrack->result_released_at->format('Y-m-d') : '') : '',
                'Result' => $labOrder->labTrack->result ?? '',
                'Status' => $labOrder->status ?? '',
                    //'Actions' => '<Action buttons/links as required>'  // Adjust as per your front-end requirements
                ];

                //dd($labOrderData);
            });

            // Return the response with all lab orders
            return response()->json([
                'message' => 'orders returned successfully..',
                'data' => $labOrderData
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'An error occurred while retrieving lab orders.',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $user = Auth::user();
        $doctor = $user->doctor;

        $labOrderId = $request->query('id');

        if (!$labOrderId || !is_numeric($labOrderId)) {
            return response()->json([
                'message' => 'Invalid or missing lab order ID.'
            ], 400);
        }
        // Retrieve the lab order with related models
        try {
            $labOrder = LabOrder::where('doctor_id', $doctor->id)->with([
                'patient',
                'doctor',
                'labTrack',
                'labTest',
                'labBranch',
                'courierCollectedTest.courier',
                'test'
            ])->findOrFail($labOrderId);

            // Check if there are no lab orders
            // if ($labOrder->isEmpty()) {
            //     return response()->json([
            //         'message' => 'No lab orders found.'
            //     ], 404);
            // }
            // Format the necessary data to return for each lab order
           // $labOrderData = $labOrders->map(function ($labOrder) {
                //dd($labOrder);

                // $labOrderData=
                //  [
                //    'Lab Order Number' => $labOrder->id,
                // 'Prescription Date' => $labOrder->created_at->format('Y-m-d'),
                // 'Patient Name' => $labOrder->patient->firstname ?? '',
                // 'Doctor Name' => $labOrder->doctor->name ?? '',
                // 'Lab Received Date' => $labOrder->labTrack ? ($labOrder->labTrack->lab_received_at ? $labOrder->labTrack->lab_received_at->format('Y-m-d') : '') : '',
                // 'Test Name' => $labOrder->test->name ?? '',
                // 'Branch Name' => $labOrder->labBranch->name ?? '',
                // 'Branch Address' => $labOrder->labBranch->address ?? '',
                // 'Branch Number' => $labOrder->labBranch->phone ?? '',
                // 'Collected Date' => $labOrder->courierCollectedTest ? ($labOrder->courierCollectedTest->collected_at ? $labOrder->courierCollectedTest->collected_at->format('Y-m-d') : '') : '',
                // 'Courier Name' => $labOrder->courierCollectedTest ? ($labOrder->courierCollectedTest->courier->name ?? '') : '',
                // 'Result Released Date' => $labOrder->labTrack ? ($labOrder->labTrack->result_released_at ? $labOrder->labTrack->result_released_at->format('Y-m-d') : '') : '',
                // 'Result' => $labOrder->labTrack->result ?? '',
                // 'Status' => $labOrder->status ?? '',
                //     //'Actions' => '<Action buttons/links as required>'  // Adjust as per your front-end requirements
                // ];

                //dd($labOrderData);
           
                // Initialize the stages of the order
                $isLabReceived = $labOrder->labTrack && $labOrder->labTrack->lab_received_at;

        $stages = [
            [
                'Lab Order Number' => $labOrder->id,
                'Date' => $labOrder->created_at->format('Y-m-d'),
                'Status' => 'Ordered',
                'isCompleted' => 1 // Prescription is always completed if we reached this point
            ],
            [
                'Lab Order Number' => $labOrder->id,
                'Date' => $labOrder->courierCollectedTest 
                    ? ($labOrder->courierCollectedTest->collected_at 
                        ? $labOrder->courierCollectedTest->collected_at->format('Y-m-d') : '') 
                    : '',
                'Status' => 'Collected by Courier',
                // Mark as completed if a courier collected it OR if the lab received the order
                'isCompleted' => $labOrder->courierCollectedTest || $isLabReceived ? 1 : 0
            ],
            [
                'Lab Order Number' => $labOrder->id,
                'Date' => $labOrder->labTrack ? ($labOrder->labTrack->lab_received_at ? $labOrder->labTrack->lab_received_at->format('Y-m-d') : '') : '',
                'Status' => 'Received by Lab',
                'isCompleted' => $labOrder->labTrack && $labOrder->labTrack->lab_received_at ? 1 : 0
            ],
            [
                'Lab Order Number' => $labOrder->id,
                'Date' => $labOrder->labTrack ? ($labOrder->labTrack->result_released_at ? $labOrder->labTrack->result_released_at->format('Y-m-d') : '') : '',
                'Status' => 'Result Released',
                'isCompleted' => $labOrder->labTrack && $labOrder->labTrack->result_released_at ? 1 : 0
            ]
        ];


            // Return the response with all lab orders
            return response()->json([
                'message' => 'Order stages returned successfully.',
                'data' => $stages
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'An error occurred while retrieving lab orders.',
                'error' => $th->getMessage(),
            ], 422);
        }
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
}
