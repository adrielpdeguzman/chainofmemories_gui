<?php

class BaseController extends Controller {

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

    protected function getOAuthCredentials()
    {
        return Config::get('constants.CLIENT_ID') . ':' . Config::get('constants.CLIENT_SECRET');
    }

    protected function getJSONFromURL($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL,$url . '?access_token=' . Session::get('access_token'));

        $result = curl_exec($ch);

        curl_close($ch);

        return json_decode($result, true);
    }

    protected function sendCurlRequestToURL($url, $data, $custom_request = "POST")
    {
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

        $result = curl_exec($ch);

        curl_close($ch);

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
