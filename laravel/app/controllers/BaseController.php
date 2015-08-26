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

    protected function getUserCredentials()
    {
        $credentials = [
            'username' => Session::get('user.username'),
            'password' => Session::get('user.password')
        ];

        return $credentials['username'] . ':' . $credentials['password'];
    }

    protected function getJSONFromURL($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $this->getUserCredentials());
        curl_setopt($ch, CURLOPT_URL,$url);

        $result = curl_exec($ch);

        curl_close($ch);

        return json_decode($result, true);
    }

    protected function sendPostRequestToURL($url, $data)
    {
        $post_data = '';
        foreach ($data as $key=>$value)
        {
            $post_data .= $key . '=' . ($value) . '&';
        }
        $post_data = rtrim($post_data, '&');

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, 'web_frontend:chainofmemories');
        curl_setopt($ch,CURLOPT_POST, count($data));
        curl_setopt($ch,CURLOPT_POSTFIELDS, $post_data);
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
