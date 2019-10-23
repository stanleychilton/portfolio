<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminNotification extends Mailable
{
    use Queueable, SerializesModels;

    //veriable for passing information value
    protected $information;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    

    public function __construct($information)
    {
        $this->information = $information;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        if($this->information[2] != "")
        {
            if($this->information[3] != "")
            {
                return $this->view('email.adminnotification')
                    ->with([
                    'subject' => $this->information[0],
                    'content' => $this->information[1],])
                    ->attach($this->information[2], [
                        'as' => $this->information[3],
                        'mime' => 'application/text',  
                    ])
                    ->subject("ITP Notification.");
            }
            else
            {
                return $this->view('email.adminnotification')
                    ->with([
                    'subject' => $this->information[0],
                    'content' => $this->information[1],])
                    ->attach($this->information[2])
                    ->subject("ITP Notification.");
            }
        }
        else
        {
            return $this->view('email.adminnotification')
                    ->with([
                    'subject' => $this->information[0],
                    'content' => $this->information[1],])
                    ->subject("ITP Notification.");
        }
    }
}
