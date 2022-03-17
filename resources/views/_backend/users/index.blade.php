@extends('_backend.layouts.app')
@section('title')
    Quản lý tài khoản Backend
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Quản lý tài khoản Backend</h1>
            <div class="section-header-breadcrumb">
                <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px"
                   href="{!! route('users.create') !!}">Thêm mới</a>
            </div>
        </div>
    </section>
    <div class="section-body">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                @include('_backend.users.table')
            </div>
        </div>
        <div class="text-center">

        </div>
    </div>
@endsection

