@extends('layouts.app')
@section('title')
    VietQR
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>VietQR</h1>
            <div class="section-header-breadcrumb">
                <a href="{{ route('vietQRs.create')}}" class="btn btn-primary form-btn">@lang('Tạo mã QR mới') <i class="fas fa-plus"></i></a>
            </div>
        </div>
        <div>
            <p><i>@lang('Công cụ sử dụng để tạo mã VietQR dùng cho thanh toán nhanh qua mã QR')</i></p>
        </div>
    <div class="section-body">
       <div class="card">
           @include('flash::message')
            <div class="card-body">
                @include('viet_q_rs.table')
            </div>
       </div>
   </div>

    </section>
@endsection

