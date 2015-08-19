<?php

class JournalController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$journal = $this->getJSONFromURL('http://localhost:8080/api/v1/journals/' . $id);

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

    public function showVolume($volume)
    {
        $journals = $this->getJSONFromURL('http://localhost:8080/api/v1/journals/volume/' . $volume);

        return View::make('journals.volume', compact('journals'));
    }

}
