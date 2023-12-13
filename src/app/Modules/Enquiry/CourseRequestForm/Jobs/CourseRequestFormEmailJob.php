<?php

namespace App\Modules\Enquiry\CourseRequestForm\Jobs;

use App\Modules\Enquiry\CourseRequestForm\Mails\SendAdminCourseRequestEnquiryEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Modules\Enquiry\CourseRequestForm\Models\CourseRequestForm;
use Illuminate\Support\Facades\Mail;

class CourseRequestFormEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected CourseRequestForm $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(CourseRequestForm $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to(config('mail.admin_email'))->send(new SendAdminCourseRequestEnquiryEmail($this->data));
    }
}
