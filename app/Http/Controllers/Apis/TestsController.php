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
        if( $type==0)
        {
            $tests = Test::where('type', 'test')->get();
        }
        if( $type==1)
        {
            $tests = Test::where('type', 'rays')->get();
        }

    } else {
        // If 'type' is not present, return all tests
        $tests = Test::all();
    }

    return response()->json([
        'message'=>'Done.!',
        'data'=>$tests
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
          $labs=Lab_Branch_Test::join('tests','tests.id','=','lab_tests.test_id') 
          ->join('labs','labs.id','=','lab_tests.lab_id')
          ->join('lab_branches','lab_branches.lab_id','=','lab_tests.lab_id')
          ->where('lab_tests.lab_id','=',$labId)
          ->select([
            
            'labs.name as lab_name',
            'labs.id as lab_id',
              'tests.name as test_name',
              'tests.id as test_id',
              'tests.type as test_type',

              'lab_tests.price',
              'lab_tests.points',
              'lab_tests.notes'
          ])->get();
  
          // dd($branches);
          if ($labs->isEmpty()) {
              return response()->json([
                  'message' => 'No items found.',
              ],200);
          }
      
          return response()->json([
              'message' => 'lab wih available tests ..done! ',
              'data' => $labs
          ], 200);
    }
    public function show($id)
    {
        $tests=Test::where('lab_branche_id',$id)->get();
        if ($tests->isEmpty()) {
            return response()->json([
              
                'message' => 'No items found.',
            ],200);
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
}
