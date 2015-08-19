@extends('layouts.master')
@section('content')
    <div class="container">
        <div class="journal-entry">
            <h2>Day {{ $journal['day'] }} | {{  $journal['publish_date'] }}</h2>
            <p>{{ $journal['contents'] }}
            <h4>Special Events</h4>
            <p>{{ $journal['special_events'] }}
        </div>
    </div>
@stop