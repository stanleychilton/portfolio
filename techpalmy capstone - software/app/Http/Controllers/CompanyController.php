<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Company; // Enables us to use any of the model functions.
use App\Models\Address;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use DB; // allows us to use SQL instead of Eloquent
use App\Models\Job;
use Carbon\Carbon;

class CompanyController extends Controller
{
    public function __construct()
    {
        
        $this->middleware('auth', ['except' => ['index','show','studentcompanies']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::where('flag', 1)->get();
        
        return view('companies.index')->with('companies',$companies);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->comp_id === NULL || Auth::user()->type == 'admin')
        {
            return view('companies.create');
        }
        return back()->with('error', 'This account has already created a company.
        Only one company can be linked to each account.');
        //return redirect('/companies')->with('error', 'This account has already created a company.
        // Only one company can be linked to each account.');
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
            'name' => 'required|max:100',
            'description' => 'required|max:5000',
            'website' => 'required|max:100',
            'logo' => 'image|nullable|max:1999', // Has to be a jpeg, gif, etc, but don't require an image (max size = 1999 kb)
            'industry' => 'required|max:250',
            'technology' => 'required|max:250',
            'business' => 'nullable|max:200',
            'contact_name' => 'required|max:50',
            'contact_email' => 'required|max:100',
            'contact_number' => 'required|max:50',
            'phone' => 'required|max:50',
            'email' => 'required|max:100',
            'terms_and_conditions' => 'accepted',
            'address1' => 'required|max:500',
            'postalcode' => 'required|max:50',
            'city' => 'required|max:100'
        ]);

        // Handle File Upload
        if($request->hasFile('logo')){// Check to see if it was actually uploaded (user clicked upload)
            // Get filename with the extension
            $filenameWithExt = $request->file('logo')->getClientOriginalName(); // This will get the exact file name.
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('logo')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension; // adds a timestamp, making the filename completely unique meaning
            // can have two of the same images.

            // Upload image to storage/app/public/logos folder (& in public/logos) that gets created if it doesn't exist yet.
            $path = $request->file('logo')->storeAs('public/logos', $fileNameToStore);
        } else {
            // If they don't upload an image, it will use this default image in the company logo.
            $fileNameToStore = 'noimage.jpg';
        }

        //create company address for the address table
        $address = new Address;
        $address->address1 = $request->input('address1');
        $address->address2 = $request->input('address2');
        $address->city = $request->input('city');
        $address->region = $request->input('region');
        $address->postalcode = $request->input('postalcode');
        $address->save();

        // Create Company
        $company = new Company; //can use this because we import it at the top with use App\Company
        $company->name = $request->input('name');
        $company->description = strip_tags($request->input('description'));
        $company->website = $request->input('website');
        $company->address = $address->ID; //link this company to the address ID.
        $company->tags = 1; //stops error 
        $company->phone = $request->input('phone');
        $company->email = $request->input('email');
        $company->contact_name = $request->input('contact_name'); // the three requirements for admin contact
        $company->contact_email = $request->input('contact_email'); // the three requirements for admin contact
        $company->contact_number = $request->input('contact_number'); // the three requirements for admin contact
        $company->internships = $request->has('internships')?1:0;
        $company->industry = $request->input('industry');
        $company->technology = $request->input('technology');
        $company->business = $request->input('business');
        $company->company_size = $request->input('company_size');
        $company->flag = 0; // NEED TO CHANGE WHEN GOES LIVE!
        $company->created_at = \Carbon\Carbon::now();
        $company->updated_at = \Carbon\Carbon::now();
        $company->expires_at = \Carbon\Carbon::now()->addMonths(config('app.companyExpiryTime'));
        $company->logo = $fileNameToStore;
        $company->save();

        //link company to user.
        $user = Auth::user();
        if($user->type != User::ADMIN)
        {
            $user->comp_id = $company->ID;
            $user->save();
        }

        return redirect('/companies')->with('success', 'Company has been created. Note that the website admin must approve this listing before it can be displayed publicly on the website.');
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
        
        if(Auth::user() && (Auth::user()->comp_id == $id || Auth::user()->type == 'admin'))
        {
            $display = true;
        }

        $company = Company::find($id);
        $address = Address::find($company->address);
        return view('companies.show')->with(compact('company','address','display'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        //$id here evaluates to 'int' rather than int i.e. '5' instead of 5. So I user == instead of ===.
        //Could this lead to security vulnerabilities? 
        if(Auth::user()->comp_id == $id || Auth::user()->type == 'admin')
        {
            $company = Company::find($id);
            $address = Address::find($company->address);
            return view('companies.edit')->with(compact('company','address'));
        }
        return back()->with('error','You must be admin of this company to edit it.');
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
            'name' => 'required|max:100',
            'description' => 'required|max:5000',
            'website' => 'required|max:100',
            'logo' => 'image|nullable|max:1999', // Has to be a jpeg, gif, etc, but don't require an image (max size = 1999 kb)
            'industry' => 'required|max:250',
            'technology' => 'required|max:250',
            'business' => 'nullable|max:200',
            'contact_name' => 'required|max:50',
            'contact_email' => 'required|max:100',
            'contact_number' => 'required|max:50',
            'phone' => 'required|max:50',
            'email' => 'required|max:100',
            'terms_and_conditions' => 'accepted',
            'address1' => 'required|max:500',
            'postalcode' => 'required|max:50',
            'city' => 'required|max:100'
        ]);

        $company = Company::find($id); //can use this because we import it at the top with use App\Company

        // Handle File Upload
        if($request->hasFile('logo')){ // Only change their logo if they have uploaded a new one.
            // Get filename with the extension
            $filenameWithExt = $request->file('logo')->getClientOriginalName(); // This will get the exact file name.
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('logo')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension; // Adds a timestamp, making the filename completely unique

            // Upload image to storage/app/public/logos folder (& in public/logos) that gets created if it doesn't exist yet.
            $path = $request->file('logo')->storeAs('public/logos', $fileNameToStore);
            $company->logo = $fileNameToStore;

        } 
        // If they don't upload a new image, it will use whatever was previously their logo. 


        //create company address for the address table
        $address = Address::find($company->address);

        $address->address1 = $request->input('address1');
        $address->address2 = $request->input('address2');
        $address->city = $request->input('city');
        $address->region = $request->input('region');
        $address->postalcode = $request->input('postalcode');
        $address->save();

        // Create Company
       
        $company->name = $request->input('name');
        $company->description = $request->input('description');
        $company->website = $request->input('website');
        $company->address = $address->ID; //link this company to the address ID.
        $company->tags = 1; //stops error 
        $company->phone = $request->input('phone');
        $company->email = $request->input('email');

        $company->contact = $request->input('contact_name'); // just contact name for now

        $company->internships = $request->has('internships')?1:0;
        $company->industry = $request->input('industry');
        $company->technology = $request->input('technology');
        $company->business = $request->input('business');
        $company->company_size = $request->input('company_size');
        // Don't need to update flag
        // $company->flag = 1;
        $company->updated_at = \Carbon\Carbon::now();
        $company->expires_at = \Carbon\Carbon::now()->addMonths(config('app.companyExpiryTime'));
        $company->save();
        
        return redirect('/companies')->with('success', 'Company Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //delete company from view. This does not remove the company from the database.
    public function destroy($id)
    {
        if(Auth::user()->comp_id == $id || Auth::user()->type == 'admin')
        {
            $company = Company::find($id);
            $user = User::where('comp_id', $company->ID)->first();
            if($user != null)
            {
                $user->comp_id = null;
                $user->save();
            }

            $jobs = Job::where('companyID', $company->ID)->get();
            foreach($jobs as $job)
            {
                $job->flag = 0;
                $job->save();
            }
        
            $company->flag = 0;
            $company->expires_at = Carbon::now();
            $company->save();
            return redirect('/companies')->with('success', 'Company Removed');
        }
        return back()->with('error','You must be admin of this company to delete it.');
    }

    /**
     * Display all companies that are likely to give summer student work.
     *
     * @return \Illuminate\Http\Response
     */
    public function studentcompanies(){
        $companies = Company::where('flag', 1)->where('internships', 1)->get();
        return view('companies.index')->with('companies',$companies);
    }
}
