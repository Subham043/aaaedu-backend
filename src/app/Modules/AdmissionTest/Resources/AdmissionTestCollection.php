<?php

namespace App\Modules\AdmissionTest\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdmissionTestCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'school_name' => $this->school_name,
            'father_name' => $this->father_name,
            'father_email' => $this->father_email,
            'father_phone' => $this->father_phone,
            'mother_name' => $this->mother_name,
            'mother_email' => $this->mother_email,
            'mother_phone' => $this->mother_phone,
            'class' => $this->class->value ?? null,
            'program' => $this->program,
            'mode' => $this->mode->value ?? null,
            'address' => $this->address,
            'exam_date' => $this->exam_date,
            'exam_center' => $this->exam_center,
            'amount' => $this->amount,
            'razorpay_order_id' => $this->razorpay_order_id,
            'payment_status' => $this->payment_status->value ?? null,
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
        ];
    }
}
