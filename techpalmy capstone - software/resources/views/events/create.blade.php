@extends('layouts.app')

@section('content')
    <h1>Create Event</h1>
    {{-- 'store() is the function we are submitting to' --}}
    <hr>
    {!! Form::open(['action' => 'EventController@store', 'method'=> 'POST']) !!} 
        <div class="form-group">
            {{Form::label('name', 'Event Name')}}<span style="color: red">*</span><h6 style="float:right"><span style="color: red">*</span> required</h6>
            {{-- Create form, so empty value --}}
            {{Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Name'])}}
        </div>
        {{-- <div class="form-group">
            {{Form::label('techgroupID', 'Tech Group ')}}
            {{Form::select('techgroupID', $techgroups, null)}}
        </div> --}}

        <div class="form-group">
            {{Form::label('event time', 'Date')}}<span style="color: red">*</span>
            {!! Form::date('date', \Carbon\Carbon::now(), ['class' => 'form-control', 'required' => true]) !!}
        </div>
        <div class="form-group">
            {{Form::label('event time', 'Start Time')}}<span style="color: red">*</span>
            {!! Form::input('time', 'time', $value = null, $options = array('class'=>'form-control')) !!}
        </div>
        <div class="form-group">
            {{Form::label('duration', 'Duration')}}
            {{Form::text('duration', '', ['class' => 'form-control', 'placeholder' => 'e.g. 2 hours'])}}
        </div>
        <div class="form-group">
            {{Form::label('link', 'Link')}}
            {{Form::text('link', '', ['class' => 'form-control', 'placeholder' => 'e.g. https://moreinfo'])}}
        </div>
        <div class="form-group">
            <h3>Location</h3>
            <hr>
            <div class="panel-body">
                <div class="row">
                    <div class="col-8">
                        <div class="form-group">
                            {{Form::label('location', 'Place')}}<span style="color: red">*</span>
                            {{Form::text('location', '', ['class' => 'form-control', 'placeholder' => 'e.g. Cafe Cuba'])}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="form-group">
                            {{Form::label('address1', 'Address 1')}}<span style="color: red">*</span>
                            {{Form::text('address1', '', ['class' => 'form-control', 'placeholder' => 'Address 1'])}}
                        </div>
                    </div>
                    <br>
                    <div class="col">
                        <div class="form-group">
                            {{Form::label('city', 'City')}}<span style="color: red">*</span>
                            {{Form::text('city', '', ['class' => 'form-control', 'placeholder' => 'City'])}}
                        </div>
                    </div>
                    <br>
                    
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="form-group">
                            {{Form::label('address2', 'Address 2')}}
                            {{Form::text('address2', '', ['class' => 'form-control', 'placeholder' => 'Address 2'])}}
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            {{Form::label('postalcode', 'Postal Code')}}<span style="color: red">*</span>
                            {{Form::number('postalcode', '', ['class' => 'form-control', 'placeholder' => 'Postal Code'])}}
                        </div>
                    </div>
                </div>
                <br>
                
                <br>
                
        </div>
        <hr>
        <div class="form-group">
            {{Form::label('description', 'Description')}}<span style="color: red">*</span>
            {{-- Description body with a text editor :) --}}
            {{Form::textarea('description', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Text'])}}
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
        <hr>
        </div>
    {{Form::submit('Submit',['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}

    @include('inc.terms_and_conditions')
    
@endsection
