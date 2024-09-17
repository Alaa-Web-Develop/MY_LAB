<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Models\Lab;
use Illuminate\Http\Request;

class LabsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $labs = Lab::paginate();
        return $labs;
    }

    /**
     * Store a newly created resource in storage.
     */
    //get las by test_id
    public function store(Request $request, $id)
    {
   
    }

    /**
     * Get_Labs_by_ test_id
     */
    public function show($id)
    {
        $labs = Lab::join('lab_tests','lab_tests.lab_id','=', 'labs.id')->distinct()
        ->join('tests', 'tests.id','=', 'lab_tests.test_id')
       
        ->where('tests.id','=', $id)
        ->select([
            'labs.*',
            'lab_tests.price',
            'lab_tests.points',
            'lab_tests.notes',

        ])->get();

        //dd($labs);
    return response()->json([
        'message' => 'labs returned successfully',
        'labs' => $labs
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
