@extends('layouts.app')

@section('content')
    <br>
    {{-- 'store() is the function we are submitting to' --}}
    {!! Form::open(['action' => ['JobController@update', $job->ID], 'method'=> 'PUT', 'enctype' => 'multipart/form-data']) !!} 
        <h2>Edit {{$job->position}}</h2>
        <div class="well">
            <div style="margin-left:15px">
                <h5><b>{!!$job->company->name!!}</b></h5>
            </div>
        </div> 
        <hr>
        <div class="form-group">
            {{Form::label('position', 'Job Position')}}<span style="color: red">*</span><h6 style="float:right"><span style="color: red">*</span> required</h6>
            {{Form::text('position', ''.$job->position, ['class' => 'form-control', 'placeholder' => 'Position'])}}
        </div>
        <div class="form-group">
            {{Form::label('companyID', 'Company ')}}
            {{Form::select('companyID', $companies, $job->company)}}
        </div>
        <div class="form-group">
            {{Form::label('external_link', 'Link')}}<span style="color: red">*</span>
            {{Form::text('external_link', ''.$job->external_link, ['class' => 'form-control', 'placeholder' => 'Link'])}}
        </div>
        <div class="form-group">
            {{Form::label('application_due_date', 'Due Date')}}<span style="color: red">*</span>
            {!! Form::date('application_due_date', \Carbon\Carbon::parse($job->application_due_date), ['class' => 'form-control', 'required' => true]) !!}
        </div>
        <div class="form-group">
            {{Form::label('description', 'Description')}}<span style="color: red">*</span>
            {{Form::textarea('description', ''.$job->description, ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Description'])}}
        </div>
        
        <hr>
        <!-- <div class="form-group"> {{--Admin eyes only--}}
            {{Form::label('T&C\'s', 'Do you accept the terms and conditions of tech palmy?')}}
            &ensp;
            {{Form::label('yes', 'Yes')}}
            {{Form::radio('terms_and_conditions', 1, false)}}
            &nbsp;
            {{Form::label('no', 'No')}}
            {{Form::radio('terms_and_conditions', 0, true)}}
        </div> -->
        {{Form::submit('Update',['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
    <hr>
    <br>
@endsection