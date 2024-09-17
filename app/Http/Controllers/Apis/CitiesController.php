<?php

namespace App\Http\Controllers\Apis;

use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CitiesController extends Controller
{
   

    public function show($govern_id)
    {
        $cities = City::where('governorate_id','=',$govern_id)->paginate();
        return $cities;
    }


}
