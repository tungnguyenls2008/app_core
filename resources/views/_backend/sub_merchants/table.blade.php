
<div class="">
    <table class="table table-bordered table-hover" id="merchants-table">
        <thead>
        <tr>
            <th>@lang('Merchant')</th>
            <th>@lang('Số dư hiện có')</th>
            <th>@lang('Giới hạn yêu cầu chi')</th>
            <th>@lang('Thông tin liên hệ')</th>
            <th>@lang('Số thẻ Topup')</th>
            <th colspan="3">@lang('Thao tác')</th>
        </tr>
        </thead>
        <tbody>
        @foreach($merchants as $merchant)
            <tr>
                <td>
                    <b>Tên:</b> {{ $merchant->name }}
                    <hr>
                    <b>Mã Merchant:</b> {{ $merchant->merchant_id }}
                    <hr>
                    <b>Email:</b> {{ $merchant->email }}
                {{--            <td>{{ $merchant->email_verified_at }}</td>--}}
                {{--            <td>{{ $merchant->password }}</td>--}}
                {{--            <td>{{ $merchant->remember_token }}</td>--}}
                <td>
                    <?php
                    $balance = \App\Models\_Backend\SubMerchantBalance::withoutTrashed()->where(['merchant_id' => $merchant->merchant_id])->first();
                    ?>
                    @if($balance!=null)
                        {{number_format($balance->amount)}}đ
                    @else
                        0đ
                    @endif
                </td>
                <td>
                    <b>Tối thiểu: </b>{{$merchant->transfer_min?number_format($merchant->transfer_min).'đ':'Chưa thiết lập'}}
                    <hr>
                    <b>Tối đa: </b>{{$merchant->transfer_max?number_format($merchant->transfer_max).'đ':'Chưa thiết lập'}}

                </td>
                <td>
                    <b>Số điện thoại: </b>{{ $merchant->phone }}
                    <hr>
                    <b>Địa chỉ: </b>{{ $merchant->address }}
                    <hr>
                    <b>Website: </b><a href="{{ $merchant->website }}" target="_blank">{{ $merchant->website }}</a>
                    <hr>
                    <b>Callback_url: </b><a href="{{ $merchant->callback_url }}"
                                            target="_blank">{{ $merchant->callback_url }}</a>
                    <hr>
                </td>
                <td>{{$merchant->default_card}}</td>
                <td class=" text-center">
                    {{--                                           {!! Form::open(['route' => ['merchants.destroy', $merchant->id], 'method' => 'delete']) !!}--}}
                    <div class='btn-group'>
                        <span data-toggle="modal" data-target="#decrease-balance-modal-{{$merchant->id}}">
                        <a
                            {{--                            href="{{route('merchant-change-default-card',['id'=>$merchant->id])}}"--}}
                            data-toggle="tooltip"
                            class="btn btn-primary btn-xs"
                            data-toggle="tooltip modal" data-placement="top" title="Giảm số dư"

{{--                           onclick="return confirm('Bạn chắc chắn muốn ĐỔI THẺ MẶC ĐỊNH cho merchant này?')"--}}
                        >
                            <i class="fa fa-eraser"></i>
                        </a>
                            </span>
                        <div class="modal fade" data-backdrop="false" id="decrease-balance-modal-{{$merchant->id}}"
                             tabindex="-1"
                             role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <form action="{{route('sub-merchant-decrease-balance')}}">

                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Giảm số dư</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <h3><i>Số dư hiện
                                                    có:<b>{{isset($balance->amount)?number_format($balance->amount):0}}
                                                        đ</b></i></h3>
                                            <label for="default_card">Số dư giảm đi:</label>
                                            <input type="text" class="form-control" style="text-align: center"
                                                   name="amount" id="de-amount_{{$merchant->merchant_id}}" required>
                                            <p style="text-align: center;color: red"
                                               name="amount-text">Bằng chữ:<br><i
                                                    id="de-amount-text-{{$merchant->merchant_id}}">Không đồng</i></p>
                                            <label>Lý do:</label>
                                            <input type="text" class="form-control"
                                                   id="de-ft_code_{{$merchant->merchant_id}}" name="ft_code" required>
                                            <input type="hidden" class="form-control"
                                                   name="merchant_id" value="{{$merchant->merchant_id}}">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy
                                            </button>
                                            <button type="submit" class="btn btn-primary">Giảm số dư</button>
                                        </div>
                                    </form>
                                    <script>
                                        $(function () {

                                            var toText = new NumToText;

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

                                            $("#de-amount_{{$merchant->merchant_id}}").on('input', function () {
                                                $("#de-amount_{{$merchant->merchant_id}}").val(addCommas($("#de-amount_{{$merchant->merchant_id}}").val()));
                                                var so;
                                                so = $("#de-amount_{{$merchant->merchant_id}}").val().replace(/,/g, '')
                                                so = so.replace('đ', '')
                                                $("#de-amount-text-{{$merchant->merchant_id}}").html(toText.doc(so) + ' đồng')

                                            })
                                        })
                                    </script>
                                </div>
                            </div>
                        </div>
                        <span data-toggle="modal" data-target="#increase-balance-modal-{{$merchant->id}}">
                        <a
                            {{--                            href="{{route('merchant-change-default-card',['id'=>$merchant->id])}}"--}}
                            data-toggle="tooltip"
                            class="btn btn-primary btn-xs"
                            data-toggle="tooltip modal" data-placement="top" title="Tăng số dư"

