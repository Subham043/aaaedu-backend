<?php

namespace App\Modules\Campaign\Enquiry\Jobs;

use App\Modules\Campaign\Enquiry\Mails\SendAdminCampaignEnquiryEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Modules\Campaign\Enquiry\Models\Enquiry;
use Illuminate\Support\Facades\Mail;

class CampaignFormEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected Enquiry $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Enquiry $data)
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
        Mail::to(config('mail.admin_email'))->send(new SendAdminCampaignEnquiryEmail($this->data));
    }
}
