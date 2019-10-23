<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

use App\Models\Event;
use App\Models\TechGroup;
use App\Models\User;
use App\Models\Mailinglist;
use App\Mail\EventsDigest;

use Carbon\Carbon;

class SendEventDigest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:eventdigest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send list of events and courses listed in the bast two weeks';

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
        $events = Event::where('created_at', ">=", Carbon::now()->subDays(config('app.eventDigestTime')))
        ->where('date', ">=", Carbon::now())->get();
        if(count($events) > 0)
        {
            $users = array();
            $userids = Mailinglist::All();
            foreach($userids as $id)
            {
                array_push($users, User::find($id));
            }
            foreach($users as $user)
            {
                Mail::to($user)->queue(new EventsDigest($events));
            }
        }
    }
}
