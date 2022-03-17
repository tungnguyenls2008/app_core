<!-- Code Field -->
<div class="col-sm-12">
    {!! Form::label('code', 'Code:') !!}
    <p>{{ $role->code }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $role->description }}</p>
</div>

<!-- Route Field -->
<div class="col-sm-12">
    {!! Form::label('route', 'Route:') !!}
    <p>{{ $role->route }}</p>
</div>

<!-- Status Field -->
<div class="col-sm-12">
    {!! Form::label('status', 'Status:') !!}
    <p>{{ $role->status }}</p>
</div>

