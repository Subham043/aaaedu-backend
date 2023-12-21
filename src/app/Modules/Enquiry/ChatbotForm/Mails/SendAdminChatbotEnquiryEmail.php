<?php

namespace App\Modules\Enquiry\ChatbotForm\Mails;

use App\Modules\Enquiry\ChatbotForm\Models\ChatbotForm;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendAdminChatbotEnquiryEmail extends Mailable
{
    use Queueable, SerializesModels;

    private ChatbotForm $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ChatbotForm $data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(config('app.name').' - Chatbot Enquiry')->view('emails.chatbot_enquiry')->with([
            'data' => $this->data
        ]);
    }
}
