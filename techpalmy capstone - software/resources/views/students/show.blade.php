@extends('layouts.app')

@section('content')
    
    <br>
    <div class="well">
        <div class="row">
            <div class="col-md-2 col-sm-2">
                <img style="width:100%;max-width:200px;max-height:200px" class="img-rounded" src="/storage/logos/{{$company->logo}}">
            </div>
            <div class="col-md-8 col-sm-8">
                <h1 class="centered">{{$company->name}}</h1>
            </div>
        {{-- This is not parsing the html with double curly braces, so use 1 curly brace and 
            two exclamation marks to show it --}}
        </div>
    </div>
    <hr>

    <div class="well">
        @if(($company->internships)==1)
            <h5>{{$company->name}} is <strong>likely</strong> to offer summer work to students.</h5>
        @else
            <h5>{{$company->name}} do <strong>not</strong> often offer sumer work to students.</h5>
        @endif
    </div>
    <br>
    <div class="well">
        <h4>Website</h4>
        <div style="margin-left:15px">
            {!!$company->website!!}
        </div>
    </div>

    <div class="well">
        <h4>Description</h4>
        <div style="margin-left:15px">
            {!!$company->description!!}
        </div>
    </div>

    <div class="well">
        <h4>Industry</h4>
        <div style="margin-left:15px">
            {!!$company->industry!!}
        </div>
    </div>

    <div class="well">
        <h4>Technologies</h4>
        <div style="margin-left:15px">
            {!!$company->technology!!}
        </div>
    </div>

    <div class="well">
        <h4>Type of Business</h4>
        <div style="margin-left:15px">
            {!!$company->business!!}
        </div>
    </div>

    <div class="well">
        <h4>Company Size</h4>
        <div style="margin-left:15px">
            {{$company->company_size}}
        </div>
    </div>

    <div class="well">
        <h4>Contact Details</h4>
        <div style="margin-left:15px">
            Phone: {{$company->phone}}<br>
            Email: <a>{{$company->email}}</a> 
        </div>
    </div>

    <div class="well">
        <h4>Address</h4>
        <div style="margin-left:15px">
            {!!$company->address!!}
        </div>
    </div>
    <hr>
    <a href='/companies/{{$company->ID}}/edit' class='btn btn-primary'>Edit</a>
    <a href="/companies" class="btn btn-primary">Back</a>
    {!!Form::open(['action'=>['CompanyController@destroy', $company->ID], 'method'=>'POST','class'=>'float-right'])!!}
        {{Form::hidden('_method', 'DELETE')}}
        {{Form::submit('Delete', ['class'=> 'btn btn-danger'])}}
    {!!Form::close()!!}
    <hr>
    <small>Created on {{\Carbon\Carbon::parse($company->created_at)->format('d/m/Y')}}</small>
    <br>
@endsection