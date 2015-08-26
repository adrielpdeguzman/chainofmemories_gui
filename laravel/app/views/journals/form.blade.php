@extends('layouts.master')
@section('content')
    <div class="container">
        {{ Form::open(['role' => 'form', 'url' => 'journals']) }}
            {{ Form::select('publish_date', $dates_without_entry, null, ['class' => 'form-control']) }}

            <div class="form-group">
                {{ Form::label('contents', 'Journal Contents') }}
                {{ Form::textarea('contents', '', ['class' => 'form-control', 'required'])}}
            </div>

            <div class="form-group">
                {{ Form::label('special_events', 'Journal Contents') }}
                {{ Form::textarea('special_events', '', ['class' => 'form-control', 'rows' => '4'])}}
            </div>

            {{ Form::submit('Create Journal Entry', ['class' => 'form-control btn btn-primary btn-block']) }}
            {{ Form::reset('Discard Changes', ['class' => 'form-control btn btn-block']) }}
        {{ Form::close() }}
    </div>
@stop