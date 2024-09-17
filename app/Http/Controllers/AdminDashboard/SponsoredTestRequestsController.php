<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\SponsoredTestRequest;
use Illuminate\Http\Request;

class SponsoredTestRequestsController extends Controller
{
    public function index()
    {
        $sponsoredRequests = SponsoredTestRequest::with('doctor', 'patient', 'labOrder.test')
        ->where('status', 'pending')
        ->get();

    return view('dashboard.sponsoredRequest.index', compact('sponsoredRequests'));
    }

}
