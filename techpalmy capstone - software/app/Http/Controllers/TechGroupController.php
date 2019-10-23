<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\TechGroup; // Enables us to use any of the model functions.
use App\Models\Usertechgroup;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use DB; // allows us to use SQL instead of Eloquent

class TechGroupController extends Controller
{

    // User must be logged in to create, edit, and delete.
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() // capstone.dev/listings calls this function here
    {
        $techGroups = TechGroup::where('flag', 1)->get();
        return view('techgroups.index')->with('techGroups',$techGroups);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $usertechgroupscount = Auth::user()->techgroups()->get()->count();
        // $usertechgroupscount = Auth::user()->techgroups()->count();

        if($usertechgroupscount < 5 || Auth::user()->type=='admin'){
            // User can only create / be admin of a max of 5 tech groups
            return view('techgroups.create');
        }
        return back()->with('error', 'You cannot be admin of more than 5 tech groups. Either edit your existing
         tech groups, or delete an existing tech group you are admin of.');
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
            'website' => 'required|max:150',
            'email' => 'required|max:50',
            'description' => 'required|max:5000',
            'terms_and_conditions' => 'accepted',
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
            // If they don't upload an image, it will use this default image as the Tech Group logo... 
            $fileNameToStore = 'noimage.jpg';
        }

        $techGroup = new TechGroup;
        $techGroup->name = $request->input('name');
        $techGroup->website = $request->input('website');
        $techGroup->email = $request->input('email');
        $techGroup->description = $request->input('description');
        $techGroup->logo = $fileNameToStore;
        $techGroup->tags = 1; //stops error 
        $techGroup->flag = 0; // NEED TO CHANGE WHEN GOES LIVE!
        $techGroup->created_at = \Carbon\Carbon::now(); # \Datetime()
        $techGroup->updated_at = \Carbon\Carbon::now();  # \Datetime()
        $techGroup->expires_at = \Carbon\Carbon::now()->addMonths(config('app.techgroupExpiryTime'));
        $techGroup->save();

        // To attach a tech group to a user by inserting a record in the
        // intermediate table that joins the models, use the attach method:
        
        $techGroup->users()->attach(Auth::user()->ID);
        
        return redirect('/techgroups')->with('success', 'Tech Group has been created. Note that the website admin must approve this listing before it can be displayed publicly on the website.');
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

        $techGroup = TechGroup::find($id);

        
        if(Auth::user()){
            $user = Auth::user();
            if ($user->type=='admin'){
                $display = true;
            } else {
                
                $userstechgroups = $user->techgroups;
                $userstechgroupsids = $userstechgroups->map(function ($user) {
                    return $user->only(['ID']);
                });
                if($userstechgroupsids->contains("ID",$techGroup->ID)){
                    $display = true;
                }
            }

        }
        
        return view('techgroups.show')->with(compact('techGroup','display'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $techGroup = TechGroup::find($id);

        if(Auth::user()){
            $user = Auth::user();
            if ($user->type=='admin'){
                return view('techgroups.edit')->with('techGroup', $techGroup);
            } else {
                
                $userstechgroups = $user->techgroups;
                $userstechgroupsids = $userstechgroups->map(function ($user) {
                    return $user->only(['ID']);
                });
                if($userstechgroupsids->contains("ID",$techGroup->ID)){
                    return view('techgroups.edit')->with('techGroup', $techGroup);
                }
            }

        }
        
        return back()->with('error','You must be admin of this Tech Group to edit it.');

        // // We can assume user is logged in, as user can only access this page if they are logged in.
        // $techGroup = TechGroup::find($id);

        // // $userisadmin = $techGroup->users()->where('ID',Auth::user()->ID)->get()->count();
        // // // Only display edit form if current user is admin of that tech group (or is the website admin)
        // $userisadmin = Usertechgroup::where('User_id', Auth::user()->ID)->first();
        // // Only admins of techgroup or website admin can edit.

        // // if(Auth::user()->isAdminOf($techGroup) || Auth::user()->type== 'admin')
        // if($userisadmin != null || Auth::user()->type== 'admin')
        // // if($userisadmin == 1 || Auth::user()->type== 'admin')
        // {
        //     return view('techgroups.edit')->with('techGroup', $techGroup);
        // }
        
        // // Otherwise redirect & display error message
        // return back()->with('error','You must be admin of this Tech Group to edit it.');
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
            'website' => 'required|max:150',
            'email' => 'required|max:50',
            'description' => 'required|max:5000',
            'terms_and_conditions' => 'accepted',
        ]);

        $techGroup = TechGroup::find($id); //can use this because we import it at the top with use App\Listing

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
            $techGroup->logo = $fileNameToStore;
        }

        $techGroup->name = $request->input('name');
        $techGroup->website = $request->input('website');
        $techGroup->email = $request->input('email');
        $techGroup->description = $request->input('description');
        $techGroup->tags = 1;
        // $techGroup->flag = 1;
        $techGroup->updated_at = \Carbon\Carbon::now();  # \Datetime()
        $techGroup->expires_at = \Carbon\Carbon::now()->addMonths(config('app.techgroupExpireTime'));
        $techGroup->save();

        return redirect('/techgroups')->with('success', 'Tech Group Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $techGroup = TechGroup::find($id);
        $userisadmin = Usertechgroup::where('User_id', Auth::user()->ID)->first();
        // Only admins of techgroup or website admin can delete.

        // if(Auth::user()->isAdminOf($techGroup) || Auth::user()->type== 'admin')
        if($userisadmin != null || Auth::user()->type== 'admin')
        {

            //The detach method will remove the appropriate records of linkage of users with this techgroup out of the usertechgroup table;
            // this is possible because the inverse many-to-many relationship is defined in TechGroup.
            $techGroup->users()->detach(); // want to remove all references of joined users to the tech group (so that all admins
            // get their reference to the tech group removed, even though 1 user is doing the removing.)
            // $techgroups->users()->detach(Auth::user()->ID); // THIS ONLY REMOVES THE CURRENT USERS REFERENCE TO THE TECH GROUP, NOT THE OTHERS

            $techGroup->flag = 0;
            $techGroup->expires_at = Carbon::now();
            $techGroup->save();
            return redirect('/techgroups')->with('success', 'The Tech Group & all references to it have been removed');
        }
        return back()->with('error','You must be admin of this Tech Group to delete it.');
    }

    public function addAdmin(Request $request)
    {
        //Allows an admin to add an additional admin to a techgroup.
        $this->validate($request, [
            'email' => 'required|max:50',
        ]);

        $email = $request->input('email');
        $user = User::where('email', $email)->first();
        $techGroup = TechGroup::find($request->input('id'));

        if($user==null){
            return back()->with('error', 'Could not find the email, "'.$email.'". Please enter a current website user\'s email.');  
        }

        $userstechgroups = $user->techgroups;
        if ($userstechgroups!=null){
            $userstechgroupsids = $userstechgroups->map(function ($user) {
                return $user->only(['ID']);
            });
            if($userstechgroupsids->contains("ID",$techGroup->ID)){
                return back()->with('error', 'User with email "'.$email.'" is already an admin of this Tech Group.'); 
            }
        }
        
        $userID = $user->ID;
        // if($techGroup->users()->get()->contains(User::find($userID)));
        // {
        //     return back()->with('error', ''.$email.' is already an admin.');   
        // }
        $techGroup->users()->attach($userID);

        return back()->with('success', "Added user with email '".$email."' as a new admin of this Tech Group.");
    }
}
