<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Models\Lab_Branch_Test;
use App\Models\Test;
use Illuminate\Http\Request;

class TestsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Define constants for types
        // const test = 0;
        // const rays = 1;

        // Check if the 'type' parameter is present in the request
        if ($request->has('type')) {
            $type = $request->query('type');

            // Validate that the type is either 0 or 1
            $request->validate([
                'type' => 'in:0,1',
            ]);
            if ($type == 0) {
                $tests = Test::where('type', 'test')->get();
            }
            if ($type == 1) {
                $tests = Test::where('type', 'rays')->get();
            }
        } else {
            // If 'type' is not present, return all tests
            $tests = Test::all();
        }

        $tests->load('diagnose:id,name');

        return response()->json([
            'message' => 'Done.!',
            'data' => $tests
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }


    //Get - search available tests in lab
    public function AvailableTestsInBranch($labId)
    {
        //->where('tests.name', 'like', '%' . $searchTerm . '%')
        $labs = Lab_Branch_Test::join('tests', 'tests.id', '=', 'lab_tests.test_id')
            ->join('labs', 'labs.id', '=', 'lab_tests.lab_id')
            ->join('lab_branches', 'lab_branches.lab_id', '=', 'lab_tests.lab_id')
            ->join('diagnoses', 'diagnoses.id', '=', 'tests.diagnose_id')
            ->where('lab_tests.lab_id', '=', $labId)
            ->select([

                'labs.name as lab_name',
                'labs.id as lab_id',
                'tests.name as test_name',
                'tests.id as test_id',
                'tests.diagnose_id as test_diagnose_id',

                'lab_tests.price',
                'lab_tests.points',
                'lab_tests.notes',
                'lab_tests.test_tot'
            ])->get();

        // dd($branches);
        if ($labs->isEmpty()) {
            return response()->json([
                'message' => 'No items found.',
            ], 200);
        }

        return response()->json([
            'message' => 'lab wih available tests ..done! ',
            'data' => $labs
        ], 200);
    }
    public function show($id)
    {
        $tests = Test::where('lab_branche_id', $id)->get();
        if ($tests->isEmpty()) {
            return response()->json([

                'message' => 'No items found.',
            ], 200);
        }

        return response()->json([
            'success' => true,
            'data' => $tests
        ], 200);
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



    //test details and questions by test_id
    public function TestDetailsWithQuestions(Request $request)
    {
        $id = $request->query('id');
        $test = Test::with('questions')->find($id);
        if (!$test) {
            return response()->json([
                'message' => 'invalid test id'
            ], 404);
        }
        return response()->json([
            'message' => 'test details with questions..!',
            'data' => $test
        ], 200);
    }

    public function getTestByDiagnoseId(Request $request)
    {
        $id = $request->query('diagnose_id');
        $tests = Test::with('diagnose')->where('diagnose_id', $id)->get();
        if ($tests->isEmpty()) {
            return response()->json([
                'message' => 'invalid diagnose id'
            ], 404);
        }
        return response()->json([
            'message' => 'test details with Diagnoses..!',
            'data' => $tests
        ], 200);
    }
}
