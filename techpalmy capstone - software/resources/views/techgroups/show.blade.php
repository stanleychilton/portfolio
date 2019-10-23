@extends('layouts.app')
@section('script')
<script type='text/javascript'>
    function addAdminShow()
    {
        if(document.getElementById('hidden').style.display == 'none')
        {
            document.getElementById('adminButton').value = 'Collapse';
            document.getElementById('hidden').style.display = 'block';
        }
        else
        {
            document.getElementById('adminButton').value = 'Add Admin';
            document.getElementById('hidden').style.display = 'none';
        }
    }
</script>
@endsection
@section('content')   
    <br>
    <div>
        <div class="row">
            <div class="col-md-2 col-sm-2">
                <img style="width:100%;max-width:200px;max-height:200px" class="img-rounded" src="/storage/logos/{{$techGroup->logo}}">
            </div>
            <div class="col-md-8 col-sm-8">
                <h1>{{$techGroup->name}}</h1>
            </div>
        {{-- This is not parsing the html with double curly braces, so use 1 curly brace and 
            two exclamation marks to show it --}}
        </div>
    </div>
    <hr>
    <div class="card" id="showCard">
        <h4 class="card-title">Website</h4>

        @if(substr($techGroup->website, 0, 4) ==='http')
            <div class="card-text" style="margin-left:15px">
                <a href="{!!$techGroup->website!!}" target="_blank">{!!$techGroup->website!!}</a>
            </div>
        @elseif(substr($techGroup->website, 0, 3) ==='www')
            <div class="card-text" style="margin-left:15px">
                <a href="http://{!!$techGroup->website!!}" target="_blank">{!!$techGroup->website!!}</a>
            </div>
        @else
            <div class="card-text" style="margin-left:15px">
                <a href="https://www.{!!$techGroup->website!!}" target="_blank">{!!$techGroup->website!!}</a>
            </div>
        @endif
        <h4 class="card-title">Email</h4>
        <div class="card-text" style="margin-left:15px">
            {!!$techGroup->email!!}
        </div>
    
        <h4 class="card-title">Description</h4>
        <div class="card-text" style="margin-left:15px">
            {!!$techGroup->description!!}
        </div>
    </div>

    <hr>
    @if(Auth::user() && Auth::user()->type == 'admin')
        @include('inc.approve', array('model' => 'TechGroup','ID' => $techGroup->ID, 'flag' => $techGroup->flag))
        <hr>
    @endif
   
    @if($display)
        <div>
            <input type='button' id='adminButton' class = 'btn btn-primary' value = 'Add Admin' onclick="addAdminShow();"/>
            <div>
            {!!Form::open(['action'=>['TechGroupController@addAdmin'], 'method'=>'POST',
                'id'=>'hidden', 'style' => 'display:none', 'enctype' => 'multipart/form-data'])!!}
                <br>
                {{Form::label('email', "New Admin's email address")}}
                {{Form::text('email', '', ['class' => 'form-control', 'placeholder' => 'example@admin.com'])}}
                {{Form::hidden('id', $techGroup->ID, array('id'=>'hid'))}}
                {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
            {!!Form::close()!!}
            <hr>
            </div>
        </div>
        <a href='/techgroups/{{$techGroup->ID}}/edit' class='btn btn-primary'>Edit</a>
    @endif
    <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
    @if($display)
        {!!Form::open(['action'=>['TechGroupController@destroy', $techGroup->ID], 'method'=>'POST','class'=>'float-right'])!!}
            {{Form::hidden('_method', 'DELETE')}}
            {{Form::submit('Delete', ['class'=> 'btn btn-danger'])}}
        {!!Form::close()!!}
    @endif
    <hr>
    <small>Created on {{\Carbon\Carbon::parse($techGroup->created_at)->format('d/m/Y')}}</small>
    <br>
@endsection

