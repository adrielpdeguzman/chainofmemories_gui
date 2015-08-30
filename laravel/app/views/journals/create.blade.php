@extends('layouts.master')
@section('content')
    <div class="container">
        @if (Session::get('message') != '')
            <p class="alert alert-danger">{{ Session::get('message', '')}}</p>
        @endif
        {{ Form::open(['role' => 'form', 'route' => 'journals.store']) }}
           @include('journals._form', ['submitButtonText' => 'Create Journal Entry'])
        {{ Form::close() }}
    </div>
@stop