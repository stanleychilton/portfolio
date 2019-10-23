<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mailinglist;

use App\Models\Company;
use App\Models\Consultant; 
use App\Models\Job; 
use App\Models\Event;
use App\Models\TechGroup;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

use DB;
use Carbon\Carbon;


class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //this controllers the loading and displaying of user profiles.
    public function show()
    {
        $user = Auth::user();
        $page = LengthAwarePaginator::resolveCurrentPage();
        $paginate = 20;

        $company = Company::select('ID','name','flag','created_at','updated_at')
                            ->where('ID',Auth::user()->comp_id)
                            ->addSelect(DB::raw("'companies' as type"));
        $consultant = Consultant::select('ID','name','flag','created_at','updated_at')
                            ->where('ID',Auth::user()->con_id)
                            ->addSelect(DB::raw("'consultants' as type"));

        $userstechgroups = $user->techgroups;
        $userstechgroupsids = $userstechgroups->map(function ($user) {
            return $user->only(['ID']);
        });
        $techgroups = Techgroup::select('ID','name','flag','created_at','updated_at')
                            ->whereIn('ID',$userstechgroupsids)
                            ->addSelect(DB::raw("'techgroups' as type"));

        $events = Event::where('users_id',$user->ID)
                        ->select('ID','name','date','created_at','updated_at')
                        ->where('date', '>', Carbon::now()->subDays(30)->format('Y/M/D')) 
                        // user can't see their events 30 days after they've been run.
                        ->addSelect(DB::raw("'events' as type"));

        $jobs = Job::where('companyID',$user->comp_id)
                    ->select('ID','position','expires_at','created_at','updated_at')
                    ->where('expires_at','>',Carbon::now()->subDays(60)) // User can see their jobs up to 30 days after expiry.
                    ->addSelect(DB::raw("'jobs' as type"));

        // Break company,consultant,techgroups into it's own query, and jobs + events in the other.
        // Don't need paginator as user cannot have more than 1 company or consultant, can't have many techgroups or events,
        // and is expected to not list more than say a thousand jobs at once 
        // (pretty fair assumption since user needs to have a brain to get their company approved and so be able to create jobs).

        $CCT = $company->union($consultant)
                        ->union($techgroups)
                        ->orderBy('created_at', 'asc')
                        ->get();

        $eventsjobs = $events->union($jobs)->orderBy('date', 'asc')->get();

        if($user->type === User::ADMIN)
        {
            return view('users.admin')->with(compact('user', 'CCT', 'eventsjobs'));
        }
        
        return view('users.show')->with(compact('user', 'CCT', 'eventsjobs'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('users.edit')->with('user', $user);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'terms_and_conditions' => 'accepted'
        ]);
            

        // Add/remove user from mailing list.
        if($request->has('join_mailing_list'))
        {
            if(Mailinglist::where('ID',$user->ID)->exists() === false)
            {
                $mailinglist = new Mailinglist();
                $mailinglist->ID = $user->ID;
                $mailinglist->save();
            }
        }
        else if(Mailinglist::where('ID',$user->ID)->exists() === true)
        {
            $mailinglist = Mailinglist::find($user->ID);
            $mailinglist->delete();
        }

        // update 
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->updated_at = \Carbon\Carbon::now();  # \Datetime()
        $user->save();
        
        return redirect('/user')->with('success', 'Profile Updated');
    }

}
