@extends('layouts.app')

@section('content')
    
    <br>
    <div>
        <div class="row">
            <div class="col-md-2 col-sm-2">
                <img style="width:100%;max-width:200px;max-height:200px" class="img-rounded" src="/storage/logos/{{$consultant->logo}}">
            </div>
            <div class="col-md-8 col-sm-8">
                <h1>{{$consultant->name}}</h1>
            </div>
        </div>
    </div>
    <hr>
    <br>

    <div class="card" id="showCard">
        <h4 class="card-title">Website</h4>
        @if(substr($consultant->website, 0, 4) ==='http')
            <div class="card-text" style="margin-left:15px">
                <a href="{!!$consultant->website!!}" target="_blank">{!!$consultant->website!!}</a>
            </div>
        @elseif(substr($consultant->website, 0, 3) ==='www')
            <div class="card-text" style="margin-left:15px">
                <a href="http://{!!$consultant->website!!}" target="_blank">{!!$consultant->website!!}</a>
            </div>
        @else
            <div class="card-text" style="margin-left:15px">
                <a href="https://www.{!!$consultant->website!!}" target="_blank">{!!$consultant->website!!}</a>
            </div>
        @endif
    
        <h4 class="card-title">Description</h4>
        <div class="card-text" style="margin-left:15px">
            {!!$consultant->description!!}
        </div>
    
        <h4 class="card-title">Area of Expertise</h4>
        <div class="card-text" style="margin-left:15px">
            {!!$consultant->expertise!!}
        </div>
    
        <hr>
        <h4 class="card-title">Contact Details</h4>
        <div class="card-text" style="margin-left:15px">
            Phone: {{$consultant->phone}}<br>
            Email: <a>{{$consultant->email}}</a> 
        </div>
    
        {{-- <h4 class="card-title">Address</h4>
        <div class="card-text" style="margin-left:15px">
            {!!$consultant->address!!}
        </div> --}}
    </div>
    <hr>
    @if(Auth::user() && Auth::user()->type == 'admin')
        @include('inc.approve', array('model' => 'Consultant','ID' => $consultant->ID, 'flag' => $consultant->flag))
        <hr>
    @endif
    @if($display)
    <a href='/consultants/{{$consultant->ID}}/edit' class='btn btn-primary'>Edit</a>
    @endif
    <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
    @if($display)
    {!!Form::open(['action'=>['ConsultantController@destroy', $consultant->ID], 'method'=>'POST','class'=>'float-right'])!!}
        {{Form::hidden('_method', 'DELETE')}}
        {{Form::submit('Delete', ['class'=> 'btn btn-danger'])}}
    {!!Form::close()!!}
    @endif
    <hr>
    <small>Created on {{\Carbon\Carbon::parse($consultant->created_at)->format('d/m/Y')}}</small>
    <br>
@endsection