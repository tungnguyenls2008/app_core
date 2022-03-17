@extends('layouts.app')
@section('title')
    Fee Config Details
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
        <h1>Fee Config Details</h1>
        <div class="section-header-breadcrumb">
            <a href="{{ route('feeConfigs.index') }}"
                 class="btn btn-primary form-btn float-right">Back</a>
        </div>
      </div>
   @include('stisla-templates::common.errors')
    <div class="section-body">
           <div class="card">
            <div class="card-body">
                    @include('_backend.fee_configs.show_fields')
            </div>
            </div>
    </div>
    </section>
@endsection
