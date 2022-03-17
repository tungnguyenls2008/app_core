<?php

namespace App\Http\Controllers\API;


use Exception;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use Response;

/**
 * Class LoginV2Controller
 * @package App\Http\Controllers\API
 */
class LoginAPIController extends BaseApiController
{

    public function doLogin(Request $request)
    {
        $post = $request->all();
        $email = $post['email'];
        $password = $post['password'];
        $curl = curl_init();
        curl_setopt_array($curl,
            [
                CURLOPT_URL => env('TOKEN_URL'),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => [
                    'grant_type' => 'password',
                    'client_id' => env('CLIENT_ID'),
                    'client_secret' => env('CLIENT_SECRET'),
                    'username' => $email,
                    'password' => $password,
                    'scope' => ''],
                CURLOPT_HTTPHEADER => [
                    'Accept: application/json'
                ],
            ]);

        $response = curl_exec($curl);
        $response = json_decode($response, true);
        curl_close($curl);
        return $this->sendResponse($response, 'Login function success with response.');

    }
}
