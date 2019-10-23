@extends('layouts.app')

@section('content')
    <br>
    {!! Form::open(['action' => ['EventController@update', $event->ID], 'method'=> 'PUT']) !!} 
        <h1>Edit {{$event->name}}</h1>
        <hr>
        <div class="form-group">
            {{Form::label('name', 'Event Name')}}<span style="color: red">*</span><h6 style="float:right"><span style="color: red">*</span> required</h6>
            {{Form::text('name', ''.$event->name, ['class' => 'form-control', 'placeholder' => 'Name'])}}
        </div>
        <div class="form-group">
            {{Form::label('event time', 'Event Date', ['class' => 'required'])}}<span style="color: red">*</span>
            {!! Form::date('date', $event->date, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {{Form::label('event time', 'Event Time')}}<span style="color: red">*</span>
            {!! Form::input('time', 'time', $value = $event->time, $options = array('class'=>'form-control')) !!}
        </div>
        <div class="form-group">
            {{Form::label('duration', 'Duration')}}
            {{Form::text('duration', $event->duration, ['class' => 'form-control', 'placeholder' => 'e.g. 2 hours'])}}
        </div>
        <div class="form-group">
            {{Form::label('link', 'Link')}}
            {{Form::text('link', $event->link, ['class' => 'form-control', 'placeholder' => 'e.g. https://moreinfo'])}}
        </div>
        <div class="form-group">
            <h3>Location</h3>
            <hr>
            <div class="panel-body">
                <div class="row">
                    <div class="col-8">
                        <div class="form-group">
                            {{Form::label('location', 'Place')}}<span style="color: red">*</span>
                            {{Form::text('location', $event->location, ['class' => 'form-control', 'placeholder' => 'e.g. Cafe Cuba'])}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="form-group">
                            {{Form::label('address1', 'Address 1')}}<span style="color: red">*</span>
                            {{Form::text('address1', ''.$address->address1, ['class' => 'form-control', 'placeholder' => 'Address 1'])}}
                        </div>
                    </div>
                    <br>
                    <div class="col">
                        <div class="form-group">
                            {{Form::label('city', 'City')}}<span style="color: red">*</span>
                            {{Form::text('city', ''.$address->city, ['class' => 'form-control', 'placeholder' => 'City'])}}
                        </div>
                    </div>
                    <br>
                    
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="form-group">
                            {{Form::label('address2', 'Address 2')}}
                            {{Form::text('address2', ''.$address->address2, ['class' => 'form-control', 'placeholder' => 'Address 2'])}}
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            {{Form::label('postalcode', 'Postal Code')}}<span style="color: red">*</span>
                            {{Form::number('postalcode', ''.$address->postalcode, ['class' => 'form-control', 'placeholder' => 'Postal Code'])}}
                        </div>
                    </div>
                </div>
        </div>
        <hr>
        <div class="form-group">
            {{Form::label('description', 'Description')}}<span style="color: red">*</span>
            {{-- Description body with a text editor :) --}}
            {{Form::textarea('description', ''.$event->description, ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Description'])}}
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
        {{Form::submit('Update',['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}

    <br>

    @include('inc.terms_and_conditions')

@endsection