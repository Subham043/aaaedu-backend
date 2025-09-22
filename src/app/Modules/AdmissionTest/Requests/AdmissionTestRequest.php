<?php

namespace App\Modules\AdmissionTest\Requests;

use App\Enums\ExamMode;
use App\Enums\AdmissionTestClassEnum;
use App\Http\Services\RateLimitService;
use Illuminate\Foundation\Http\FormRequest;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password as PasswordValidation;


class AdmissionTestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        (new RateLimitService($this))->ensureIsNotRateLimited(3);
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'school_name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'father_email' => 'required|string|max:255',
            'father_phone' => 'required|numeric|digits:10',
            'mother_name' => 'required|string|max:255',
            'mother_email' => 'required|string|max:255',
            'mother_phone' => 'required|numeric|digits:10',
            'address' => 'required|string|max:500',
            'program' => 'required|string|max:500',
            'image' => 'required|image|min:1|max:5000',
            'class' => ['required', new Enum(AdmissionTestClassEnum::class)],
            'mode' => ['required', new Enum(ExamMode::class)],
            'exam_date' => ['nullable','required_if:mode,'.ExamMode::OFFLINE->value, 'string'],
            'exam_center' => ['nullable','required_if:mode,'.ExamMode::OFFLINE->value, 'string'],
            'password' => ['required',
                'string',
                PasswordValidation::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
            ],
            'confirm_password' => ['required_with:password','same:password'],
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
