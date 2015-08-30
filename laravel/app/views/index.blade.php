@extends('layouts.master')
@section('content')
    <div class="container">
        <div class="jumbotron">
        <h1>Chain of Memories</h1>
        <p>Where memories are cherished and kept forever ~</p>
        </div>

        <div class="row">
            <div class="col-md-4">
                <h3>Journals</h3>
                <p>Re-visit the memoires of the past, chapter by chapter in this section! Here, we'll find those forgotten conversations and events, as detailed as possible!</p>
                <p>{{ link_to('journals/', 'View Journals &raquo;', array('class' => 'btn btn-default')) }}</p>
            </div>
            <div class="col-md-4 hidden">
                <h3>Messages</h3>
                <p>Catch those simple, yet memorable text messages! Have you forgotten a small fact that could affect your relationship? Head over here and have a review!</p>
                <p>{{ link_to('messages/', 'View Messages &raquo;', array('class' => 'btn btn-default')) }}</p>
            </div>
            <div class="col-md-4 hidden">
                <h3>Photos</h3>
                <p>A picture conveys a thousand words! View all those happy moments, grouped by certain events and venues! Let's walk across memory lane!
                <p><a class="btn btn-default" href="#" role="button">View Photos &raquo;</a></p>
            </div>
        </div>
    </div>
@stop