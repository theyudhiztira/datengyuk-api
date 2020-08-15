<?php

namespace App\Jobs\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendVerificationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    private $payload;

    public function __construct($payload)
    {
        $this->payload = $payload;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $emailData = [
            'file' => 'emails.verification',
            'data' => [
                'from'      => ['address' => 'noreply@dipandu.id', 'name' => 'DiPandu'],
                'email'     => $this->payload->email,
                'subject'   => '[DiPandu] Activate your account',
                'data'      => $this->payload->token
            ]
        ];

        $mail = new \App\Mail\MailGenerator($emailData);
        return \Mail::to($this->payload->email)->send($mail);
    }
}
