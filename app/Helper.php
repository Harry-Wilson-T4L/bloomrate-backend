<?php

use App\Models\Notification;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;


// function push_notification($push_arr){
    
//      $apiKey = env('FIRE_BASE_API_KEY');

//     // $apiKey = "AAAARtHAFkk:APA91bHPCwemOxQQYftfn2n5TPD505lmoh-HyiM6cw8dr1dmKREUm9j-C_YQdT1q5G0pi7miBEasQPIQclAQGnwOmSwITYnOk0Kj0pX40ZE_RIhyM-tG4PhdXqxd180Q-9skwKli7p8m";
//     // $apiKey = "AAAA9m3GF5Q:APA91bGSIgZQx2QA5gI9eEo3WCloA-sw_96H8UYcyuZlA9uv3XJlBvhF9vDvw_DGkH56GVYVxSdqTKkOpaULhoWh93-xMe9tJ0-Lm3bAbUFbw8UeFgwsry0tjcpttO7YaD7YQaeOsQ65";
    
//     $registrationIDs 	    = (array) $push_arr['device_token'];
//     $message 			    = array(
//         "body"         	    => $push_arr['description'],
//         "title"        		=> $push_arr['title'],
//         "notification_type" => $push_arr['type'],
//         "other_id"          => $push_arr['record_id'],
//         "date"        		=> now(),
//         'vibrate'           => 1,
//         'sound'             => 1,
//     );
//     $url = 'https://fcm.googleapis.com/fcm/send';

//     // if($push_arr->user_device == "ios"){
//     //     $fields = array(
//     //         'registration_ids'     =>  $registrationIDs,
//     //         'notification'         =>  $message,
//     //         'data'         =>  $message
//     //     );
//     // }else if($push_arr->user_device == "android"){
//         $fields = array(
//             'registration_ids'     =>  $registrationIDs,
//             'notification'         =>  $message,
//             'data'         =>  $message
//         );
//     // }

//     $headers = array(
//         'Authorization: key='. $apiKey,
//         'Content-Type: application/json'
//     );
//     $ch = curl_init();
//     curl_setopt( $ch, CURLOPT_URL, $url );
//     curl_setopt( $ch, CURLOPT_POST, true );
//     curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
//     curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
//     curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $fields ) );
//     $result = curl_exec($ch);
//     curl_close($ch);
    
//     return $result;
// }



if (!function_exists('getAccessToken')) {
    function getAccessToken()
    {
        $keyFile = storage_path('app/googleConfigFile.json');
        $key = json_decode(file_get_contents($keyFile), true);

        $jwtHeader = json_encode(['alg' => 'RS256', 'typ' => 'JWT']);
        $jwtPayload = json_encode([
            'iss' => $key['client_email'],
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
            'aud' => 'https://oauth2.googleapis.com/token',
            'exp' => time() + 3600,
            'iat' => time(),
        ]);

        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($jwtHeader));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($jwtPayload));
        $signature = '';
        openssl_sign("$base64UrlHeader.$base64UrlPayload", $signature, $key['private_key'], OPENSSL_ALGO_SHA256);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        $jwt = "$base64UrlHeader.$base64UrlPayload.$base64UrlSignature";

        $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt,
        ]);

        return $response->json()['access_token'];
    }
}

if (!function_exists('push_notification')) {
    function push_notification($push_arr)
    {
        $accessToken = getAccessToken();

        $registrationIDs = array_filter((array) ($push_arr['device_token'] ?? []));
        if (empty($registrationIDs)) {
            Log::debug('No valid device token found, skipping notification.');
            return [
                'success' => false,
                'message' => 'No valid device token provided, notification not sent.',
            ];
        }

        $message = [
            'notification' => [
                'title' => $push_arr['title'] ?? 'Notification',
                'body' => $push_arr['description'] ?? '',
            ],
            'data' => [
                "notification_type" => (string) ($push_arr['type'] ?? ''),
                'receiver_id' => (string) ($push_arr['receiver_id'] ?? ''),
                'other_id' => (string) (  $push_arr['type'] == 'create_post' ? $push_arr['record_id'] : ($push_arr['sender_id'] ?? $push_arr['record_id'] ?? '')),
                'date' => now()->toString(),
                'vibrate' => '1',
                'sound' => '1',
            ],
        ];

        $fields = [
            'message' => [
                'token' => $registrationIDs[0],
                'notification' => $message['notification'],
                'data' => $message['data'],
            ],
        ];

        $apiUrl = 'https://fcm.googleapis.com/v1/projects/bloomrate-7c081/messages:send';

        $response = Http::withToken($accessToken)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post($apiUrl, $fields);

        Log::debug('push_notification');
        Log::debug(json_encode($response->json()));

        return $response->json();
    }
}


function in_app_notification($data) {
    $notification = new Notification();
    $notification->sender_id = $data['sender_id'];
    $notification->receiver_id = $data['receiver_id'];
    $notification->title = $data['title'];
    $notification->description = $data['description'];
    $notification->record_id = $data['record_id'];
    $notification->type = $data['type'];
    $notification->save();
}

function emitSocketNotification($user_id, $data)
{
    $client = new Client();

    try {
        $client->post('https://admin.bloomrate.com:3002/send-notification', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [
                'type' => "notification_count",
                'user_id' => $user_id,
                'data' => $data
            ]
        ]);
      
    } catch (\Exception $e) {
        Log::error('Socket Notification Error: ' . $e->getMessage());
    }
}

