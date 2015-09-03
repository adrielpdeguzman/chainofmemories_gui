<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		return View::make('index');
	}

	public function login()
	{
		if (Session::has('access_token'))
		{
			return Redirect::route('home');
		}
		return View::make('login');
	}

	public function doLogin()
	{
		$url = Config::get('constants.API_URL') . 'oauth/access_token';

		$credentials = [
			'username'		=> Input::get('username'),
			'password'		=> Input::get('password'),
		];

		$rules = [
			'username'  => 'required',
			'password'  => 'required'
		];


		$response = $this->client->post($url, [
				'body' 		=> [
					'grant_type'	=> 'password',
					'username'		=> Input::get('username'),
					'password'		=> Input::get('password'),
					'client_id'		=> Config::get('constants.CLIENT_ID'),
					'client_secret'	=> Config::get('constants.CLIENT_SECRET')
				],
				'exceptions' => 'false'
			])
			->json();

		$errors = $this->validateAndReturnErrors($credentials, $rules);

		if ($errors)
		{
			return Redirect::to('login')
			->withErrors($errors)
			->withInput(Input::except('password'));
		}

		if (isset($response['error']))
		{
			return Redirect::to('login')
			->withInput(Input::except('password'))
			->with('message', $response['error_description']);
		}

		Session::put('refresh_token', ($response['refresh_token']));
		Session::put('access_token', ($response['access_token']));
		Session::put('oauth_token_expiry', (date(time()) + $response['expires_in']));

		return Redirect::intended('/');
	}

	public function doLogout()
	{
		Session::flush();

		return Redirect::to('/');
	}

	public function changelog()
	{
		return View::make('changelog');
	}
}
