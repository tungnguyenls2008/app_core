<div class="table-responsive">
    <table class="table" id="vietQRs-table">
        <thead>
        <tr>
            <th>@lang('Chuyển vào')</th>
            <th>@lang('Số tiền')</th>
            <th>@lang('Số tài khoản/ số thẻ thụ hưởng')</th>
            <th>@lang('Nội dung')</th>
            <th colspan="3">@lang('Thao tác')</th>
        </tr>
        </thead>
        <tbody>
        @foreach($vietQRs as $vietQR)
            <tr>
                <td>
                    @switch ($vietQR->ftType)
                        @case ('ACC') <div class="badge badge-primary">@lang('Tài khoản')</div>@break;
                        @case ('PAN') <div class="badge badge-success">@lang('Số thẻ')</div>@break;
                    @endswitch
                    </td>
                <td>{{ number_format($vietQR->amount) }}đ</td>
                <td>{{ $vietQR->numberOfBeneficiary }}</td>
                <td>{{ $vietQR->description }}</td>
                <td class=" text-center">
                    {!! Form::open(['route' => ['vietQRs.destroy', $vietQR->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('vietQRs.show', [$vietQR->id]) !!}" class='btn btn-light action-btn '><i
                                class="fa fa-eye"></i></a>
{{--                        <a href="{!! route('vietQRs.edit', [$vietQR->id]) !!}"--}}
{{--                           class='btn btn-warning action-btn edit-btn'><i class="fa fa-edit"></i></a>--}}
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger action-btn delete-btn', 'onclick' => 'return confirm(\''.Lang::get("Bạn chắc chắn muốn xóa mã QR này?").'\')']) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
