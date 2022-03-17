<!-- Merchant Id Field -->
<div class="form-group">
    {!! Form::label('merchant_id', 'Merchant Id:') !!}
    <p>{{ $feeConfig->merchant_id }}</p>
</div>

<!-- Type Field -->
<div class="form-group">
    {!! Form::label('type', 'Type:') !!}
    <p>{{ $feeConfig->type }}</p>
</div>

<!-- Fixed Fee Field -->
<div class="form-group">
    {!! Form::label('fixed_fee', 'Fixed Fee:') !!}
    <p>{{ $feeConfig->fixed_fee }}</p>
</div>

<!-- Percentage Fee Field -->
<div class="form-group">
    {!! Form::label('percentage_fee', 'Percentage Fee:') !!}
    <p>{{ $feeConfig->percentage_fee }}</p>
</div>

<!-- Status Field -->
<div class="form-group">
    {!! Form::label('status', 'Status:') !!}
    <p>{{ $feeConfig->status }}</p>
</div>

