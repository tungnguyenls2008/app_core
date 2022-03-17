@extends('layouts.auth_app')
@section('title')
    Đăng nhập/Login
@endsection
@section('content')
    <div class="card card-primary">
        <div class="card-header text-center" >
            <h4 style="width: -webkit-fill-available;">Chào mừng bạn quay trở lại, xin mời đăng nhập.<br>
            Welcome back, please login.</h4>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger p-0">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="form-group">
                    <label for="email">Email của bạn/Your email</label>
                    <input aria-describedby="emailHelpBlock" id="email" type="email"
                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                           placeholder="Nhập email bạn đã đăng ký/Your registered email address" tabindex="1"
                           value="{{ (Cookie::get('email') !== null) ? Cookie::get('email') : old('email') }}" autofocus
                           required>
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                </div>

                <div class="form-group">
                    <div class="d-block">
                        <label for="password" class="control-label">Mật khẩu/Password</label>
                        <div class="float-right">
                            <a href="{{ route('password.request') }}" class="text-small">
                                Quên mật khẩu? / Forgot your password?
                            </a>
                        </div>
                    </div>
                    <input aria-describedby="passwordHelpBlock" id="password" type="password"
                           value="{{ (Cookie::get('password') !== null) ? Cookie::get('password') : null }}"
                           placeholder="Mật khẩu của bạn/Your password"
                           class="form-control{{ $errors->has('password') ? ' is-invalid': '' }}" name="password"
                           tabindex="2" required>
                    <div class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </div>
                </div>

{{--                <div class="form-group">--}}
{{--                    <div class="custom-control custom-checkbox">--}}
{{--                        <input type="checkbox" name="remember" class="custom-control-input" tabindex="3"--}}
{{--                               id="remember"{{ (Cookie::get('remember') !== null) ? 'checked' : '' }}>--}}
{{--                        <label class="custom-control-label" for="remember">Lưu phiên đăng nhập</label>--}}
{{--                    </div>--}}
{{--                </div>--}}

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4" id="submit-button">
                        Đăng nhập/Login
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
        // $(function () {
        //     $("#submit-button").on('click',function () {
        //         $(this).attr('disabled','true')
        //     })
        // })
    </script>
@endsection
