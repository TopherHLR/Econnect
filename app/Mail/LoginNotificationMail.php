<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Request;

class LoginNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $ip;
    public $time;

    public function __construct($user)
    {
        $this->user = $user;
        $this->ip = request()->ip();
        $this->time = now()->format('F j, Y, g:i a');
    }

    public function build()
    {
        return $this->subject('🔐 New Login to Your Econnect Account')
                    ->view('emails.login_notification');
    }
}
