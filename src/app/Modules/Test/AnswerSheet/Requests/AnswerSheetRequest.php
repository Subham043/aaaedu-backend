<?php

namespace App\Modules\Test\AnswerSheet\Requests;

use App\Enums\CorrectAnswer;
use App\Enums\TestAttemptStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rule;


class AnswerSheetRequest extends FormRequest
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
            'attempted_answer' => ['nullable', Rule::requiredIf(empty($this->attempt_status)), new Enum(CorrectAnswer::class)],
            'attempt_status' => ['nullable', Rule::requiredIf(empty($this->attempted_answer)), new Enum(TestAttemptStatus::class)],
            'reason' => ['nullable', Rule::requiredIf((empty($this->attempted_answer) && !empty($this->attempt_status)) && ($this->attempt_status==TestAttemptStatus::FAILED->value || $this->attempt_status==TestAttemptStatus::ELIMINATED->value))]
        ];
    }

    /**
     * Handle a passed validation attempt.
     *
     * @return void
     */
    protected function passedValidation()
    {
        $request = Purify::clean(
            $this->validated()
        );
        if(!empty($request['attempted_answer'])){
            $request['attempt_status'] = TestAttemptStatus::ATTEMPTED->value;
        }
        $this->replace(
            [...$request]
        );
    }
}
