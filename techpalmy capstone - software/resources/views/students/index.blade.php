@extends('layouts.app') 
{{-- Just need to implement  --}}

@section('content')

    <div class="container">
        <header class="blog-header py-3">
            <div class="row flex-nowrap justify-content-between align-items-center">
            <div class="col-3 text-center">
                <h1 class="blog-header-logo text-dark">Student jobs</h1>
            </div>
            </div>
        </header>
    <div>
    @if(count($companies) > 0)
        @foreach ($companies as $company)
            <div class='myBox' id="myBox">
                <div class="card border-dark mb-3">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-2 col-sm-2">
                                <img class="img-rounded" style="width:100%;max-width:200px;max-height:200px" src="/storage/logos/{{$company->logo}}">
                            </div>
                            <div class="col-md-8 col-sm-8">
                                <h2 class="card-title">{{str_limit($company->name,27)}}</h2>
                                <h6 class="card-subtitle mb-2 text-muted">Technology: &nbsp; <strong>{{$company->technology}}</strong><h6>
                                <a href="companies/{{$company->ID}}" class="card-link"></a>
                                <p class="card-text">{{$company->website}}</p>
                                <small>Created on {{\Carbon\Carbon::parse($company->created_at)->format('d/m/Y')}}</small>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
            </div>

        @endforeach
        {{$companies->links()}}
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