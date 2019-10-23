<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*
    Controller for all admin related routings. 
*/

class AdminController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('abort_if_guest'); // sends 404 error if user is not logged in
    //     $this->middleware('is_admin');  // sends 404 error if user is not admin
    // }
    public function admin()
    {
        return view('users.admin')->with(['user', 'CCT'], [Auth::user(), array()]);
    }
    public function email()
    {
        return view('admin.notificationemailpage'); //test view for the email function.
    }
}
