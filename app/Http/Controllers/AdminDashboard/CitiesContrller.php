<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CitiesContrller extends Controller
{
    public function getCitiesByGovernId($governId)
    {
        $cities=City::where('governorate_id','=',$governId)->get();
        return response()->json($cities);
    }
}
