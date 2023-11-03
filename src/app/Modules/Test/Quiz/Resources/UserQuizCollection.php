<?php

namespace App\Modules\Test\Quiz\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserQuizCollection extends JsonResource
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
            'question' => $this->question,
            'question_unfiltered' => $this->question_unfiltered,
            'answer_1' => $this->answer_1,
            'answer_1_unfiltered' => $this->answer_1_unfiltered,
            'answer_2' => $this->answer_2,
            'answer_2_unfiltered' => $this->answer_2_unfiltered,
            'answer_3' => $this->answer_3,
            'answer_3_unfiltered' => $this->answer_3_unfiltered,
            'answer_4' => $this->answer_4,
            'answer_4_unfiltered' => $this->answer_4_unfiltered,
            'duration' => $this->duration,
            'mark' => $this->mark,
            'difficulty' => $this->difficulty,
            'correct_answer' => $this->correct_answer,
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
        ];
    }
}
