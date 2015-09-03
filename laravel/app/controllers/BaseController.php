<?php

use GuzzleHttp\Client;

class BaseController extends Controller {

	/**
	 * undocumented class variable
	 *
	 * @var Client
	 **/
	protected $client;

	public function __construct()
	{
		$client_params = [
			'base_url' => Config::get('constants.API_URL')
			];

		$this->client = new Client($client_params);
	}

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
		$url = 'oauth/access_token';

		if (Session::has('refresh_token'))
		{
			$response = $this->client->post($url, [
				'body' 		=> [
					'grant_type'	=> 'refresh_token',
					'refresh_token'	=> Session::get('refresh_token'),
					'client_id'		=> Config::get('constants.CLIENT_ID'),
					'client_secret'	=> Config::get('constants.CLIENT_SECRET')
				],
				'exceptions' => 'false'
			])
			->json();

			if(isset($response['access_token']))
			{
				Session::put('access_token', $response['access_token']);
				Session::put('refresh_token', $response['refresh_token']);
				Session::put('oauth_token_expiry', (date(time()) + $response['expires_in']));

				return true;
			}

			return Redirect::guest('login');
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

	protected function sendGuzzleRequest($http_verb = 'GET', $url, $data = null)
	{
		if (date(time()) >= Session::get('oauth_token_expiry'))
		{
			$this->refreshAccessToken();
		}

		$request = $this->client->createRequest($http_verb, $url, [
			'json' 		=> $data,
			'headers'	=> [
				'Authorization'		=> 'Bearer ' . Session::get('access_token')
				]
			]);

		return $this->client->send($request)->json();
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
