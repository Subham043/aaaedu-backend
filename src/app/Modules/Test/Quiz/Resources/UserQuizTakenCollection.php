<?php

namespace App\Modules\Test\Quiz\Resources;

use App\Modules\Test\Subject\Resources\UserSubjectCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class UserQuizTakenCollection extends JsonResource
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
            'duration' => $this->duration,
            'mark' => $this->mark,
            'negative_mark' => $this->negative_mark,
            'difficulty' => $this->difficulty,
            'subject' => UserSubjectCollection::make($this->subject),
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
        ];
    }
}
