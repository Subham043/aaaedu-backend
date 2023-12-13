<?php

namespace App\Modules\Enquiry\VrddhiForm\Jobs;

use App\Modules\Enquiry\VrddhiForm\Mails\SendAdminVrddhiEnquiryEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Modules\Enquiry\VrddhiForm\Models\VrddhiForm;
use Illuminate\Support\Facades\Mail;

class VrddhiFormEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected VrddhiForm $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(VrddhiForm $data)
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
        Mail::to(config('mail.admin_email'))->send(new SendAdminVrddhiEnquiryEmail($this->data));
    }
}
