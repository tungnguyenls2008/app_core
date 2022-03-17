@extends('layouts.app')
@section('title')
    @lang('Lịch sử nạp tiền')
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>@lang('Lịch sử nạp tiền')</h1>
{{--            <div class="section-header-breadcrumb">--}}
{{--                <a href="{{ route('backend-topup-history-export')}}" class="btn btn-primary form-btn"><i class="fas fa-file-export"></i> Xuất file Excel</a>--}}
{{--            </div>--}}
        </div>
    <div class="section-body">
        <div>
            @include('operator_logs.search')
        </div>
       <div class="card">
           @include('flash::message')
            <div class="card-body">
                @include('operator_logs.table')
            </div>
       </div>
   </div>

    </section>
@endsection

