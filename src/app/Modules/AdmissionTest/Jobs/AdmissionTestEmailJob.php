<?php

namespace App\Modules\AdmissionTest\Jobs;

use App\Modules\AdmissionTest\Mails\SendAdminAdmissionTestEnquiryEmail;
use App\Modules\AdmissionTest\Mails\SendUserAdmissionTestEnquiryEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Modules\AdmissionTest\Models\AdmissionTest;
use Illuminate\Support\Facades\Mail;

class AdmissionTestEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected AdmissionTest $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(AdmissionTest $data)
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
        Mail::to($this->data->email)->send(new SendUserAdmissionTestEnquiryEmail($this->data));
        Mail::to(config('mail.admin_email'))->send(new SendAdminAdmissionTestEnquiryEmail($this->data));
    }
}
