<?php

use GuzzleHttp\Client;

class BaseController extends Controller {

	/**
	 * undocumented class variable
	 *
	 * @var Client
	 **/
	protected $client = new Client([
		// Base URI is used with relative requests
		'base_uri' => 'http://httpbin.org',
		// You can set any number of default request options.
		'timeout'  => 2.0,
		]);

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	protected function refreshAccessToken()
	{
		$url = Config::get('constants.API_URL') . 'oauth/access_token';

		if (Session::has('refresh_token'))
		{
			$login_string   = 'grant_type=refresh_token';
			$login_string  .= '&client_id=' . urlencode(Config::get('constants.CLIENT_ID'));
			$login_string  .= '&client_secret=' . urlencode(Config::get('constants.CLIENT_SECRET'));
			$login_string  .= '&refresh_token=' . Session::get('refresh_token');

			$ch = curl_init();

			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch,CURLOPT_POSTFIELDS, $login_string);
			curl_setopt($ch,CURLOPT_POST, 4);
			curl_setopt($ch, CURLOPT_URL,$url);

			$result = json_decode(curl_exec($ch), true);

			curl_close($ch);

			if(isset($result['access_token']))
			{
				Session::put('access_token', $result['access_token']);
				Session::put('refresh_token', $result['refresh_token']);
				Session::put('oauth_token_expiry', (date(time()) + $result['expires_in']));
			}
		}

		return Redirect::guest('login');
	}

	protected function getJSONFromURL($url)
	{
		if (date(time()) >= Session::get('oauth_token_expiry'))
		{
			$this->refreshAccessToken();
		}

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Authorization: Bearer ' . Session::get('access_token'),
			'Content-Type: application/json'
			]);
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_URL, $url);

		$result = json_decode(curl_exec($ch), true);

		curl_close($ch);

		if (isset($result['error']))
		{
			return Redirect::guest('login');
		}

		return $result;
	}

	protected function sendCurlRequestToURL($url, $data, $custom_request = "POST")
	{
		if (date(time()) >= Session::get('oauth_token_expiry'))
		{
			$this->refreshAccessToken();
		}

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $custom_request);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch,CURLOPT_POST, true);
		curl_setopt($ch,CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Authorization: Bearer ' . Session::get('access_token'),
			'Content-Type: application/json',
			'Content-Length: ' . strlen($data)
			]);
		curl_setopt($ch, CURLOPT_URL,$url);

		$result = json_decode(curl_exec($ch), true);

		curl_close($ch);

		if (isset($result['error']))
		{
			return Redirect::guest('login');
		}

		return $result;
	}

	protected function validateAndReturnErrors($data, $rules)
	{
		$validator = Validator::make($data, $rules);
		if ($validator->fails())
			return $validator->messages();
		else
			return null;
	}
}
