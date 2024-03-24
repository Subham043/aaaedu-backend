<?php

namespace App\Modules\Enquiry\EnrollmentForm\Requests;

use App\Enums\PaymentStatus;
use App\Modules\Enquiry\EnrollmentForm\Models\EnrollmentForm;
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
        return EnrollmentForm::where('razorpay_order_id', $this->razorpay_order_id)->where('payment_status', PaymentStatus::PENDING->value)->firstOrFail();
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