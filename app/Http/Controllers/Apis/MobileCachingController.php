<?php

namespace App\Http\Controllers\Apis;

use App\Models\Lab;
use App\Models\Test;
use App\Models\Diagnose;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Lab_Branch_Test;
use App\Models\LabBranch;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;

class MobileCachingController extends Controller
{
    //Auth: governorate cities
    // 1- diagnoses
    public function getAllDiagnoses()
    {
        $data = Diagnose::get();
        return response()->json([
            'message' => 'Diagnoses returned successfuly..',
            'data' => $data
        ], 200);
    }
    // 4- labs
    public function getAllLabs()
    {

        $data = Lab::with(['city', 'govern'])->get();
        return response()->json([
            'message' => 'Labs returned successfuly..',
            'data' => $data
        ], 200);
    }
    // 5- tests
    public function getAllTests()
    {
        $data = Test::all();
        $data->load('diagnose:id,name');

        return response()->json([
            'message' => 'Tests returned successfuly..',
            'data' => $data
        ], 200);
    }
    // 6- lab_branches
    public function getAllLab_branches()
    {
        $data = LabBranch::with(['city', 'govern'])->get();
        return response()->json([
            'message' => 'Lab_branches returned successfuly..',
            'data' => $data
        ], 200);
    }
    // 7- patients
    public function getAllPatients()
    {
        $doctorId = Auth::user()->doctor->id;
        $data = Patient::where('doctor_id', $doctorId)->get();

        $data->load('diagnose:id,name');

        return response()->json([
            'message' => 'Patients returned successfuly..',
            'data' => $data
        ], 200);
    }
    // 8- lab_tests
    public function getAllLabTests(Request $request)
    {
        $lab_id = $request->query('lab_id');
        $test_id = $request->query('test_id');

        $query = Lab_Branch_Test::join('tests', 'tests.id', '=', 'lab_tests.test_id')
            ->join('diagnoses', 'diagnoses.id', '=', 'tests.diagnose_id');
        // ->where('lab_tests.test_id', $test_id)
        // ->where('lab_tests.lab_id', $lab_id)
        //->get();
        if ($lab_id && $test_id) {
            $query->where('lab_tests.test_id', $test_id)->where('lab_tests.lab_id', $lab_id);
        } elseif ($lab_id) {
            $query->where('lab_tests.lab_id', $lab_id);
        } elseif ($test_id) {
            $query->where('lab_tests.test_id', $test_id);
        }
        $data = $query->get();

        $data->load('test:id,name');


        $total_points = Auth::user()->doctor->total_points;



        return response()->json([
            'message' => 'LabTests returned successfuly..',
            'data' => $data,
            'Doctor Total Points' => $total_points,
        ], 200);
    }


    // 9- test_questions
    public function getAllTestQuestions()
    {
        $data = Test::with('questions')->get();
        return response()->json([
            'message' => 'TestsQuestions returned successfuly..',
            'data' => $data
        ], 200);
    }

    //get tests by lab_id
    public function getTestsByLabId(Request $request)
    {
        $id = $request->query('lab_id');
        $data = Lab_Branch_Test::join('tests', 'tests.id', '=', 'lab_tests.test_id')
            ->join('diagnoses', 'diagnoses.id', '=', 'tests.diagnose_id')
            ->where('lab_tests.lab_id', $id)
            ->get();
        $data->load('test:id,name');

        if (!$data) {
            return response()->json([
                'message' => 'in valid lab_id',
            ], 404);
        }
        return response()->json([
            'message' => 'LabTests returned successfuly..',
            'data' => $data,
        ], 200);
    }
    // {
    //     "test_id": 1,
    //     "lab_id": 1,
    //     "price": "30.00",
    //     "discount_points": 0,
    //     "points": 40,
    //     "notes": "notes5",
    //     "courier_id": null,
    //     "has_courier": 0,
    //     "created_at": "2024-10-01T18:06:08.000000Z",
    //     "updated_at": "2024-10-01T18:06:08.000000Z",
    //     "test_tot": 0,
    //     "id": 5,
    //     "name": "Diagnose5",
    //     "diagnose_id": 5,
    //     "details": "test_1 Details",
    //     "status": "active",
    //     "questions": null
    // },
}
