<?php

namespace App\Http\Controllers\_Backend;

use App\Http\Controllers\Controller;
use App\Models\_Backend\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        $this->middleware('backend');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('_backend.home');
    }
    public function changePassword(Request $request){
        $request=$request->all();

        if (password_verify($request['password_current'],Auth::guard('backend')->user()->getAuthPassword())){
            $user=User::find(['id'=>Auth::guard('backend')->user()->id])->first();
            if ($request['password']==$request['password_confirmation']){
                $user->password=Hash::make($request['password']);
                if($user->save()){
                    Flash::success('Đã đổi mật khẩu thành công, mời bạn đăng nhập lại.');
                    Auth::logout();
                    return redirect(route('backend-login-view'));
                }
                Flash::error('Có lỗi xảy ra khi tiến hành thanh đổi mật khẩu, liên hệ với trung tâm CSKH để được giải quyết.');
                return redirect(route('backend-home'));
            }else{
                Flash::error('Vui lòng xác nhận lại mật khẩu.');
                return redirect(route('backend-home'));
            }

        }else{
            Flash::error('Mật khẩu hiện tại không đúng.');
            return redirect(route('backend-home'));
        }
    }

}
