<?php

namespace App\Modules\Enquiry\EnrollmentForm\Jobs;

use App\Modules\Enquiry\EnrollmentForm\Mails\SendAdminEnrollmentEnquiryEmail;
use App\Modules\Enquiry\EnrollmentForm\Mails\SendUserEnrollmentRecieptEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Modules\Enquiry\EnrollmentForm\Models\EnrollmentForm;
use Illuminate\Support\Facades\Mail;

class EnrollmentFormEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected EnrollmentForm $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(EnrollmentForm $data)
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
        Mail::to($this->data->email)->send(new SendUserEnrollmentRecieptEmail($this->data));
        Mail::to(config('mail.admin_email'))->send(new SendAdminEnrollmentEnquiryEmail($this->data));
    }
}
