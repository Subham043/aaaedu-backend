<?php

namespace App\Modules\Enquiry\SubscriptionForm\Mails;

use App\Modules\Enquiry\SubscriptionForm\Models\SubscriptionForm;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendAdminSubscriptionEnquiryEmail extends Mailable
{
    use Queueable, SerializesModels;

    private SubscriptionForm $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(SubscriptionForm $data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(config('app.name').' - Subscription Enquiry')->view('emails.subscription_enquiry')->with([
            'data' => $this->data
        ]);
    }
}
