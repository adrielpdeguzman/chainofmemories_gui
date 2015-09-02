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
            'username'  => Input::get('username'),
            'password'  => Input::get('password')
        ];
        $rules = [
            'username'  => 'required',
            'password'  => 'required'
        ];
        $login_string   = 'grant_type=password';
        $login_string  .= '&client_id=' . urlencode(Config::get('constants.CLIENT_ID'));
        $login_string  .= '&client_secret=' . urlencode(Config::get('constants.CLIENT_SECRET'));
        $login_string  .= '&username=' . urlencode($credentials['username']);
        $login_string  .= '&password=' . urlencode($credentials['password']);

        $errors = $this->validateAndReturnErrors($credentials, $rules);

        if ($errors)
        {
            return Redirect::to('login')
                ->withErrors($errors)
                ->withInput(Input::except('password'));
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $login_string);
        curl_setopt($ch,CURLOPT_POST, 5);
        curl_setopt($ch, CURLOPT_URL,$url);

        $result = json_decode(curl_exec($ch), true);

        curl_close($ch);

        if (isset($result['error']))
        {
            return Redirect::to('login')
                ->withInput(Input::except('password'))
                ->with('message', $result['error_description']);
        }

        Session::put('refresh_token', ($result['refresh_token']));
        Session::put('access_token', ($result['access_token']));
        Session::put('oauth_token_expiry', (date(time()) + $result['expires_in']));

        return Redirect::intended('/');
    }

    public function doLogout()
    {
        Session::flush();

        return Redirect::to('/');
    }
}
