<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Job; // Enables us to use any of the model functions.
use App\Models\Company; // Enables us to use any of the model functions.
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use DB; // allows us to use SQL instead of Eloquent

class JobController extends Controller
{
    // User must be logged in to view create & edit forms (so that we can check permissions).
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        // only display jobs that haven't expired.
        $jobs = Job::where('flag', 1)->where('expires_at', '>', \Carbon\Carbon::now())
                ->orderBy('created_at','asc')
                ->get();

        return view('jobs.index')->with('jobs',$jobs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        if(Auth::user()->type=='admin'){ // Admin can link jobs with any company they like.
            
            $companies = Company::where('flag',1)->pluck('name', 'ID');
            return view('jobs.create')->with('companies', $companies);

        } elseif(Auth::user()->comp_id !== NULL) { // User needs to be linked to a company

            $userscompanyflag = Company::find(Auth::user()->comp_id)->flag;

            if($userscompanyflag===0){    // User needs to be linked to an ACTIVE company
                return back()->with('error', 'Your company must be approved before you can post jobs.');

            }
            $userscompany = Company::where('ID',Auth::user()->comp_id)->pluck('name', 'ID');
            return view('jobs.create')->with('companies', $userscompany);
        }

        return back()->with('error', 'Only admins of currently active (listed) companies can create jobs.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'position' => 'required|max:100',
            'external_link' => 'required|max:150',
            'application_due_date' => 'required|max:50',
            'description' => 'required|max:5000'
        ]);


        // Create Job
        $job = new Job; //can use this because we import it at the top with use App\Company
        $job->companyID = $request->input('companyID');
        $job->position = $request->input('position');
        $job->description = $request->input('description');
        $job->external_link = $request->input('external_link');
        $job->application_due_date = $request->input('application_due_date');
        $job->tags = 1; //stops error 
        $job->flag = 1; // NEED TO CHANGE WHEN GOES LIVE!
        $job->created_at = \Carbon\Carbon::now(); # \Datetime()
        $job->updated_at = \Carbon\Carbon::now();  # \Datetime()
        $job->expires_at = \Carbon\Carbon::parse($job->application_due_date)->addDays(config('app.jobExpiryTime'));
        $job->save();

        return redirect('/jobs')->with('success', 'Job Created');
         // displays a success message after submitting form.
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { 
        $display = false;

        $job = Job::find($id);

        if(Auth::user() && (Auth::user()->comp_id === $job->company->ID || Auth::user()->type=='admin'))
        {
            $display = true;
        }

        return view('jobs.show')->with(compact('job','display'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
        $job = Job::find($id);

        if(Auth::user()->type=='admin'){ // Admin can edit any job they like.

            $companies = Company::where('flag',1)->pluck('name', 'ID');
            return view('jobs.edit')->with(compact('job','companies'));

        } elseif(Auth::user()->comp_id === $job->company->ID) { // User needs to be linked to a company

            $userscompany = Company::where('ID',Auth::user()->comp_id)->pluck('name', 'ID');
            return view('jobs.edit')->with('companies', $userscompany)->with('job', $job);
        }

        return back()->with('error', 'You can only edit your company\'s jobs');

        // $job = Job::find($id);
        // // $companies = Company::pluck('name', 'ID');
        // // return view('jobs.edit')->with('job', $job)->with('companies', $companies);
        // return view('jobs.edit')->with(compact('job','companies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'position' => 'required|max:100',
            'external_link' => 'required|max:150',
            'application_due_date' => 'required|max:50',
            'description' => 'required|max:5000'
        ]);

        // // Handle File Upload
        // if($request->hasFile('logo')){// Check to see if it was actually uploaded (user clicked upload)
        //     // Get filename with the extension
        //     $filenameWithExt = $request->file('logo')->getClientOriginalName(); // This will get the exact file name.
        //     // Get just filename
        //     $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        //     // Get just ext
        //     $extension = $request->file('logo')->getClientOriginalExtension();
        //     // Filename to store
        //     $fileNameToStore = $filename.'_'.time().'.'.$extension; // adds a timestamp, making the filename completely unique meaning
        //     // can have two of the same images.

        //     // Upload image to storage/app/public/logos folder (& in public/logos) that gets created if it doesn't exist yet.
        //     $path = $request->file('logo')->storeAs('public/logos', $fileNameToStore);
        // }

        
        // update job 
        $job = Job::find($id); //can use this because we import it at the top with use App\Listing
        $job->position = $request->input('position');
        $job->description = $request->input('description');
        $job->external_link = $request->input('external_link');
        $job->application_due_date = $request->input('application_due_date');
        $job->tags = 1; //stops error 
        $job->flag = 1; // NEED TO CHANGE WHEN GOES LIVE!
        $job->updated_at = \Carbon\Carbon::now();
        $job->expires_at = \Carbon\Carbon::parse($job->application_due_date)->addDays(config('app.jobExpiryTime'));
        $job->save();

        return redirect('/jobs')->with('success', 'Job Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $job = Job::find($id);
        if(Auth::user()->ID == User::where('comp_id', $job->companyID)->first->ID
             || Auth::user()->type=='admin')
        {
            $job->companyID = null;
            $job->flag = 0;
            $job->expires_at = Carbon::now();
            $job->save();
        }
        return redirect('/jobs')->with('success', 'Job Removed');
    }
}
