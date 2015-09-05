<?php
//file : app/constants.php
$API_URL = '';

if (App::environment() == 'local')
{
	$API_URL = 'http://localhost:8001/api/v1/';
}
else
{
	$API_URL = 'http://chainofmemoriesapi.sytes.net/api/v1/';
}
return [
    'ANNIVERSARY'   => Carbon\Carbon::create(2013, 12, 7, 0, 0, 0, 'Asia/Manila'),
    'API_URL'       => $API_URL,
    'CLIENT_ID'     => 'web_frontend',
    'CLIENT_SECRET' => 'chainofmemories'
];