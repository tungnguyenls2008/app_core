<?php
?>
@extends('layouts.app')
@section('title')
    VietQR Code
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>VietQR Code</h1>
            <div class="section-header-breadcrumb">
                <a href="{{ route('vietQRs.index') }}"
                   class="btn btn-primary form-btn float-right">@lang('Quay lại')</a>
            </div>
        </div>
        @include('stisla-templates::common.errors')
        <div class="section-body">
            <div class="card">
                <div class="card-body text-center">
                    {!! QrCode::size(500)->generate($result); !!}
                    <div>
                        <p><i>@lang('Sử dụng ứng dụng Internet Banking có hỗ trợ mã QR để tiến hành thanh toán')</i></p>
                    </div>
                    <div >
                        <a href="{{ route('vietQRs.index') }}"
                           class="btn btn-primary">@lang('Quay lại')</a>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
