<?php

namespace App\Modules\HomePage\Banner\Requests;

use App\Modules\HomePage\Banner\Services\BannerService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BannerUpdateRequest extends BannerCreateRequest
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
            'banner_image' => ['nullable','image', 'min:1', 'max:500', Rule::requiredIf(function (){
                $banner = (new BannerService)->getById($this->route('id'));
                return empty($banner->banner_image);
            }),],
            'banner_image_alt' => 'nullable|string|max:500',
            'banner_image_title' => 'nullable|string|max:500',
            'counter_image_1' => 'nullable|image|min:1|max:500',
            'counter_title_1' => 'required|string|max:500',
            'counter_description_1' => 'required|string|max:500',
            'counter_image_2' => 'nullable|image|min:1|max:500',
            'counter_title_2' => 'required|string|max:500',
            'counter_description_2' => 'required|string|max:500',
        ];
    }

}
