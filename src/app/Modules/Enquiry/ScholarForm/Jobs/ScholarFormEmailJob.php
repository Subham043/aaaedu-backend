<?php

namespace App\Modules\Enquiry\ScholarForm\Jobs;

use App\Modules\Enquiry\ScholarForm\Mails\SendAdminScholarEnquiryEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Modules\Enquiry\ScholarForm\Models\ScholarForm;
use Illuminate\Support\Facades\Mail;

class ScholarFormEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected ScholarForm $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ScholarForm $data)
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
        Mail::to(config('mail.admin_email'))->send(new SendAdminScholarEnquiryEmail($this->data));
    }
}
