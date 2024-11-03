<?php

namespace App\Http\Controllers\CourierTracking;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CourierCollectedTest;
use Illuminate\Support\Facades\Auth;

class CourierTrackingController extends Controller
{
 public function index(){
    $user = Auth::user();        
    $courier=$user->courier;
     // Fetch collected tests related to the courier
     $orders=$courier->courierCollectedTests()->with(['labOrder.patient', 'labOrder.labBranch', 'labOrder.lab'])->get();

     //dd($orders);
    return view('courierTracking.index',compact('courier','orders'));
    //$branch=LabBranch::where('id',$branch_id)->first();

 }

 public function update(Request $request,$id){
    $request->validate([
'status'=>'in:new,collected',
'collected_at'=>'nullable|date_format:Y-m-d\TH:i', // Correct datetime-local format
    ]);
    $collectedTest=CourierCollectedTest::find($id);
    if( $collectedTest){
        $collectedTest->status=$request->post('status');
          // Set collected_at only if provided
          if ($request->has('collected_at') && $request->post('collected_at')) {
            $collectedTest->collected_at = $request->post('collected_at');
        }

        $collectedTest->save();
    }
    return redirect()->route('dashboard.courierTracking.index')->with('success','lab order editted sussessfully.!');
 }



}
