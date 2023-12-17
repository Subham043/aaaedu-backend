<?php

namespace App\Modules\Test\Questionarie\Requests;

use App\Enums\CorrectAnswer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Validation\Rules\Enum;


class QuestionarieRequest extends FormRequest
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
            'question' => 'required|string',
            'question_unfiltered' => 'required|string',
            'answer_1' => 'required|string',
            'answer_1_unfiltered' => 'required|string',
            'answer_2' => 'required|string',
            'answer_2_unfiltered' => 'required|string',
            'answer_3' => 'required|string',
            'answer_3_unfiltered' => 'required|string',
            'answer_4' => 'required|string',
            'answer_4_unfiltered' => 'required|string',
            'correct_answer' => ['required', new Enum(CorrectAnswer::class)],
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
        $this->replace(
            [...$request]
        );
    }
}
