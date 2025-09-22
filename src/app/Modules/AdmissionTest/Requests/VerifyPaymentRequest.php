<?php

namespace App\Modules\AdmissionTest\Requests;

use App\Enums\PaymentStatus;
use App\Http\Services\RazorpayService;
use App\Modules\AdmissionTest\Models\AdmissionTest;
use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Stevebauman\Purify\Facades\Purify;


class VerifyPaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return AdmissionTest::where('razorpay_order_id', $this->razorpay_order_id)->where('payment_status', PaymentStatus::PENDING->value)->firstOrFail();
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
            'razorpay_payment_id' => ['required', 'string'],
            'razorpay_signature' => [
                'required',
                'string',
                function (string $attribute, mixed $value, Closure $fail) {
                    $verify_signature = (new RazorpayService)->payment_verify($this->safe()->only(['razorpay_order_id', 'razorpay_payment_id', 'razorpay_signature']));
                    if (!$verify_signature) {
                        $fail("Payment verification failed.");
                    }
                },
            ],
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
