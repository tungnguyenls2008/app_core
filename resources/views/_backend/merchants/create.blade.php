@extends('_backend.layouts.app')
@section('title')
    Đăng ký Merchant mới
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading m-0">Đăng ký Merchant</h3>
            <div class="filter-container section-header-breadcrumb row justify-content-md-end">
                <a href="{{ route('merchants.index') }}" class="btn btn-primary">Quay lại</a>
            </div>
        </div>
        <div class="card card-primary">
            <div class="card-header"><h4>Đăng ký Merchant</h4></div>

            <div class="card-body pt-1">
                @include('flash::message')
                <form method="POST" action="{{ route('merchant-register') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="first_name">Tên merchant:</label><span
                                    class="text-danger">*</span>
                                <input id="firstName" type="text"
                                       class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                       name="name"
                                       tabindex="1" placeholder="Nhập tên merchant" value="{{ old('name') }}"
                                       autofocus required>
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email:</label><span
                                    class="text-danger">*</span>
                                <input id="email" type="email"
                                       class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                       placeholder="Nhập địa chỉ email" name="email" tabindex="1"
                                       value="{{ old('email') }}"
                                       required autofocus>
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Số điện thoại:</label>
                                <input id="phone"
                                       class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                       placeholder="Nhập số điện thoại" name="phone" tabindex="1"
                                       value="{{ old('phone') }}"
                                       >
                                <div class="invalid-feedback">
                                    {{ $errors->first('phone') }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address">Địa chỉ:</label>
                                <input id="address"
                                       class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}"
                                       placeholder="Nhập địa chỉ hành chính" name="address" tabindex="1"
                                       value="{{ old('address') }}"
                                       >
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="website">Trang chủ:</label>
                                <input id="website"
                                       class="form-control{{ $errors->has('website') ? ' is-invalid' : '' }}"
                                       placeholder="Nhập địa chỉ trang chủ" name="website" tabindex="1"
                                       value="{{ old('website') }}"
                                       >
                                <div class="invalid-feedback">
                                    {{ $errors->first('website') }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password" class="control-label">Mật khẩu
                                    :</label><span
                                    class="text-danger">*</span>
                                <input id="password" type="password"
                                       class="form-control{{ $errors->has('password') ? ' is-invalid': '' }}"
                                       placeholder="Đặt mật khẩu" name="password" tabindex="2" required>
                                <div class="invalid-feedback">
                                    {{ $errors->first('password') }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password_confirmation"
                                       class="control-label">Xác nhận mật khẩu:</label><span
                                    class="text-danger">*</span>
                                <input id="password_confirmation" type="password" placeholder="Nhập lại mật khẩu một lần nữa"
                                       class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid': '' }}"
                                       name="password_confirmation" tabindex="2">
                                <div class="invalid-feedback">
                                    {{ $errors->first('password_confirmation') }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-4">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                    Đăng ký Merchant
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

