@extends('_backend.layouts.app')
@section('title')
    Danh sách HQPAY Merchant
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Danh sách HQPAY Merchant</h1>
            <div class="section-header-breadcrumb">
                <a class="btn btn-outline-primary form-btn" data-toggle="modal" data-target="#set_default_bank_info"><i
                        class="fas fa-cogs"></i> Mặc định AppId và Secret </a>
                <div class="modal fade" data-backdrop="false" id="set_default_bank_info" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalCenterTitle">Mặc định AppId và Secret <a
                                        id="default_bank_info_edit_btn"
                                        class="btn btn-sm btn-primary">Thay đổi</a></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                &nbsp;&nbsp;&nbsp;
                <a href="{{ route('sub-merchants.create')}}" class="btn btn-primary form-btn"><i
                        class="fas fa-plus"></i> Đăng ký mới </a>
            </div>
        </div>
        <div class="section-body">
            <div>
                @include('_backend.sub_merchants.search')
            </div>
            @include('flash::message')
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body text-center">
                            <h3 class="">Số dư khả dụng</h3>
                            <h1 class="" id="balance_info">...</h1>
                            <button class="btn btn-outline-primary " id="check-account" data-toggle="tooltip"
                                    data-placement="bottom" title="Cập nhật"><i class="fas fa-sync-alt"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    @include('_backend.sub_merchants.table')
                </div>
                {!! $merchants->links() !!}

            </div>
        </div>

    </section>
    <script>
        $(function () {
            $(document).on('click', '#default_bank_info_edit_btn', function () {
                $("#default-bank-form :input").attr("readonly", false);
                $("#default-bank-modal-footer").attr("hidden", false);
                $("#default-bank-info-hint").attr("hidden", false);
                $("#default-bank-modal-footer").fadeIn().show();
            })
            $('#set_default_bank_info').on('hidden.bs.modal', function (e) {
                $("#default-bank-form :input").attr("readonly", true);
                $("#default-bank-modal-footer").hide();
                $("#default-bank-info-hint").hide();

            })
            $("#balance_info").fadeOut().hide().fadeIn().show().html('...')

        })
    </script>

@endsection



