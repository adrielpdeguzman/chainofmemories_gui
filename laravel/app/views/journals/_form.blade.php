@if (Route::currentRouteName() == 'journals.edit')
    <h2><a class="pseudolink">DAY {{ $response['journals']['day'] }} | {{  $response['journals']['publish_date'] }}</a></h2>
@else
    {{ Form::select('publish_date', $dates_without_entry, null, ['class' => 'form-control']) }}
@endif

<div class="form-group">
    {{ Form::label('contents', 'Journal Contents') }}
    {{ Form::textarea('contents', (isset($response['journals']) ? $response['journals']['contents'] : ''), ['class' => 'form-control', 'required']) }}
</div>

<div class="form-group">
    {{ Form::label('special_events', 'Special Events') }}
    {{ Form::textarea('special_events', (isset($response['journals']) ? $response['journals']['special_events'] : ''), ['class' => 'form-control', 'rows' => '4'])}}
</div>

{{ Form::submit($submitButtonText, ['class' => 'form-control btn btn-primary btn-block']) }}
{{ Form::reset('Discard Changes', ['class' => 'form-control btn btn-block']) }}