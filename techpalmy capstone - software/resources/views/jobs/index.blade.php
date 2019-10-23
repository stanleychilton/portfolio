@extends('layouts.app') 
{{-- Just need to implement  --}}

@section('content')

    <div class="container">
        <header class="blog-header py-3">
            <div class="row flex-nowrap justify-content-between align-items-center">
            <div class="col-2 text-center">
                <h1 class="blog-header-logo text-dark">JOBS</h1>
            </div>
            </div>
        </header>
    <div>

    @if(count($jobs) > 0)

        <div class="row">
            @php
                $half = ceil($jobs->count() / 2);
                $chunks = $jobs->chunk($half);
            @endphp
            <div class="col-6">
                @foreach ($chunks[0] as $job)
                <div class='myBox' id="myBox">
                    <div class="card border-dark mb-3" style='cursor: pointer;'>
                        <div class="card-body">
                            <a href="jobs/{{$job->ID}}" class="card-link"></a>
                            <div class="row">
                                <div class="col-md-9 col-sm-9">
                                    <h4 class="card-title">{{$job->position}}</h4>
                                </div>
                                <div class="col-md-3 col-sm-3" >
                                    <p class="card-text" style="float:right"><strong>{{$job->company->name}}</strong></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <i>{{str_limit($job->external_link,40)}}</i>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <p class="card-text float-right"><strong>Application Due Date: </strong>{{\Carbon\Carbon::parse($job->application_due_date)->toFormattedDateString()}}</p>
                                </div>    
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <p class="card-text">&nbsp;{!!str_limit($job->description,125)!!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>

                @endforeach
            </div>

            <div class="col-6">
                @if(count($jobs) > 1)
                    @foreach ($chunks[1] as $job)
                    <div class='myBox' id="myBox">
                        <div class="card border-dark mb-3" style='cursor: pointer;'>
                            <div class="card-body">
                                <a href="jobs/{{$job->ID}}" class="card-link"></a>
                                <div class="row">
                                    <div class="col-md-9 col-sm-9">
                                        <h4 class="card-title">{{$job->position}}</h4>
                                    </div>
                                    <div class="col-md-3 col-sm-3" >
                                        <p class="card-text"style="float:right"><strong>{{$job->company->name}}</strong></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <i>{{str_limit($job->external_link,40)}}</i>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <p class="card-text float-right"><strong>Application Due Date: </strong>{{\Carbon\Carbon::parse($job->application_due_date)->toFormattedDateString()}}</p>
                                    </div>    
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <p class="card-text">&nbsp;{!!str_limit($job->description,125)!!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    @endforeach
                @endif
            </div>
    @else
        <p>No Job Found</p>
    @endif

<script>
$(".myBox").click(function() {
  window.location = $(this).find("a").attr("href"); 
  return false;
});
</script>

@endsection