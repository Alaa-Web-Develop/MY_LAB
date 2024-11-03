<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Models\Lab_Branch_Test;
use App\Models\LabBranch;
use Illuminate\Http\Request;

class LabsBranchesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branches=LabBranch::paginate();
        return $branches;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

   
      //Get_available_branches_by-test    
    public function show($test_id)
    {
        //->where('tests.name', 'like', '%' . $searchTerm . '%')
        $branches=Lab_Branch_Test::join('tests','tests.id','=','lab_tests.test_id') 
        ->join('labs','labs.id','=','lab_tests.lab_id')
        ->join('lab_branches','lab_branches.lab_id','=','lab_tests.lab_id')
        ->where('tests.id','=',$test_id)
        ->select([
            'tests.name as test_name',
            'tests.id as test_id',
            'tests.type as test_type',


            'lab_branches.id as branche_id',
            'lab_branches.name as branche_name',

            'labs.id as lab_id',
            'labs.name as lab_name',
            'lab_tests.price',
            'lab_tests.points',
            'lab_tests.notes'
        ])->get();

        // dd($branches);
        if ($branches->isEmpty()) {
            return response()->json([
                'message' => 'No items found.',
            ],200);
        }
    
        return response()->json([
            'success' => true,
            'data' => $branches
        ], 200);
    }

    //GetBranchesBy lab_id  &  test_id 
    public function GetBranchesByLab_id_Test_id(Request $request)
    {
        $test_id=$request->query('test_id');
        $lab_id=$request->query('lab_id');

        $branches = LabBranch::join('labs','lab_branches.lab_id','=', 'labs.id')
        //->join('lab_branches', 'lab_branches.lab_id','=', 'labs.id')
        ->join('lab_tests', 'lab_tests.lab_id','=','labs.id')
        ->join('tests', 'lab_tests.test_id','=','tests.id')

        ->where('tests.id','=', $test_id)
        ->where('labs.id','=',$lab_id)
        ->select([
            'lab_branches.id as branche_id',
            'lab_branches.name as branche_name',
            'labs.id as lab_id',
            'labs.name as Lab_name',

            'tests.id as test_id',
            'tests.name as test_name',
           // 'tests.type as test_type',


            'lab_tests.price as test_price',
            'lab_tests.points as doctor_points',
            'lab_tests.notes as test_notes',


            
        ])->get();

        //dd($labs);
    return response()->json([
        'message' => 'labs returned successfully',
        'Available_lab_branches' => $branches
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
}
