@extends('layouts.app') 
{{-- Just need to implement  --}}

@section('content')

    <div class="container">
        <header class="blog-header py-3">
            <div class="row flex-nowrap justify-content-between align-items-center">
            <div class="col-12 text-left">
                <h1 class="blog-header-logo text-dark">TECH GROUPS</h1>
            </div>
            </div>
        </header>
    <div>
    @if(count($techGroups) > 0)

        <div class="row">
            @php
                $half = ceil($techGroups->count() / 2);
                $chunks = $techGroups->chunk($half);
            @endphp
            <div class="col-6">
                @foreach ($chunks[0] as $techGroup)
                    <div class='myBox' id="myBox">
                        <div class="card border-dark mb-3" style='cursor: pointer;'>
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-2 col-sm-2">
                                        <img class="img-rounded" style="width:100%;max-width:200px;max-height:200px" src="/storage/logos/{{$techGroup->logo}}">
                                    </div>
                                    <div class="col-md-10 col-sm-10">
                                        <small class="float-right">Lasted updated on {{\Carbon\Carbon::parse($techGroup->updated_at)->format('d/m/Y')}}</small>
                                        <h3 class="card-title">{{$techGroup->name}}</h3>
                                        <a href="techgroups/{{$techGroup->ID}}" class="card-link"></a>
                                        <i>{{$techGroup->website}}</i>
                                        <p class="card-text">{!!str_limit($techGroup->description,250)!!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>

                @endforeach
            </div>

            <div class="col-6">
                @if(count($techGroups) > 1)
                    @foreach ($chunks[1] as $techGroup)
                        <div class='myBox' id="myBox">
                            <div class="card border-dark mb-3" style='cursor: pointer;'>
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-md-2 col-sm-2">
                                            <img class="img-rounded" style="width:100%;max-width:200px;max-height:200px" src="/storage/logos/{{$techGroup->logo}}">
                                        </div>
                                        <div class="col-md-10 col-sm-10">
                                            <small class="float-right">Lasted updated on {{\Carbon\Carbon::parse($techGroup->updated_at)->format('d/m/Y')}}</small>
                                            <h3 class="card-title">{{$techGroup->name}}</h3>
                                            <a href="techgroups/{{$techGroup->ID}}" class="card-link"></a>
                                            <i>{{$techGroup->website}}</i>
                                            <p class="card-text">{!!str_limit($techGroup->description,250)!!}</p>
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
        <p>No Tech Groups Found</p>
    @endif

<script>
$(".myBox").click(function() {
  window.location = $(this).find("a").attr("href"); 
  return false;
});
</script>

@endsection