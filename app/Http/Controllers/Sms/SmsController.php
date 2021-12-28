<?php

namespace App\Http\Controllers\Sms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class SmsController extends Controller
{
    public function dispatchSms($recipient, $message = 'Hi, some test msg'){
        $client = new Client();
        $requestBody = [
            'apikey' => config('app.sms_key'),
            'partnerID' => config('app.sms_partner'),
            'message' => $message,
            'shortcode' => config('app.sms_sender_id'),
            'mobile' => '254' . substr($recipient, -9)
        ];
        $response = $client->request('POST', 
            config('app.sms_url'), [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode($requestBody)
        ]);
        $response = (string)$response->getBody();
        return json_decode($response, true);
    }
}
