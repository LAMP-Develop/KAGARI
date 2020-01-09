<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FormAdminSendmail extends Mailable
{
    use Queueable, SerializesModels;

    private $email;
    private $name;
    private $cause;
    private $enquete;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($inputs)
    {
        $this->email = $inputs['email'];
        $this->name = $inputs['name'];
        $this->cause = $inputs['cause'];
        $this->enquete = $inputs['enquete'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
        ->subject('【KAGARI】退会申請がありました')
        ->view('form.unsubsc-admin-mail')
        ->with([
            'email' => $this->email,
            'name' => $this->name,
            'cause' => $this->cause,
            'enquete' => $this->enquete
        ]);
    }
}
