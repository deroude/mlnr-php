<?php

namespace App\Jobs;

use App\Domain\RSVP;
use App\Mail\RSVPMail;
use Illuminate\Support\Facades\Mail;

class MailSender extends Job
{

    private $rsvp;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(RSVP $rsvp)
    {
        $this->rsvp = $rsvp;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->rsvp->user->email)->send(new RSVPMail($this->rsvp));
    }
}
