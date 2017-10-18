<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    protected $token;

    public $subject = '重置密码';
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        //
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url = url('password/reset', $this->token);

        return $this->view('emails.password.reset', compact('url'));
    }
}
