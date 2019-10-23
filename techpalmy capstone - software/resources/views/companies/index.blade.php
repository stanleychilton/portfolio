@extends('layouts.app')   {{--Extend sidebar, navbar, and all other base html--}}

@section('content')

    <div class="container">
        <header class="blog-header py-3">
            <div class="row flex-nowrap justify-content-between align-items-center">
            <div class="col-2 text-center">
                <h1 class="blog-header-logo text-dark">COMPANIES</h1>
            </div>
            </div>
        </header>
    <div>

    

    @if(count($companies) > 0)

        <div class="row">
            @php
                $half = ceil($companies->count() / 2);
                $chunks = $companies->chunk($half);
            @endphp
            <div class="col-6">
                @foreach ($chunks[0] as $company)
                <div class='myBox' id="myBox">
                    <div class="card border-dark mb-3">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-2 col-sm-2">
                                    <img class="img-rounded" style="width:100%;max-width:200px;max-height:200px" src="/storage/logos/{{$company->logo}}">
                                </div>
                                <div class="col-md-10 col-sm-10">
                                    <small class="float-right">Last updated on {{\Carbon\Carbon::parse($company->updated_at)->format('d/m/Y')}}</small>
                                    <h4 class="card-title">
                                            {{str_limit($company->name,27)}}  
                                    </h4>
                                    <h6 class="card-subtitle mb-2 text-muted">Technology: &nbsp; <strong>{{str_limit($company->technology,50)}}</strong><h6>
                                    <p class="card-text">{!! str_limit($company->description,150)!!}</p> {{-- Only display a portion of the description.--}}

                                    <a href="companies/{{$company->ID}}" class="card-link"></a>
                                    <i>{{$company->website}}</i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>

                @endforeach
            </div>

            <div class="col-6">
                @if($companies->count() > 1)
                    @foreach ($chunks[1] as $company)
                    <div class='myBox' id="myBox">
                        <div class="card border-dark mb-3" style='cursor: pointer;'>
                            <div class="card-body">

                                <div class="row">
                                        <div class="col-md-2 col-sm-2">
                                            <img class="img-rounded" style="width:100%;max-width:200px;max-height:200px" src="/storage/logos/{{$company->logo}}">
                                        </div>
                                        <div class="col-md-10 col-sm-10">
                                            <small class="float-right">Last updated on {{\Carbon\Carbon::parse($company->updated_at)->format('d/m/Y')}}</small>
                                            <h4 class="card-title">
                                                    {{str_limit($company->name,27)}}  
                                            </h4>
                                            <h6 class="card-subtitle mb-2 text-muted">Technology: &nbsp; <strong>{{str_limit($company->technology,50)}}</strong><h6>
                                            <p class="card-text">{!! str_limit($company->description,150)!!}</p> {{-- Only display a portion of the description.--}}
        
                                            <a href="companies/{{$company->ID}}" class="card-link"></a>
                                            <i>{{$company->website}}</i>
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
        <p>No Companies Found</p>
    @endif

<script>
$(".myBox").click(function() {
  window.location = $(this).find("a").attr("href"); 
  return false;
});
</script>

@endsection