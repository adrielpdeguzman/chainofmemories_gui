@extends('layouts.master')
@section('content')
    <div class="container">
        @foreach ($journals as $journal)
            <div class="journal-entry">
                <h3>Day {{ $journal['day'] }} | {{  $journal['publish_date'] }}</h3>
                <p>{{ $journal['contents'] }}
            </div>
        @endforeach
    </div>
@stop