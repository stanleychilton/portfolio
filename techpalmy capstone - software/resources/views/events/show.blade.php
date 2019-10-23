@extends('layouts.app')

@section('content')
    <br>
    <div>
        <div class="row">
            <div class="col-md-8 col-sm-8">
                <h1>{{$event->name}}</h1>
            </div>

        </div>
    </div>
    
    <div class="card" id="showCard">
        @if($event->link!==NULL)
            <h4 class="card-title">Link</h4>
            @if(substr($event->link, 0, 4) ==='http')
                <div class="card-text" style="margin-left:15px">
                    <a href="{!!$event->link!!}" target="_blank">{!!$event->link!!}</a>
                </div>
            @elseif(substr($event->link, 0, 3) ==='www')
                <div class="card-text" style="margin-left:15px">
                    <a href="http://{!!$event->link!!}" target="_blank">{!!$event->link!!}</a>
                </div>
            @else
                <div class="card-text" style="margin-left:15px">
                    <a href="https://www.{!!$event->link!!}" target="_blank">{!!$event->link!!}</a>
                </div>
            @endif
        @endif

    {{-- <small>{{$event->techgroup->name}}</small> --}}
        <h4 class="card-title">When</h4>
        <div class="card-text" style="margin-left:15px">
            <b>{{\Carbon\Carbon::parse($event->date.' '.$event->time)->format('l jS \\of F Y \\a\\t h:i A')}}</b>
        </div>

    @if($event->duration!==NULL)
        <h4 class="card-title">Duration</h4>
        <div class="card-text" style="margin-left:15px">
            <p>{{$event->duration}}</p>
        </div>
    @endif

    <h4 class="card-title">Location</h4>
    <div class="card-text" style="margin-left:15px">
        <b>{{$event->location}}</b><br>
        {{$event->address->address1}}<br>
        @if(($event->address->address2)!==NULL)
            {{$event->address->address2}}<br>
        @endif
        {{$event->address->city}}
        @if(($event->address->postalcode)!== NULL)
            <br>{{$event->address->postalcode}}
        @endif    
    </div>

    <h4 class="card-title">Description</h4>
    <div class="card-text" style="margin-left:15px">
        <p>{!!$event->description!!}</p>
    </div>

    </div>
    <br>
    <tr>
        <td colspan ="2">
            <div id ="map" style="height:600px;width:600px" >
            </div>
        </td>
    </tr>
    <hr>        
    <br>
    @if($display)
        <a href='/events/{{$event->ID}}/edit' class='btn btn-primary'>Edit</a>
    @endif
    <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
    @if($display)
        {!!Form::open(['action'=>['EventController@destroy', $event->ID], 'method'=>'POST','class'=>'float-right'])!!}
            {{Form::hidden('_method', 'DELETE')}}
            {{Form::submit('Delete', ['class'=> 'btn btn-danger'])}}
        {!!Form::close()!!}
    @endif
    <hr>
    
    <small>Created on {{\Carbon\Carbon::parse($event->created_at)->format('d/m/Y')}}</small>
    <br>

    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyByEUXiv7TNUppDZ_J2dDp9-1fqhxl7wow&callback=initMap" type="text/javascript"></script>
    <script language="javascript" type="text/javascript">
    var langs = {!! json_encode($event->address->toArray()) !!};
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