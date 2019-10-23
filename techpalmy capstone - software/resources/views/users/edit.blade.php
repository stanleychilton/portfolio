@extends('layouts.app')

@section('content')
    <br>
    {{-- 'store() is the function we are submitting to' --}}
    {!! Form::open(['action' => ['ProfileController@update'], 'method'=> 'PUT', 'enctype' => 'multipart/form-data']) !!} 
        <h1>Edit {{$user->name}}</h1>
       
        <hr>
        <div class="form-group">
            {{Form::label('name', 'Your Name')}}<span style="color: red">*</span><h6 style="float:right"><span style="color: red">*</span> required</h6>
            {{Form::text('name', ''.$user->name, ['class' => 'form-control', 'placeholder' => 'Name'])}}
        </div>
        <div class="form-group">
            {{Form::label('email', 'Email')}}<span style="color: red">*</span>
            {{Form::text('email', ''.$user->email, ['class' => 'form-control', 'placeholder' => 'Email'])}}
        </div>
        <div class="form-group">
            {{Form::checkbox('join_mailing_list', 1, ($user->mailinglist)==1)}}
            &nbsp;
            {{Form::label('join_mailing_list', 'Join the mailing list to keep updated on job postings and events.')}} 
        </div>

        <hr>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#TermsAndConditionsModal">
            Terms and Conditions
        </button>
        <div class="form-group"> {{--Admin eyes only--}}
            {{Form::label('T&C\'s', 'Do you accept the terms and conditions of tech palmy?')}}
            &ensp;
            {{Form::label('yes', 'Yes')}}
            {{Form::radio('terms_and_conditions', 1, true)}}
            &nbsp;
            {{Form::label('no', 'No')}}
            {{Form::radio('terms_and_conditions', 0, false)}}
        </div>
        <hr>
        {{Form::submit('Update',['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
    <hr>
    @include('inc.terms_and_conditions')

    <br>
@endsection