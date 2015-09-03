@section('title')
    :: Changelogs
@stop

@extends('layouts.master')

@section('content')
    <div class="container">
        <h2>September 7, 2015</h2>
        <ul>
            <li>Both of us can now properly post our own journal entries</li>
            <li>De-coupled the Backend with the Frontend in preparation for Mobile App :)</li>
            <li>Cleaned most parts of the codes</li>
            <li>Re-made database structure</li>
            <li>Temporarily removed [Messages] module in preparation for a new feature</li>
            <li>Several design/CSS changes</li>
        </ul>
        <h2>November 26, 2014</h2>
        <ul>
            <li>Finished migrating the entire website using Laravel Framework</li>
            <li>Re-designed most UI elements using Bootstrap</li>
            <li>Optimized database structure</li>
            <li>Overall improvements versus the old website</li>
        </ul>
        <h2>August 25, 2014</h2>
        <ul>
            <li>Added new video on homepage: Memory Lane</li>
            <li>Added <a href="{{ URL::route('changelog') }}">Changelog Page</a> for updates</li>
            <li>Added Outline of Significant Event on <a href="{{ URL::route('journals.volumes') }}">Journals Page</a></li>
            <li>Updated exported journal entry to include Special Events at the end</li>
        </ul>
        <h2>June 7, 2014</h2>
        <ul>
            <li>Published this site as <a href="{{Request::root()}}">{{ Request::root() }}</a></li>
        </ul>
    </div>
@stop