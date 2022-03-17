<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\CollectOnBehalfAPIController;
use App\Models\BalanceChangeCallback;
use App\Models\Merchant;
use App\Models\MerchantBankAccount;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function changePassword(Request $request){
        $request=$request->all();

        if (password_verify($request['password_current'],Auth::user()->getAuthPassword())){
            $user=User::find(['id'=>Auth::user()->id])->first();
            if ($request['password']==$request['password_confirmation']){
                $user->password=Hash::make($request['password']);
                if($user->save()){
                    Flash::success(Lang::get('Đã đổi mật khẩu thành công, mời bạn đăng nhập lại.'));
                    Auth::logout();
                    return redirect('/login');
                }
                Flash::error(Lang::get('Có lỗi xảy ra khi tiến hành thanh đổi mật khẩu, liên hệ với trung tâm CSKH để được giải quyết.'));
                return redirect('/home');
            }else{
                Flash::error(Lang::get('Vui lòng xác nhận lại mật khẩu.'));
                return redirect('/home');
            }

        }else{
            Flash::error(Lang::get('Mật khẩu hiện tại không đúng.'));
            return redirect('/home');
        }
    }
    public function updateProfile(Request $request){
        $request_data=$request->all();

        $merchant=Merchant::find(['id'=>Auth::user()->id])->first();
        $merchant->fill($request_data);
        if ($request->file('logo') !== null) {
            $image = $request->file('logo');
            $image->move('img/organization_logos', $merchant->merchant_id . '.png');
            $merchant->logo='img/organization_logos/'.$merchant->merchant_id . '.png';
        }
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'email_verified_at' => 'nullable',
            //'password' => 'required|string|max:255',
            'remember_token' => 'nullable|string|max:100',
            'created_at' => 'nullable',
            'updated_at' => 'nullable',
            'merchant_id' => 'nullable|string|max:24',
            //'phone' => 'nullable|string|max:16',
            //'logo' => 'nullable|string|max:500',
            'address' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:64',
            'app_id' => 'nullable|string|max:8',
            'secret' => 'nullable|string|max:32',
            'app_id_addition' => 'nullable|string|max:8',
            'secret_addition' => 'nullable|string|max:32',
            'bank_account' => 'nullable|string|max:32',
            'bank_id' => 'nullable|integer',
        ];
        $validation = Validator::make( $request->all(), $rules );
        if ( $validation->fails()) {
            Flash::error(Lang::get('Một hoặc nhiều thông tin cập nhật không hợp lệ!'));

            return redirect(route('home'))->withErrors($validation);
        }
        $merchant->save();

        Flash::success(Lang::get('Cập nhật thông tin merchant thành công!'));


        return redirect(route('home'));

    }

    public function getNotification(){
        $callback=BalanceChangeCallback::withoutTrashed()->where(['merchant_id'=>Auth::user()->merchant_id])->OrderBy('created_at','desc')->where('created_at','>=',Carbon::now()->subSeconds(3))->first();
        if ($callback!=null){
            return $callback->toArray();
        }
        else{
            return false;
        }
    }
    public function updateNotification(){
        $callback=BalanceChangeCallback::withoutTrashed()->where(['merchant_id'=>Auth::user()->merchant_id])->OrderBy('created_at','desc')->take(15)->get();
        if ($callback!=null){
            return $callback->toArray();
        }
        else{
            return false;
        }
    }
}
