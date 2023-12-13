<?php

namespace App\Modules\Enquiry\SubscriptionForm\Jobs;

use App\Modules\Enquiry\SubscriptionForm\Mails\SendAdminSubscriptionEnquiryEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Modules\Enquiry\SubscriptionForm\Models\SubscriptionForm;
use Illuminate\Support\Facades\Mail;

class SubscriptionFormEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected SubscriptionForm $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(SubscriptionForm $data)
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
        Mail::to(config('mail.admin_email'))->send(new SendAdminSubscriptionEnquiryEmail($this->data));
    }
}
