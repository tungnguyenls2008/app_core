<?php
?>
<div class="col-md-12 border">
    {!! Form::model($merchants, ['route' => 'merchants.index','method'=>'get']) !!}

    <div class="row">
        <div class="col-sm-4">
            <label class="label label-primary form-control-label">
                Tên Merchant
            </label>
            <input type="text" id="name" name="name"
                   placeholder="Tìm tên Merchant..."
                   value="{{request()->filled('name')?request()->name:''}}"
                   class="form-control">
        </div>
        <div class="col-sm-4">
            <label class="label label-primary form-control-label">
                Email
            </label>
            <input type="email" id="email" name="email"
                   placeholder="Tìm Email..."
                   value="{{request()->filled('email')?request()->email:''}}"
                   class="form-control">
        </div>
        <div class="col-sm-4">
            <?php
            $merchants = \App\Models\Merchant::withoutTrashed()->where(['is_sub_merchant'=>0])->select(['merchant_id', 'name'])->get();
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

    </div>
    <div class="row">
        <div class="col-md-4">
            <label for="">Số điện thoại</label><br>
            <input type="text" id="phone" name="phone"
                   placeholder="Tìm số điện thoại..."
                   value="{{request()->filled('phone')?request()->phone:''}}"
                   class="form-control">

        </div>
        <div class="col-md-4">
            <label for="">Địa chỉ</label><br>
            <input type="text" id="address" name="address"
                   placeholder="Tìm địa chỉ..."
                   value="{{request()->filled('address')?request()->address:''}}"
                   class="form-control">

        </div>
        <div class="col-md-4">
            <label for="">Trang chủ</label><br>
            <input type="text" id="website" name="website"
                   placeholder="Tìm trang chủ..."
                   value="{{request()->filled('website')?request()->website:''}}"
                   class="form-control">

        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label for="">Số thẻ mặc định</label><br>
            <input type="text" id="default_card" name="default_card"
                   placeholder="Tìm số thẻ mặc định..."
                   value="{{request()->filled('default_card')?request()->default_card:''}}"
                   class="form-control">

        </div>
    </div>
    <hr>
    <div class="form-group" style="text-align: center">
        <button type="submit" class="btn btn-success">Tìm kiếm</button>
        <a href="{{route('merchants.index')}}"> Hủy</a>
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
            allowClear: true
        })
        var selected = '{{request()->merchant_id??''}}';
        $("#merchant_id").val(selected).trigger('change');
        {{--$.ajax({--}}
        {{--    url: '{{route('backend-get-banks')}}',--}}
        {{--    method: 'GET',--}}
        {{--    success: function (data) {--}}
        {{--        data = JSON.parse(data)--}}
        {{--        if (data['ok'] == true) {--}}
        {{--            data = data['banks'];--}}
        {{--            data = data.map(item => {--}}
        {{--                return {--}}
        {{--                    id: item.bankId,--}}
        {{--                    text: item.bankName--}}
        {{--                };--}}
        {{--            });--}}
        {{--            var options--}}
        {{--            data.forEach(function (item) {--}}
        {{--                options += '<option value="' + item.id + '" >' + item.text + '</option>'--}}
        {{--            })--}}
        {{--            $("#bank_id_search").append(options)--}}
                    $("#bank_id_search").select2({
                        placeholder: 'Tìm theo ngân hàng thụ hưởng...',
                        allowClear: true
                    })
                    var selected = '{{request()->bank_id_search??''}}';
                    $("#bank_id").val(selected).trigger('change');
                    var selected={{\Illuminate\Support\Facades\Auth::user()->bank_id!=null?\Illuminate\Support\Facades\Auth::user()->bank_id:'99999'}};
                    $("#bank_id_search").val(selected).trigger('change');

        {{--        }--}}
        {{--    }--}}
        {{--})--}}
    })
</script>
