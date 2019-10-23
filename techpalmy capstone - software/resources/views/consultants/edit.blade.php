@extends('layouts.app')

@section('content')
    <br>
    {!! Form::open(['action' => ['ConsultantController@update', $consultant->ID], 'method'=> 'PUT', 'enctype' => 'multipart/form-data']) !!} 
        <h1>Edit {{$consultant->name}}</h1>
        <hr>
        <div class="form-group">
            {{Form::label('name', 'Consultant Name')}}<span style="color: red">*</span><h6 style="float:right"><span style="color: red">*</span> required</h6>
            {{Form::text('name', ''.$consultant->name, ['class' => 'form-control', 'placeholder' => 'Name'])}}
        </div>
        <div class="form-group">
            {{Form::label('website', 'Website')}}<span style="color: red">*</span>
            {{Form::text('website', ''.$consultant->website, ['class' => 'form-control', 'placeholder' => 'Website'])}}
        </div>
        <div class="form-group">
            {{Form::label('expertise', 'Area of Expertise')}}<span style="color: red">*</span>
            {{Form::text('expertise', ''.$consultant->expertise, ['class' => 'form-control', 'placeholder' => 'e.g. Web Development'])}}
        </div>
        <div class="form-group">
            {{Form::label('phone', 'Phone')}}<span style="color: red">*</span>
            {{Form::text('phone', ''.$consultant->phone, ['class' => 'form-control', 'placeholder' => 'Phone'])}}
        </div>
        <div class="form-group">
            {{Form::label('email', 'Email')}}<span style="color: red">*</span>
            {{Form::email('email', ''.$consultant->email, ['class' => 'form-control', 'placeholder' => 'e.g. example@gmail.com'])}} {{--consultant email--}}
        </div>
        {{-- <div class="form-group">
            <h3>Address</h3>
            <hr>
            <div class="input-group-sm" style="margin-left:25px">
                
                {{Form::label('city', 'City')}}<span style="color: red">*</span>
                {{Form::text('city', ''.$address->city, ['class' => 'form-control', 'placeholder' => 'City'])}}
                <br>
                {{Form::label('address1', 'Address 1')}}<span style="color: red">*</span>
                {{Form::text('address1', ''.$address->address1, ['class' => 'form-control', 'placeholder' => 'Address 1'])}}
                <br>
                {{Form::label('address2', 'Address 2')}}
                {{Form::text('address2', ''.$address->address2, ['class' => 'form-control', 'placeholder' => 'Address 2'])}}
                <br>
                {{Form::label('region', 'Region')}}
                {{Form::text('region', ''.$address->region, ['class' => 'form-control', 'placeholder' => 'Region'])}}
                <br>
                {{Form::label('postalcode', 'Postal Code')}}
                {{Form::number('postalcode', ''.$address->postalcode, ['class' => 'form-control', 'placeholder' => 'Postal Code'])}}
            </div>
            <hr>
            <br>
        </div> --}}

        <div class="form-group">
            {{Form::label('description', 'Description')}}<span style="color: red">*</span>
            {{Form::textarea('description', ''.$consultant->description, ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Description'])}}
        </div>

        <div class="form-group">
            {{Form::checkbox('join_mailing_list', 1, ($consultant->mailinglist)==1)}}
            &nbsp;
            {{Form::label('join_mailing_list', 'Add this consultant to the local tech business mailing list')}} 
        </div>

        <hr>

        <div class="form-group">
            {{Form::label('logo', 'Logo')}}
            <br>
            <img class="img-rounded" style="width:100%;max-width:200px;max-height:200px" src="/storage/logos/{{$consultant->logo}}">
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
        <hr>
        {{Form::submit('Update',['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
    <hr>
    <br>
    @include('inc.terms_and_conditions')
    
@endsection