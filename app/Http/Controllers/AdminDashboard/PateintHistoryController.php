<?php

namespace App\Http\Controllers\AdminDashboard;

use ZipArchive;
use App\Models\Patient;
use App\Models\LabOrder;
use PhpParser\JsonDecoder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PateintHistoryController extends Controller
{
    public function PatientHistory(Request $request)
    {
        $patientCode = $request->query('tracking');

        $patient = Patient::where('tracking_number', $patientCode)
            ->with(['doctor', 'labOrders', 'cases', 'diagnose'])
            ->first();
        if (!$patient) {
            return response()->json(['patient not found..'], 404);
        }
        $history = $patient->labOrders->map(function ($labOrder) {
            return [
                'labOrder_id'=>$labOrder->id,
                'labOrder_date'=>$labOrder->created_at ??'',
                'diagnose_name'=>$labOrder->test->diagnose->name??'',
                'doctor_name'=>$labOrder->doctor->name??'',
                'test_name'=>$labOrder->test->name??'',
                'lab_name'=>$labOrder->lab->name??'',
                'branch_name'=>$labOrder->labBranch->name??'',
                'branch_address'=>$labOrder->labBranch->address??'',
                'branch_phone'=>$labOrder->labBranch->phone??'',
                'expected_result_at'=>$labOrder->labTrack->expected_result_released_date??'',
                'result_released_at'=>$labOrder->labTrack->result_released_at??'',
                'result'=>optional($labOrder->labTrack)->result ? json_encode($labOrder->labTrack->result) : ''

            ];
        });
       
        return view('dashboard.patient-history.index', compact('patient','history'));
    }

    public function downloadResult($id){
        $labOrder=LabOrder::findOrFail($id);
        $results=json_decode($labOrder->labTrack->result, true);
        // Create a zip file with the results
        $zip= new \ZipArchive();
        $zipFilename = 'lab_order_' . $id . '_results.zip';
        $zipPath = public_path('uploads/' . $zipFilename);
        if ($zip->open($zipPath, \ZipArchive::CREATE) === TRUE) {
                foreach ($results as $file) {
                    $filePath = public_path($file);
                    if (file_exists($filePath)) {
                        $zip->addFile($filePath, basename($filePath));
                    }
                }
                $zip->close();
            }
            // Return the zip file as a download
            return response()->download($zipPath)->deleteFileAfterSend(true);

    }
   
}
