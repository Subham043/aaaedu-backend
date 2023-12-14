<?php

namespace App\Modules\Test\AnswerSheet\Mails;

use App\Modules\Test\AnswerSheet\Models\TestTaken;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendUserTestApplyEmail extends Mailable
{
    use Queueable, SerializesModels;

    private TestTaken $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(TestTaken $data)
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
        return $this->subject(config('app.name').' - Online Test Reciept')->view('emails.test_reciept')->with([
            'data' => $this->data
        ]);
    }
}
