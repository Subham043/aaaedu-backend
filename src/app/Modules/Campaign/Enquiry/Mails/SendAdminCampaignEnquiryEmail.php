<?php

namespace App\Modules\Campaign\Enquiry\Mails;

use App\Modules\Campaign\Enquiry\Models\Enquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendAdminCampaignEnquiryEmail extends Mailable
{
    use Queueable, SerializesModels;

    private Enquiry $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Enquiry $data)
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
        return $this->subject(config('app.name').' - Campaign Enquiry')->view('emails.campaign_enquiry')->with([
            'data' => $this->data
        ]);
    }
}
