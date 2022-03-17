<div class="table-responsive">
    <table class="table  table-bordered table-hover" id="merchants-table">
        <thead>
        <tr>
            <th>@lang('Merchant')</th>
            <th>@lang('Email')</th>
            {{--        <th>@lang('models/merchants.fields.email_verified_at')</th>--}}
            {{--        <th>@lang('models/merchants.fields.password')</th>--}}
            {{--        <th>@lang('models/merchants.fields.remember_token')</th>--}}
            <th>@lang('Mã Merchant')</th>
            <th>@lang('Số điện thoại')</th>
            <th>@lang('Địa chỉ')</th>
            <th>@lang('Trang chủ')</th>
            <th>@lang('Số thẻ mặc định')</th>
            <th colspan="3">@lang('Thao tác')</th>
        </tr>
        </thead>
        <tbody>
        @foreach($merchants as $merchant)
            <tr>
                <td>{{ $merchant->name }}</td>
                <td>{{ $merchant->email }}</td>
                {{--            <td>{{ $merchant->email_verified_at }}</td>--}}
                {{--            <td>{{ $merchant->password }}</td>--}}
                {{--            <td>{{ $merchant->remember_token }}</td>--}}
                <td>{{ $merchant->merchant_id }}</td>
                <td>{{ $merchant->phone }}</td>
                <td>{{ $merchant->address }}</td>
                <td><a href="{{ $merchant->website }}" target="_blank">{{ $merchant->website }}</a></td>
                <td>{{ $merchant->default_card }}</td>

                <td class=" text-center">
                    {{--                                           {!! Form::open(['route' => ['merchants.destroy', $merchant->id], 'method' => 'delete']) !!}--}}
                    <div class='btn-group'>
                        @switch($merchant->status)
                            @case(1) <a href="{{route('merchant-toggle-lock',['id'=>$merchant->id])}}"
                                        class="btn btn-danger btn-xs"
                                        data-toggle="tooltip" data-placement="top" title="Đổi trạng thái"
                                        onclick="return confirm('Bạn chắc chắn muốn MỞ KHÓA merchant này?')"><i
                                    class="fas fa-lock"></i></a>@break
                            @case(0) <a href="{{route('merchant-toggle-lock',['id'=>$merchant->id])}}"
                                        class="btn btn-success btn-xs"
                                        data-toggle="tooltip" data-placement="top" title="Đổi trạng thái"
                                        onclick="return confirm('Bạn chắc chắn muốn KHÓA merchant này?')"><i
                                    class="fas fa-lock-open"></i></a>@break
                        @endswitch
                        <span data-toggle="modal" data-target="#change-default-card-modal-{{$merchant->id}}">
                        <a
                            {{--                            href="{{route('merchant-change-default-card',['id'=>$merchant->id])}}"--}}
                            data-toggle="tooltip"
                            class="btn btn-warning btn-xs"
                            data-toggle="tooltip modal" data-placement="top" title="Đổi thẻ mặc định"

{{--                           onclick="return confirm('Bạn chắc chắn muốn ĐỔI THẺ MẶC ĐỊNH cho merchant này?')"--}}
                        >
                            <i class="fas fa-credit-card"></i>
                        </a>
                            </span>
                        <a href="{{route('merchant-password.reset',['id'=>$merchant->id])}}"
                           class="btn btn-danger btn-xs"
                           data-toggle="tooltip" data-placement="top" title="Đổi mật khẩu"
                           onclick="return confirm('Bạn chắc chắn muốn ĐẶT LẠI MẬT KHẨU merchant này?')"><i
                                class="fas fa-redo"></i></a>
                        <div class="modal fade" data-backdrop="false" id="change-default-card-modal-{{$merchant->id}}"
                             tabindex="-1"
                             role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <form action="{{route('merchant-change-default-card')}}">

                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Đổi thẻ mặc định</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <label for="default_card">Thẻ mặc định:</label>
                                            <input type="text" class="form-control" id="default_card" name="default_card" value="{{$merchant->default_card}}">
                                            <input type="hidden" class="form-control" id="merchant_id" name="merchant_id" value="{{$merchant->id}}">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                            </button>
                                            <button type="submit" class="btn btn-primary">Đổi thẻ mặc định</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                        {{--                                               <a href="{!! route('merchants.show', [$merchant->id]) !!}" class='btn btn-light action-btn '><i class="fa fa-eye"></i></a>--}}
                        {{--                                               <a href="{!! route('merchants.edit', [$merchant->id]) !!}" class='btn btn-warning action-btn edit-btn'><i class="fa fa-edit"></i></a>--}}
                        {{--                                               {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger action-btn delete-btn', 'onclick' => 'return confirm("'.__('crud.are_you_sure').'")']) !!}--}}
                    </div>
                    {{--                                           {!! Form::close() !!}--}}
                </td>
            </tr>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
