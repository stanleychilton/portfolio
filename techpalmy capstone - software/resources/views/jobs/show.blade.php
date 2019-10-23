@extends('layouts.app')

@section('content')
    
    <br>
    <div>
        <div class="row">
            <div class="col-md-8 col-sm-8">
                <h1>{{$job->position}}</h1>
            </div>
        </div>
    </div>
    <hr>

    <div class="card" id="showCard">
        <h4 class="card-title">Company</h4>
        <div class="card-text" style="margin-left:15px">
            <h5><a href="/companies/{{$job->company->ID}}" style="text-decoration:none" target="_blank">{!!$job->company->name!!}</a></h5>
        </div>
    
        <h4 class="card-title">Application Due Date</h4>
        <div class="card-text" style="margin-left:15px">
            <p>{{\Carbon\Carbon::parse($job->application_due_date)->toFormattedDateString()}}</p>
        </div>
       
        <h4 class="card-title">Website</h4>
        @if(substr($job->external_link, 0, 4) ==='http')
            <div class="card-text" style="margin-left:15px">
                <a href="{!!$job->external_link!!}" target="_blank">{!!$job->external_link!!}</a>
            </div>
        @elseif(substr($job->external_link, 0, 3) ==='www')
            <div class="card-text" style="margin-left:15px">
                <a href="http://{!!$job->external_link!!}" target="_blank">{!!$job->external_link!!}</a>
            </div>
        @else
            <div class="card-text" style="margin-left:15px">
                <a href="https://www.{!!$job->external_link!!}" target="_blank">{!!$job->external_link!!}</a>
            </div>
        @endif
   
        <h4 class="card-title">Description</h4>
        <div class="card-text" style="margin-left:15px">
            {!!$job->description!!}
        </div>
    </div>
    
    <hr>
    @if($display)
        <a href='/jobs/{{$job->ID}}/edit' class='btn btn-primary'>Edit</a>
    @endif
    <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
    @if($display)
    {!!Form::open(['action'=>['JobController@destroy', $job->ID], 'method'=>'POST','class'=>'float-right'])!!}
        {{Form::hidden('_method', 'DELETE')}}
        {{Form::submit('Delete', ['class'=> 'btn btn-danger'])}}
    {!!Form::close()!!}
    @endif
    <hr>
    <small>Created on {{\Carbon\Carbon::parse($job->created_at)->format('d/m/Y')}}</small>
    <br>
@endsection