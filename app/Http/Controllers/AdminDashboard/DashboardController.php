<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Models\LabOrder;
use App\Models\TrackLabTest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\PointTransaction;

class DashboardController extends Controller
{
    public function index()
    {
        //dd(asset('uploads/patient_Pathology_report/1724454781.pdf'));

        // Calculate the total number of tests requested
        $totalTestsRequested = LabOrder::count();

        // Calculate the number of pending lab orders
        $pendingLabOrders = TrackLabTest::where('status', 'pending')->count();

        // Calculate the total points earned
        $totalPointsEarned = PointTransaction::where('type', 'earned')->sum('points');

        // Calculate the total points redeemed
        $totalPointsRedeemed = PointTransaction::where('type', 'redeemed')->sum('points');

        return view('dashboard.main.index', compact('totalTestsRequested', 'pendingLabOrders', 'totalPointsEarned', 'totalPointsRedeemed'));
    }

    public function ActionFilter(Request $request)
    {
        // Calculate the total number of tests requested
        $totalTestsRequested = LabOrder::count();

        // Calculate the number of pending lab orders
        $pendingLabOrders = TrackLabTest::where('status', 'pending')->count();

        // Calculate the total points earned
        $totalPointsEarned = PointTransaction::where('type', 'earned')->sum('points');

        // Calculate the total points redeemed
        $totalPointsRedeemed = PointTransaction::where('type', 'redeemed')->sum('points');

        $query = Action::query();
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        if ($request->has('action_date') && $request->action_date != '') {
            $query->whereDate('action_date', $request->action_date);
        }
       

        $actions = $query->orderBy('action_date', 'desc')->get();

      


        return view('dashboard.main.filter', compact('actions','totalTestsRequested', 'pendingLabOrders', 'totalPointsEarned', 'totalPointsRedeemed'));
    }
}
