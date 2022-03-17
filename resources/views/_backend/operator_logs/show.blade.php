@extends('layouts.app')
@section('title')
    Operator Log Details
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
        <h1>Operator Log Details</h1>
        <div class="section-header-breadcrumb">
            <a href="{{ route('operatorLogs.index') }}"
                 class="btn btn-primary form-btn float-right">Back</a>
        </div>
      </div>
   @include('stisla-templates::common.errors')
    <div class="section-body">
           <div class="card">
            <div class="card-body">
                    @include('_backend.operator_logs.show_fields')
            </div>
            </div>
    </div>
    </section>
@endsection
