<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class RSVPMail extends Mailable
{

    public $text;
    public $secret;
    public $name;
    public $date;

    public function __construct($name, $text, $secret, $date)
    {
        $this->text = $text;
        $this->secret = $secret;
        $this->name = $name;
        $this->date = $date;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from(['address' => 'rltf77@gmail.com', 'name' => 'Toleranta si Fraternitate'])
            ->subject('Invitatie')
            ->markdown('rsvp_mail');
    }
}
