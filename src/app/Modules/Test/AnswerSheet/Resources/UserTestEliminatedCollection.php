<?php

namespace App\Modules\Test\AnswerSheet\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserTestEliminatedCollection extends JsonResource
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
            'test_status' => $this->test_status,
            'reason' => $this->reason,
            'eliminated_at' => $this->updated_at->diffForHumans(),
        ];
    }
}
