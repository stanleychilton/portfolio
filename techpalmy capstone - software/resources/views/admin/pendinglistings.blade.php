@extends('layouts.app')   {{--Extend sidebar, navbar, and all other base html--}}

@section('content')
    <div class="well">
        <div class="row">
            <div class="col-md-8 col-sm-8" style="">
                <h1 style='margin:15px;'>Pending Listings</h1>
            </div>
        </div>
    </div>

    <div class="col-sm-12 text-left" style="word-wrap: break-word;padding-top: 10px;">
        
        <h4><strong>How to verifying pending listings</strong></h4><hr>
        <p style='margin:15px;'>To approve pending listings, click on the listing and click "Approve Listing".
        <p style='margin:15px;'>You can use the official New Zealand list of businesses to help verify 
            pending company listings. 
        <p style='margin:15px;'>Contact details for administrative purposes are included for companies, you can also use this information to verify whether a pending company is legit.

        <br>
        
        <h4><strong>Links</strong></h4><hr>
        
        <p style='margin:15px;'>All businesses in New Zealand are required to be registered on this website:
        <br>
        <a href="https://companies-register.companiesoffice.govt.nz/help-centre/getting-support-to-use-the-companies-register/searching-the-companies-register/" target="_blank" style='margin-left:30px;'>NZ Companies Register</a>
    

    {{-- Pending Listings --}}
    <hr>
    <div name="pendinglistings">
        <p>There are {{$pendinglistings['combinedpending']->total()}} pending listings.</p>
        @if(count($pendinglistings['combinedpending']) > 0)
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Type</th>
                        <th scope="col">Description</th>
                        {{-- <th scope="col">Created By</th> --}}
                        <th scope="col">Created On</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pendinglistings['combinedpending'] as $listing)
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
                            <td>
                                {!! str_limit($listing->description,80)!!}
                            </td>
                            {{-- @if($listing->type=='techgroups')
                                <td>{{$temp}}</td>
                                <td>{{$listing->users()}}</td>
                            @else
                                <td>Can't pull user from company or consultant side.</td>
                                <td>{{$temp}}</td>
                                <td>{{$listing->user}}</td>
                            @endif --}}
                            <td>
                                {{\Carbon\Carbon::parse($listing->created_at)->format('d/m/Y')}}
                            </td>
                        </tr>
                    @endforeach     
                </tbody>
            </table>
            {{$pendinglistings['combinedpending']->links()}}
        @endif
    </div>
</div>
    <br>
@endsection