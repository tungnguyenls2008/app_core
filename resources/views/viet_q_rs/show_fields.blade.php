<div class="row">
    <div class="col-md-6">
        <!-- Fttype Field -->
        <div class="form-group">
            {!! Form::label('ftType', Lang::get('Chuyển vào')).':' !!}
            <p>{{ $vietQR->ftType }}</p>
        </div>

        <!-- Amount Field -->
        <div class="form-group">
            {!! Form::label('amount', Lang::get('Số tiền')).':' !!}
            <p>{{ $vietQR->amount }}</p>
        </div>

        <!-- Numberofbeneficiary Field -->
        <div class="form-group">
            {!! Form::label('numberOfBeneficiary', Lang::get('Số tài khoản/ số thẻ thụ hưởng')).':' !!}
            <p>{{ $vietQR->numberOfBeneficiary }}</p>
        </div>

        <!-- Description Field -->
        <div class="form-group">
            {!! Form::label('description', Lang::get('Nội dung')).':' !!}
            <p>{{ $vietQR->description }}</p>
        </div>

        <!-- Qr Code Field -->
        <div class="form-group">
            {!! Form::label('qr_code', 'Qr Code:') !!}
            <p>{{ $vietQR->qr_code }}</p>
        </div>
    </div>
    <div class="col-md-6">
        {!! QrCode::size(500)->generate($vietQR->qr_code); !!}
    </div>

</div>
