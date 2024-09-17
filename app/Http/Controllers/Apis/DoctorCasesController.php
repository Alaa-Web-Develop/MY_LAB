<?php

namespace App\Http\Controllers\Apis;

use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DoctorCasesController extends Controller
{
    //get doctor cases lab_orders 
    
public function getDoctorWithPatientsCasesLabOrders(Request $request)
{
    // Get the authenticated doctor
    $doctor = auth()->user()->doctor; // Assuming the authenticated user has a relation to the doctor model
//dd($doctor);
    if (!$doctor) {
        return response()->json(['error' => 'Doctor not found'], 200);
    }

    // Load patients, their cases, and lab orders with related information
    // $doctor = Doctor::with(['patients.cases.labOrders.test', 'patients.cases.labOrders.lab', 'patients.cases.labBranch'])
    $doctor = Doctor::with(['patients.cases.labOrders.test', 'patients.cases.labOrders.lab', 'patients.cases.labOrders.labBranch'])
        ->where('id', $doctor->id)
        ->firstOrFail();

    // Prepare the response data
    $response = [];
    $response['doctor_name'] = $doctor->name;
    $response['patients'] = [];

    foreach ($doctor->patients as $patient) {
        $patientData = [];
        $patientData['patient_name'] = $patient->firstname . ' ' . $patient->lastname;
        $patientData['cases'] = [];

        foreach ($patient->cases as $case) {
            $caseData = [];
            $caseData['case_id'] = $case->id;
            $caseData['lab_orders'] = [];
            // $labOrderData['test_name'] = $labOrder->test?->name;
            // $labOrderData['lab'] = $labOrder->lab?->name;
            // $labOrderData['lab_branch'] = $labOrder->labBranch?->name;
            foreach ($case->labOrders as $labOrder) {
                $labOrderData = [];
                $labOrderData['date'] = $labOrder->created_at->format('Y-m-d');
                $labOrderData['test_type'] = $labOrder->test->type;
                $labOrderData['test_name'] = $labOrder->test?->name;
                $labOrderData['lab'] = $labOrder->lab?->name;
                $labOrderData['lab_branch'] =$labOrder->labBranch?->name;
                $labOrderData['comments'] = $case->comment;

                $caseData['lab_orders'][] = $labOrderData;
            }

            $patientData['cases'][] = $caseData;
        }

        $response['patients'][] = $patientData;
    }
//dd($response);
    return response()->json([
        'message' => 'doctor with his cases with lab Orders return succssefully...!',
        'data'=>$response
    ], 200);
}
}
