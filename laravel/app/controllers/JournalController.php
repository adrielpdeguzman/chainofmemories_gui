<?php

class JournalController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return Redirect::to(Request::url() . '/volume/1');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $dates_without_entry = $this->getJSONFromURL(Config::get('constants.API_URL') . 'journals/getDatesWithoutEntry');

		return View::make('journals.create', compact('dates_without_entry'));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $url = Config::get('constants.API_URL') . 'journals';
        $data = [
            'publish_date'  => Input::get('publish_date'),
            'contents'      => Input::get('contents'),
            'special_events'=> Input::get('special_events')
        ];

        $result = json_decode($this->sendCurlRequestToURL($url, json_encode($data)), true);

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
		$url = Config::get('constants.API_URL') . 'journals/' . $id;
        $response = $this->getJSONFromURL($url);

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
        $url = Config::get('constants.API_URL') . 'journals/' . $id;
        $response = $this->getJSONFromURL($url);

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
		$url = Config::get('constants.API_URL') . 'journals/' . $id;
        $data = [
            'contents'      => Input::get('contents'),
            'special_events'=> Input::get('special_events')
        ];

        $result = json_decode($this->sendCurlRequestToURL($url, json_encode($data), "PUT"), true);

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
        $url = Config::get('constants.API_URL') . 'journals/volume/' . $volume;
        $response = $this->getJSONFromURL($url);

        return View::make('journals.volume', compact('response'));
    }

    public function random($id)
    {
        $url = Config::get('constants.API_URL') . 'journals/random';
        $response = $this->getJSONFromURL($url);

        return View::make('journals.show', compact('response'));
    }

}
