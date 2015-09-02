@extends('layouts.master')

@section('title')
    :: Update Journal Entry
@stop

@section('content')
    <div class="container">
        @if (Session::get('message') != '')
            <p class="alert alert-danger">{{ Session::get('message', '')}}</p>
        @endif
        {{ Form::open(['method' => 'PUT', 'role' => 'form', 'route' => ['journals.update', $response['journals']['id']]]) }}
           @include('journals._form', ['submitButtonText' => 'Edit Journal Entry'])
        {{ Form::close() }}
    </div>
@stop