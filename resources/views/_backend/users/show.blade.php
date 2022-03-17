@extends('_backend.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>
                        User
                    </h1>
                </div>
            </div>
        </div>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('_backend.users.show_fields')
                    <a href="{!! route('users.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
