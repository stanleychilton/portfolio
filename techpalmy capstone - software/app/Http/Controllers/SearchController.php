<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Consultant; 
use App\Models\Job; 
use App\Models\Event;
use App\Models\TechGroup;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class SearchController extends Controller
{
    /**
     * Search Method
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     */
    public function search(Request $request)
    {

        // To prevent mass display of everything on the website
        $request->validate([
            'query' => 'required|min:3',
        ]);

        $query = $request->input('query');
        // $companies = Company::where('name', 'like', "%$query%")
        //                     ->orWhere('industry', 'like', "%$query%")
        //                     ->orWhere('technology', 'like', "%$query%")
        //                     ->orWhere('business', 'like', "%$query%")
        //                     ->orWhere('description', 'like', "%$query%")
        //                     ->where('flag', 1)->paginate(2);  Only need this if you do not have the search package,
        //                                                          'nicolaslopezj/searchable' not installed 
        $companies = Company::select('ID','name','description')->search($query)->addSelect(DB::raw("'companies' as type"));

        // $consultants = Consultant::where('name', 'like', "%$query%")
        //                             ->orWhere('website', 'like', "%$query%")
        //                             ->orWhere('expertise', 'like', "%$query%")
        //                             ->orWhere('description', 'like', "%$query%")
        //                             ->where('flag', 1)->paginate(5);
        $consultants = Consultant::select('ID','name','description')->search($query)->addSelect(DB::raw("'consultants' as type"));

        // $jobs = Job::where('position', 'like', "%$query%")
        //             ->orWhere('description', 'like', "%$query%")
        //             ->where('flag', 1)->paginate(5);
        $jobs = Job::select('ID','position','description')->search($query)->addSelect(DB::raw("'jobs' as type"));

        // $events = Event::where('name', 'like', "%$query%")
        //                 ->orWhere('description', 'like', "%$query%");
        //                 // ->where('flag', 1)->paginate(5);
        $events = Event::select('ID','name','description')->search($query)->addSelect(DB::raw("'events' as type"));

        // $techGroups = TechGroup::where('name', 'like', "%$query%")
        //                         ->orWhere('website', 'like', "%$query%")
        //                         ->orWhere('technology', 'like', "%$query%")
        //                         ->orWhere('description', 'like', "%$query%")
        //                         ->where('flag', 1)->paginate(5);
        $techgroups = Techgroup::select('ID','name','description')->search($query)->addSelect(DB::raw("'techgroups' as type"));


        $listings = $companies->union($consultants)
                                ->union($jobs)
                                ->union($events)
                                ->union($techgroups)
                                ->get();
                                // They are ordered by order of relevance.

        $page = LengthAwarePaginator::resolveCurrentPage();
        $paginate = 20;

        $listingsarray = array();

        $collection = new Collection($listings);
        $slice = $collection->slice(($page-1) * $paginate, $paginate)->all();
        
        //Create our paginator and add it to the data array
        $listingsarray['listings'] = new LengthAwarePaginator($slice, count($collection), $paginate);
        $listingsarray['listings']->setPath($request->url());

        // Check techevents.nz rss feedfor any palmy events that match search query
        $rssevents = $this->getRSSfeedevents('https://techevents.nz/rss/pnorth', $query);

        return view('pages.search-results',compact('listingsarray','rssevents'));
    }

    private function getRSSfeedevents($link, $query){
        $feed = \Feeds::make($link, true);
        $palmyitems = array();
        foreach($feed->get_items() as $item):
            if (stripos($item->get_title(),'palmerston north') !== false) {
                // search title, link, and description for the query. 
                if(stripos($item->get_title(),$query) !== false ||
                stripos($item->get_permalink(),$query) !== false||
                stripos($item->get_description(),$query) !== false){
                    array_push($palmyitems,$item);
                }
            }
        endforeach;

        return $palmyitems;
    }
}
