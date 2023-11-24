<?php

namespace App\Modules\Test\AnswerSheet\Requests;

use App\Enums\TestStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Stevebauman\Purify\Facades\Purify;


class EliminatedRequest extends FormRequest
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
            'reason' => ['required', 'string']
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
        $request['test_status'] = TestStatus::ELIMINATED->value;
        $this->replace(
            [...$request]
        );
    }
}
