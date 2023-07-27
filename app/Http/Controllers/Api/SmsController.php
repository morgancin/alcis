<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Exception;
use Twilio\Rest\Client;

class SmsController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function sendMessage(Request $request)
    {
        //$receiverNumber = "RECEIVER_NUMBER";
        //$message = "This is testing from ItSolutionStuff.com";

        //$request->receiver_number;
        //$request->message;

        try {
            $account_sid = getenv("TWILIO_SID");
            $auth_token = getenv("TWILIO_TOKEN");
            $twilio_number = getenv("TWILIO_FROM");

            $client = new Client($account_sid, $auth_token);
            $client->messages->create($request->receiver_number, [
                'from' => $twilio_number,
                'body' => $request->message]);

            return response()->json([
                        'message' => __('api.messages.added')
                    ], Response::HTTP_OK);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
