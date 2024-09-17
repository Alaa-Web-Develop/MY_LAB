<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DoctorDownloadApp extends Controller
{
    public function index()
    {
        return view('downloadMobileApp.index');
    }
}
