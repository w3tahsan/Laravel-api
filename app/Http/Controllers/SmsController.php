<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Twilio\Rest\Client;

class SmsController extends Controller
{
    function sms()
    {
        return view('admin.sms.sms');
    }
    function sms_send(Request $request)
    {
        $receiverNumber = '+88001990779785';
        $message = 'adad';

        try {

            $account_sid = env("TWILIO_SID");
            $auth_token = env("TWILIO_TOKEN");
            $twilio_number = env("TWILIO_FROM");

            $client = new Client($account_sid, $auth_token);
            $client->messages->create($receiverNumber, [
                'from' => $twilio_number,
                'body' => $message
            ]);

            return back()->with('send', 'Message Send Success!');
        } catch (Exception $e) {
            dd("Error: " . $e->getMessage());
        }
    }
}
