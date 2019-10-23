<?php

namespace App\Http\Controllers;

use App\Mail\AdminNotification;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Mailinglist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;


class EmailController extends Controller
{
    //check if this user is the admin.
    // public function __construct()
    // {
    //     $this->middleware('abort_if_guest');
    //     $this->middleware('is_admin');
    // }

    public function sendNotification(Request $request)
    {

        $this->validate($request, [
            'subject' => 'required|max:100',
            'content' => 'required|max:1000',
        ]);

        $info = array(); //contains all email information
        $ids = Mailinglist::all();
        $users = array();
        foreach($ids as $id)
        {
            array_push($users, User::find($id));
        };

        array_push($info, $request->input('subject'));
        array_push($info, strip_tags($request->input('content')));
            
        if($request->file('attachedfile') != null)
        {
            array_push($info, Storage::disk('public')->path($request->file('attachedfile')->store('folder', 'public')));
        }

        array_push($info, $request->attname);

        foreach($users as $user)
        {
            Mail::to($user)->queue(new AdminNotification($info));
        }
        return redirect('/admin/email')->with('success', 'Emails Sent');
    }

    /*
        Send verification email after a new user has registered.
    */
}
