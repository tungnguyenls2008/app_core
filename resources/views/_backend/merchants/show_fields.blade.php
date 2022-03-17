<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', __('models/merchants.fields.name').':') !!}
    <p>{{ $merchant->name }}</p>
</div>

<!-- Email Field -->
<div class="form-group">
    {!! Form::label('email', __('models/merchants.fields.email').':') !!}
    <p>{{ $merchant->email }}</p>
</div>

<!-- Email Verified At Field -->
<div class="form-group">
    {!! Form::label('email_verified_at', __('models/merchants.fields.email_verified_at').':') !!}
    <p>{{ $merchant->email_verified_at }}</p>
</div>

<!-- Password Field -->
<div class="form-group">
    {!! Form::label('password', __('models/merchants.fields.password').':') !!}
    <p>{{ $merchant->password }}</p>
</div>

<!-- Remember Token Field -->
<div class="form-group">
    {!! Form::label('remember_token', __('models/merchants.fields.remember_token').':') !!}
    <p>{{ $merchant->remember_token }}</p>
</div>

<!-- Merchant Id Field -->
<div class="form-group">
    {!! Form::label('merchant_id', __('models/merchants.fields.merchant_id').':') !!}
    <p>{{ $merchant->merchant_id }}</p>
</div>

<!-- Phone Field -->
<div class="form-group">
    {!! Form::label('phone', __('models/merchants.fields.phone').':') !!}
    <p>{{ $merchant->phone }}</p>
</div>

<!-- Address Field -->
<div class="form-group">
    {!! Form::label('address', __('models/merchants.fields.address').':') !!}
    <p>{{ $merchant->address }}</p>
</div>

<!-- Website Field -->
<div class="form-group">
    {!! Form::label('website', __('models/merchants.fields.website').':') !!}
    <p>{{ $merchant->website }}</p>
</div>

