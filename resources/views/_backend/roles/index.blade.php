@extends('_backend.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header" style="display: block">
            <div class="row">
                <div class="col-sm-6">
                    <h1>Phân quyền</h1>
                </div>
                <div class="col-sm-6 ">
                    <a class="btn btn-primary float-right"
                       href="{{ route('roles.create') }}">
                        Tạo mới
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body p-0">
                @include('_backend.roles.table')

                <div class="card-footer clearfix float-right">
                    <div class="float-right">

                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

