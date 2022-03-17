<div id="EditProfileModal" class="modal fade" role="dialog">

    <div class="modal-dialog modal-lg profile-div">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Thông tin tài khoản')</h5>&nbsp;
                <button class="badge badge-primary badge-pill" id="profile-edit-btn"> @lang('Chỉnh sửa')</button>
                <button type="button" aria-label="Close" class="close outline-none" data-dismiss="modal">×</button>
            </div>
            <form method="POST" id="update-profile-form"

                  {{--                  id="editProfileForm" --}}
                  enctype="multipart/form-data" action="{{route('update-profile')}}">
                <div class="modal-body">
                    <div class="alert alert-danger d-none" id="editProfileValidationErrorsBox"></div>
                    <input type="hidden" name="user_id" id="pfUserId">
                    <input type="hidden" name="is_active" value="1">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="form-group col-sm-3">
                            <label>@lang('Tên merchant'):</label><span class="required">*</span>
                            <input type="text" name="name" id="pfName" class="form-control" required
                                   tabindex="1">
                        </div>
                        <div class="form-group col-sm-3">
                            <label>@lang('Mã merchant'):</label><span class="required">*</span>
                            <p>{{\Illuminate\Support\Facades\Auth::user()->merchant_id}}</p>
                        </div>
                        <div class="form-group col-sm-6 d-flex">
                            <div class="col-sm-4 col-md-6 pl-0 form-group">
                                <label>@lang('Logo/Ảnh đại diện'):</label>
                                <br>
                                <label
                                    class="image__file-upload btn btn-primary text-white"
                                    tabindex="2"> @lang('Chọn ảnh')
                                    <input type="file" name="logo" id="pfImage" class="d-none"
                                           accept="image/jpeg,image/x-png">
                                </label>
                            </div>
                            <div class="col-sm-3 preview-image-video-container float-right mt-1">
                                <img id='edit_preview_photo'
                                     class="img-thumbnail user-img user-profile-img profilePicture"
                                     @if(isset(Auth::user()->logo))
                                     src="{{asset(Auth::user()->logo)}}"/>

                                @else
                                    src="{{asset('img/logo.png')}}"/>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>@lang('Số điện thoại'):</label>
                            <input type="text" name="phone" id="pfPhone" class="form-control" tabindex="3"
                                   value="{{\Illuminate\Support\Facades\Auth::user()->phone}}">
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Website:</label>
                            <input type="text" name="website" id="pfWebsite" class="form-control" tabindex="3"
                                   value="{{\Illuminate\Support\Facades\Auth::user()->website}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Email:</label><span class="required">*</span>
                            <input type="email" name="email" id="pfEmail" class="form-control" required tabindex="3"
                                   value="{{\Illuminate\Support\Facades\Auth::user()->email}}">
                        </div>
                        <div class="form-group col-sm-6">
                            <label>@lang('Địa chỉ'):</label>
                            <input type="text" name="address" id="pfAddress" class="form-control" tabindex="3"
                                   value="{{\Illuminate\Support\Facades\Auth::user()->address}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>Callback URL:</label><span class="required">*</span>
                            <input type="text" name="callback_url" id="pfCallbackUrl" class="form-control"
                                   required tabindex="3"
                                   value="{{\Illuminate\Support\Facades\Auth::user()->callback_url}}">
                        </div>
                        @if(\Illuminate\Support\Facades\Auth::user()->is_sub_merchant!=1)

                            <div class="form-group col-sm-6">
                                <label>@lang('Số thẻ Topup'):</label><span class="required">*</span>

                            </div>
                        @endif
                    </div>
                    <fieldset style="border: 2px groove;padding: 5px">
                        <legend style="width: auto" id="bank_info_legend">
                            @if(\Illuminate\Support\Facades\Auth::user()->is_sub_merchant!=1)
                                <a id="bank_info_edit_btn"
                                   class="btn btn-sm btn-primary">
                                    @lang('Thay đổi')
                                </a>
                            @endif

                        </legend>
                        <div class="row">

                            <div class="form-group col-sm-6">
                                <label>AppId @lang('tài khoản thu'):</label><span class="required">*</span>
                                <div id="app_id_div">
                                    @if(\Illuminate\Support\Facades\Auth::user()->app_id==null)
                                        <input type="text" name="app_id" id="pfAppId" class="form-control" maxlength="8"
                                               tabindex="3" required>
                                    @else
                                        <p style="color: green"><i>@lang('Đã thiết lập')</i></p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Secret @lang('tài khoản thu'):</label><span class="required">*</span>
                                <div id="secret_div">
                                    @if(\Illuminate\Support\Facades\Auth::user()->secret==null)
                                        <input type="text" name="secret" id="pfSecret" class="form-control"
                                               maxlength="32" required
                                               tabindex="3">
                                    @else
                                        <p style="color: green"><i>@lang('Đã thiết lập')</i></p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="form-group col-sm-6">
                                <label>AppId @lang('tài khoản chi'):</label>
                                <div id="app_id_addition_div">
                                    @if(\Illuminate\Support\Facades\Auth::user()->app_id_addition==null)
                                        <input type="text" name="app_id_addition" id="pfAppIdAddition"
                                               class="form-control"
                                               maxlength="8"
                                               tabindex="3">
                                    @else
                                        <p style="color: green"><i>@lang('Đã thiết lập')</i></p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Secret @lang('tài khoản chi'):</label>
                                <div id="secret_addition_div">
                                    @if(\Illuminate\Support\Facades\Auth::user()->secret_addition==null)
                                        <input type="text" name="secret_addition" id="pfSecret" class="form-control"
                                               maxlength="32"
                                               tabindex="3">
                                    @else
                                        <p style="color: green"><i>@lang('Đã thiết lập')</i></p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <p style="color: red">
                                    <i>*@lang('Nếu không thiết lập AppId và Secret của tài khoản chi, hệ thống sẽ chọn AppId và Secret của tài khoản thu làm mặc định')
                                        .</i></p>

                            </div>
                        </div>
                    </fieldset>
                    <fieldset style="border: 2px groove;padding: 5px;width: -webkit-fill-available;">
                        <legend style="width: auto" id="bank_account"><a id="bank_account_update_btn"
                                                                         class="btn btn-sm btn-primary">@lang('Cập nhật')</a>
                        </legend>

                    </fieldset>
                    <div class="text-right update-profile-div">
                        <button type="submit" class="btn btn-primary" id="btnPrEditSave"
                                data-loading-text="<span class='spinner-border spinner-border-sm'></span> Processing..."
                                tabindex="5">@lang('Cập nhật')
                        </button>
                        <button type="button" class="btn btn-light ml-1 edit-cancel-margin margin-left-5"
                                data-dismiss="modal">@lang('Hủy')
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(function () {
        $("#update-profile-form .row :input").attr("readonly", true);
        $(".update-profile-div").attr("hidden", true);
        $(".image__file-upload").attr("hidden", true);
        $("#profile-edit-btn").on('click', function () {
            $(".row :input").attr("readonly", false);
            $(".update-profile-div").attr("hidden", false);
            $(".image__file-upload").attr("hidden", false);
        })
        $(document).on('click', '#bank_info_edit_btn', function () {
            var app_id = `<input type="text" name="app_id"  class="form-control" maxlength="8"
                              tabindex="3" required>`
            var secret = `<input type="text" name="secret"  class="form-control" maxlength="32"
                              tabindex="3" required>`
            var app_id_addition = `<input type="text" name="app_id_addition"  class="form-control" maxlength="8"
                              tabindex="3" required>`
            var secret_addition = `<input type="text" name="secret_addition"  class="form-control" maxlength="32"
                              tabindex="3" required>`
            $("#app_id_div").html(app_id)
            $("#secret_div").html(secret)
            $("#app_id_addition_div").html(app_id_addition)
            $("#secret_addition_div").html(secret_addition)
            $(".update-profile-div").attr("hidden", false);
            $("#bank_info_legend").html(`<a id="bank_info_edit_cancel_btn" class="btn btn-sm btn-secondary">@lang('Hủy')</a>`)
        })
        $('#EditProfileModal').on('hidden.bs.modal', function (e) {
            $(".profile-div .row :input").attr("readonly", true);
            $(".update-profile-div").attr("hidden", true);
            $(".image__file-upload").attr("hidden", true);
            var p_set = `<p style="color: green"><i>@lang('Đã thiết lập')</i></p>`;
            $("#app_id_div").html(p_set)
            $("#secret_div").html(p_set)
            $("#app_id_addition_div").html(p_set)
            $("#secret_addition_div").html(p_set)
        })
        $(document).on('click', '#bank_info_edit_cancel_btn', function () {
            var p_set = `<p style="color: green"><i>@lang('Đã thiết lập')</i></p>`;
            $("#app_id_div").html(p_set)
            $("#secret_div").html(p_set)
            $("#app_id_addition_div").html(p_set)
            $("#secret_addition_div").html(p_set)
            $(".update-profile-div").attr("hidden", true);

            $("#bank_info_legend").html(`<a id="bank_info_edit_btn" class="btn btn-sm btn-primary">@lang('Thay đổi')</a>`)

        })
{{--        @if(\Illuminate\Support\Facades\Auth::user()->is_sub_merchant!=1)--}}

        $("#default_card").select2({
            placeholder: 'Chọn thẻ Topup',
            allowClear: true,
            theme: 'default default-card-select'
        })
        var selected = '{{request()->default_card??''}}';
        $("#default_card").val(selected).trigger('change');
        $(".default-card-select").css('display', 'block');
{{--        @endif--}}
        $("#bank_id").select2({
            placeholder: '@lang('Chọn ngân hàng')',
            allowClear: true,
            theme: 'default bank-select'
        })
        $(".bank-select").css('display', 'block');

        var selected = {{\Illuminate\Support\Facades\Auth::user()->bank_id!=null?\Illuminate\Support\Facades\Auth::user()->bank_id:'99999'}};
        $("#bank_id").val(selected).trigger('change');
        $("#bank_account_update_btn").on('click', function () {
            $("#profile_bank_account").fadeOut().hide().fadeIn().show().html('@lang('Đang cập nhật...')')


        })
    })

</script>
