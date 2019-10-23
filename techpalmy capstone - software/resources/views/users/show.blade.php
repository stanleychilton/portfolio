@extends('layouts.app')

@section('content')
    
    <br>
    <div class="text-center">
        <div class="row">
            <div class="col-md-2 col-sm-2">
                {{-- <img style="width:100%;max-width:200px;max-height:200px" class="img-rounded" src="/storage/logos/{{$user->profilepic}}"> 
                  Set up a profile picture. --}}
            </div>
            <div class="col-md-8 col-sm-8">
                <h1>{{$user->name}}</h1>
            </div>
        </div>
    </div>
    <hr>
    <div class="card ">
        <div class="card-header"> 
            <ul class="nav nav-tabs card-header-tabs pull-right"  id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#Email" role="tab" aria-controls="Email" aria-selected="true">Email</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="mailinglist-tab" data-toggle="tab" href="#mailinglist" role="tab" aria-controls="mailinglist" aria-selected="false">Mailing List</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="listings-tab" data-toggle="tab" href="#listings" role="tab" aria-controls="listings" aria-selected="false">Your Listings</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="Email" role="tabpanel" aria-labelledby="Email-tab">
                    <h4>Email Address:</h4>
                    {!!$user->email!!}
                </div>
                <div class="tab-pane fade" id="mailinglist" role="tabpanel" aria-labelledby="mailinglist-tab">
                    @if($user->mailinglist)
                        {!!$user->mailinglist!!}
                    @else
                        <p>You are not part of any mailing lists.</p>

                        <p>You can opt into Tech Palmy's mailing list by editing your profile.</p>
                    @endif
                </div>
                <div class="tab-pane fade" id="listings" role="tabpanel" aria-labelledby="listings-tab">
                    <h4>User's Listings</h4>
                    <p>You have <b>{{$CCT->count()+$eventsjobs->count()}}</b> total listings.</p>
                    @if($CCT->count() > 0)
                        <p>You are admin of <b>{{$CCT->count()}}</b> companies, consultants, and tech groups.</p>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Displayed on Website</th>
                                    <th scope="col">Created On</th>
                                    <th scope="col">Last Updated</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($CCT as $listing)
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
                                        @if($listing->flag==1)
                                            <td>Yes</td>
                                        @else
                                            <td>No</td>
                                        @endif
                                        <td>{{\Carbon\Carbon::parse($listing->created_at)->format('d/m/Y')}}</td>
                                        <td>{{\Carbon\Carbon::parse($listing->updated_at)->format('d/m/Y')}}</td>
                                    </tr>
                                @endforeach     
                            </tbody>
                        </table>
                    @else
                        <p>You are not admin of any companies, consultants, or techgroups. To create a listing, go to <a href="/information_page">Information Page<a></p>
                    @endif
                    <br>
                    @if($eventsjobs->count() > 0)
                        <p>You have <b>{{$eventsjobs->count()}}</b> Events/Courses and Jobs</p>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Displayed on Website</th>
                                    <th scope="col">Created On</th>
                                    <th scope="col">Last Updated</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($eventsjobs as $listing)
                                    <tr>
                                        <th scope="row">{{$loop->index+1}}</th>
                                        <td>
                                            <a href="{{ route($listing->type.'.show', $listing->ID) }}"><b>{{ $listing->name}}</b></a>
                                        </td>
                                        <td>{{ucfirst(substr($listing->type,0,-1))}}</td>

                                        {{-- THIS NEEDS TO ALLIGN WITH JOBS AND EVENTS INDEX CONTROLLER --}}
                                        @if($listing->type == "events")
                                            @if(\Carbon\Carbon::parse($listing->date) > \Carbon\Carbon::now()->subDays(config('app.eventExpiryTime')))
                                                <td>Yes</td>
                                            @else
                                                <td>No</td>
                                            @endif
                                        @else
                                            @if(\Carbon\Carbon::parse($listing->date) > \Carbon\Carbon::now())
                                                <td>Yes</td>
                                            @else
                                                <td>No</td>
                                            @endif
                                        @endif
                                        <td>{{\Carbon\Carbon::parse($listing->created_at)->format('d/m/Y')}}</td>
                                        <td>{{\Carbon\Carbon::parse($listing->updated_at)->format('d/m/Y')}}</td>
                                    </tr>
                                @endforeach     
                            </tbody>
                        </table>
                    @else
                        <p>You have no jobs or events. To create a listing, go to <a href="/information_page">Information Page<a></p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <hr>
    <a href='/user/edit' class='btn btn-primary'>Edit Profile</a>

    {{-- {!!Form::open(['redirect'=> 'ProfileController@destroy', 'method'=>'POST','class'=>'float-right'])!!}
        {{Form::hidden('_method', 'DELETE')}}
        {{Form::submit('Delete Profile', ['class'=> 'btn btn-danger'])}}
    {!!Form::close()!!} --}}
    <hr>

    @yield('admin')

    <small>Created on {{\Carbon\Carbon::parse($user->created_at)->format('d/m/Y')}}</small>
    <br>
    <small>Last updated on {{\Carbon\Carbon::parse($user->updated_at)->format('d/m/Y')}}</small>

@endsection