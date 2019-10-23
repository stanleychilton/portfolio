<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EventsDigest extends Mailable
{
    use Queueable, SerializesModels;

    protected $events;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($events)
    {
        $this->events = $events;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.eventsdigest')
        ->subject('New Events and Courses')
        ->with([
            'events' => $this->events,
            ]);
    }
}
