<?php

namespace App\Modules\HomePage\Banner\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Stevebauman\Purify\Facades\Purify;


class BannerCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:250',
            'heading' => 'required|string|max:250',
            'button_link' => 'nullable|required_with:button_text|url|max:500',
            'button_text' => 'nullable|required_with:button_link|string|max:250',
            'description' => 'required|string|max:500',
            'is_active' => 'required|boolean',
            'banner_image' => 'required|image|min:1|max:500',
            'banner_image_alt' => 'nullable|string|max:500',
            'banner_image_title' => 'nullable|string|max:500',
            'counter_image_1' => 'required|image|min:1|max:500',
            'counter_title_1' => 'required|string|max:500',
            'counter_description_1' => 'required|string|max:500',
            'counter_image_2' => 'required|image|min:1|max:500',
            'counter_title_2' => 'required|string|max:500',
            'counter_description_2' => 'required|string|max:500',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'is_active' => 'Active',
            'banner_image' => 'Image',
            'banner_image_alt' => 'Image Alt',
            'banner_image_title' => 'Image Title',
            'counter_image_1' => 'Image',
            'counter_title_1' => 'Title',
            'counter_description_1' => 'Description',
            'counter_image_2' => 'Image',
            'counter_title_2' => 'Title',
            'counter_description_2' => 'Description',
        ];
    }

    /**
     * Handle a passed validation attempt.
     *
     * @return void
     */
    protected function passedValidation()
    {
        $this->replace(
            Purify::clean(
                $this->all()
            )
        );
    }
}
