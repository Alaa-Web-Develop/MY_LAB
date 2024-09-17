<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Models\Patient;
use App\Models\LabOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class PatientsController extends Controller
{
    public function index()
    {
        $patients = Patient::leftJoin('doctors', 'doctors.id', '=', 'patients.doctor_id')
            //->join('diagnoses', 'diagnoses.id', '=', 'patients.diagnose_id')
            ->select([
                'patients.*',
                'doctors.name as doctor_name',
                //'diagnoses.name as diagnose_name',


            ])->get();
        //dd($patients);

        $labOrders = LabOrder::leftJoin('patients', 'lab_orders.patient_id', '=', 'patients.id')
            ->join('tests', 'lab_orders.test_id', '=', 'tests.id')
            ->join('lab_branches', 'lab_branches.id', '=', 'lab_orders.lab_branche_id')
            ->Join('doctors', 'doctors.id', '=', 'lab_orders.doctor_id')

            ->select([
                'lab_orders.*',
                'patients.firstname as fname_patient',
                'tests.name as test_name',
                'lab_branches.name as branch',
                'doctors.name as doctor_name'
            ])
            ->get();

        return view('dashboard.patients.index', compact('patients','labOrders'));
    }

    public function downloadResult($id)
    {

        $patient_report=DB::table('patients')->where('id','=',$id)->first();
        $file_path=public_path($patient_report->pathology_report_image);
        if($file_path){
            return Response::download($file_path);
        }else{
            return response()->json([
            'message' => 'No uploaded reports for patient'
            ]);
        }
       
    }
    
}
