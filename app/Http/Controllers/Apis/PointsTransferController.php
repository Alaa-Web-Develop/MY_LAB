<?php

namespace App\Http\Controllers\Apis;

use App\Models\Action;
use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Models\PointTransaction;
use App\Http\Controllers\Controller;
use App\Models\PointTranferRrequest;
use Illuminate\Support\Facades\Auth;

class PointsTransferController extends Controller
{
    public function requestTransfer(Request $request)
    {

        // $table->integer('points')->default(0);
        // $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade');
        // $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
        // $table->enum('transfer_type', ['instapay', 'vodafone_cach', 'orange_cach'])->default('instapay');

        // $table->string('transfer_phone_number');

        $request->validate([
            'transfer_phone_number' => ['required', 'string'],
            'points' => 'required|integer|min:0',
            //'status' =>'in:pending,approved,rejected',
            'transfer_type'=>'in:instapay,vodafone_cach,orange_cach',
             'money' => 'required|integer|min:1',

        ]);
        //dd( $request->all());
        //======Auth doctor
        $user = Auth::guard('sanctum')->user();
        $doctor_id = $user->doctor->id;

        $doctor = Doctor::find($doctor_id);
        try {
            if ($doctor->total_points < $request->post('points')) {
                return response()->json(['error' => 'Not enough points'], 200);
            }

            $transferRequest = PointTranferRrequest::create([
                'doctor_id' => $doctor->id,
                'points' => $request->post('points'),
                'status' => 'pending',
                'transfer_phone_number' => $request->post('transfer_phone_number'),
                'money'=>$request->post('money'),
                'transfer_type'=>$request->post('transfer_type'),
            ]);

            Action::create([
                'action' => "Doctor:  $doctor->name- make arequest for transfer $request->post('points') points",
                'type' => 'points',
                'action_date' => now()
            ]);

            return response()->json(
                [
                    'message' => 'Points transfer request submitted successfully',
                    'request' => $transferRequest
                ],
                201
            );
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 200);
        }
    }

    public function CheckAdminApproval($id) // $id requesttrnasfer id
    {
        //======Auth doctor
        $user = Auth::guard('sanctum')->user();
        $doctor_id = $user->doctor->id;

        $doctor = Doctor::find($doctor_id);

        $transferRequest = PointTranferRrequest::find($id);

        if ($transferRequest->status === 'pending') {
            return response()->json(['message' => 'This request has already been processed'], 200);
        }

        if ($transferRequest->status === 'rejected') {
            return response()->json(['message' => 'This request has already been rejected'], 200);
        }

        if ($transferRequest->status === 'approved') {

            $doctor->total_points -= $transferRequest->points;
            $doctor->save();

            // Record the transaction
            PointTransaction::create([
                'doctor_id' => $doctor->id,
                'points' => $transferRequest->points,
                'type' => 'transferred',
            ]);


            return response()->json([
                'message' => 'Points transfer approved, doctor\'s points updated, and transaction recorded'
            ]);
        }
    }
}
