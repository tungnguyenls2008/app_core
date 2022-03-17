
<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', __('models/merchants.fields.name').':') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', __('models/merchants.fields.email').':') !!}
    {!! Form::email('email', null, ['class' => 'form-control']) !!}
</div>

<!-- Email Verified At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email_verified_at', __('models/merchants.fields.email_verified_at').':') !!}
    {!! Form::date('email_verified_at', null, ['class' => 'form-control','id'=>'email_verified_at']) !!}
</div>

@push('scripts')
    <script type="text/javascript">
        $('#email_verified_at').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false
        })
    </script>
@endpush

<!-- Password Field -->
<div class="form-group col-sm-6">
    {!! Form::label('password', __('models/merchants.fields.password').':') !!}
    {!! Form::password('password', ['class' => 'form-control']) !!}
</div>

<!-- Remember Token Field -->
<div class="form-group col-sm-6">
    {!! Form::label('remember_token', __('models/merchants.fields.remember_token').':') !!}
    {!! Form::text('remember_token', null, ['class' => 'form-control']) !!}
</div>

<!-- Merchant Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('merchant_id', __('models/merchants.fields.merchant_id').':') !!}
    {!! Form::text('merchant_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('phone', __('models/merchants.fields.phone').':') !!}
    {!! Form::text('phone', null, ['class' => 'form-control']) !!}
</div>

<!-- Address Field -->
<div class="form-group col-sm-6">
    {!! Form::label('address', __('models/merchants.fields.address').':') !!}
    {!! Form::text('address', null, ['class' => 'form-control']) !!}
</div>

<!-- Website Field -->
<div class="form-group col-sm-6">
    {!! Form::label('website', __('models/merchants.fields.website').':') !!}
    {!! Form::text('website', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit(__('crud.save'), ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('merchants.index') }}" class="btn btn-light">@lang('crud.cancel')</a>
</div>
