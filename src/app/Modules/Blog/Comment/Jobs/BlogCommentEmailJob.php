<?php

namespace App\Modules\Blog\Comment\Jobs;

use App\Modules\Blog\Comment\Mails\SendAdminBlogCommentEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Modules\Blog\Comment\Models\Comment;
use Illuminate\Support\Facades\Mail;

class BlogCommentEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected Comment $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Comment $data)
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
        Mail::to(config('mail.admin_email'))->send(new SendAdminBlogCommentEmail($this->data));
    }
}
