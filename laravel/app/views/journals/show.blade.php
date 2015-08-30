@extends('layouts.master')
@section('content')
    <div class="container">
        @if (Session::get('message') != '')
            <p class="alert alert-info">{{ Session::get('message', '')}}</p>
        @endif
        <div class="journal-entry">
            <h2>DAY {{ $response['journals']['day'] }} | {{  $response['journals']['publish_date'] }}</h2>
            {{ Helper::splitStringIntoParagraphs($response['journals']['contents']) }}

            @if (($response['journals']['special_events']) != '')
                <ul>
                    {{ Helper::splitStringIntoListItems($response['journals']['special_events']) }}
                </ul>
            @endif
            @if ($response['isOwner'])
                {{ link_to_route('journals.edit', 'Edit', [$response['journals']['id']]) }}
            @endif
        </div>
    </div>
@stop