@extends('layouts.app')   {{--Extend sidebar, navbar, and all other base html--}}

@section('content')
    <br>
    <div class="well">
        <div class="row">
            <div class="col-md-8 col-sm-8">
                {{-- <h1 class="centered">Site Information</h1> --}}
                <h1>Site Information</h1>
            </div>
        </div>
    </div>



    <hr>
    {{-- Listings information --}}
    <div class="container">
        <div class="row no-gutters">
            <div class="col-sm">
                <h4><b>Listing Type</b></h4>
            </div>
            <div class="col-sm">
                <h4><b>Active/Approved</b></h4>
            </div>
            <div class="col-sm">
                <h4><b>Inactive/Pending</b></h4>
            </div>
        </div>
        <div class="row no-gutters">
            <div class="col-sm">
                <h5>Companies</h5>
            </div>
            <div class="col-sm">
                {{$ncompanies}}
            </div>
            <div class="col-sm">
                {{$pendingcompanies}}
            </div>
        </div>
        <div class="row no-gutters">
            <div class="col-sm">
                <h5>Consultants</h5>
            </div>
            <div class="col-sm">
                {{$nconsultants}}
            </div>
            <div class="col-sm">
                {{$pendingconsultants}}
            </div>
        </div>
        <div class="row no-gutters">
            <div class="col-sm">
                <h5>Total</h5>
            </div>
            <div class="col-sm">
                <b>{{$ncompanies+$nconsultants}}</b>
            </div>
            <div class="col-sm">
                <b>{{$pendingcompanies+$pendingconsultants}}</b>
            </div>
        </div>
    </div>
    {{-- <div class="well">
    <h4>Number of </h4>
    <div style="margin-left:15px">
        {!!$company->website!!}
    </div>
    </div> --}}

    <hr>
    {{-- Number of events run--}}
    <div class="container" name="events">
        <div name="events" class="row no-gutters">
            <div class="col-sm">
                <h5>Total Events Run</h5>
            </div>
            <div class="col-sm">
                {{$neventsrun}}
            </div>
            <div class="col-sm">
            </div>
        </div>
    </div>
    <hr>
    
    <div class="row no-gutters">
        <div class="col-md-2 col-sm-2">
            <a href="/companies" class="nav-link">Active Companies</a>
        </div>
        <div class="col-md-2 col-sm-2">
            <a href="/consultants" class="nav-link">Active Consultants</a>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col">
            <p>Log in with itp email address to view the Google Analytics report</p>
            <a href="https://analytics.google.com/analytics/web/#/report-home/a126285430w184983500p182223597" class="nav-link" target="_blank">Google Analytics for Website</a>
            
        </div>
    </div>

    {{-- TO DO --}}
    {{-- <hr>
    <p>Site was last maintenanced on: {{\Carbon\Carbon::now()->toFormattedDateString()}}</p> --}}

    {{-- How many listings are getting out of date --}}
    <hr>
    {{-- <p>Resulting union of queries: {{$expiringlistings['combinedlistings']}} </p> --}}
    <div name="expiringlistings">
        <p>There are {{$expiringlistings['combinedlistings']->total()}} listings expiring soon.</p>
        @if(count($expiringlistings['combinedlistings']) > 0)
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Type</th>
                        <th scope="col">Expiry Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($expiringlistings['combinedlistings'] as $listing)
                        
                        <tr>
                            <th scope="row">{{$loop->index+1}}</th>
                            <td>
                                <a href="{{ route($listing->type.'.show', $listing->ID) }}"><b>{{ $listing->name}}</b></a>
                            </td>
                            @if($listing->type=='techgroups')
                                <td>Tech Group</td>
                            @elseif($listing->type=='companies')
                                <td>Company</td>
                            @else
                                <td>{{ucfirst(substr($listing->type,0,-1))}}</td>
                            @endif
                            @if($listing->type=='events')
                                <td>{{\Carbon\Carbon::parse($listing->expires_at)->addDays(7)->toFormattedDateString()}}</td>
                            @else
                                <td>{{\Carbon\Carbon::parse($listing->expires_at)->toFormattedDateString()}}</td>
                            @endif
                        </tr>
                    @endforeach     
                </tbody>
            </table>
            {{$expiringlistings['combinedlistings']->links()}}
        @else
            <p>Companies are considered 'expiring soon' if they are expiring in the next 2 months.</p>
            <p>Consultants and Tech Groups are considered 'expiring soon' if they are expiring in the next month.</p>
            <p>Events are considered 'expiring soon' if they are expiring in the next 7 days.</p>
            <p>Jobs are considered 'expiring soon' if they are expiring in the next 2 weeks</p>
        @endif
    </div>
    
    <br>
@endsection