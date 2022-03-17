<?php

namespace App\Http\Controllers\_Backend\Auth;

use App\Http\Controllers\Controller;
use App\Models\_Backend\DefaultAppIdAndSecret;
use App\Models\_Backend\OperatorLog;
use App\Models\Merchant;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;

class SubMerchantRegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('backend');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['string', 'max:16'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user=Merchant::orderBy('id','desc')->first();
        $default_collect=DefaultAppIdAndSecret::withoutTrashed()->where(['type'=>1])->first();
        $default_pay=DefaultAppIdAndSecret::withoutTrashed()->where(['type'=>2])->first();
        OperatorLog::create(['operator_id'=>Auth::guard('backend')->id(),'content'=>'Tạo HQPAY Merchant '.idGenerator($user->id+1,'MC')]);

        return Merchant::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'website' => $data['website'],
            'app_id'=>$default_collect->app_id??'',
            'secret'=>$default_collect->secret??'',
            'app_id_addition'=>$default_pay->app_id??'',
            'secret_addition'=>$default_pay->secret??'',
            'merchant_id' => idGenerator($user->id+1,'MC'),
            'password' => Hash::make($data['password']),
            'status' => 0,
            'is_sub_merchant' => 1,
        ]);
    }
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        $this->create($request->all());
        //event(new Registered($user = $this->create($request->all())));

        //$this->guard()->login($user);

//        if ($response = $this->registered($request, $user)) {
//            return $response;
//        }

        return redirect(route('sub-merchants.index'));
    }
    public function toggleLock(Request $request)
    {
        $merchant = Merchant::find($request->id);
        if ($merchant->status == 0) {
            $merchant->status = 1;
        } elseif ($merchant->status == 1) {
            $merchant->status = 0;
        }

        if ($merchant->save()) {
            if ($merchant->status == 0) {
                Flash::success('MỞ KHÓA merchant thành công!');
            } elseif ($merchant->status == 1) {
                Flash::success('KHÓA merchant thành công!');
            }
            return redirect(route('sub-merchants.index'));
        }
    }

}
