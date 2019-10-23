<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Job; // Enables us to use any of the model functions.
use App\Models\Company; 
use App\Models\Consultant;
use App\Models\Event;

class PageController extends Controller
{
    public function index()
    {
        $companies = Company::where('flag', 1)->inRandomOrder()->limit(10)->get();
        $consultants = Consultant::where('flag', 1)->inRandomOrder()->limit(10)->get();
        $jobs = Job::where('flag', 1)->inRandomOrder()->limit(10)->get();
        $events = Event::where('date', '>', \Carbon\Carbon::now()->toDateString())
                    ->inRandomOrder()->limit(10)->get();
        return view('pages.index')->with(compact('jobs','companies','consultants','events'));
    }

    public function about_us()
    {
        return view('pages.about_us');
    }

    public function contactus()
    {
        return view('pages.contactus');
    }

    public function information_page()
    {
        return view('pages.information_page');
    }    

    public function moreinfo() //student job search info page.
    {
        return view('students.more_info');
    }

    public function summeroftech() //summer of tech info page. 
    {
        return view('students.summer_of_tech');
    }
}
