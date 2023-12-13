<?php

namespace App\Modules\Enquiry\EnrollmentForm\Mails;

use App\Modules\Enquiry\EnrollmentForm\Models\EnrollmentForm;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendUserEnrollmentRecieptEmail extends Mailable
{
    use Queueable, SerializesModels;

    private EnrollmentForm $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(EnrollmentForm $data)
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
        return $this->subject(config('app.name').' - Enrollment Reciept')->view('emails.enrollment_reciept')->with([
            'data' => $this->data
        ]);
    }
}
