@extends('layouts.app')

@section('content')
    
    <br>
    <div>
        <div class="row">
            <div class="col-md-2 col-sm-2">
                <img style="width:100%;max-width:200px;max-height:200px" class="img-rounded" src="/storage/logos/{{$company->logo}}">
            </div>
            <div class="col-md-8 col-sm-8">
                <h1>{{$company->name}}</h1>
            </div>
        {{-- This is not parsing the html with double curly braces, so use 1 curly brace and 
            two exclamation marks to show it --}}
        </div>
    </div>
    <hr>
    <br>

    <div>
        @if(($company->internships)==1)
            <h5>{{$company->name}} is <strong>likely</strong> to offer summer work to students.</h5>
        @else
            <h5>{{$company->name}} do <strong>not</strong> often offer sumer work to students.</h5>
        @endif
    </div>
    <br>
    <div class="card" id="showCard">
        <div class="row">
            <div class="col">
        
                <h4 class="card-title">Website</h4>

                @if(substr($company->website, 0, 4) ==='http')
                    <div class="card-text" style="margin-left:15px">
                        <a href="{!!$company->website!!}" target="_blank">{!!$company->website!!}</a>
                    </div>
                @elseif(substr($company->website, 0, 3) ==='www')
                    <div class="card-text" style="margin-left:15px">
                        <a href="http://{!!$company->website!!}" target="_blank">{!!$company->website!!}</a>
                    </div>
                @else
                    <div class="card-text" style="margin-left:15px">
                        <a href="https://www.{!!$company->website!!}" target="_blank">{!!$company->website!!}</a>
                    </div>
                @endif
                
                <h4 class="card-title">Company Size</h4>
                @if (empty(Auth::user()->age))
                    <div class="card-text" style="margin-left:15px">
                        <i>Not Listed</i>
                    </div>
                @else
                    <div class="card-text" style="margin-left:15px">
                        {{$company->company_size}}
                    </div>
                @endif
            
                <h4 class="card-title">Contact Details</h4>
                <div class="card-text" style="margin-left:15px">
                    Phone: {{$company->phone}}<br>
                    Email: <a>{{$company->email}}</a> 
                </div>

                <h4 class="card-title">Description</h4>
                <div class="card-text" style="margin-left:15px">
                    {!!$company->description!!}
                </div>

            </div>
            <div class="col">
                <h4 class="card-title">Industry</h4>
                <div class="card-text" style="margin-left:15px">
                    {!!$company->industry!!}
                </div>
            
                <h4 class="card-title">Technologies / Areas of Expertise</h4>
                <div class="card-text" style="margin-left:15px">
                    {!!$company->technology!!}
                </div>
                
                
                <h4 class="card-title">Type of Business</h4>
                <div class="card-text" style="margin-left:15px">
                    @if($company->business != null)
                        {!!$company->business!!}
                    @else
                        <i>Not Listed</i>
                    @endif
                </div>
                
            </div>
        </div>
            <hr>
			{{-- <div class="col-6"> --}}
			
			{{-- </div> --}}
				
			<h4 class="card-title">Address</h4>
            <div style="margin-left:15px">
            @if(($address->address1)!='N/A')
                {{$address->address1}}
            @endif
            @if(($address->address2)!='N/A')
                {{$address->address2}}
            @endif
            @if(($address->city)!='N/A')
                ,{{$address->city}}
            @endif
            @if(($address->region)!='N/A')
                {{$address->region}}
            @endif
            @if(($address->postalcode)!='N/A')
                ,{{$address->postalcode}}
            @endif    
            </div>
		</div>
    <br>

    <tr>
        <td colspan ="2">
            <div id ="map" style="height:600px;width:600px" >
            </div>
        </td>
    </tr>
    <br>
    
    @if($display)
    <hr>
        <h5><b>Contact Details for Admin Purposes</b></h5>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        {!!$company->contact_name!!}
                    </td>
                    <td>
                        {!!$company->contact_email!!}
                    </td>
                    <td>
                        {!!$company->contact_number!!}
                    </td>
                </tr>
            </tbody>
        </table>
    <hr>
    @endif
    
    @if(Auth::user() && Auth::user()->type == 'admin')
        @include('inc.approve', array('model' => 'Company','ID' => $company->ID, 'flag' => $company->flag))
        <hr>
    @endif
    @if($display)
        <a href='/companies/{{$company->ID}}/edit' class='btn btn-primary'>Edit</a>
    @endif
    {{-- <a href="{{Request::referrer()}}" class="btn btn-primary">Back</a> --}}
    <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
    @if($display)
        {!!Form::open(['action'=>['CompanyController@destroy', $company->ID], 'method'=>'POST','class'=>'float-right'])!!}
            {{Form::hidden('_method', 'DELETE')}}
            {{Form::submit('Delete', ['class'=> 'btn btn-danger'])}}
        {!!Form::close()!!}
    @endif
    <hr>
    <small>Created on {{\Carbon\Carbon::parse($company->created_at)->format('d/m/Y')}}</small>
    <br><br>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyByEUXiv7TNUppDZ_J2dDp9-1fqhxl7wow&callback=initMap" type="text/javascript"></script>
    <script language="javascript" type="text/javascript">
    var langs = {!! json_encode($address->toArray()) !!};
    var address = langs.address1 + " " + langs.city + " " + langs.postalcode;


    console.log(address);
    var map;
    var geocoder;
    function InitializeMap() {

        var latlng = new google.maps.LatLng(-40.35636, 175.61113);
        var myOptions =
        {
            zoom: 14,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            disableDefaultUI: true
        };
        map = new google.maps.Map(document.getElementById("map"), myOptions);
    }

    function FindLocaiton() {
        geocoder = new google.maps.Geocoder();
        InitializeMap();

        //var address = document.getElementById("addressinput").value;
        geocoder.geocode({ 'address': address }, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
                var marker = new google.maps.Marker({
                    map: map,
                    position: results[0].geometry.location
                });
                console.log("test", status);

            }
            else {
                console.log("Geocode was not successful for the following reason: " + status);
            }
            
        });

    }


    function Button1_onclick() {
        FindLocaiton();
    }

    window.onload = InitializeMap;
    window.onload = Button1_onclick;

</script>
   
@endsection