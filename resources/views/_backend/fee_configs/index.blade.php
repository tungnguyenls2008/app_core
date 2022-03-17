@extends('_backend.layouts.app')
@section('title')
    Cấu hình phí
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Cấu hình phí</h1>
            <div class="section-header-breadcrumb">
                <a href="{{ route('feeConfigs.create')}}" class="btn btn-primary form-btn">Thêm mới <i class="fas fa-plus"></i></a>
            </div>
        </div>
    <div class="section-body">
        <div>
            @include('_backend.fee_configs.search')
        </div>
       <div class="card">
           @include('flash::message')
            <div class="card-body">
                @include('_backend.fee_configs.table')
            </div>
       </div>
   </div>

    </section>
@endsection

