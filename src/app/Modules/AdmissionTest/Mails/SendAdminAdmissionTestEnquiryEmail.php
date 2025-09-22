<?php

namespace App\Modules\AdmissionTest\Mails;

use App\Modules\AdmissionTest\Models\AdmissionTest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendAdminAdmissionTestEnquiryEmail extends Mailable
{
    use Queueable, SerializesModels;

    private AdmissionTest $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(AdmissionTest $data)
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
        return $this->subject(config('app.name').' - Admission Test Registration')->view('emails.registration_enquiry_admin')->with([
            'data' => $this->data
        ]);
    }
}
