<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\Courier;
use App\Models\CourierCollectedTest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CourierCollectedTestController extends Controller
{
    public function index(){

           // Fetch all CourierCollectedTest records with their related LabOrder and Courier
//     $courierCollectedTests = CourierCollectedTest::with(['labOrder.patient', 'labOrder.lab', 'labOrder.branch', 'courier'])
//     ->get();

// // Pass the data to the Blade view
// return view('dashboard.courier_collected_tests.index', [
//     'courierCollectedTests' => $courierCollectedTests
// ]);

       $couriersLabOrders=CourierCollectedTest::with(['labOrder.patient', 'labOrder.lab', 'labOrder.labBranch', 'courier'])
        ->get();

        $couriers=Courier::select('id','name')->get();
        //dd($couriersLabOrders);
        return view('dashboard.courierCollectedLabOrders.index',compact('couriersLabOrders','couriers'));
    }

    public function update(Request $request,$id){
        $request->validate([
            'courier_id' => 'nullable|exists:couriers,id',
            'collected_at'=>'date'
        ]);
    
        // Find the CourierCollectedTest record by id
        $courierCollectedTest = CourierCollectedTest::findOrFail($id);
    
        // Update the courier_id
        $courierCollectedTest->courier_id = $request->courier_id;
        $courierCollectedTest->collected_at=Carbon::now();
        $courierCollectedTest->status='collected';

        $courierCollectedTest->save();
    
        // Redirect back to the index with a success message
        return redirect()->route('dashboard.couriercollectedtests.index')->with('success', 'Courier updated successfully.');
    }
}
