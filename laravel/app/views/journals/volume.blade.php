@extends('layouts.sidebar')

@section('title')
    :: Volume {{ Route::getCurrentRoute()->getParameter('volume') }}
@stop

@section('styles')
    #journal-nav {
    font-size: 12pt;
    }
@stop

@section('sidebar')
    <div class="panel panel-default">
        <div class="panel-heading">
            {{ Form::select('volume', $volumes_with_start_date, Route::getCurrentRoute()->getParameter('volume'), ['class' => 'form-control']) }}
        </div>
        <div class="panel-body">
            <ul id="journal-nav" class="list-unstyled">

            </ul>
        </div>
    </div>
@stop

@section('content')
    @foreach ($response['journals'] as $journal)
        <div class="journal-entry panel panel-default">
            <a href="#" class="anchor" id="{{ $journal['id'] }}"></a>
            <div class="panel-heading">
                <h3 class="journal-heading text-uppercase"><strong>{{ link_to('journals/' . $journal['id'], 'Day ' . $journal['day'] . ' | ' . $journal['publish_date']) }}</strong></h3>
                <hr>
                <h4>Posted by: {{ $journal['user']['first_name'] . ' ' . $journal['user']['last_name']}}</h4>
            </div>
            <div class="panel-body">
                {{ Helper::splitStringIntoParagraphs($journal['contents'], ['class' => 'journal-contents']) }}
            </div>
        </div>

        @if ($journal['special_events'] != '')
            <div class='special-events-list hide'>
                <em>
                    {{ 'Day ' . $journal['day'] . ' | ' . $journal['publish_date'] }}
                    {{ ' by: ' . $journal['user']['first_name'] . ' ' . $journal['user']['last_name'] }}
                </em>
                <ul>
                    {{ Helper::splitStringIntoListItems($journal['special_events']) }}
                </ul>
            </div>
        @endif

    @endforeach

    <div class="journal-entry panel panel-default">
        <a href="#" class="anchor" id="special-events"></a>
        <div class="panel-heading">
            <h3 class="journal-heading text-uppercase"><a class="pseudolink">Outline of Special Events</a></h3>
        </div>
        <div class="panel-body" id="special-events-content">
        </div>
    </div>
@stop

@section('scripts')
$(function(){
$('[name="volume"]').change(function(e) {
window.location.href = $(this).val();
});
});

var journal_nav = "";
var last_date = "";
$( ".journal-entry" ).each(function(index) {
nav_label = $(this).children().children('.journal-heading').text();
if (last_date == nav_label)
{
  return true;
}
journal_nav += "<li><a href=\"#" + $(this).children('.anchor').attr('id') + "\" class=\"center-block\">" + nav_label  + "</a></li>";
last_date = nav_label;
});

$( ".special-events-list").each(function(index) {
$(this).removeClass('hide').appendTo('#special-events-content');
});

$('#journal-nav').html(journal_nav);
@stop