@extends('layouts.app')

@section('content')
    <h1>Create Consultant</h1>
    <hr>
    {!! Form::open(['action' => 'ConsultantController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!} 
        <div class="form-group">
            {{Form::label('name', 'Consultant Name')}}<span style="color: red">*</span><h6 style="float:right"><span style="color: red">*</span> required</h6>
            {{-- Create form, so empty value --}}
            {{Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Name'])}}
        </div>
        <div class="form-group">
            {{Form::label('website', 'Website')}}<span style="color: red">*</span>
            {{Form::text('website', '', ['class' => 'form-control', 'placeholder' => 'URL'])}}
        </div>
        <div class="form-group">
            {{Form::label('expertise', 'Area of Expertise')}}<span style="color: red">*</span>
            {{Form::text('expertise', '', ['class' => 'form-control', 'placeholder' => 'e.g. Web Development'])}}
        </div>    
        <div class="form-group">
            {{Form::label('phone', 'Phone')}}<span style="color: red">*</span>
            {{Form::text('phone', '', ['class' => 'form-control', 'placeholder' => 'Phone'])}}
        </div>
        <div class="form-group">
            {{Form::label('email', 'Email')}}<span style="color: red">*</span>
            {{Form::email('email', '', ['class' => 'form-control', 'placeholder' => 'e.g. example@gmail.com'])}}
        </div>
        {{-- <div class="form-group">
            <h3>Address</h3>
            <hr>
            <div class="panel-body">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            {{Form::label('address1', 'Address 1')}}<span style="color: red">*</span>
                            {{Form::text('address1', '', ['class' => 'form-control', 'placeholder' => 'Address 1'])}}
                            <br>
                            {{Form::label('address2', 'Address 2')}}
                            {{Form::text('address2', '', ['class' => 'form-control', 'placeholder' => 'Address 2'])}}
                        </div>
                    </div>
                    <br>
                    <div class="col">
                        <div class="form-group">
                            {{Form::label('city', 'City')}}<span style="color: red">*</span>
                            {{Form::text('city', '', ['class' => 'form-control', 'placeholder' => 'City'])}}
                            <br>
                            {{Form::label('region', 'Region')}}
                            {{Form::text('region', '', ['class' => 'form-control', 'placeholder' => 'Region'])}}
                        </div>
                    </div>
                    <br>
                    <div class="col">
                        <div class="form-group">
                            {{Form::label('postalcode', 'Postal Code')}}
                            {{Form::number('postalcode', '', ['class' => 'form-control', 'placeholder' => 'Postal Code'])}}
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <br>
        </div> --}}
        <div class="form-group">
            {{Form::label('description', 'Description')}}<span style="color: red">*</span>
            {{-- Description body with a text editor :) --}}
            {{Form::textarea('description', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Text'])}}
        </div>
        <div class="form-group">
            {{Form::checkbox('join_mailing_list', 1, true)}}
            &nbsp;
            {{Form::label('join_mailing_list', 'Add this consultant to the local tech business mailing list')}} 
        </div>
        <hr>
        <div class="form-group">
            {{Form::label('logo', 'Consultant Logo', ['class' => 'required'])}}
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
        <div class="form-group">
            {{Form::label('T&C\'s', 'Do you accept the terms and conditions of tech palmy?')}}
            &ensp;
            {{Form::label('yes', 'Yes')}}
            {{Form::radio('terms_and_conditions', 1, false)}}
            &nbsp;
            {{Form::label('no', 'No')}}
            {{Form::radio('terms_and_conditions', 0, true)}}
        </div>
        <p><b>Note: This Consultant will not be displayed on the website until it has been approved by the website admin.</b>
        <hr>
        {{Form::submit('Submit',['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
    <br><br>

    @include('inc.terms_and_conditions')
@endsection