{{--                           onclick="return confirm('Bạn chắc chắn muốn ĐỔI THẺ MẶC ĐỊNH cho merchant này?')"--}}
                        >
                            <i class="fas fa-funnel-dollar"></i>
                        </a>
                            </span>
                        <div class="modal fade" data-backdrop="false" id="increase-balance-modal-{{$merchant->id}}"
                             tabindex="-1"
                             role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <form action="{{route('sub-merchant-increase-balance')}}">

                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Tăng số dư</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <h3><i>Số dư hiện
                                                    có:<b>{{isset($balance->amount)?number_format($balance->amount):0}}
                                                        đ</b></i></h3>
                                            <label for="default_card">Số dư tăng thêm:</label>
                                            <input type="text" class="form-control" style="text-align: center"
                                                   name="amount" id="amount_{{$merchant->merchant_id}}" required>
                                            <p style="text-align: center;color: red"
                                               name="amount-text">Bằng chữ:<br><i
                                                    id="amount-text-{{$merchant->merchant_id}}">Không đồng</i></p>
                                            <label>Mã đối chiếu ngân hàng:</label>
                                            <input type="text" class="form-control"
                                                   id="ft_code_{{$merchant->merchant_id}}" name="ft_code" required>
                                            <input type="hidden" class="form-control"
                                                   name="merchant_id" value="{{$merchant->merchant_id}}">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy
                                            </button>
                                            <button type="submit" class="btn btn-primary">Tăng số dư</button>
                                        </div>
                                    </form>
                                    <script>
                                        $(function () {

                                            var toText = new NumToText;

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

                                            $("#amount_{{$merchant->merchant_id}}").on('input', function () {
                                                $("#amount_{{$merchant->merchant_id}}").val(addCommas($("#amount_{{$merchant->merchant_id}}").val()));
                                                var so;
                                                so = $("#amount_{{$merchant->merchant_id}}").val().replace(/,/g, '')
                                                so = so.replace('đ', '')
                                                $("#amount-text-{{$merchant->merchant_id}}").html(toText.doc(so) + ' đồng')

                                            })
                                        })
                                    </script>
                                </div>
                            </div>
                        </div>
                        <span data-toggle="modal" data-target="#set-transfer-limit-{{$merchant->id}}">
                        <a
                            {{--                            href="{{route('merchant-change-default-card',['id'=>$merchant->id])}}"--}}
                            data-toggle="tooltip"
                            class="btn btn-warning btn-xs"
                            data-toggle="tooltip modal" data-placement="top" title="Thiết lập giới hạn yêu cầu chi"

