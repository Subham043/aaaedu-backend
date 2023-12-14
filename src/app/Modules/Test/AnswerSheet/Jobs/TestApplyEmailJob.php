<?php

namespace App\Modules\Test\AnswerSheet\Jobs;

use App\Modules\Test\AnswerSheet\Mails\SendAdminTestApplyEmail;
use App\Modules\Test\AnswerSheet\Mails\SendUserTestApplyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Modules\Test\AnswerSheet\Models\TestTaken;
use Illuminate\Support\Facades\Mail;

class TestApplyEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected TestTaken $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(TestTaken $data)
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
        Mail::to($this->data->user->email)->send(new SendUserTestApplyEmail($this->data));
        Mail::to(config('mail.admin_email'))->send(new SendAdminTestApplyEmail($this->data));
    }
}
