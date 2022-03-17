@extends('_backend.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Sửa quyền</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('stisla-templates::common.errors')

        <div class="card">

            {!! Form::model($role, ['route' => ['roles.update', $role->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <?php
                $routeCollection=getBackendRouteListEdit();
                ?>
                <div class="row">
                    @include('_backend.roles.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('Cập nhật', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('roles.index') }}" class="btn btn-default">Hủy</a>
            </div>

           {!! Form::close() !!}

        </div>
    </div>
@endsection
