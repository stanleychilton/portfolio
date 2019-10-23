<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Job;
use App\Models\Event;
use App\Models\Company;
use App\Models\Consultant;
use App\Models\TechGroup;
use App\Models\User;
use App\Models\Usertechgroup;
use App\Models\Mailinglist;
use App\Models\Address;

use App\Mail\DeletionNotice;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function()
        {
            //Carbon::now()->subDays(x) adds x number of days passed expiry
            // till it is collected for deletion.

            //delete expired jobs
            $outofDate = Job::where('expires_at', '<=',
                Carbon::now()->subDays(config('app.jobDeleteTime')))->get();
            foreach($outofDate as $expired)
            {
                $expired->delete();
            }

            //delete expired events
            $outofDate = Event::where('date', '<=',
                Carbon::now()->subDays(config('app.eventDeleteTime')))->get();
            foreach($outofDate as $expired)
            {
                //delete address
                $address = Address::find($expired->addresses_id);
                $expired->addresses_id = null;
                $expired->delete();
                $address->delete();
            }

            //delete expired company
            $outofDate = Company::where('expires_at', '<=',
                Carbon::now()->subMonths(config('app.companyDeleteTime')))->get();
            foreach($outofDate as $expired)
            {
                //remove and delete all jobs
                $jobs = Job::where('companyID', $expired->ID)->get();
                foreach($jobs as $job)
                {
                    $job->delete();
                }

                //remove user reference if not created by admin
                
                $user = User::where('comp_id', $expired->ID)->first();
                
                //admin woud return null here so check
                
                if($user != null)
                {
                    $user->comp_id = null;
                    $user->save();

                     //send user email about deletion.
                    if(Mailinglist::where('ID', $user->ID)->first() != null)
                    {
                        Mail::to($user)->send(new DeletionNotice($expired));
                    }
                }

               
                //delete address

                $address = Address::find($expired->address);
                $expired->address = null;
                $address->delete();

                //delete company

                if($expired->logo != 'noimage.jpg'){
                    // Delete image
                    Storage::delete('public/logos/'.$company->logo);
                }

                $expired->delete();
            }

            //delete expired consultant

            $outofDate = Consultant::where('expires_at', '<=',
                Carbon::now()->subMonths(config('app.consultantDeleteTime')))->get();
            foreach($outofDate as $expired)
            {
                $user = User::where('con_id', $expired->ID)->first();
    
                if($user != null)
                {
                    $user->con_id = null;
                    $user->save();

                    //send user email about deletion.
                    if(Mailinglist::where('ID', $user->ID) != null)
                    {
                        Mail::to($user)->send(new DeletionNotice($expired));
                    }
                }

                if($expired->logo != 'noimage.jpg'){
                    // Delete image
                    //Storage::delete('public/logos/'.$consultant->logo);
                }

                //delete address

                if($expired->address != null)
                {
                    $address = Address::find($expired->address);
                    $expired->addressID = null;
                    $expired->delete();
                    $address->delete();
                }
                else
                {
                    $expired->delete();
                }
            }

            $outofDate = TechGroup::where('expires_at', '<=',
                Carbon::now()->subMonths(config('app.techgroupDeleteTime')))->get();
            foreach($outofDate as $expired)
            {
                //delete user reference
                $usertech = Usertechgroup::where('Tech_id', $expired->ID)->first();

                if($usertech != null)
                {
                    $user = User::find($usertech->User_id);
                    //send email about deletion, if not admin.
                    if($user->type != User::ADMIN)
                    {
                        if(Mailinglist::where('ID', $user->ID)->first() != null)
                        {
                            Mail::to($user)->send(new DeletionNotice($expired));
                        }
                    }

                    $usertech->delete();  
                }

                //delete related events. :: Events used to be tied to tech groups.
                /*
                $events = Event::where('techgroupID', $expired->ID)->get();
                foreach($events as $event)
                {
                    $address = Address::find($event->addresses_id);
                    $event->addresses_id;
                    $event->delete();
                    $address->delete();
                }
                */
                
                //delete techgroup
                if($expired->logo != 'noimage.jpg'){
                    // Delete image
                    Storage::delete('public/logos/'.$expired->logo);
                }

                $expired->delete();
            }
            
        })->everyMinute();

        //send reminder email of out-of-date for expired companies
        $schedule->command('email:outofdate')->everyMinute();
        $schedule->command('email:jobsdigest')->everyMinute(); //have to create a custom cron for bi-weekly.
        $schedule->command('email:eventdigest')->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
