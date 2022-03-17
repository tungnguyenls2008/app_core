<?php
?>
<div class="col-md-12 border">
    {!! Form::model($feeConfigs, ['route' => 'feeConfigs.index','method'=>'get']) !!}

    <div class="row">
        <div class="col-sm-4">
            <label class="label label-primary form-control-label">
                Loại dịch vụ
            </label>
            <select id="type" name="type" class="form-control">
                <option value="" disabled selected>Tìm loại dịch vụ...</option>
                <option value="1" {{request()->type=='1'?'selected':''}}>Thu hộ</option>
                <option value="2" {{request()->type=='2'?'selected':''}}>Chi hộ</option>
            </select>
        </div>
        <div class="col-sm-4">
                <?php
                $merchants = \App\Models\Merchant::withoutTrashed()->select(['merchant_id', 'name'])->get();
                $merchant_select = '';
                foreach ($merchants as $merchant) {
                    $merchant_select .= '<option value="' . $merchant->merchant_id . '">' . $merchant->merchant_id . '-' . $merchant->name . '</option>';
                }
                ?>
                <label>Mã Merchant</label>
                <select name="merchant_id" id="merchant_id" class="form-control">
                    <option value="" disabled {{request()->merchant_id==''?'selected':''}}>Tìm mã Merchant...</option>
                    {!!  $merchant_select!!}
                </select>
        </div>
        <div class="col-sm-4">
            <label>
                Trạng thái
            </label>
            <select type="text" id="status" name="status" value="{{request()->filled('status')?request()->status:''}}"
                    class="form-control">
                <option value="" disabled {{request()->status==''?'selected':''}}>Tìm trạng thái...</option>
                <option value="0" {{request()->status=='0'?'selected':''}}>Kích hoạt</option>
                <option value="1" {{request()->status=='1'?'selected':''}}>Đã khóa</option>
                <option value="2" {{request()->status=='2'?'selected':''}}>Chưa kích hoạt</option>

            </select>
        </div>

    </div>
    <div class="row">
        <div class="col-md-4">
            <label for="">Thời gian áp dụng</label><br>
            <div style="display: flex">
                <input type="date" name="applied_from" id="applied_from" placeholder="Từ" class="form-control"
                       style="width: 50%" value="{{request()->filled('applied_from')?request()->applied_from:''}}">
                <input type="date" name="applied_to" id="applied_to" placeholder="Đến" class="form-control"
                       style="width: 50%" value="{{request()->filled('applied_to')?request()->applied_to:''}}">
            </div>
        </div>

    </div>

    <hr>
    <div class="form-group" style="text-align: center">
        <button type="submit" class="btn btn-success">Tìm kiếm</button>
        <a href="{{route('feeConfigs.index')}}"> Hủy</a>
        <div><?php
            if (isset($count)) {
                echo "<i>Tìm thấy $count kết quả.</i>";
            }
            ?></div>
    </div>
    {!! Form::close() !!}

</div>
<script>
    $(function () {
        $("#merchant_id").select2({
            placeholder: 'Tìm theo mã Merchant...',
            allowClear: true,
        })
        var selected = '{{request()->merchant_id??''}}';
        $("#merchant_id").val(selected).trigger('change');
    })
</script>
