@extends('layouts.app')
@section('title')
    @lang('Chi tiết mã QR')
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
        <h1>@lang('Chi tiết mã QR')</h1>
        <div class="section-header-breadcrumb">
            <a href="{{ route('vietQRs.index') }}"
                 class="btn btn-primary form-btn float-right">@lang('Quay lại')</a>
        </div>
      </div>
   @include('stisla-templates::common.errors')
    <div class="section-body">
           <div class="card">
            <div class="card-body">
                    @include('viet_q_rs.show_fields')
            </div>
            </div>
    </div>
    </section>
@endsection
