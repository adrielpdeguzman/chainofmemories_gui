@extends('layouts.master')
@section('content')
    <div class="container">
        @foreach ($response['journals'] as $journal)
            <div class="journal-entry">
                <h3>{{ link_to('journals/' . $journal['id'], 'DAY ' . $journal['day'] . ' | ' . $journal['publish_date']) }}</h3>
                {{ Helper::splitStringIntoParagraphs($journal['contents']) }}
            </div>
        @endforeach
    </div>
@stop