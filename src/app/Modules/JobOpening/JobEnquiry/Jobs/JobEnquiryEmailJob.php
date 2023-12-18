<?php

namespace App\Modules\JobOpening\JobEnquiry\Jobs;

use App\Modules\JobOpening\JobEnquiry\Mails\SendAdminJobEnquiryEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Modules\JobOpening\JobEnquiry\Models\JobEnquiry;
use Illuminate\Support\Facades\Mail;

class JobEnquiryEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected JobEnquiry $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(JobEnquiry $data)
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
        Mail::to(config('mail.admin_email'))->send(new SendAdminJobEnquiryEmail($this->data));
    }
}
