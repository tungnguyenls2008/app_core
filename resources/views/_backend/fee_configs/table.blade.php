<div class="table-responsive">
    <table class="table  table-bordered table-hover" id="feeConfigs-table">
        <thead>
        <tr>
            <th>Mã Merchant</th>
            <th>Loại dịch vụ</th>
            <th>Khoảng giao dịch</th>
            <th>Phí cố định</th>
            <th>Phí phần trăm (%)</th>
            <th>Trạng thái</th>
            <th>Thời gian áp dụng</th>
            {{--                <th colspan="3">Action</th>--}}
        </tr>
        </thead>
        <tbody>
        @foreach($feeConfigs as $feeConfig)
            <tr>
                <td>{{ $feeConfig->merchant_id }}</td>
                <td>
                    <?php
                    if ($feeConfig->type == 1) {
                        echo '<div class="badge badge-success">Thu hộ</div>';
                    } elseif ($feeConfig->type == 2) {
                        echo '<div class="badge badge-primary">Chi hộ</div>';
                    } else {
                        echo '<div class="badge badge-secondary">Đang cập nhật</div>';
                    }
                    ?>
                </td>
                <?php
                if ($feeConfig->fee_data!=null){
                    $fee_data = json_decode($feeConfig->fee_data, true);
                    foreach ($fee_data as $key => $datum) {
                        $fee_data[$key] = json_decode($datum, true);
                    }
                }

                ?>
                <td>
                    @foreach($fee_data as $fee_datum)
                        {{number_format($fee_datum['amount_from'])}}đ - {{number_format($fee_datum['amount_to'])}}đ
                        <hr>
                    @endforeach
                </td>

                <td>
                    @foreach($fee_data as $fee_datum)
                        {{$fee_datum['fixed_fee']?number_format($fee_datum['fixed_fee']).'đ':'0đ'}}
                        <hr>
                    @endforeach
                </td>
                <td>
                    @foreach($fee_data as $fee_datum)
                        {{$fee_datum['percentage_fee']??0}}
                        <hr>
                    @endforeach
                </td>
                <td>
                    <?php
                    if ($feeConfig->status == 0) {
                        echo '<div class="badge badge-success">Kích hoạt</div>';
                    } elseif ($feeConfig->status == 1) {
                        echo '<div class="badge badge-danger">Đã khóa</div>';
                    } elseif ($feeConfig->status == 2) {
                        echo '<div class="badge badge-warning">Chưa kích hoạt</div>';
                    } else {
                        echo '<div class="badge badge-secondary">Đang cập nhật</div>';
                    }
                    ?>
                </td>
                <td>{{strtotime($feeConfig->applied_from)?date('d-m-Y H:i:s',strtotime($feeConfig->applied_from)):''}}</td>
                {{--                       <td class=" text-center">--}}
                {{--                           {!! Form::open(['route' => ['feeConfigs.destroy', $feeConfig->id], 'method' => 'delete']) !!}--}}
                {{--                           <div class='btn-group'>--}}
                {{--                               <a href="{!! route('feeConfigs.show', [$feeConfig->id]) !!}" class='btn btn-light action-btn '><i class="fa fa-eye"></i></a>--}}
                {{--                               <a href="{!! route('feeConfigs.edit', [$feeConfig->id]) !!}" class='btn btn-warning action-btn edit-btn'><i class="fa fa-edit"></i></a>--}}
                {{--                               {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger action-btn delete-btn', 'onclick' => 'return confirm("Are you sure want to delete this record ?")']) !!}--}}
                {{--                           </div>--}}
                {{--                           {!! Form::close() !!}--}}
                {{--                       </td>--}}
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $feeConfigs->links() !!}
</div>
