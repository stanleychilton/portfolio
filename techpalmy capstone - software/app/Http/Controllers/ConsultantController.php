<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Consultant; // Enables us to use any of the model functions.
use App\Models\Address;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use DB; // allows us to use SQL instead of Eloquent

class ConsultantController extends Controller
{
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
        $consultant = Consultant::where('flag', 1)->get();
        return view('consultants.index')->with('consultants',$consultant);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->con_id === NULL || Auth::user()->type == 'admin')
        {
            return view('consultants.create');
        }
        //home page is being used as a message page.
        return back()->with('error', 'This account is already a consultant.
        Only one consultant can be linked to each account.');
        //Do we want a person to be able to create multiple consultants?
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
            'expertise' => 'required|max:200',
            'phone' => 'required|max:15',
            'email' => 'required|max:50',
            'terms_and_conditions' => 'accepted',
            // 'city' => 'required|max:35'
            // 'address' => 'nullable|address' it is optional, but if it is entered, needs to be a valid address
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
            // If they don't upload an image, it will use this default image in the consultant logo... 
            $fileNameToStore = 'noimage.jpg';
        }

        //create consultant address for the address table
        // $address = new Address;
        // $address->address1 = $request->input('address1');
        // $address->address2 = $request->input('address2');
        // $address->city = $request->input('city');
        // $address->region = $request->input('region');
        // $address->postalcode = $request->input('postalcode');
        // $address->save();

        // Create Consultant
        $consultant = new Consultant; //can use this because we import it at the top with use App\Consultant
        $consultant->name = $request->input('name');
        $consultant->description = $request->input('description');
        $consultant->website = $request->input('website');
        // $consultant->address = $address->ID; //link consultant to address
        $consultant->tags = 1; //stops error 
        $consultant->phone = $request->input('phone');
        $consultant->email = $request->input('email');
        $consultant->expertise = $request->input('expertise');
        $consultant->flag = 0; // NEED TO CHANGE WHEN GOES LIVE!
        $consultant->created_at = \Carbon\Carbon::now();
        $consultant->updated_at = \Carbon\Carbon::now();
        $consultant->expires_at = \Carbon\Carbon::now()->addMonths(config('app.consultantExpiryTime'));
        $consultant->logo = $fileNameToStore;
        $consultant->save();

        //link consultant to user.
        $user = Auth::user();
        if($user->type != User::ADMIN)
        {
            $user->con_id = $consultant->ID;
            $user->save();
        }

        return redirect('/consultants')->with('success', 'Consultant has been created. Note that the website admin must approve this listing before it can be displayed publicly on the website.');
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

        if(Auth::user() && (Auth::user()->con_id == $id || Auth::user()->type == 'admin')) {
            $display = true;
        }

        $consultant = Consultant::find($id);
        return view('consultants.show')->with(compact('consultant','display'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->con_id == $id || Auth::user()->type == 'admin') 
        // user is admin of consultant or admin of site
        {
            $consultant = Consultant::find($id);
            // $address = Address::find($consultant->address);
            return view('consultants.edit')->with(compact('consultant','address'));
        }

        return back()->with('error','You must be admin of this consultant to edit it.');
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
            'expertise' => 'required|max:200',
            'phone' => 'required|max:15',
            'email' => 'required|max:50',
            'terms_and_conditions' => 'accepted',
            // 'city' => 'required|max:35',
            // 'address1' => 'required|max:50'
        ]);

        $consultant = Consultant::find($id); //can use this because we import it at the top with use App\Listing

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
            $consultant->logo = $fileNameToStore;
        }

        
        // update address
        // $address = Address::find($consultant->address);

        // $address->address1 = $request->input('address1');
        // $address->address2 = $request->input('address2');
        // $address->city = $request->input('city');
        // $address->region = $request->input('region');
        // $address->postalcode = $request->input('postalcode');
        // $address->save();

        //update consultant
        $consultant->name = $request->input('name');
        $consultant->description = $request->input('description');
        $consultant->website = $request->input('website');
        $consultant->tags = 1; //stops error 
        $consultant->phone = $request->input('phone');
        $consultant->email = $request->input('email');
        $consultant->expertise = $request->input('expertise');
        // Don't need to update flag.
        // $consultant->flag = 1; // Trust the consultants to update their listing without requiring approval.
        $consultant->updated_at = \Carbon\Carbon::now();
        $consultant->expires_at = \Carbon\Carbon::now()->addMonths(config('app.consultantExpiryTime'));
        $consultant->save();
        
        return redirect('/consultants')->with('success', 'Consultant Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->con_id == $id || Auth::user()->type == 'admin'){
            $consultant = Consultant::find($id);
            $user = User::where('con_id', $consultant->ID)->first();
            if($user != null)
            {
                $user->con_id = null;
                $user->save();
            }

            $consultant->flag = 0;
            $consultant->expires_at = Carbon::now();
            $consultant->save();
            return redirect('/consultants')->with('success', 'Consultant Removed');
        }
        return back()->with('error','You must be admin of this consultant to delete it.');
    }
}
