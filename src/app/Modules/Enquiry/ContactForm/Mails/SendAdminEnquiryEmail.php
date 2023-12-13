<?php

namespace App\Modules\Enquiry\ContactForm\Mails;

use App\Modules\Enquiry\ContactForm\Models\ContactForm;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendAdminEnquiryEmail extends Mailable
{
    use Queueable, SerializesModels;

    private ContactForm $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ContactForm $data)
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
        return $this->subject(config('app.name').' - New Enquiry')->view('emails.enquiry')->with([
            'data' => $this->data
        ]);
    }
}
