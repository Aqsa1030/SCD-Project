<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class EmailVerifiedByAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $admin;

    public function __construct(User $user, User $admin)
    {
        $this->user = $user;
        $this->admin = $admin;
    }

    public function build()
    {
        return $this->subject('Your Email Has Been Verified - Academia')
            ->view('emails.email-verified-by-admin');
    }
}