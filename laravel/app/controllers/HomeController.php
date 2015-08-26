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
        return View::make('login');
    }

    public function doLogin()
    {
        $url = Config::get('constants.API_URL') . 'oauth/access_token';
        $credentials = [
            'grant_type'=> 'password',
            'username'  => Input::get('username'),
            'password'  => Input::get('password')
        ];
        $rules = [
            'username'  => 'required',
            'password'  => 'required'
        ];

        $errors = $this->validateAndReturnErrors($credentials, $rules);

        if ($errors)
        {
            return Redirect::to('login')
                ->withErrors($errors)
                ->withInput(Input::except('password'));
        }

        $result = json_decode($this->sendPostRequestToURL($url, $credentials));

        dd($result);

        if ( ! isset($result->user))
        {
            return Redirect::to('login')
                ->withInput(Input::except('password'))
                ->with('message', $result->message);
        }

        Session::put('user', $credentials);

        return Redirect::to('/');
    }

    public function doLogout()
    {
        Session::flush();

        return Redirect::to('/');
    }
}
