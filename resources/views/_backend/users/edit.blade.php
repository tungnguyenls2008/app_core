@extends('_backend.layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="row mb-2">
                <div class="col-sm-12">
            <h1>{{$user->name}}</h1>
                </div>
            </div>
        </div>
   </section>
   <div class="content">
       @include('stisla-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row" style="display: contents;">
                   {!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'patch']) !!}

                        @include('_backend.users.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
