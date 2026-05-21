<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $resetLink;
    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct($resetLink, $user)
    {
        $this->resetLink = $resetLink;
        $this->user = $user;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Reset Your Password - Academia')
                    ->view('emails.reset-password')
                    ->with([
                        'link' => $this->resetLink,
                        'userName' => $this->user->name,
                    ]);
    }
}