@extends('_backend.layouts.app')
@section('title')
    Lịch sử vận hành
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Lịch sử vận hành</h1>
            <div class="section-header-breadcrumb">
                <a href="{{ route('backend-operator-log-export')}}" class="btn btn-primary form-btn"><i class="fas fa-file-export"></i> Xuất file Excel</a>
            </div>
        </div>
    <div class="section-body">
        <div>
            @include('_backend.operator_logs.search')
        </div>
       <div class="card">
           @include('flash::message')
            <div class="card-body">
                @include('_backend.operator_logs.table')
            </div>
       </div>
   </div>

    </section>
@endsection

