<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmailMail extends Mailable
{
    use Queueable, SerializesModels;

    public $verificationLink;
    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct($verificationLink, $user)
    {
        $this->verificationLink = $verificationLink;
        $this->user = $user;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Verify Your Email Address - Academia')
                    ->view('emails.verify-email')
                    ->with([
                        'link' => $this->verificationLink,
                        'userName' => $this->user->name,
                    ]);
    }
}