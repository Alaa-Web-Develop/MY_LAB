<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Models\TrackLabTest;
use Illuminate\Http\Request;

class LabOrdersTrackingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $labOrdersTrack=TrackLabTest::where('doctor_id',2)->paginate();
        return $labOrdersTrack;
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
}
