<?php

namespace App\Modules\Enquiry\ScholarForm\Mails;

use App\Modules\Enquiry\ScholarForm\Models\ScholarForm;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendAdminScholarEnquiryEmail extends Mailable
{
    use Queueable, SerializesModels;

    private ScholarForm $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ScholarForm $data)
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
        return $this->subject(config('app.name').' - Day Scholar / Residential Enquiry')->view('emails.scholar_enquiry')->with([
            'data' => $this->data
        ]);
    }
}
