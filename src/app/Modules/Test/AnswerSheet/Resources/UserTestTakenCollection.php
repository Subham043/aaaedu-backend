<?php

namespace App\Modules\Test\AnswerSheet\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserTestTakenCollection extends JsonResource
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
            'uuid' => $this->uuid,
            'is_enrolled' => $this->is_enrolled,
            'enrollment_type' => $this->enrollment_type,
            'test_name' => $this->test->name,
            'test_slug' => $this->test->slug,
            'test_status' => $this->test_status,
            'reason' => $this->reason,
            'amount' => $this->amount,
            'receipt' => $this->receipt,
            'razorpay_order_id' => $this->razorpay_order_id,
            'payment_status' => $this->payment_status,
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
        ];
    }
}