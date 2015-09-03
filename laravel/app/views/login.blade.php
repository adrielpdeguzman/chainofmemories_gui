@extends('layouts.master')

@section('title')
    :: Sign In
@stop

@section('content')
    <div class="container">
        {{ Form::open(['role' => 'form', 'class' => 'text-center col-md-4 col-md-offset-4']) }}

        @if (Session::get('message') != '')
            <p class="alert alert-danger">{{ Session::get('message', '')}}</p>
        @endif

        <div class="form-group">
            {{ Form::label('username', 'Username') }}
            {{ Form::text('username', null, ['class' => 'form-control', 'required', 'placeholder' => 'Username']) }}
        </div>

        <div class="form-group">
            {{ Form::label('password', 'Password') }}
            {{ Form::password('password', ['class' => 'form-control', 'required', 'placeholder' => 'Password']) }}
        </div>

        {{ Form::submit('Login', ['class' => 'form-control btn btn-block btn-info']) }}
        {{ Form::close() }}
    </div>
@stop