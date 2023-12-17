<?php

namespace App\Modules\Test\AnswerSheet\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserTestEnrollmentCollection extends JsonResource
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
            'test_id' => $this->test_id,
            'current_quiz_id' => $this->current_quiz_id,
            'current_question_id' => $this->current_question_id,
            'user_id' => $this->user_id,
            'is_enrolled' => $this->is_enrolled,
            'enrollment_type' => $this->enrollment_type,
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
