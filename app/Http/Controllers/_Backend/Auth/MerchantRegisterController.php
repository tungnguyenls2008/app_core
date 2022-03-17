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

class MerchantRegisterController extends Controller
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
            //'phone' => ['string', 'max:16'],
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
        if ($user==null) {
            $id=0;
        }else{
            $id=$user->id;
        }
        OperatorLog::create(['operator_id'=>Auth::guard('backend')->id(),'content'=>'Tạo Merchant '.idGenerator($id+1,'MC')]);

        return Merchant::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'website' => $data['website'],
            'merchant_id' => idGenerator($id+1,'MC'),
            'password' => Hash::make($data['password']),
            'status' => 0,
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

        return redirect(route('merchants.index'));
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
                OperatorLog::create(['operator_id'=>Auth::guard('backend')->id(),'content'=>'Mở khóa cho Merchant '.$merchant->merchant_id]);

                Flash::success('MỞ KHÓA merchant thành công!');
            } elseif ($merchant->status == 1) {
                OperatorLog::create(['operator_id'=>Auth::guard('backend')->id(),'content'=>'Khóa Merchant '.$merchant->merchant_id]);

                Flash::success('KHÓA merchant thành công!');
            }
            return redirect(route('merchants.index'));
        }
    }
}
