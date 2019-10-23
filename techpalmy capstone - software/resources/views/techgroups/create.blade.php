@extends('layouts.app')

@section('content')
    <h1>Create Tech Group Listing</h1>
    <hr>
    {{-- 'store()'' is the function this view submits to --}}
    {{-- NOTE: whenever you are submitting a file, you need: 1. have enctype attribute in the form and 2. set it to multipart form data  --}}
    {!! Form::open(['action' => 'TechGroupController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!} 
        <div class="form-group">
            {{Form::label('name', 'Name')}}<span style="color: red">*</span><h6 style="float:right"><span style="color: red">*</span> required</h6>
            {{-- Create form, so empty value --}}
            {{Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Name'])}}
        </div>
        <div class="form-group">
            {{Form::label('website', 'Website')}}<span style="color: red">*</span>
            {{Form::text('website', '', ['class' => 'form-control', 'placeholder' => 'Website'])}}
        </div>
        <div class="form-group">
            {{Form::label('email', 'Email')}}<span style="color: red">*</span>
            {{Form::email('email', '', ['class' => 'form-control', 'placeholder' => 'Email'])}}
        </div>
        {{-- <div class="form-group">
            {{Form::label('technology', 'Technology')}}
            {{Form::text('technology', '', ['class' => 'form-control', 'placeholder' => 'Technology'])}}
        </div> --}}
        <div class="form-group">
            {{Form::label('description', 'Description')}}<span style="color: red">*</span>
            {{-- Description body with a text editor :) --}}
            {{Form::textarea('description', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Text'])}}
        </div>

        {{--********** Website Admin Eye's Only End **************--}} 
        <div class="form-group">
            {{Form::label('logo', 'Tech Group Logo', ['class' => 'required'])}}
            {{-- When we submit the form, two things need to happen: 
                1. Save the name of the image to the database so we can access & display it later on, and
                2. Upload the actual file so it knows where to look for it. --}}
            {{Form::file('logo')}}
            <p> For the best results, please ensure your image is aproximately square. 200x200 or 400x400 for best results.

        </div>
        <hr>

        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#TermsAndConditionsModal">
            Terms and Conditions
        </button>
        <div class="form-group"> {{--Admin eyes only--}}
            {{Form::label('T&C\'s', 'Do you accept the terms and conditions of tech palmy?')}}
            &ensp;
            {{Form::label('yes', 'Yes')}}
            {{Form::radio('terms_and_conditions', 1, false)}}
            &nbsp;
            {{Form::label('no', 'No')}}
            {{Form::radio('terms_and_conditions', 0, true)}}
        </div>
        <p><b>Note: This Tech Group will not be displayed on the website until it has been approved by the website admin.</b>
        <hr>
        {{Form::submit('Submit',['class'=>'btn btn-primary'])}}
        <hr>

    {!! Form::close() !!}
    <br><br>

    @include('inc.terms_and_conditions')

@endsection
