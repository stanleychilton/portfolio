<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company; // Enables us to use any of the model functions.
use App\Models\Consultant; 
use App\Models\Job; 
use App\Models\Event;
use App\Models\TechGroup;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
// use Illuminate\Pagination\Paginator;
use DB;
use Carbon\Carbon;  // To save writing the namespace each time

/**
 * This controller goes to the database and counts how many active listings the site has,
 * how many events have been run, how many listings are getting 'out of date',
 * and information like when site maintenance was last done.
 * It passes this information to a view.
 */


class SiteGovernance extends Controller
{
    /**
     *
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     */
    
    public function __construct()
    {
        // $this->middleware('auth');  // Don't actually want user to be sent to login page if they try access /sitegovernance as a guest,
        // because this shows them that there is a page, even if after they log in they're sent a 404 error. Instead,
        // guests are just shown 404 error, and admin needs to realize they must login to access admin part of website.
        $this->middleware('abort_if_guest');
        $this->middleware('is_admin');
    }

    public function info(Request $request)
    {
        // How many listings we have
        $ncompanies = Company::where('flag', 1)->count();
        $nconsultants = Consultant::where('flag', 1)->count();
        $pendingcompanies = Company::where('flag', 0)->count();
        $pendingconsultants = Consultant::where('flag', 0)->count();

        // How many events have been run
        $neventsrun =  Event::where('date', '<', Carbon::now()->toDateString())->count();
        // $temp = Event::all()->first();

        // How many listings are getting 'out of date' (List table with all listings sorted by expiry date)
        $page = LengthAwarePaginator::resolveCurrentPage();
        $paginate = 10;
        $expiringcompanies = Company::select('ID','name','expires_at')->where('flag',1)
                                    ->where('expires_at','>',Carbon::now()) // Shouldn't need this line as flag is set to 0 after it expires
                                    ->where('expires_at','<',Carbon::now()->addMonths(config('app.soonExpireCompany'))) // Show companies expiring within 2 months
                                    ->addSelect(DB::raw("'companies' as type"));
        $expiringconsultants = Consultant::select('ID','name','expires_at')->where('flag',1)
                                    ->where('expires_at','>',Carbon::now()) // Shouldn't need this line as flag is set to 0 after it expires
                                    ->where('expires_at','<',Carbon::now()->addMonths(config('app.soonExpireConsultant'))) // Show consultants expiring within a month
                                    ->addSelect(DB::raw("'consultants' as type"));
        $expiringtechgroups = TechGroup::select('ID','name','expires_at')->where('flag',1)
                                    ->where('expires_at','>',Carbon::now()) // once flag works off expires won't need this
                                    ->where('expires_at','<',Carbon::now()->addMonths(config('app.soonExpireTechGroup'))) // Show techgroups expiring within a month
                                    ->addSelect(DB::raw("'techgroups' as type"));
        $expiringevents = Event::select('ID','name','date')->where('date', '<', Carbon::now()->toDateString())
                                    ->where('date', '>', Carbon::now()->subDays(config('app.soonExpireEvent'))->toDateString()) 
                                    // Event expiry date is 7 days after it has been held, so see if the date held lies between now and 7 days ago.
                                    ->addSelect(DB::raw("'events' as type"));
        $expiringjobs = Job::select('ID','position','expires_at')->where('flag',1) // note position gets renamed to name
                                    ->where('expires_at','>',Carbon::now()) // once flag works off expires won't need this
                                    ->where('expires_at','<',Carbon::now()->subDays(config('app.soonExpireJob'))) // Show jobs expiring in 14 days. 
                                    // Note that this will show jobs where the application due date was 1-14 days ago.
                                    ->addSelect(DB::raw("'jobs' as type"));

        $combinedlistings = $expiringcompanies->union($expiringconsultants)
                                                ->union($expiringtechgroups)
                                                ->union($expiringevents)
                                                ->union($expiringjobs)
                                                ->orderBy('expires_at', 'asc')
                                                ->get();
        // Notes: When doing union, it renames the columns in the second query to be the same as the first query, BUT still keeps the right values.
        // For example, the date column in second query becomes 'updated_at', but still holds value of date. This is beneficial because
        // when pulling jobs now, we can generalize the view to just call name on the collection of listings and it'll still work on job listings
        // even though jobs use 'position' instead of 'name'. 


        // This will contain all expiring listings to be sent to the view
        $expiringlistings = array();

        $collection = new Collection($combinedlistings);
        $slice = $collection->slice(($page-1) * $paginate, $paginate)->all();
        
        //Create our paginator and add it to the data array
        $expiringlistings['combinedlistings'] = new LengthAwarePaginator($slice, count($collection), $paginate);
        $expiringlistings['combinedlistings']->setPath($request->url());


        // $slice = array_slice($combinedlistings->toArray(), $paginate * ($page - 1), $paginate);
        // $expiringlistings = Paginator::make($slice, count($combinedlistings), $paginate);

        // TODO: When site maintenance was last done.
        return view('admin.sitegovernance', compact('ncompanies', 'nconsultants', 'pendingcompanies', 'pendingconsultants',
        'expiringlistings', 'neventsrun'));
        // return view('pages.sitegovernance')->with(compact('ncompanies', 'nconsultants', 'pendingcompanies', 'pendingconsultants',
        //                                         'expiringlistings', 'neventsrun'));
    }

    public function showpendinglistings(Request $request)
    {   
        $page = LengthAwarePaginator::resolveCurrentPage();
        $paginate = 20;

        $pendingcompanies = Company::select('ID','name','created_at','description','flag')->where('flag', 0)
                                    ->where('expires_at', '>', Carbon::now())
                                    ->addSelect(DB::raw("'companies' as type"));
        $pendingconsultants = Consultant::select('ID','name','created_at','description','flag')->where('flag', 0)
                                    ->where('expires_at', '>', Carbon::now())
                                    ->addSelect(DB::raw("'consultants' as type"));
        $pendingtechgroups = TechGroup::select('ID','name','created_at','description','flag')->where('flag', 0)
                                    ->where('expires_at', '>', Carbon::now())
                                    ->addSelect(DB::raw("'techgroups' as type"));

        $combinedpending = $pendingcompanies->union($pendingconsultants)
                                                ->union($pendingtechgroups)
                                                ->orderBy('created_at', 'desc')
                                                ->get();

        $pendinglistings = array();

        $collection = new Collection($combinedpending);
        $slice = $collection->slice(($page-1) * $paginate, $paginate)->all();
        
        //Create our paginator and add it to the data array
        $pendinglistings['combinedpending'] = new LengthAwarePaginator($slice, count($collection), $paginate);
        $pendinglistings['combinedpending']->setPath($request->url());

        return view('admin.pendinglistings', compact('pendinglistings'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function flaglisting(Request $request)
    {
        $model = app("App\Models\\$request->model");
        $listing = $model::find($request->id);
        $listing->flag = $request->flag;
        $listing->save();
        if($request->flag==1){
            return redirect('/admin/pendinglistings')->with('success', 'Listing is now approved & displayed on the website.');
        } else{
            return back()->with('success', 'Listing is now hidden from the public on the website.');
        }
        
    }

}
