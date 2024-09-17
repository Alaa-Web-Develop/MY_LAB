<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Models\Institution;
use Illuminate\Http\Request;

class InstitutionsController extends Controller
{
    public function index()
    {
        $insts = Institution::get();
        return response()->json([
'data'=>$insts
        ]);
    }
}
