@extends('layouts.master')

@section('title')
    :: Write Journal Entry
@stop

@section('content')
    <div class="container">
        @if (Session::get('message') != '')
            <p class="alert alert-danger">{{ Session::get('message', '')}}</p>
        @endif

        @if( ! empty($dates_without_entry))
            <h3 class="text-warning center-block">You have already written all your journals until today!</h3>
            <p>{{ link_to_route('journals.index', 'View Journals &raquo;', null, ['class' => 'btn btn-default']) }}</p>
        @else
            {{ Form::open(['role' => 'form', 'route' => 'journals.store']) }}
               @include('journals._form', ['submitButtonText' => 'Create Journal Entry'])
            {{ Form::close() }}
        @endif
    </div>
@stop