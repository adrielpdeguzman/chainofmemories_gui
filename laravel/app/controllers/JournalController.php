<?php

class JournalController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$current_volume = Carbon\Carbon::today()->diffInMonths(Config::get('constants.ANNIVERSARY')) + (Config::get('constants.ANNIVERSARY')->day != Carbon\Carbon::today()->day ? 2 : 3);

		return Redirect::to(Request::url() . '/volume/' . $current_volume);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$url = 'journals/getDatesWithoutEntry';
		$dates_without_entry = $this->sendGuzzleRequest('GET', 'journals/getDatesWithoutEntry');

		return View::make('journals.create', compact('dates_without_entry'));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$url = 'journals';
		$data = [
			'publish_date'  => Input::get('publish_date'),
			'contents'      => Input::get('contents'),
			'special_events'=> Input::get('special_events')
			];

		$result = $this->sendGuzzleRequest('POST', $url, $data);

		if(isset($result['error']))
		{
			return Redirect::to('/journals/create')->withInput()->with('message', $result['error_description']);
		}

		return Redirect::to('/journals/' . $result['journals']['id'])->with('message', 'Your journal entry has been created!');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$url = 'journals/' . $id;
		$response = $this->sendGuzzleRequest('GET', $url);

		return View::make('journals.show', compact('response'));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$url ='journals/' . $id;
		$response = $this->sendGuzzleRequest('GET', $url);

		if( ! $response['isOwner'])
		{
			return Redirect::to('/journals/' . $id)->with('message', 'You are not authorized to update this journal entry');
		}

		return View::make('journals.edit', compact('response'));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$url = 'journals/' . $id;
		$data = [
		'contents'      => Input::get('contents'),
		'special_events'=> Input::get('special_events')
		];

		$result = $this->sendGuzzleRequest('PUT', $url, $data);

		if(isset($result['error']))
		{
			return Redirect::to('/journals/' , $id , '/edit')->withInput()->with('message', $result['error_description']);
		}

		return Redirect::to('/journals/' . $result['journals']['id'])->with('message', 'Your journal entry has been updated!');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function showVolume($volume)
	{
		$url = 'journals/volume/' . $volume;
		$response = $this->sendGuzzleRequest('GET', $url);

		$url2 = Config::get('constants.API_URL') . 'journals/getVolumesWithStartDate';
		$volumes_with_start_date = $this->sendGuzzleRequest('GET', $url2);

		$special_events = "";

		return View::make('journals.volume', compact('response', 'volumes_with_start_date', 'special_events'));
	}

	public function random()
	{
		$url = 'journals/random';
		$response = $this->sendGuzzleRequest('GET', $url);

		return View::make('journals.show', compact('response'));
	}

	public function search()
	{
		$url = 'journals/getVolumesWithStartDate';
		$volumes_with_start_date = $this->sendGuzzleRequest('GET', $url);

		$volumes_with_start_date = ['0' => 'All Volumes'] + $volumes_with_start_date;

		return View::make('journals.search', compact('volumes_with_start_date'));
	}

	public function doSearch()
	{
		$url = 'journals/search';

		$query_string = "?text=" . urlencode(Input::get('text'));
		$query_string .= "&volume=" . Input::get('volume');

		$url2 = Config::get('constants.API_URL') . 'journals/getVolumesWithStartDate';
		$volumes_with_start_date = $this->sendGuzzleRequest('GET', $url2);

		$volumes_with_start_date = ['0' => 'All Volumes'] + $volumes_with_start_date;

		$response = $this->sendGuzzleRequest('GET', $url . $query_string);

		return View::make('journals.search', compact('response', 'volumes_with_start_date'));
	}
}
