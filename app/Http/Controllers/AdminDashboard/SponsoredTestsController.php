<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\SponserTest;
use Illuminate\Http\Request;

class SponsoredTestsController extends Controller
{
    public function index(){
        $sponsoredTests=SponserTest::with([
            'test' => function($query){
                $query->select('id','name');//fetch test name
            },
            'test.LabOrder' =>function($query){
                $query ->with('patient:id,name','doctor:id,name');
            },
            'test.LabOrder'=>function($query){
                $query->select('test_id','create_at as date_of_prescription','updated_at as date_of_delivery');
            },
            'lab'=>function($query){
                $query->select('id','name');//fetch lab name
            },
            'sponsor'=>function($query){
                $query->select('id','name');//fetch sponsor name
            }
        ])->get();

        return view('dashboard.sponsoredTests.index',compact('sponsoredTests'));
    //     // Step 2: Calculate remaining tests quota
    // $sponsoredTests->each(function ($sponsoredTest) {
    //     $sponsoredTest->remaining_quota = $sponsoredTest->quota - $sponsoredTest->test->labOrders()->count();
    // });
    

      
    }
}
