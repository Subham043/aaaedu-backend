<?php

namespace App\Modules\Enquiry\ChatbotForm\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Stevebauman\Purify\Facades\Purify;


class ChatbotFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'lead_id' => 'nullable|string',
            'name' => 'nullable|string',
            'email' => 'nullable|string',
            'phone' => 'nullable|string',
            'ip_address' => 'nullable|string',
            'country' => 'nullable|string',
            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',
            'browser' => 'nullable|string',
            'visit_question' => 'nullable|string',
            'admission_question' => 'nullable|string',
            'contact_question' => 'nullable|string',
            'multiple_choice_query' => 'nullable|string',
            'school_course_question' => 'nullable|string',
            'course_location_question' => 'nullable|string',
            'course_standard_question' => 'nullable|string',
            'final_callback_question' => 'nullable|string',
            'schedule_callback_question' => 'nullable|string',
            'status' => 'nullable|string',
            'page_url' => 'nullable|string',
            'is_mobile' => 'nullable|boolean',
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
