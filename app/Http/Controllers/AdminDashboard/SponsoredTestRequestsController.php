<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\Sponser;
use App\Models\SponsoredTestRequest;
use Illuminate\Http\Request;

class SponsoredTestRequestsController extends Controller
{
    public function index(Request $request)
    {
        $sponsors = Sponser::all();

        $query = SponsoredTestRequest::with('doctor', 'patient', 'labOrder.test','sponsor');
       // ->where('status', 'pending')
        //->get();
 // Filter by sponsor name if provided
 if($request->sponsor_name){
    $query->whereHas('sponsor',function($q) use ($request){
$q->where('name','like','%'.$request->sponsor_name.'%');
    });
 }

 // Filter by date range if provided
 if($request->from_date && $request->to_date){
    $query->whereBetween('created_at',[$request->from_date,$request->to_date]);
 }
 $sponsoredRequests = $query->get();
    return view('dashboard.sponsoredRequest.index', compact('sponsoredRequests','sponsors'));
    }


}
