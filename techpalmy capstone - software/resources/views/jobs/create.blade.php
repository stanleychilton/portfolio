@extends('layouts.app')

@section('content')
    <h1>Create Job Listing</h1>
    <hr>
    {{-- 'store()'' is the function this view submits to --}}
    {{-- NOTE: whenever you are submitting a file, you need: 1. have enctype attribute in the form and 2. set it to multipart form data  --}}
    {!! Form::open(['action' => 'JobController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!} 
        <div class="form-group">
            {{Form::label('position', 'Job Position')}}<span style="color: red">*</span><h6 style="float:right"><span style="color: red">*</span> required</h6>
            {{-- Create form, so empty value --}}
            {{Form::text('position', '', ['class' => 'form-control', 'placeholder' => 'Position'])}}
        </div>
        <div class="form-group">
            {{Form::label('companyID', 'Company')}}
            {{Form::select('companyID', $companies, null)}}
        </div>
        <div class="form-group">
            {{Form::label('external_link', 'Link')}}<span style="color: red">*</span>
            {{Form::text('external_link', '', ['class' => 'form-control', 'placeholder' => 'Link'])}}
        </div>
        <div class="form-group">
            {{Form::label('application_due_date', 'Due Date (dd/mm/yyyy)')}}<span style="color: red">*</span>
            {!! Form::date('application_due_date', \Carbon\Carbon::now()->addDays(14), ['class' => 'form-control', 'required' => true]) !!}
        </div>
        <div class="form-group">
            {{Form::label('description', 'Description')}}<span style="color: red">*</span>
            {{Form::textarea('description', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Text'])}}
        </div>
        
        {{--********** Website Admin Eye's Only **************--}}
        {{-- <div class="form-group"> --}}
        <!-- <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                {{Form::label('contact', 'Contact person for administative purposes', ['class' => 'h5'])}}
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            {{Form::label('contact_name', 'Name', ['class' => 'required'])}}
                            {{Form::text('contact_name', '', ['class' => 'form-control', 'placeholder' => 'e.g. John Doe'])}} {{--name--}}
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            {{Form::label('email', 'Email', ['class' => 'required'])}}
                            {{Form::email('contact_email', '', ['class' => 'form-control', 'placeholder' => 'e.g. example@gmail.com'])}} {{--email--}}
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            {{Form::label('phone', 'Phone', ['class' => 'required'])}}
                            {{Form::text('contact_phone', '', ['class' => 'form-control', 'placeholder' => 'e.g. (06) 123 4567'])}} {{--work phone--}}
                        </div>
                    </div>    
                </div>  
            </div>
        </div>
        </div> -->
        {{-- </span> --}}
        <hr>
        <!-- {{--********** Website Admin Eye's Only End **************--}} 
        <div class="form-group">
            {{Form::label('logo', 'Company Logo', ['class' => 'required'])}}
            {{-- When we submit the form, two things need to happen: 
                1. Save the name of the image to the database so we can access & display it later on, and
                2. Upload the actual file so it knows where to look for it. --}}
            {{Form::file('logo')}}
        </div> -->

        <!-- <div class="form-group"> {{--Admin eyes only--}}
            {{Form::label('T&C\'s', 'Do you accept the terms and conditions of tech palmy?')}}
            &ensp;
            {{Form::label('yes', 'Yes')}}
            {{Form::radio('terms_and_conditions', 1, false)}}
            &nbsp;
            {{Form::label('no', 'No')}}
            {{Form::radio('terms_and_conditions', 0, true)}}
        </div> -->
        {{Form::submit('Submit',['class'=>'btn btn-primary'])}}
        <hr>

    {!! Form::close() !!}
    <br><br>
@endsection
