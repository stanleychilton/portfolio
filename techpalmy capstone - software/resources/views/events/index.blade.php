@extends('layouts.app') 
{{-- Just need to implement  --}}

@section('content')

    <div class="container">
        <header class="blog-header py-3">
            <div class="row flex-nowrap justify-content-between align-items-center">
            <div class="col-2 text-center">
                <h1 class="blog-header-logo text-dark">EVENTS</h1>
            </div>
            </div>
        </header>
    <div>
    @if(count($events) + count($rssevents)> 0)
        @if(count($rssevents)>0 && (app('request')->input('page') == 1 ||app('request')->input('page')==NULL))
            @foreach ($rssevents as $item)
            <div class='rssBox' id="myBox">
                <div class="card border-dark mb-3" id="eventCard">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <h3 class="card-title">
                                    <a href="{{$item->get_permalink()}}" style="text-decoration : none; color : #000000;">
                                        {{preg_replace( "/^[^A-Za-z0-9]+/", '', $item->get_title() ) }}
                                    </a>
                                </h3>
                                {{-- Above->removes any nonaphanumeric characters from beginning of title, since palmy events always begin with : --}}
                                <div class="card-text">{!!str_limit($item->get_description(),300)!!}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            @endforeach
        @endif
        @foreach ($events as $event)
        <div class='myBox' id="myBox">
            <div class="card border-dark mb-3" id="eventCard">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <small class="float-right">Created on {{\Carbon\Carbon::parse($event->created_at)->format('d/m/Y')}}</small>
                                <h3 class="card-title">
                                    <a href="events/{{$event->ID}}" style="text-decoration : none; color : #000000;">
                                        {{$event->name}}
                                    </a>
                                </h3>
                                <div class="card-text">{{$event->location}}</div>
                                <strong>{{\Carbon\Carbon::parse($event->date.' '.$event->time)->toDayDateTimeString()}}</strong>
                                <div class="card-text">{!!str_limit($event->description,300)!!}<br></div> {{-- Only display a portion of the description.--}}
                                <a href="events/{{$event->ID}}" class="card-link"></a>
                                <div>
                                <a href="{{$event->link}}" target="_blank" class="card-link"></a>
                                </div>
                                {{-- <a href="$event->link">More Information</a> --}}
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>

        @endforeach
        {{$events->links()}}
    @else
        <p>No Events Found</p>
    @endif

<script>
$(".myBox").click(function() {
  window.location = $(this).find("a").attr("href"); 
  return false;
});
</script>
<script>
$(".rssBox").click(function() {
    window.open($(this).find("a").attr("href")); 
    return false;
});
</script>

@endsection