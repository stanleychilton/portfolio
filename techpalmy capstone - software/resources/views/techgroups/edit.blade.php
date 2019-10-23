@extends('layouts.app')

@section('content')
    <br>
    {{-- 'store() is the function we are submitting to' --}}
    {!! Form::open(['action' => ['TechGroupController@update', $techGroup->ID], 'method'=> 'PUT', 'enctype' => 'multipart/form-data']) !!} 
        <h1>Edit {{$techGroup->name}}</h1>
        <hr>
        <div class="form-group">
            {{Form::label('name', 'Name')}}<span style="color: red">*</span><h6 style="float:right"><span style="color: red">*</span> required</h6>
            {{Form::text('name', ''.$techGroup->name, ['class' => 'form-control', 'placeholder' => 'Name'])}}
        </div>
        <div class="form-group">
            {{Form::label('website', 'Website')}}<span style="color: red">*</span>
            {{Form::text('website', ''.$techGroup->website, ['class' => 'form-control', 'placeholder' => 'Website'])}}
        </div>
        <div class="form-group">
            {{Form::label('email', 'Email')}}<span style="color: red">*</span>
            {{Form::email('email', ''.$techGroup->email, ['class' => 'form-control', 'placeholder' => 'Email'])}}
        </div>
        <div class="form-group">
            {{Form::label('description', 'Description')}}<span style="color: red">*</span>
            {{Form::textarea('description', ''.$techGroup->description, ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Description'])}}
        </div>
        <div class="form-group">
            {{Form::label('logo', 'Logo')}}
            <br>
            <img class="img-rounded" style="width:100%;max-width:200px;max-height:200px" src="/storage/logos/{{$techGroup->logo}}">
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
        {{Form::submit('Update',['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
    <hr>
    <br>

    @include('inc.terms_and_conditions')

@endsection