<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Company;

class JobsDigest extends Mailable
{
    use Queueable, SerializesModels;


    protected $jobs;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($jobs)
    {
        $this->jobs = $jobs;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.jobsdigest')
                ->subject('New Job Listings')
                ->with([
                    'jobs' => $this->jobs,
                    ]);
    }
}
