<?php

namespace App\Modules\Enquiry\ChatbotForm\Jobs;

use App\Modules\Enquiry\ChatbotForm\Mails\SendAdminChatbotEnquiryEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Modules\Enquiry\ChatbotForm\Models\ChatbotForm;
use Illuminate\Support\Facades\Mail;

class ChatbotFormEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected ChatbotForm $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ChatbotForm $data)
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
        Mail::to(config('mail.admin_email'))->send(new SendAdminChatbotEnquiryEmail($this->data));
    }
}
