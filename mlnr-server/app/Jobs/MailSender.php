<?php

namespace App\Jobs;

use App\Mail\RSVPMail;
use Illuminate\Support\Facades\Mail;

class MailSender extends Job
{

    private $email;
    private $text;
    private $secret;
    private $name;
    private $date;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $name, $text, $secret, $date)
    {
        $this->email = $email;
        $this->text = $text;
        $this->$secret = $secret;
        $this->name = $name;
        $this->date = $date;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)->send(new RSVPMail($this->name, $this->text, $this->secret, $this->date));
    }
}
