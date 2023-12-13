<?php

namespace App\Modules\Enquiry\CourseRequestForm\Mails;

use App\Modules\Enquiry\CourseRequestForm\Models\CourseRequestForm;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendAdminCourseRequestEnquiryEmail extends Mailable
{
    use Queueable, SerializesModels;

    private CourseRequestForm $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(CourseRequestForm $data)
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
        return $this->subject(config('app.name').' - Course Reuqest Callback Enquiry')->view('emails.course_request_enquiry')->with([
            'data' => $this->data
        ]);
    }
}
