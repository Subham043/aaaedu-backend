<?php

namespace App\Modules\Test\AnswerSheet\Requests;

use App\Enums\PaymentStatus;
use App\Modules\Test\AnswerSheet\Models\TestTaken;
use Illuminate\Foundation\Http\FormRequest;
use Stevebauman\Purify\Facades\Purify;


class CancelPaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && TestTaken::where('razorpay_order_id', $this->razorpay_order_id)->where('payment_status', PaymentStatus::PENDING->value)->where('is_enrolled', false)->where('user_id', auth()->user()->id)->firstOrFail();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'razorpay_order_id' => ['required', 'string'],
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