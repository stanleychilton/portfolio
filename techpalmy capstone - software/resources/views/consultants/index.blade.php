@extends('layouts.app')   {{--Extend sidebar, navbar, and all other base html--}}

@section('content')

    <div class="container">
        <header class="blog-header py-3">
            <div class="row flex-nowrap justify-content-between align-items-center">
            <div class="col-2 text-center">
                <h1 class="blog-header-logo text-dark">CONSULTANTS</h1>
            </div>
            </div>
        </header>
    <div>
    @if(count($consultants) > 0)

        <div class="row">
            @php
                $half = ceil($consultants->count() / 2);
                $chunks = $consultants->chunk($half);
            @endphp
            <div class="col-6">

                @foreach ($chunks[0] as $consultant)
                <div class='myBox' id="myBox">
                    <div class="card border-dark mb-3" style='cursor: pointer;'>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-2 col-sm-2">
                                    <img class="img-rounded" style="width:100%;max-width:200px;max-height:200px" src="/storage/logos/{{$consultant->logo}}">
                                </div>
                                <div class="col-md-10 col-sm-10">
                                    <small class="float-right">Last updated on {{\Carbon\Carbon::parse($consultant->updated_at)->format('d/m/Y')}}</small>
                                    <h2 class="card-title">{{$consultant->name}}</h2>
                                    <h6 class="card-subtitle mb-2 text-muted">Area of Expertise: &nbsp; <strong>{{str_limit($consultant->expertise,50)}}</strong><h6>
                                    <a href="consultants/{{$consultant->ID}}" class="card-link"></a>
                                    
                                    <p class="card-text">{!! str_limit($consultant->description,200)!!}</p>
                                    <i>{{$consultant->website}}</i>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <br>

                @endforeach
            </div>

            <div class="col-6">
                @if(count($consultants) > 1)
                    @foreach ($chunks[1] as $consultant)
                    <div class='myBox' id="myBox">
                        <div class="card border-dark mb-3" style='cursor: pointer;'>
                            <div class="card-body">

                                <div class="row">
                                        <div class="col-md-2 col-sm-2">
                                            <img class="img-rounded" style="width:100%;max-width:200px;max-height:200px" src="/storage/logos/{{$consultant->logo}}">
                                        </div>
                                        <div class="col-md-10 col-sm-10">
                                            <small class="float-right">Last updated on {{\Carbon\Carbon::parse($consultant->updated_at)->format('d/m/Y')}}</small>
                                            <h2 class="card-title">{{$consultant->name}}</h2>
                                            <h6 class="card-subtitle mb-2 text-muted">Area of Expertise: &nbsp; <strong>{{str_limit($consultant->expertise,50)}}</strong><h6>
                                            <a href="consultants/{{$consultant->ID}}" class="card-link"></a>
                                            
                                            <p class="card-text">{!! str_limit($consultant->description,200)!!}</p>
                                            <i>{{$consultant->website}}</i>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        </div>
                        <br>

                    @endforeach
                @endif
            </div>
        </div>
    @else
        <p>No Consultants Found</p>
    @endif

<script>
$(".myBox").click(function() {
  window.location = $(this).find("a").attr("href"); 
  return false;
});
</script>

@endsection