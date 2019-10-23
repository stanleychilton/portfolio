@extends('layouts.app')

@section('content')
    <br>
    {{-- 'store() is the function we are submitting to' --}}
    {!! Form::open(['action' => ['CompanyController@update', $company->ID], 'method'=> 'PUT', 'enctype' => 'multipart/form-data']) !!} 
        <h1>Edit {{$company->name}}</h1>
        <hr>
        <div class="form-group">
            {{Form::label('name', 'Company Name')}}<span style="color: red">*</span><h6 style="float:right"><span style="color: red">*</span> required</h6>
            {{Form::text('name', ''.$company->name, ['class' => 'form-control', 'placeholder' => 'Name'])}}
        </div>
        <div class="form-group">
            {{Form::label('website', 'Website')}}<span style="color: red">*</span>
            {{Form::text('website', ''.$company->website, ['class' => 'form-control', 'placeholder' => 'Website'])}}
        </div>
        <div class="form-group">
            {{Form::label('industry', 'Industry')}}<span style="color: red">*</span>
            {{Form::text('industry', ''.$company->industry, ['class' => 'form-control', 'placeholder' => 'e.g. Medical, Financial, Payroll, etc'])}}
        </div>
        <div class="form-group">
            {{Form::label('technology', 'Technologies / Areas of Expertise')}}<span style="color: red">*</span>
            {{Form::text('technology', ''.$company->technology, ['class' => 'form-control', 'placeholder' => 'e.g. .NET, Linux, PHP, C#, Java, etc'])}}
        </div>
        <div class="form-group">
            {{Form::label('business', 'Type of Business')}}
            {{Form::text('business', ''.$company->business, ['class' => 'form-control', 'placeholder' => 'e.g. Product, Software Product, or Services'])}}
        </div>
        <div class="form-group">
            {{Form::label('company_size', 'Company Size')}}
            {{Form::number('company_size', ''.$company->company_size, ['class' => 'form-control', 'placeholder' => ''])}}
        </div>
        <div class="form-group">
            {{Form::label('phone', 'Company Phone')}}<span style="color: red">*</span>
            {{Form::text('phone', ''.$company->phone, ['class' => 'form-control', 'placeholder' => 'Phone'])}}
        </div>
        <div class="form-group">
            {{Form::label('email', 'Company Email')}}<span style="color: red">*</span>
            {{Form::email('email', ''.$company->email, ['class' => 'form-control', 'placeholder' => 'e.g. example@gmail.com'])}} {{--company email--}}
        </div>
        <div class="form-group">
            <h3>Address</h3>
            <hr>
            <div class="panel-body">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            {{Form::label('address1', 'Address 1')}}<span style="color: red">*</span>
                            {{Form::text('address1', ''.$address->address1, ['class' => 'form-control', 'placeholder' => 'Address 1'])}}
                            <br>
                            {{Form::label('address2', 'Address 2')}}
                            {{Form::text('address2', ''.$address->address2, ['class' => 'form-control', 'placeholder' => 'Address 2'])}}
                        </div>
                    </div>
                    <br>
                    <div class="col">
                        <div class="form-group">
                            {{Form::label('city', 'City')}}<span style="color: red">*</span>
                            {{Form::text('city', ''.$address->city, ['class' => 'form-control', 'placeholder' => 'City'])}}
                            <br>
                            {{Form::label('region', 'Region')}}
                            {{Form::text('region', ''.$address->region, ['class' => 'form-control', 'placeholder' => 'Region'])}}
                        </div>
                    </div>
                    <br>
                    <div class="col">
                        <div class="form-group">
                            {{Form::label('postalcode', 'Postal Code')}}<span style="color: red">*</span>
                            {{Form::number('postalcode', ''.$address->postalcode, ['class' => 'form-control', 'placeholder' => 'Postal Code'])}}
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <br>
        </div>
        <div class="form-group">
            {{Form::checkbox('internships', 1, ($company->internships)==1)}}
            &nbsp;
            {{Form::label('internships', 'Summer Internships Offered')}}
        </div>
        <div class="form-group">{{--Admin eyes only--}}
            {{-- {{$temp = ($company->join_mailing_list)=='1'}}
            {{$temp}} --}}
            {{Form::checkbox('join_mailing_list', 1, ($company->mailinglist)==1)}}
            &nbsp;
            {{Form::label('join_mailing_list', 'Add this company to the local tech business mailing list')}} 
        </div>
        <div class="form-group">
            {{Form::label('description', 'Description')}}<span style="color: red">*</span>
            {{Form::textarea('description', ''.$company->description, ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Description'])}}
        </div>
        <hr>
        <div class="container">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{Form::label('contact', 'Contact person for administative purposes', ['class' => 'h5'])}}
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                {{Form::label('contact_name', 'Name', ['class' => 'required'])}}<span style="color: red">*</span>
                                {{Form::text('contact_name', ''.$company->contact_name, ['class' => 'form-control', 'placeholder' => 'contact'])}} {{--name--}}
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                {{Form::label('email', 'Email', ['class' => 'required'])}}<span style="color: red">*</span>
                                {{Form::email('contact_email', ''.$company->contact_email, ['class' => 'form-control', 'placeholder' => 'contact_email'])}} {{--email--}}
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                {{Form::label('phone', 'Phone', ['class' => 'required'])}}<span style="color: red">*</span>
                                {{Form::number('contact_number', ''.$company->contact_number, ['class' => 'form-control', 'placeholder' => 'Contact_number'])}} {{--work phone--}}
                            </div>
                        </div>    
                    </div>  
                </div>
            </div>
        </div>
        <hr>

        <div class="form-group">
            {{Form::label('logo', 'Logo')}}
            <br>
            <img class="img-rounded" style="width:100%;max-width:200px;max-height:200px" src="/storage/logos/{{$company->logo}}">
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
        <hr>
        {{Form::submit('Update',['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
    <hr>
    @include('inc.terms_and_conditions')
    <br>
@endsection