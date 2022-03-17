@extends('_backend.layouts.app')
@section('title')
     Danh sách Merchant
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Danh sách Merchant</h1>
            <div class="section-header-breadcrumb">
                <a href="{{ route('merchants.create')}}" class="btn btn-primary form-btn"><i class="fas fa-plus"></i> Đăng ký mới </a>
            </div>
        </div>
    <div class="section-body">
        <div>
            @include('_backend.merchants.search')
        </div>
        @include('flash::message')
       <div class="card">
            <div class="card-body">
                @include('_backend.merchants.table')
            </div>
           {!! $merchants->links() !!}

       </div>
   </div>

    </section>
@endsection



