@extends('layouts.app')   {{--Extend sidebar, navbar, and all other base html--}}

@section('content')

<br>
<h2>Notification Email</h2>

    {!! Form::open(['action' => 'EmailController@sendNotification', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!} 
        <div class="form-group">
            <h4>{{Form::label('subject', 'Subject')}}</h4>
            {{Form::text('subject', '', ['class' => 'form-control', 'placeholder' => 'Subject Matter'])}}
        </div>
        <div class="form-group">
            <h4>{{Form::label('content', 'Content')}}</h4>
            {{Form::textarea('content', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => ''])}}
        </div>
        <div class="form-group">
            <h4>{{Form::label('attachment', 'Attachment')}}</h4>
            {{-- attachment files will only allow text here. --}}
            <div class="form-group" style="margin-left:25px"> 
            {{Form::label('attname', 'Attachment Display Name')}}
            {{Form::text('attname', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => ''])}}
            <br>
            {{Form::file('attachedfile', ['MAXLENGTH' =>'50', 'ALLOW'=>'text/*', 'class' => 'btn btn-primary'])}}
            </div>    
        </div>
        {{Form::submit('Submit',['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}


@endsection