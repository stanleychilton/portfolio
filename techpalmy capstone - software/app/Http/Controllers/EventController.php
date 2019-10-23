<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Event;
use App\Models\Address; 
use App\Models\User;
use App\Mail\EventCreationAdmin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use Carbon\Carbon;
use DB;

class EventController extends Controller
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
        $events = Event::where('date', '>', \Carbon\Carbon::now()->subDays(config('app.eventExpiryTime'))->toDateString())
                        ->inRandomOrder()
                        ->paginate(10); 
        // only display events yet to be held (or been held recently)
        $rssevents = $this->getRSSfeed('https://techevents.nz/rss/pnorth'); // Need this to point interpreter to local object, instead of looking for getRSSfeed globally.
        return view('events.index')->with(compact('events','rssevents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $usereventscount = Event::where('users_id', Auth::user()->ID)
                                        ->where('date','<',\Carbon\Carbon::now()->toDateString())
                                        ->get()->count();
        if($usereventscount < 5 || Auth::user()->type=='admin'){
            // User cannot have more than 5 events in the future (to prevent spamming of events)
            // Must have this since any logged in user can create & display events.
            // $techgroups = TechGroup::pluck('name', 'ID');
            return view('events.create');
        }

        return back()->with('error', 'You have reached your max of 5 current events. Either edit your existing
         \'to-be-run\' events, or wait until they have been run.');
        
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
            'description' => 'required|max:2000',
            'link' => 'nullable|max:100',
            'time' => 'required',
            'date' => 'required',
            'location' => 'required|max:75',
            'address1' => 'required|max:75',
            'city' => 'required|max:50',
            'address2' => 'nullable|max:75', //not required, but should not be unreasonably long.
            'postalcode' => 'required|max:10',
            'duration' => 'nullable|max:50',
            'terms_and_conditions' => 'accepted'
        ]);

        $event = new Event; //can use this because we import it at the top with use App\Listing

        // create event location & address
        $address = new Address;
        $address->address1 = $request->input('address1');
        $address->address2 = $request->input('address2');
        $address->city = $request->input('city');
        $address->postalcode = $request->input('postalcode');
        $address->save();
        $event->location = $request->input('location');
        $event->addresses_id = $address->ID;
        
        // Create Listing
        
        $event->name = $request->input('name');
        $event->description = $request->input('description');
        $event->time = $request->input('time');
        $event->duration = $request->input('duration');
        $event->link = $request->input('link');
        $event->date = $request->input('date');
        $event->created_at = \Carbon\Carbon::now();
        $event->updated_at = \Carbon\Carbon::now();
        
        if(Auth::user()->type != User::ADMIN)
        {
            $event->users_id = Auth::user()->ID;
        }
        // $event->expires_at = \Carbon\Carbon::now()->addMonths(6);
        //$event->flag = 0; //Don't want to show this event by default
        $event->save();

        //send admin email that the event has been created. 
        $admins = User::where('type', User::ADMIN)->get();
        foreach($admins as $admin)
        {
            Mail::to($admin)->queue(new EventCreationAdmin($event));
        }

        return redirect('/events')->with('success', 'Event Created');
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

        $event = Event::find($id);
        $address = $event->address();
        
        if(Auth::user() && (Auth::user()->ID == $event->users_id || Auth::user()->type=='admin'))
        {
            $display = true;
        }


        return view('events.show')->with(compact('event','address','display'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = Event::find($id);
        if(Auth::user()->ID == $event->users_id || Auth::user()->type=='admin'){
            $address = $event->address;
            return view('events.edit')->with(compact('event','address'));
        }
        return back()->with('error','You must be admin of this event to edit it.');

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
            'description' => 'required|max:2000',
            'link' => 'nullable|max:100',
            'time' => 'required',
            'date' => 'required',
            'location' => 'required|max:75',
            'address1' => 'required|max:75',
            'city' => 'required|max:50',
            'address2' => 'nullable|max:75', //not required, but should not be unreasonably long.
            'postalcode' => 'required|max:10',
            'duration' => 'nullable|max:50',
            'terms_and_conditions' => 'accepted',
        ]);

        $event = Event::find($id); //can use this because we import it at the top with use App\Listing

        // create event location & address
        $address = $event->address();
        $address->address1 = $request->input('address1');
        $address->address2 = $request->input('address2');
        $address->city = $request->input('city');
        $address->postalcode = $request->input('postalcode');
        // $address->save();
        $event->location = $request->input('location');
        // $event->address()->save($address);

        // update event
        $event->name = $request->input('name');
        $event->description = $request->input('description');
        $event->time = $request->input('time');
        $event->date = $request->input('date');
        $event->duration = $request->input('duration');
        $event->link = $request->input('link');
        $event->date = $request->input('date');
        $event->updated_at = \Carbon\Carbon::now();
        $event->save();
        
        return redirect('/events')->with('success', 'Event Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        $event = Event::find($id);
        if(Auth::user()->ID == $event->users_id || Auth::user()->type=='admin')
        {
            $event->date = Carbon::now()->subDay(config('app.eventExpiryTime')); //subbing a day ensures this dosn't appear in index.
            $event->users_id = null;
            $event->save();
            return redirect('/events')->with('success', 'Event Listing Removed');
        }
        return back()->with('error','You must be admin of this event to delete it.');
    }

    private function getRSSfeed($link){
        $feed = \Feeds::make($link, true); // if RSS Feed has invalid mime types, force to read
        $palmyitems = array();
        foreach($feed->get_items() as $item):
            if (stripos($item->get_title(),'palmerston north') !== false) {
                array_push($palmyitems,$item);
            }
        endforeach;

        return $palmyitems;
    }

}
