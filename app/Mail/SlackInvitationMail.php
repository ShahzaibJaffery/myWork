<?php

namespace App\Mail;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SlackInvitationMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    public $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $data )
    {
        $this->name = $data['fname'];

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       return $this->subject('Slack Invitation')
         ->view('emails.slackmail',['name' => $this->name]);
    }
}
