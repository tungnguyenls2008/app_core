<?php
use App\Models\CardIdToNumber;use Carbon\Carbon;
?>
@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">@lang('Bảng điều khiển')</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    @include('flash::message')
                    @if ($errors!=[])
                        @foreach($errors as $error)
                            <div class="alert alert-danger">
                                {{ $error }}
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="row" data-aos="fade-up" data-aos-delay="100">
                <div class="col-md-12 " data-aos="zoom-in" data-aos-delay="300">
                    <div class="alert alert-info">
                        @lang('Chào mừng bạn quay trở lại'), <strong>{{\Illuminate\Support\Facades\Auth::user()->name}}
                            .</strong>
                    </div>
                </div>
            </div>
            @if(\Illuminate\Support\Facades\Auth::user()->is_sub_merchant!=1)
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body text-center">
                                <h3 class="">@lang('Số dư khả dụng')</h3>
                                <h1 class="balance_info" id="balance_info">...</h1>
                                <button class="btn btn-outline-primary check-account" data-toggle="tooltip"
                                        data-placement="bottom" title="@lang('Cập nhật')"><i class="fas fa-sync-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    var formatter = new Intl.NumberFormat('vi-VN', {
                        style: 'currency',
                        currency: 'VND',

                    });

                </script>
            @else
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body text-center">
                                <h3 class="">@lang('Số dư khả dụng')</h3>



                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-6">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3>@lang('Thống kê thu trong ngày')</h3>
                        </div>
                        <div class="card-body">

                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3>@lang('Thống kê chi trong ngày')</h3>
                        </div>
                        <div class="card-body">

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    {{--    @livewire('show-modal',['content'=>'This is the first content','modal_id'=>1])--}}
    {{--    @livewire('show-modal',['content'=>'This is the second content','modal_id'=>2])--}}

@endsection

