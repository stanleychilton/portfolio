<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeletionNotice extends Mailable
{
    use Queueable, SerializesModels;

    protected $model;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.delete')
        ->subject('A listing has been deleted.')
        ->with([
            'name' => $this->model->name,
        ]);
    }
}
