<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Governorate;
use Illuminate\Http\Request;

class CitiesContrller extends Controller
{
    public function getCitiesByGovernId($governId)
    {
        $cities=City::where('governorate_id','=',$governId)->get();
        return response()->json($cities);
    }

    public function index(){
        $governorates = Governorate::with('cities')->get();
    return view('dashboard.cities-govrs.cities-govrs', compact('governorates'));
    }
    public function storeGovernorate(Request $request)
    {
        $request->validate([
            'governorate_name_ar' => 'required|unique:governorates,governorate_name_ar',
            'governorate_name_en' => 'required|unique:governorates,governorate_name_en',
        ]);

        Governorate::Insert([
            'governorate_name_ar' =>$request->governorate_name_ar,
            'governorate_name_en'=>$request->governorate_name_en
        ]);

        return redirect()->back()->with('success', 'Governorate added successfully.');
    }

    public function storeCity(Request $request)
    {
        $request->validate([
            'governorate_id' => 'required|exists:governorates,id',
            'city_name_ar' => 'required|unique:cities,city_name_ar,NULL,id,governorate_id,' . $request->governorate_id,
            'city_name_en' => 'required|unique:cities,city_name_en,NULL,id,governorate_id,' . $request->governorate_id,
        ]);

        City::Insert([
            'governorate_id' =>$request->governorate_id ,
            'city_name_ar' =>$request->city_name_ar ,
            'city_name_en' =>$request-> city_name_en
        ]);

        return redirect()->back()->with('success', 'City added successfully.');
    }
}
