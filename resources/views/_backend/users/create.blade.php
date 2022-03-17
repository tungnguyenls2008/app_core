@extends('_backend.layouts.app')
@section('title')
    Tạo mới tài khoản Backend
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>
                Tạo mới tài khoản Backend
            </h1>
        </div>
    </section>
    <div class="section-body">
        @include('stisla-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row" style="display: contents;">

                    {!! Form::open(['route' => 'users.store']) !!}

                    @include('_backend.users.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
