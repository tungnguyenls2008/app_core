<?php
use Illuminate\Support\Facades\Lang;
?>
<div class="col-md-12 border">
    {!! Form::model($operatorLogs, ['route' => 'topupLogs.index','method'=>'get']) !!}

    <div class="row">
{{--        <div class="col-sm-4">--}}
{{--            <label class="label label-primary form-control-label">--}}
{{--                Vận hành--}}
{{--            </label>--}}
{{--            <?php--}}
{{--            $operators=\App\Models\_Backend\User::query()->select(['id','name'])->get()->toArray();--}}
{{--            $operator_select='';--}}
{{--            foreach ($operators as $operator){--}}
{{--                $operator_select.='<option value="'.$operator['id'].'">'.$operator['name'].'</option>';--}}
{{--            }--}}
{{--            ?>--}}
{{--            <select type="text" id="operator_id" name="operator_id" placeholder="Tìm Vận hành..." value="{{request()->filled('operator_id')?request()->operator_id:''}}"--}}
{{--                           class="form-control">--}}
{{--                {!! $operator_select !!}--}}
{{--            </select>--}}
{{--            --}}{{--    <input type="date" id="created_at" name="created_at" placeholder="Tìm theo ngày..." class="form-control" style="width: auto" >--}}

{{--        </div>--}}
{{--        <div class="col-sm-4">--}}

{{--            <label class="label label-primary form-control-label">--}}
{{--                Nội dung thao tác--}}
{{--            </label>--}}
{{--            <input type="text" id="content" name="content" placeholder="Tìm Nội dung thao tác..." value="{{request()->filled('content')?request()->content:''}}"--}}
{{--                   class="form-control">--}}
{{--            --}}{{--<input type="number" id="total_from" name="total_from" placeholder="Từ..." class="form-control"--}}
{{--            --}}{{--                                                   style="width: auto">--}}
{{--            --}}{{--            <input type="number" id="total_to" name="total_to" placeholder="Đến..." class="form-control"--}}
{{--            --}}{{--                   style="width: auto">--}}
{{--            --}}{{--    <input type="date" id="created_at" name="created_at" placeholder="Tìm theo ngày..." class="form-control" style="width: auto" >--}}
{{--        </div>--}}
       <div class="col-md-4">
            <label for="">@lang('Thời gian thực hiện')</label><br>
            <div style="display: flex">
                <input type="date" name="create_from" id="create_from" placeholder="Từ" class="form-control" style="width: 50%" value="{{request()->filled('create_from')?request()->create_from:''}}">
                <input type="date" name="create_to" id="create_to" placeholder="Đến" class="form-control" style="width: 50%" value="{{request()->filled('create_to')?request()->create_to:''}}">
            </div>

        </div>


    </div>
    <hr>
    <div class="form-group" style="text-align: center">
        <button type="submit" class="btn btn-success">@lang('Tìm kiếm')</button>
        <a href="{{route('topupLogs.index')}}"> @lang('Hủy')</a>
        <div><?php
            if (isset($count)) {
                echo "<i>".Lang::get('Tìm thấy')." $count ".Lang::get('kết quả')."</i>";
            }
            ?></div>
    </div>
    {!! Form::close() !!}

</div>
{{--<script>--}}
{{--    $(function () {--}}

{{--        $("#operator_id").select2({--}}
{{--            placeholder: 'Tìm theo vận hành viên...',--}}
{{--            allowClear: true--}}
{{--        })--}}
{{--        var selected = '{{request()->operator_id??''}}';--}}
{{--        $("#operator_id").val(selected).trigger('change');--}}
{{--    })--}}
{{--</script>--}}
