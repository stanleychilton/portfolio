@extends('layouts.app') 

@section('title', 'Search Results')

@section('content')

    <div class="container">
        <header class="blog-header py-3">
            <div class="row flex-nowrap justify-content-between align-items-center">
            <div class="col-12 text-left">
                <h1 class="blog-header-logo text-dark">Search Results</h1>
 
            </div>

            </div>
        </header>
    <div>
    <div class="search-container container">
        <p><b>{{$listingsarray['listings']->total()+count($rssevents)}}</b> total result(s) for '{{ request()->input('query') }}'</p>
     
        @if($listingsarray['listings']->total()+count($rssevents) > 0)
        {{-- Reason for the second part of the condition: as the rss events are not paginated, it will carry them through
            at the beginning of the table into the other paginated tables. Now it only displays them on the first page. --}}
        <hr>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Type</th>
                        <th scope="col">Description</th>
                    </tr>
                </thead>
                <tbody>
                    @php ($count = 0)
                    @if(count($rssevents)>0 && (app('request')->input('page') == 1 ||app('request')->input('page')==NULL))
                        @foreach ($rssevents as $rssevent)
                            <tr class="myrsseventRow" style='cursor: pointer'>
                                <th scope="row">{{$loop->index+1}}</th>
                                <td>
                                    <a href="{{ $rssevent->get_permalink() }}" style='text-decoration:none'><p><b>
                                        {{preg_replace( "/^[^A-Za-z0-9]+/", '', $rssevent->get_title() ) }}</b></p></a>
                                </td>
                                <td>Event</td>
                                <td>
                                    {!! str_limit($rssevent->get_description(),150)!!}
                                </td>
                            </tr>
                            @php ($count = $count + 1)
                        @endforeach    
                    @endif
                    @foreach ($listingsarray['listings'] as $listing)
                        <tr class="myRow" style='cursor: pointer'>
                            <th scope="row">{{$loop->index+1+$count}}</th>
                            <td>
                                <a href="{{ route($listing->type.'.show', $listing->ID) }}" style='text-decoration:none'><p><b>{{ $listing->name}}</b></p></a>
                            </td>
                            @if($listing->type=='techgroups')
                                <td>Tech Group</td>
                            @elseif($listing->type=='companies')
                                <td>Company</td>
                            @else
                                <td><p>{{ucfirst(substr($listing->type,0,-1))}}</p></td>
                            @endif
                            <td>
                                {!! str_limit($listing->description,150)!!}
                            </td>
                        </tr>
                    @endforeach     
                </tbody>
            </table>
            {{ $listingsarray['listings']->appends(request()->input())->links() }}
            {{-- {{$listingsarray['listings']->links()}} --}}
        @endif
    </div> <!-- end search container -->

<script>
$(".myRow").click(function() {
    window.location = $(this).find("a").attr("href"); 
    return false;
});

$(".myrsseventRow").click(function() {
    window.open($(this).find("a").attr("href")); 
    return false;
});
</script>
@endsection

{{--         <p>Total of {{ $companies->count()+$consultants->count()+$jobs->count()+$events->count()+$techGroups->count()}} result(s) for '{{ request()->input('query') }}'</p>
        
        @if(count($companies) > 0)
            <div>
                <h3>Companies:</h3>
                @foreach ($companies as $company)
                    <div class="card border-dark mb-3">
                        <div class="card-body">
                            {{$company->ID}}
                            <div class="row">
                                <div class="col-md-8 col-sm-8">
                                    <h2 class="card-title">{{$company->name}}</h2>
                                    <h6 class="card-subtitle mb-2 text-muted">Technology: &nbsp; <strong>{{$company->technology}}</strong><h6>
                                    <p class="card-text">{!! str_limit($company->description,80)!!}</p>
                                    <a href="companies/{{$company->ID}}" class="card-link">View Company</a>
                                    <a href="{{$company->website}}" target="_blank" class="card-link">Website</a><br><br>
                                    <small>Created on {{\Carbon\Carbon::parse($company->created_at)->format('d/m/Y')}}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                @endforeach
                {{ $companies->appends(request()->input())->links() }}
            </div>
        <hr>  
        @endif
      
        @if(count($consultants) > 0)
            <div>
                <h3>Consultants:</h3>
                @foreach ($consultants as $consultant)
                    <div class="card border-dark mb-3">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-8 col-sm-8">
                                    <h2 class="card-title">{{$consultant->name}}</h2>
                                    <h6 class="card-subtitle mb-2 text-muted">Area of Expertise: &nbsp; <strong>{{$consultant->expertise}}</strong><h6>
                                    <p class="card-text">{!! str_limit($consultant->description,80)!!}</p>
                                    <a href="consultants/{{$consultant->ID}}" class="card-link">View Consultant</a>
                                    <a href="{{$consultant->website}}" target="_blank" class="card-link">Website</a><br><br>
                                    <small>Created on {{\Carbon\Carbon::parse($consultant->created_at)->format('d/m/Y')}}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                @endforeach
                {{ $consultants->appends(request()->input())->links() }}
            </div>
        <hr>
        @endif
        
        @if(count($jobs) > 0)
            <div>
                <h3>Jobs:</h3>
                @foreach ($jobs as $job)
                    <div class="card border-dark mb-3">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-8 col-sm-8">
                                    <h2 class="card-title">{{$job->position}}</h2>
                                    <a href="jobs/{{$job->ID}}" class="card-link">View Job</a>
                                    <a href="{{$job->external_link}}" target="_blank" class="card-link">Link</a><br><br>
                                    <small>Created on {{\Carbon\Carbon::parse($job->created_at)->format('d/m/Y')}}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                @endforeach
                {{ $jobs->appends(request()->input())->links() }}
            </div>
        <hr>
        @endif
        
        @if($events->count() > 0)
            <div>
                <h3>Events & Courses:</h3>
                @foreach ($events as $event)
                    <div class="well">
                        <h3><a href="events/{{$event->ID}}">{{$event->name}}</a></h3>
                        <h4>Description: {!!$event->description!!}</h4>
                        <small>Event time - {{$event->time}}</small><br>
                        <small>Event date - {{$event->date}}</small>
                    </div>
                @endforeach
                {{ $events->appends(request()->input())->links() }}
            </div>
        <hr>
        @endif
        
        @if(count($techGroups) > 0)
            <div>
                <h3>Tech Groups:</h3>
                @foreach ($techGroups as $techGroup)
                    <div class="card border-dark mb-3">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-8 col-sm-8">
                                    <h2 class="card-title">{{$techGroup->name}}</h2>
                                    <a href="techgroups/{{$techGroup->ID}}" class="card-link">View TechGroup</a>
                                    <a href="{{$techGroup->website}}" target="_blank" class="card-link">Website</a><br><br>
                                    <small>Created on {{\Carbon\Carbon::parse($techGroup->created_at)->format('d/m/Y')}}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                @endforeach
                {{ $techGroups->appends(request()->input())->links() }}
            </div>
        @endif --}}

