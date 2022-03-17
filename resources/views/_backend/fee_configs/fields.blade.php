<div class="col-sm-12">
    <div class="row">
        <!-- Merchant Id Field -->
        <div class="form-group col-md-4">
            <?php
            $merchants = \App\Models\Merchant::withoutTrashed()->select(['merchant_id', 'name'])->get();
            $merchant_select = '';
            foreach ($merchants as $merchant) {
                $merchant_select .= '<option value="' . $merchant->merchant_id . '">' . $merchant->merchant_id . '-' . $merchant->name . '</option>';
            }
            ?>
            <label>Mã Merchant</label>
            <select name="merchant_id" id="merchant_id" class="form-control">
                <option value="" disabled {{request()->merchant_id==''?'selected':''}}>Chọn Merchant</option>
                {!!  $merchant_select!!}
            </select>

        </div>

        <!-- Type Field -->
        <div class="form-group col-md-4">
            {!! Form::label('type', 'Loại dịch vụ:') !!}
            <div class="row">
                <div class="col-md-6 text-center">
                    <label for="card">
                        Thu
                        hộ{!! Form::radio('type', 1,false, ['class' => 'form-control radio-inline','id'=>'card']) !!}
                    </label>
                </div>
                <div class="col-md-6 text-center">
                    <label for="account">
                        Chi
                        hộ{!! Form::radio('type', 2,false, ['class' => 'form-control radio-inline','id'=>'account']) !!}
                    </label>
                </div>
            </div>


        </div>
        <div class="form-group col-md-4">
            {!! Form::label('applied_from', 'Thời điểm áp dụng:') !!}
            {!! Form::input('dateTime-local','applied_from', date('Y-m-d\TH:i',$_SERVER['REQUEST_TIME']), ['class' => 'form-control','min'=>date('Y-m-d\TH:i',$_SERVER['REQUEST_TIME'])]) !!}
        </div>
    </div>
</div>
<div id="fee-config-div" class="col-sm-12" >
    <div class="row">
        <div class="form-group col-md-3">
            <label for="">Khoảng giao dịch</label><br>
            <div style="display: flex">
                <input type="text" name="amount_from[0]" id="amount_from-0" placeholder="Từ" class="form-control"
                       style="width: 50%" value="{{request()->filled('amount_from')?request()->amount_from:''}}" required>
                <input type="text" name="amount_to[0]" id="amount_to-0" placeholder="Đến" class="form-control"
                       style="width: 50%" value="{{request()->filled('amount_to')?request()->amount_to:''}}" required>
            </div>
        </div>
        <!-- Fixed Fee Field -->
        <div class="form-group col-md-3">
            {!! Form::label('fixed_fee[0]', 'Phí cố định:') !!}
            {!! Form::number('fixed_fee[0]', null, ['class' => 'form-control','id'=>'fixed_fee-0','min'=>0, 'required'=>true]) !!}
        </div>

        <!-- Percentage Fee Field -->
        <div class="form-group col-md-3">
            {!! Form::label('percentage_fee[0]', 'Phí phần trăm (%):') !!}
            {!! Form::number('percentage_fee[0]', null, ['class' => 'form-control','id'=>'percentage_fee-0','min'=>0,'max'=>100,'step'=>0.01, 'required'=>true]) !!}
        </div>
{{--        <div class="form-group col-md-3 text-center" style="margin-top: 10px">--}}
{{--            <label for=""></label><br>--}}
{{--            <a class="btn btn-danger less" style="color: white" id="remove-menu-0"><i--}}
{{--                    class="fas fa-minus-circle"></i></a>--}}
{{--        </div>--}}
    </div>
</div>


<div class="form-group col-md-12" style="text-align: center">
    <a class="btn btn-lg btn-success" style="color: white" id="more" data-toggle="tooltip" data-placement="bottom" title="Thêm khoảng giao dịch"><i class="fas fa-plus-circle"></i></a>
</div>
<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Tạo cấu hình phí', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('feeConfigs.index') }}" class="btn btn-light">Hủy</a>
</div>
<script>
    $(function () {
        $("#merchant_id,#type").select2({
            placeholder: 'Mã Merchant',
            allowClear: true
        })
        let i = 0;
        let html = '';
        function addCommas(value) {
            return value
                // Keep only digits and decimal points:
                .replace(/[^\d.]/g, "")
                // Remove duplicated decimal point, if one exists:
                .replace(/^(\d*\.)(.*)\.(.*)$/, '$1$2$3')
                // Keep only two digits past the decimal point:
                .replace(/\.(\d{2})\d+/, '.$1')
                // Add thousands separators:
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        }

        $("#amount_from-0").on('input', function () {
            $("#amount_from-0").val(addCommas($("#amount_from-0").val()));
        })
        $("#amount_to-0").on('input', function () {
            var next_value=parseInt($(this).val().replaceAll(',',''))+1;
            $(this).parent().parent().parent().next().find('.amount-from:first').val(addCommas(next_value.toString()))
            //$(this).val(addCommas($(this).val()));
            $("#amount_to-0").val(addCommas($("#amount_to-0").val()));
        })
        $("#more").on('click', function () {
            i++;
            html = `<div class="row"><div class="form-group col-sm-3 next-amount">
    <label for="">Số tiền</label><br>
    <div style="display: flex" class="amount-div">
        <input type="text" name="amount_from[${i}]" id="amount_from-${i}" placeholder="Từ" class="form-control amount-from"
               style="width: 50%" value="" required>
        <input type="text" name="amount_to[${i}]" id="amount_to-${i}" placeholder="Đến" class="form-control "
               style="width: 50%" value="" required>
    </div>
</div>
<!-- Fixed Fee Field -->
<div class="form-group col-sm-3">
    <label for="fixed_fee[${i}]">Phí cố định:</label>
    <input class="form-control" min="0" name="fixed_fee[${i}]" type="number" id="fixed_fee-${i}" required>
</div>

<!-- Percentage Fee Field -->
<div class="form-group col-sm-3">
    <label for="percentage_fee[${i}]">Phí phần trăm (%):</label>
    <input class="form-control" min="0" max="100" step="0.01" name="percentage_fee[${i}]" type="number" id="percentage_fee-${i}" required>
</div>
<div class="form-group col-sm-3 text-center" style="margin-top: 10px">
        <label for=""></label><br>
        <a class="btn btn-danger less" style="color: white" id="remove-menu-${i}" data-toggle="tooltip" data-placement="bottom" title="Gỡ bỏ" data-boundary="viewport"><i class="fas fa-minus-circle"></i></a>
    </div>
</div>`;
            $("#fee-config-div").fadeIn().append(html);
            for (let j = 0; j <= i; j++) {
                $("#remove-menu-" + j).on('click', function () {
                    $(this).parent().parent().remove();
                })
            }
            $("#amount_from-"+i).on('input', function () {
                $(this).val(addCommas($(this).val()));
            })
            $("#amount_to-"+i).on('input', function () {
                var next_value=parseInt($(this).val().replaceAll(',',''))+1;
                $(this).parent().parent().parent().next().find('.amount-from:first').val(addCommas(next_value.toString()))
                $(this).val(addCommas($(this).val()));
            })
        });
    })
</script>
