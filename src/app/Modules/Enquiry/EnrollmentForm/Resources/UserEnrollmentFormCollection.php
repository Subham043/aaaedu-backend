<?php

namespace App\Modules\Enquiry\EnrollmentForm\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserEnrollmentFormCollection extends JsonResource
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
            'phone' => $this->phone,
            'amount' => $this->amount,
            'discount' => $this->discount,
            'discounted_amount' => $this->discounted_amount,
            'payment_status' => $this->payment_status,
            'course' => $this->course->name,
            'branch' => $this->branch->name,
            'razorpay_order_id' => $this->razorpay_order_id,
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
        ];
    }
}