{{--                           onclick="return confirm('Bạn chắc chắn muốn ĐỔI THẺ MẶC ĐỊNH cho merchant này?')"--}}
                        >
                            <i class="fa fa-code"></i>
                        </a>
                            </span>
                        <div class="modal fade" data-backdrop="false" id="set-transfer-limit-{{$merchant->id}}"
                             tabindex="-1"
                             role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <form action="{{route('sub-merchant-set-transfer-limit')}}">

                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Thiết lập giới hạn yêu cầu chi</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <label for="default_card">Tối thiểu:</label>
                                            <input type="text" class="form-control" id="transfer_min_{{$merchant->merchant_id}}"
                                                   name="transfer_min" value="{{$merchant->transfer_min}}" required>
                                            <label for="default_card">Tối đa:</label>
                                            <input type="text" class="form-control" id="transfer_max_{{$merchant->merchant_id}}"
                                                   name="transfer_max" value="{{$merchant->transfer_max}}" required>
                                            <input type="hidden" class="form-control"
                                                   name="merchant_id" value="{{$merchant->id}}">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy
                                            </button>
                                            <button type="submit" class="btn btn-primary">Xác nhận</button>
                                        </div>
                                    </form>
                                    <script>
                                        $(function () {
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

                                            $("#transfer_min_{{$merchant->merchant_id}}").on('input', function () {
                                                $("#transfer_min_{{$merchant->merchant_id}}").val(addCommas($("#transfer_min_{{$merchant->merchant_id}}").val()));
                                            })
                                            $("#transfer_max_{{$merchant->merchant_id}}").on('input', function () {
                                                $("#transfer_max_{{$merchant->merchant_id}}").val(addCommas($("#transfer_max_{{$merchant->merchant_id}}").val()));
                                            })
                                        })
                                    </script>
                                </div>
                            </div>
                        </div>

                        @switch($merchant->status)
                            @case(1) <a href="{{route('sub-merchant-toggle-lock',['id'=>$merchant->id])}}"
                                        class="btn btn-danger btn-xs"
                                        data-toggle="tooltip" data-placement="top" title="Đổi trạng thái"
                                        onclick="return confirm('Bạn chắc chắn muốn MỞ KHÓA merchant này?')"><i
                                    class="fas fa-lock"></i></a>@break
                            @case(0) <a href="{{route('sub-merchant-toggle-lock',['id'=>$merchant->id])}}"
                                        class="btn btn-success btn-xs"
                                        data-toggle="tooltip" data-placement="top" title="Đổi trạng thái"
                                        onclick="return confirm('Bạn chắc chắn muốn KHÓA merchant này?')"><i
                                    class="fas fa-lock-open"></i></a>@break
                        @endswitch
                        @switch($merchant->re_transferable)
                            @case(1) <a href="{{route('sub-merchant-toggle-re-transferable',['id'=>$merchant->id])}}"
                                        class="btn btn-danger btn-xs"
                                        data-toggle="tooltip" data-placement="top" title="Đổi chức năng chi lại"
                                        onclick="return confirm('Bạn chắc chắn muốn MỞ chức năng chi lại cho merchant này?')">
                                <i class="fas fa-recycle"></i></a>@break
                            @case(0) <a href="{{route('sub-merchant-toggle-re-transferable',['id'=>$merchant->id])}}"
                                        class="btn btn-success btn-xs"
                                        data-toggle="tooltip" data-placement="top" title="Đổi chức năng chi lại"
                                        onclick="return confirm('Bạn chắc chắn muốn KHÓA chức năng chi lại cho merchant này?')">
                                <i class="fas fa-recycle"></i></a>@break
                        @endswitch
                        <span data-toggle="modal" data-target="#change-default-card-modal-{{$merchant->id}}">
                        <a
                            {{--                            href="{{route('merchant-change-default-card',['id'=>$merchant->id])}}"--}}
                            data-toggle="tooltip"
                            class="btn btn-warning btn-xs"
                            data-toggle="tooltip modal" data-placement="top" title="Đổi thẻ Topup"

{{--                           onclick="return confirm('Bạn chắc chắn muốn ĐỔI THẺ MẶC ĐỊNH cho merchant này?')"--}}
                        >
                            <i class="fas fa-credit-card"></i>
                        </a>
                            </span>
                        <a href="{{route('sub-merchant-password.reset',['id'=>$merchant->id])}}"
                           class="btn btn-danger btn-xs"
                           data-toggle="tooltip" data-placement="top" title="Đổi mật khẩu"
                           onclick="return confirm('Bạn chắc chắn muốn ĐẶT LẠI MẬT KHẨU merchant này?')"><i
                                class="fas fa-redo"></i></a>
                        <div class="modal fade" data-backdrop="false" id="change-default-card-modal-{{$merchant->id}}"
                             tabindex="-1"
                             role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <form action="{{route('sub-merchant-change-default-card')}}">

                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Đổi thẻ Topup</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <label for="default_card">Thẻ Topup:</label>
                                            <input type="text" class="form-control"
                                                   name="default_card" value="{{$merchant->default_card}}">
                                            <input type="hidden" class="form-control"
                                                   name="merchant_id" value="{{$merchant->id}}">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy
                                            </button>
                                            <button type="submit" class="btn btn-primary">Xác nhận</button>
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
