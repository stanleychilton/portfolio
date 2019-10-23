<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

use App\Models\Job;
use App\Models\User;
use App\Models\Mailinglist;
use App\Mail\JobsDigest;

use Carbon\Carbon;

class SendJobsDigestEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:jobsdigest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a bi-weekly email updating users on newly listed jobs';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $jobs = Job::where('created_at', '>=', Carbon::now()->subDays(config('app.jobDigestTime')))
            ->where('flag',1)->get();
        if(count($jobs) > 0)
        {
            $userids = Mailinglist::All();
            $users = array();
            foreach ($userids as $id)
            {
                array_push($users, User::find($id));
            }
            foreach ($users as $user)
            {
                Mail::to($user)->queue(new JobsDigest($jobs));
            }
        }
    }
}
