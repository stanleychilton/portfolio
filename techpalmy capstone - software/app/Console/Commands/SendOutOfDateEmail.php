<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Consultant;
use App\Models\TechGroup;
use App\Models\Usertechgroup;
use App\Models\Mailinglist;
use App\Mail\OutOfDate;

class SendOutOfDateEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:outofdate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Email user when a listing has gone out of date.';

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
        $companies = Company::where('expires_at', '<=', 
        Carbon::now())->where('flag', 1)->get();
        $consultants = Consultant::where('expires_at', '<=',
        Carbon::now())->where('flag', 1)->get();
        $techgroups = Techgroup::where('expires_at', '<=',
        Carbon::now())->where('flag', 1)->get();


        foreach($companies as $company)
        {
            $user = User::where('comp_id', $company->ID)->get()->first();
            $company->flag = 0;
            $company->save();

            //if the user is on the mailing list send them a reminder email.
            if(Mailinglist::where('ID', $user->ID) != null)
            {
                Mail::to($user)->send(new OutOfDate($company)); //change send to queue
            }
            
        }

        foreach($consultants as $consultant)
        {
            $user = User::where('con_id', $consultant->ID)->get()->first();
            $consultant->flag = 0;
            $consultant->save();
            //if the user is on the mailing list send them a reminder email.
            if(Mailinglist::where('ID', $user->ID) != null)
            {
                info($user);
                Mail::to($user)->send(new OutOfDate($consultant)); //change send to queue
            }
        }

        foreach($techgroups as $tech)
        {
            $user = User::where('ID',
                 Usertechgroup::where('Tech_id', $tech->ID)->first()->User_id)->first();
            $tech->flag = 0;
            $tech->save();
            if(Mailinglist::where('ID', $user->ID) != null)
            {
                Mail::to($user)->send(new OutOfDate($tech)); //change send to queue
            }
        }
    }
}
