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

		return View::make('journals.form', compact('dates_without_entry'));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $url = Config::get('constants.API_URL') . 'journals';

        $result = $this->sendPostRequestToURL($url, Input::all());

        dd($result);
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
        $journal = $this->getJSONFromURL($url);

        return View::make('journals.show', compact('journal'));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
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
        $journals = $this->getJSONFromURL($url);

        return View::make('journals.volume', compact('journals'));
    }

    public function random($id)
    {
        $url = Config::get('constants.API_URL') . 'journals/random';
        $journal = $this->getJSONFromURL($url);

        return View::make('journals.show', compact('journal'));
    }

}
