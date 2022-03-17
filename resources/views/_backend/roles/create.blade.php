@extends('_backend.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Tạo phân quyền mới</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('stisla-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'roles.store']) !!}

            <div class="card-body">
<?php
                $routeCollection=getBackendRouteList();
                ?>
                <div class="row">
                    @include('_backend.roles.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('Tạo phân quyền', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('roles.index') }}" class="btn btn-default">Hủy</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>

@endsection
