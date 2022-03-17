<!-- Fttype Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ftType', Lang::get('Chuyển đến').':') !!}
    {!! Form::select('ftType', [''=>'','ACC'=>Lang::get('Tài khoản'),'PAN'=>Lang::get('Số thẻ')],null, ['class' => 'form-control','maxlength' => 12,'maxlength' => 12]) !!}
</div>

<!-- Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('amount', Lang::get('Số tiền').':') !!}
    {!! Form::number('amount', null, ['class' => 'form-control']) !!}
</div>

<!-- Numberofbeneficiary Field -->
<div class="form-group col-sm-6">
    {!! Form::label('numberOfBeneficiary', Lang::get('Tài khoản thụ hưởng').':') !!}
    {!! Form::text('numberOfBeneficiary', null, ['class' => 'form-control','maxlength' => 24,'maxlength' => 24]) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', Lang::get('Nội dung').':') !!}
    {!! Form::text('description', null, ['class' => 'form-control','maxlength' => 500,'maxlength' => 500]) !!}
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit(Lang::get('Tạo mã QR'), ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('vietQRs.index') }}" class="btn btn-light">@lang('Hủy')</a>
</div>
<input type="hidden" name="merchant_id" value="{{\Illuminate\Support\Facades\Auth::user()->merchant_id}}">
<script>
    $(function () {

        $("#ftType").select2({
            placeholder: "@lang('Chọn chuyển đến...')"
        })

    })
</script>
