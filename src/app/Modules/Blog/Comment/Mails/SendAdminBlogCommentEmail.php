<?php

namespace App\Modules\Blog\Comment\Mails;

use App\Modules\Blog\Comment\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendAdminBlogCommentEmail extends Mailable
{
    use Queueable, SerializesModels;

    private Comment $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Comment $data)
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
        return $this->subject(config('app.name').' - Blog Comment')->view('emails.blog_comment_enquiry')->with([
            'data' => $this->data
        ]);
    }
}
