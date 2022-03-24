<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewPostCreateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $newPostInfo;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($_newPostInfo)
    {
        $this->newPostInfo = $_newPostInfo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Nuovo post')->view('mails.newPostCreateMail');
    }
}
