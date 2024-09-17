<?php

namespace App\Http\Controllers\Apis;

use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PointTransaction;
use Illuminate\Support\Facades\Auth;

class PointTransactionsController extends Controller
{
    public function GetDoctorPoints(Request $request)
    {
      //======Auth doctor
      $user = Auth::guard('sanctum')->user();
      $doctor_id = $user->doctor->id;

      $doctor = Doctor::where('id', $doctor_id)->first();
      $DRPoints = $doctor->total_points;

      return response()->json([
          'message' => 'Doctor Available Points..!',
          'doctor_available_points' =>(int)$DRPoints,
          'point value in L.E = '=>1,
      ], 201);
    }

    public function redeemPoints(Request $request) //in params (patient_id redeemPoints)
    {
        $p_id = $request->query('patient_id');
        $redeemPoints = $request->query('redeem_points');
        

        //======Auth doctor
        $user = Auth::guard('sanctum')->user();
        $doctor_id = $user->doctor->id;

        $doctor = Doctor::where('id', $doctor_id)->first();


        if ($doctor->total_points >= $redeemPoints) {
            $doctor->total_points -= $redeemPoints;
            $doctor->save();

            $p_trans = PointTransaction::create([
                'doctor_id' => $doctor->id,
                'patient_id' => $p_id,
                'points' => $redeemPoints,
                'type' => 'redeemed',
            ]);
$drAvailableoints=$doctor->total_points;

            return response()->json([
                'message' => 'Points redeemed!',
                'point_transaction' => $p_trans,
                'doctor_available_points_after_reedemed'=>(int)$drAvailableoints,
            ], 200);
        }

        return response()->json(['error' => 'Not available...'], 200);
    }

    //Get Auth Doctor Trans
    public function GetAuthDoctorTransacions(Request $request)
    {
          // Get the authenticated doctor
    $user = Auth::guard('sanctum')->user();
    $doctor_id = $user->doctor->id;

    // Fetch the doctor's transactions
    $transactions = PointTransaction::with('doctor')
        ->where('point_transactions.doctor_id', $doctor_id)
        ->orderBy('point_transactions.type', 'asc')
        ->get()
        ->map(function ($transaction) {
            return [
                'id' => $transaction->id,
                'type' => $transaction->type,
                'points' => $transaction->points,
                'patient_id'=>$transaction->patient_id ? $transaction->patient_id : '',
                'created_at' => $transaction->created_at->toDateTimeString(),
                'money' => $transaction->type === 'transferred' ? $transaction->points : '',
            ];
        });

        return response()->json([
            'message' => 'Doctor Transactions returned successfully!',
            'data' => $transactions
        ], 200);

    } 
}
