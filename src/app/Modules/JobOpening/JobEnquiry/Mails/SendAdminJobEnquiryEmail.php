<?php

namespace App\Modules\JobOpening\JobEnquiry\Mails;

use App\Modules\JobOpening\JobEnquiry\Models\JobEnquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendAdminJobEnquiryEmail extends Mailable
{
    use Queueable, SerializesModels;

    private JobEnquiry $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(JobEnquiry $data)
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
        return $this->subject(config('app.name').' - Job Enquiry')->view('emails.job_enquiry')->with([
            'data' => $this->data
        ]);
    }
}
