<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientCaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'visit id' => $this->id,
            'patient_name' => $this->patient_name,
            'visit_date' =>$this->created_at,
            'comment' => $this->comment,
            'lab_orders' => $this->labOrders->map(function ($labOrder){
                return[
                    'id' => $labOrder->id,
                    'test_id' => $labOrder->test_id,
                    'lab_branche_id' => $labOrder->lab_branche_id,
                ];
            }),
        ];
    }
}
