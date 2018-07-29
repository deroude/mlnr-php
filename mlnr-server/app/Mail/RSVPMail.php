<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use App\Domain\RSVP;

class RSVPMail extends Mailable
{

    public $rsvp;

    public function __construct(RSVP $rsvp)
    {
        $this->rsvp = $rsvp;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('rsvp.mail');
    }
}
