<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailGenerator extends Mailable
{
    use Queueable, SerializesModels;

    protected $parameters;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($parameters)
    {
        //
        $this->file = $parameters['file'];
        $this->data = $parameters['data'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->to($this->data['email']);
        $this->from(isset($this->data['from']) ? $this->data['from'] : ['address' => 'noreply@myvios.cloud', 'name' => 'DiPandu']);

        if (isset($this->data['cc']) && !empty($this->data['cc'])) {
            $this->cc([$this->data['cc']]);
        }

        if (isset($this->data['bcc']) && !empty($this->data['bcc'])) {
            $this->bcc([$this->data['bcc']]);
        }

        if (isset($this->data['attach']) && !empty($this->data['attach'])) {
            $this->attach($this->data['attach']);
        }

        $this->subject($this->data['subject'] ? $this->data['subject'] : 'vOffice Automated Email');
        $this->view($this->file)->with([
            'data' => $this->data['data']
        ]);

        return $this;
    }
}
