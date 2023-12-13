<?php

namespace App\Modules\AdmissionForm\Jobs;

use App\Modules\AdmissionForm\Mails\SendAdminNotPucEnquiryEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Modules\AdmissionForm\Models\AdmissionForm;
use Illuminate\Support\Facades\Mail;

class NotPucFormEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected AdmissionForm $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(AdmissionForm $data)
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
        Mail::to(config('mail.admin_email'))->send(new SendAdminNotPucEnquiryEmail($this->data));
    }
}
