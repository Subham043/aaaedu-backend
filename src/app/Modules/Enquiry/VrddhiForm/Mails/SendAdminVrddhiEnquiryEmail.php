<?php

namespace App\Modules\Enquiry\VrddhiForm\Mails;

use App\Modules\Enquiry\VrddhiForm\Models\VrddhiForm;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendAdminVrddhiEnquiryEmail extends Mailable
{
    use Queueable, SerializesModels;

    private VrddhiForm $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(VrddhiForm $data)
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
        return $this->subject(config('app.name').' - Vrddhi Enquiry')->view('emails.vrddhi_enquiry')->with([
            'data' => $this->data
        ]);
    }
}
