<?php

namespace App\Http\Controllers\Apis;

use App\Models\Sponser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SponsorController extends Controller
{
    //all sponsors
    public function index(){
        $sponsors = Sponser::get();

        return response()->json([
            'message'=>'sponsors list retrieved..',
            'data'=>  $sponsors
        ],200);
    }

    public function show(Request $request){

        $id=$request->query('id');
        $sponsor = Sponser::find($id);
        if($sponsor){
            return response()->json([
                'message'=>'sponsor retrieved..',
                'data'=>  $sponsor
            ],200);  
        }else{
            return response()->json([
                'message'=>'in valid sponsor id ',
              
            ],400);  
        }
    }

    //specific sponsor
    
}
