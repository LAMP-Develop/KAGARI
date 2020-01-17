<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerSendmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $site_url;
    private $site_name;
    private $action_url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($site_url, $site_name, $action_url)
    {
        $this->site_url = $site_url;
        $this->site_name = $site_name;
        $this->action_url = $action_url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
        ->subject('アクセス解析ツール「KAGARI」｜レポート送付のお知らせ')
        ->markdown('mail.report-customer')
        ->with([
            'site_url' => $this->site_url,
            'site_name' => $this->site_name,
            'action_url' => $this->action_url,
        ]);
    }
}
