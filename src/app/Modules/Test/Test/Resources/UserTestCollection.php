<?php

namespace App\Modules\Test\Test\Resources;

use App\Modules\Test\AnswerSheet\Resources\UserTestEnrollmentCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class UserTestCollection extends JsonResource
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
            'slug' => $this->slug,
            'amount' => $this->amount,
            'description' => $this->description,
            'description_unfiltered' => $this->description_unfiltered,
            'short_description' => str()->limit($this->description_unfiltered, 80),
            'image_title' => $this->image_title,
            'image_alt' => $this->image_alt,
            'image' => asset($this->image),
            'is_active' => $this->is_active,
            'is_paid' => $this->is_paid,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'meta_keywords' => $this->meta_keywords,
            'meta_scripts' => $this->meta_scripts,
            'is_test_enrolled' => !empty($this->test_taken) ? UserTestEnrollmentCollection::make($this->test_taken) : null,
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
            'created' => $this->created_at->format('Y, d M'),
            'updated' => $this->updated_at->format('Y, d M'),
        ];
    }
}
