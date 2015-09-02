@extends('layouts.master')

@section('title')
    :: Day {{ $response['journals']['day'] }}
@stop

@section('content')
  <div class="container">
    @if (Session::get('message') != '')
        <p class="alert alert-info fade in alert-dismissible" role="alert">
          {{ Session::get('message', '') }}
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        </p>
    @endif
    <div id="{{ $response['journals']['id'] }}" class="journal-entry panel panel-default">
        <div class="panel-heading">
            <h3><strong><a class="pseudolink">VOL. {{ $response['journals']['volume'] }} DAY {{ $response['journals']['day'] }} | {{  $response['journals']['publish_date'] }}</strong></a>
              @if ($response['isOwner'])
                <a href="{{ route('journals.edit', $response['journals']['id']) }}" class="pull-right"><span class="glyphicon glyphicon-edit"></span></a>
              @endif
            </h3>
            <hr>
            <h4>Posted by: {{ $response['journals']['user']['first_name'] . ' ' . $response['journals']['user']['last_name']}}</h4>
            <div class="clearfix"></div>
        </div>

        <div class="panel-body">
            {{ Helper::splitStringIntoParagraphs($response['journals']['contents'], ['class' => 'journal-contents']) }}
        </div>

        @if (($response['journals']['special_events']) != '')
          <div class="panel-footer">
            <ul>
              {{ Helper::splitStringIntoListItems($response['journals']['special_events']) }}
            </ul>
          </div>
        @endif
      </div>
      <small class="pull-right text-muted">This entry was last edited {{ Carbon\Carbon::parse($response['journals']['updated_at'], 'Asia/Manila')->diffForHumans() }}</small>
  </div>
@stop