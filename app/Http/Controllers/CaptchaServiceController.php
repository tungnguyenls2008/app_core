<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;

class CaptchaServiceController extends Controller
{
    public function index()
    {
        return view('index');
    }
    public function captchaFormValidate(Request $request)
    {
        $rules=[
            'captcha' => 'required|captcha'
        ];
        $validation = Validator::make( $request->all(), $rules );
        if ( $validation->fails()) {
            $result=[
                'success'=>false,
                'message'=>'Captcha không hợp lệ!'
            ];
        }else{
            $result=[
                'success'=>true,
                'message'=>''
            ];
        }
        return $result;

    }
    public function reloadCaptcha()
    {
        return response()->json(['captcha'=> captcha_img()]);
    }
}
