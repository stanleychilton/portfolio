@extends('layouts.app')

@section('content')

<br>
    <!-- Companies Carousel -->
    @if(count($companies) > 0)
        <div class="container-fluid" id="CompaniesCarouselDiv">      

            <h1 class="text-center mb-3">Companies</h1>

            @if(count($companies) < 4)
                <div id="myCompaniesCarousel" class="carousel slide" data-ride="carousel" data-interval="0">
            @else
                <div id="myCompaniesCarousel" class="carousel slide" data-ride="carousel">
            @endif


                <div class="carousel-inner row w-100 mx-auto">

                
                    @foreach ($companies as $company)
                        @if ($loop->first) 
                        <div class="carousel-item col-md-4 active">
                        @else
                        <div class="carousel-item col-md-4">
                        @endif
                            <div class="card" style="height: 600px;">
                                <img class="card-img-top img-fluid" src="/storage/logos/{{$company->logo}}" alt="Card image cap" style="height: 300px;">
                                <a href="companies/{{$company->ID}}"></a>
                                <div class="card-body">
                                    <h4 class="card-title">{{$company->name}}</h4>
                                    <p class="card-text">{!! str_limit($company->description,300)!!}</p>
                                    <p class="card-text"><small class="text-muted">Last updated on {{\Carbon\Carbon::parse($company->updated_at)->format('d/m/Y')}}</small></p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                {{-- @else
                    <p id="NoneFoundP">No Companies Found</p> --}}
                </div>

                @if(count($companies) > 3)

                    <ol class="carousel-indicators">
                        @foreach ($companies as $company)
                            @if ($loop->first) 
                            <li data-target="#myCompaniesCarousel" data-slide-to="{{$loop->index}}" class="active"></li>
                            @else
                            <li data-target="#myCompaniesCarousel" data-slide-to="{{$loop->index}}"></li> 
                            @endif
                        @endforeach
                    </ol>

                    <a class="carousel-control-prev" href="#myCompaniesCarousel" role="button" data-slide="prev">
                        <div class="carousel-control-prev-icon" aria-hidden="true"></div>
                        <div class="sr-only">Previous</div>
                    </a>
                    <a class="carousel-control-next" href="#myCompaniesCarousel" role="button" data-slide="next">
                        <div class="carousel-control-next-icon" aria-hidden="true"></div>
                        <div class="sr-only">Next</div>
                    </a>
                @endif
            </div>
        </div>
    @endif

    <br>
    
    <!-- Consultants  Carousel -->
    @if(count($consultants) > 0)
        <div class="container-fluid" id="consultantsCarouselDiv">      

        <h1 class="text-center mb-3">Consultants</h1>
            @if(count($consultants) < 4)
                <div id="myconsultantsCarousel" class="carousel slide" data-ride="carousel" data-interval="0">
            @else
                <div id="myconsultantsCarousel" class="carousel slide" data-ride="carousel">
            @endif

            


            <div class="carousel-inner row w-100 mx-auto">

                @foreach ($consultants as $consultant)
                    @if ($loop->first) 
                    <div class="carousel-item col-md-4 active">
                    @else
                    <div class="carousel-item col-md-4">
                    @endif
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">{{$consultant->name}}</h4>
                                <a href="consultants/{{$consultant->ID}}"></a>
                                <p class="card-text">{!! str_limit($consultant->description,80)!!}</p>
                                <p class="card-text"><small class="text-muted">Last updated on {{\Carbon\Carbon::parse($consultant->updated_at)->format('d/m/Y')}}</small></p>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{-- <p id="NoneFoundP">No consultants Found</p>
            @endif --}}
            </div>

            @if(count($consultants) > 3)

                <ol class="carousel-indicators">
                    @foreach ($consultants as $consultant)
                        @if ($loop->first) 
                        <li data-target="#myconsultantsCarousel" data-slide-to="{{$loop->index}}" class="active"></li>
                        @else
                        <li data-target="#myconsultantsCarousel" data-slide-to="{{$loop->index}}"></li> 
                        @endif
                    @endforeach
                </ol>

                <a class="carousel-control-prev" href="#myconsultantsCarousel" role="button" data-slide="prev">
                    <div class="carousel-control-prev-icon" aria-hidden="true"></div>
                    <div class="sr-only">Previous</div>
                </a>
                <a class="carousel-control-next" href="#myconsultantsCarousel" role="button" data-slide="next">
                    <div class="carousel-control-next-icon" aria-hidden="true"></div>
                    <div class="sr-only">Next</div>
                </a>
            @endif
            </div>
        </div>
    @endif 

    <br>
    <!-- Jobs Carousel -->
    @if(count($jobs) > 0)
        <div class="container-fluid" id="JobsCarouselDiv">      

        <h1 class="text-center mb-3">Jobs</h1>
            @if(count($jobs) < 4)
                <div id="myJobsCarousel" class="carousel slide" data-ride="carousel" data-interval="0">
            @else
                <div id="myJobsCarousel" class="carousel slide" data-ride="carousel">
            @endif

            


            <div class="carousel-inner row w-100 mx-auto">

                @foreach ($jobs as $job)
                    @if ($loop->first) 
                    <div class="carousel-item col-md-4 active">
                    @else
                    <div class="carousel-item col-md-4">
                    @endif
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">{{$job->position}}</h4>
                                <a href="jobs/{{$job->ID}}"></a>
                                <p class="card-text">{!! str_limit($job->description,40)!!}</p>
                                <p class="card-text"><small class="text-muted">Last updated on {{\Carbon\Carbon::parse($job->updated_at)->format('d/m/Y')}}</small></p>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{-- <p id="NoneFoundP">No Jobs Found</p>
            @endif --}}
            </div>

            @if(count($jobs) > 3)

                <ol class="carousel-indicators">
                    @foreach ($jobs as $job)
                        @if ($loop->first) 
                        <li data-target="#myJobsCarousel" data-slide-to="{{$loop->index}}" class="active"></li>
                        @else
                        <li data-target="#myJobsCarousel" data-slide-to="{{$loop->index}}"></li> 
                        @endif
                    @endforeach
                </ol>

                <a class="carousel-control-prev" href="#myJobsCarousel" role="button" data-slide="prev">
                    <div class="carousel-control-prev-icon" aria-hidden="true"></div>
                    <div class="sr-only">Previous</div>
                </a>
                <a class="carousel-control-next" href="#myJobsCarousel" role="button" data-slide="next">
                    <div class="carousel-control-next-icon" aria-hidden="true"></div>
                    <div class="sr-only">Next</div>
                </a>
            @endif
            </div>
        </div>
    @endif

    <br>
    <!-- Events Carousel -->
    @if(count($events) > 0)

        <div class="container-fluid" id="EventsCarouselDiv">      

        <h1 class="text-center mb-3">Events</h1>
            @if(count($events) < 4)
                <div id="myEventsCarousel" class="carousel slide" data-ride="carousel" data-interval="0">
            @else
                <div id="myEventsCarousel" class="carousel slide" data-ride="carousel">
            @endif

            
            <div class="carousel-inner row w-100 mx-auto">
                @foreach ($events as $event)
                    @if ($loop->first) 
                    <div class="carousel-item col-md-4 active">
                    @else
                    <div class="carousel-item col-md-4">
                    @endif
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">{{$event->name}}</h4>
                                <a href="events/{{$event->ID}}"></a>
                                <p class="card-text">{!! str_limit($event->description,40)!!}</p>
                                <p class="card-text"><small class="text-muted">Last updated on {{\Carbon\Carbon::parse($event->updated_at)->format('d/m/Y')}}</small></p>
                            </div>
                        </div>
                    </div>
                @endforeach
            {{-- @else
                <p id="NoneFoundP">No Events Found</p> --}}
            </div>

            @if(count($events) > 3)

                <ol class="carousel-indicators">
                    @foreach ($events as $event)
                        @if ($loop->first) 
                        <li data-target="#myEventsCarousel" data-slide-to="{{$loop->index}}" class="active"></li>
                        @else
                        <li data-target="#myEventsCarousel" data-slide-to="{{$loop->index}}"></li> 
                        @endif
                    @endforeach
                </ol>

                <a class="carousel-control-prev" href="#myEventsCarousel" role="button" data-slide="prev">
                    <div class="carousel-control-prev-icon" aria-hidden="true"></div>
                    <div class="sr-only">Previous</div>
                </a>
                <a class="carousel-control-next" href="#myEventsCarousel" role="button" data-slide="next">
                    <div class="carousel-control-next-icon" aria-hidden="true"></div>
                    <div class="sr-only">Next</div>
                </a>
            @endif
            </div>
        </div>
    @endif


           

    <script>
        $(document).ready(function() {
            
            $("#CompaniesCarouselDiv").on("slide.bs.carousel", function(e) {
                var $e = $(e.relatedTarget);
                var idx = $e.index();
                var itemsPerSlide = 3;
                var totalItems = $(".carousel-item").length;

                if (idx >= totalItems - (itemsPerSlide - 1)) {
                var it = itemsPerSlide - (totalItems - idx);
                for (var i = 0; i < it; i++) {
                    // append slides to end
                    if (e.direction == "left") {
                    $(".carousel-item")
                        .eq(i)
                        .appendTo(".carousel-inner");
                    } else {
                    $(".carousel-item")
                        .eq(0)
                        .appendTo($(this).find(".carousel-inner"));
                    }
                }
                }
            });
        });
        
        $(document).ready(function() {
            
            $("#consultantsCarouselDiv").on("slide.bs.carousel", function(e) {
                var $e = $(e.relatedTarget);
                var idx = $e.index();
                var itemsPerSlide = 3;
                var totalItems = $(".carousel-item").length;

                if (idx >= totalItems - (itemsPerSlide - 1)) {
                var it = itemsPerSlide - (totalItems - idx);
                for (var i = 0; i < it; i++) {
                    // append slides to end
                    if (e.direction == "left") {
                    $(".carousel-item")
                        .eq(i)
                        .appendTo(".carousel-inner");
                    } else {
                    $(".carousel-item")
                        .eq(0)
                        .appendTo($(this).find(".carousel-inner"));
                    }
                }
                }
            });
        });

        $(document).ready(function() {
            
            $("#JobsCarouselDiv").on("slide.bs.carousel", function(e) {
                var $e = $(e.relatedTarget);
                var idx = $e.index();
                var itemsPerSlide = 3;
                var totalItems = $(".carousel-item").length;

                if (idx >= totalItems - (itemsPerSlide - 1)) {
                var it = itemsPerSlide - (totalItems - idx);
                for (var i = 0; i < it; i++) {
                    // append slides to end
                    if (e.direction == "left") {
                    $(".carousel-item")
                        .eq(i)
                        .appendTo(".carousel-inner");
                    } else {
                    $(".carousel-item")
                        .eq(0)
                        .appendTo($(this).find(".carousel-inner"));
                    }
                }
                }
            });
        });

        $(document).ready(function() {
            
            $("#EventsCarouselDiv").on("slide.bs.carousel", function(e) {
                var $e = $(e.relatedTarget);
                var idx = $e.index();
                var itemsPerSlide = 3;
                var totalItems = $(".carousel-item").length;

                if (idx >= totalItems - (itemsPerSlide - 1)) {
                var it = itemsPerSlide - (totalItems - idx);
                for (var i = 0; i < it; i++) {
                    // append slides to end
                    if (e.direction == "left") {
                    $(".carousel-item")
                        .eq(i)
                        .appendTo(".carousel-inner");
                    } else {
                    $(".carousel-item")
                        .eq(0)
                        .appendTo($(this).find(".carousel-inner"));
                    }
                }
                }
            });
        });
    </script>

    <script>
        $(".card").click(function() {
        window.location = $(this).find("a").attr("href"); 
        return false;
        });
    </script>
@endsection