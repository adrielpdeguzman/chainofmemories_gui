@extends('layouts.sidebar')

@section('title')
    :: Search Journal
@stop

@section('sidebar')
    <div class="panel panel-default">
        <div class="panel-body">
            {{ Form::open(['method' => 'get', 'role' => 'form', 'route' => 'journals.doSearch']) }}
            <div class="form-group">
                {{ Form::label('text', 'Search') }}
                {{ Form::text('text', Input::get('text'), ['class' => 'form-control', 'required', 'placeholder' => 'Search for text']) }}
            </div>
            {{ Form::select('volume', $volumes_with_start_date, Input::get('volume'), ['class' => 'form-control']) }}

            {{ Form::submit('Search', ['class' => 'form-control btn btn-block btn-info', 'style' => 'margin-top: 15px'])}}
            {{ Form::close() }}
        </div>
    </div>
@stop

@section('content')
    @if (isset($response))
        @foreach ($response['journals'] as $journal)
        <div class="journal-entry panel panel-default">
            <a href="#" class="anchor" id="{{ $journal['id'] }}"></a>
            <div class="panel-heading">
                <h3 class="journal-heading text-uppercase">{{ link_to('journals/' . $journal['id'], 'Day ' . $journal['day'] . ' | ' . $journal['publish_date']) }}</h3>
                <h4>Posted by: {{ $journal['user']['first_name'] . ' ' . $journal['user']['last_name']}}</h4>
            </div>
            <div class="panel-body">
                {{ Helper::splitStringIntoParagraphs($journal['contents'], ['class' => 'journal-contents'], 1) }}
            </div>
        </div>
        @endforeach
    @endif
@stop