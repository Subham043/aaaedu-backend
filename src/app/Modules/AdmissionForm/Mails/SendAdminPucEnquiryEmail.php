<?php

namespace App\Modules\AdmissionForm\Mails;

use App\Modules\AdmissionForm\Models\AdmissionForm;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendAdminPucEnquiryEmail extends Mailable
{
    use Queueable, SerializesModels;

    private AdmissionForm $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(AdmissionForm $data)
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
        return $this->subject(config('app.name').' - Admission - Class 11 or 1st PUC Enquiry')->view('emails.puc_enquiry')->with([
            'data' => $this->data
        ]);
    }
}
