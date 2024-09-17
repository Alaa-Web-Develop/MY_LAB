<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Models\Action;
use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Models\PointTransaction;
use App\Http\Controllers\Controller;
use App\Models\PointTranferRrequest;
use App\Notifications\PointsTransferStatus;
use App\Notifications\PointsTransferRejection;

class PointsController extends Controller
{
    //'type', ['earned','redeemed', 'transferred']
    public function index()
    {
        $doctors = Doctor::with(['pointsTransactions'])
            ->get()
            ->map(function ($doctor) {
                return [
                    'name' => $doctor->name,
                    'id' => $doctor->id,
                    'pointsTransactions' => $doctor->pointsTransactions,
                    'pointsTransferRequests' => $doctor->pointsTransferRequests,
                    'total_points' => $doctor->total_points,
                    'total_points_earned' => $doctor->pointsTransactions->where('type', 'earned')->sum('points'),
                    'total_points_redeemed' => $doctor->pointsTransactions->where('type', 'redeemed')->sum('points'),
                    'total_points_transferred' => $doctor->pointsTransactions->where('type', 'transferred')->sum('points'),
                ];
            });
        return view('dashboard.points.index', compact('doctors'));
    }

    public function getAllPontsTransferRequests()
    {
        $transferRequests = PointTranferRrequest::with(['doctor'])
            ->get()
            ->map(function ($request) {
                return [
                    'id' => $request->id,
                    'doctor_id' => $request->doctor->id,
                    'doctor_name' => $request->doctor->name,
                    'points' => $request->points,
                    'status' => $request->status, //'pending', 'approved', 'rejected'
                    'transfer_type' => $request->transfer_type, //'instapay', 'vodafone_cach', 'orange_cach'
                    'transfer_phone_number' => $request->transfer_phone_number,
                    'money' => $request->money,
                    'created_at' => $request->created_at,
                ];
            });
        return view('dashboard.points.displayDrPointsRequest', compact('transferRequests'));
    }


    public function updateTransferStatus(Request $request)
    {

    try {
        $request->validate([
            'request_id' => 'required|exists:points_transfer_requests,id',
            'status' => 'required|in:pending,approved,rejected',
            'doctor_id' => 'required|exists:doctors,id',
            'rejection_reason' => 'required_if:status,rejected|string|nullable',
        ]);

        $transferRequest = PointTranferRrequest::find($request->request_id);
        $transferRequest->status = $request->status;
        if($request->status == 'rejected')
        {
            $transferRequest->rejection_reason=$request->post('rejection_reason');
        }
        $transferRequest->save();

        // Update doctor's total points and add a transaction if approved
        if ($request->status == 'approved') {
            $doctor = Doctor::find($request->doctor_id);
            $doctor->total_points -= $transferRequest->points;
            $doctor->save();

            PointTransaction::create([
                'doctor_id' => $doctor->id,
                'points' => $transferRequest->points,
                'type' => 'transferred',
            ]);

            // Send email notification to the doctor
            $doctor->notify(new PointsTransferStatus($doctor, $transferRequest));

            // Mail::to($doctor->email)->send(new PointsTransferStatusMail($doctor, $transferRequest));
        }elseif ($request->status == 'rejected') {
            $doctor = Doctor::find($request->doctor_id);

            PointTransaction::create([
                'doctor_id' => $doctor->id,
                'points' => $transferRequest->points,
                'type' => 'rejected',]);

               // Mail  
           $doctor->notify(new PointsTransferRejection($doctor,$transferRequest));
        }

        Action::create([
            'action' => "Admin update request status for doctor:$doctor->name   ",
            'type' => 'points',
            'action_date' => now()
        ]);

        return view('dashboard.points.displayDrPointsRequest', compact('transferRequests'));
    }catch (\Exception $e) {
        // Log the exception
       // \Log::error('Update Transfer Status Error: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Failed to update status.');
    }

       
    }
}
