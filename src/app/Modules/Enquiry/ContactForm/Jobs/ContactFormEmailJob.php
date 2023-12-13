<?php

namespace App\Modules\Enquiry\ContactForm\Jobs;

use App\Modules\Enquiry\ContactForm\Mails\SendAdminEnquiryEmail;
use App\Modules\Enquiry\ContactForm\Mails\SendUserThankyouEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Modules\Enquiry\ContactForm\Models\ContactForm;
use Illuminate\Support\Facades\Mail;

class ContactFormEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected ContactForm $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ContactForm $data)
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
        Mail::to($this->data['email'])->send(new SendUserThankyouEmail($this->data));
        Mail::to(config('mail.admin_email'))->send(new SendAdminEnquiryEmail($this->data));
    }
}
