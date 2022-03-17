<?php

namespace App\Http\Controllers;

use InfyOm\Generator\Utils\ResponseUtil;
use Response;

/**
 * @SWG\Swagger(
 *   basePath="/api/v1",
 *   @SWG\Info(
 *     title="Laravel Generator APIs",
 *     version="1.0.0",
 *   )
 * )
 * This class should be parent class for other API controllers
 * Class AppBaseController
 */
class AppBaseController extends Controller
{

    public function sendResponse($result, $message)
    {
        return Response::json(self::makeResponse($message, $result));
    }

    public function sendError($error,$code='001')
    {
        return Response::json(self::makeError($error,[],$code));
    }

    public function sendSuccess($message)
    {
        return Response::json([
            'success' => true,
            'message' => $message
        ], 200);
    }
    /**
     * @param string $message
     * @param mixed  $data
     *
     * @return array
     */
    public static function makeResponse($message, $data)
    {
        return [
            'success' => true,
            'data'    => $data,
            'message' => $message,
        ];
    }

    /**
     * @param string $message
     * @param array  $data
     *
     * @return array
     */
    public static function makeError($message, array $data = [],$code=101)
    {
        $res = [
            'success' => false,
            'message' => $message,
            'error_code'=>$code,
        ];

        if (!empty($data)) {
            $res['data'] = $data;
        }

        return $res;
    }

    public function genSignature($input)
    {
        $private_key = file_get_contents(storage_path('epg-private.key'));
        $public_key=file_get_contents(storage_path('epg-public.key'));
       $result= openssl_sign($input, $signature, $private_key,OPENSSL_ALGO_SHA256);
       if ($result){
           $r = openssl_verify($input, $signature, $public_key, "sha256WithRSAEncryption");
           return base64_encode($signature);
       }
        return $this->sendError('Error compute signature','013');
    }
    public function verifyCallbackSignature($input,$signature)
    {
        $signature=base64_decode($signature);
        $public_key=file_get_contents(storage_path('epg-public.key'));
        return openssl_verify($input, $signature, $public_key, 'sha256WithRSAEncryption');

    }
    public function genData($input){
        $signature = $this->genSignature(json_encode($input));
        $data['data'] = json_encode($input);
        $data['signature'] = $signature;
        $data['version'] = '1.1';
        return json_encode($data);
    }
    public function validateRequestId($requestId){
        if (preg_match('/^[a-zA-Z0-9]+$/i', $requestId) == 0) {
            return $this->sendError('requestId contains invalid character(s).', '102');
        }
        if (strlen($requestId) > 16 || strlen($requestId) < 6) {
            return $this->sendError('requestId length must be between 6 and 16.','103');
        }
    }
}
