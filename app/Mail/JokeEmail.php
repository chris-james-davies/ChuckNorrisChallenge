<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JokeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $joke;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($joke)
    {
        $this->joke = $joke;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.joke');
    }
}
