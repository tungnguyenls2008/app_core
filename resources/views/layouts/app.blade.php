<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>@yield('title') | {{ \Illuminate\Support\Facades\Auth::user()->name }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 4.1.1 -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- Ionicons -->
    <link href="//fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
    <link href="{{ asset('assets/css/@fortawesome/fontawesome-free/css/all.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/iziToast.min.css') }}">
    <link href="{{ asset('assets/css/sweetalert.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
@yield('page_css')
<!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('web/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('web/css/components.css')}}">
    @yield('page_css')


    @yield('css')
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/js/iziToast.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.nicescroll.js') }}"></script>

    <!-- Template JS File -->
    <script src="{{ asset('web/js/stisla.js') }}"></script>
    <script src="{{ asset('web/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/profile.js') }}"></script>
    <script src="{{ asset('assets/js/custom/custom.js') }}"></script>
    @yield('page_js')
    @yield('scripts')
</head>
<style>
    hr {
        margin-top: 0;
        margin-bottom: revert;
    }
    .select2-selection__clear{
        margin-right: 15px;
        z-index: 100;
    }
</style>
<body>

<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg" style="background-color: #fe6703"></div>
        <nav class="navbar navbar-expand-lg main-navbar position-fixed" style="background-color: #fe6703">
            @include('layouts.header')

        </nav>
        <div class="main-sidebar main-sidebar-postion">
            @include('layouts.sidebar')
        </div>
        <!-- Main Content -->
        <div class="main-content">
            @yield('content')
        </div>
        <footer class="main-footer">
            @include('layouts.footer')
        </footer>
    </div>
</div>

@include('profile.change_password')
@include('profile.edit_profile')


</body>

<script>
    let loggedInUser =@json(\Illuminate\Support\Facades\Auth::user());
    let loginUrl = '{{ route('login') }}';
    // Loading button plugin (removed from BS4)
    (function ($) {
        $('#callback-noti').on('click', function () {
            if ($("#callback-dropdown").hasClass('show')) {
                $("#callback-dropdown p").css('background-color', '')
            }
        });
        $.fn.button = function (action) {
            if (action === 'loading' && this.data('loading-text')) {
                this.data('original-text', this.html()).html(this.data('loading-text')).prop('disabled', true);
            }
            if (action === 'reset' && this.data('original-text')) {
                this.html(this.data('original-text')).prop('disabled', false);
            }
        };
        let last_id = 1;
        let event = new EventSource('https://tapi.ecomit.vn/collection/22:07d91f34d600/effects');
        event.onmessage = msg => {
            let data = JSON.parse(msg);
//luu id xử lý cuối cùng để truyền vào trong trường hợp cần kết nối lại.
//new EventSource('{baseURL}/collection/{token}/effects?cursor={last_id}');
            last_id = data.id;
            console.log(data);
            /*
            {
            "amount": 100000,
            "tranDate": "2021-01-30 03:04:06",
            "tranId": "abc",
            "cardId": "0123456789",
            "numberOfBeneficiary": "NA",
            "id": 1,
            "fee": 0,
            "description": "noi dung chuyen khoan",
            }
            */
        }
        let currentCount = 0;
        let countIndicator = document.getElementById("unseen_count");
        $("#unseen_count").hide()
        var now = Date.now();
        // Create our number formatter.
        var formatter = new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND',

            // These options are needed to round to whole numbers if that's what you want.
            //minimumFractionDigits: 0, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
            //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
        });
        setInterval(function () {
            $.ajax({
                url: '{{route('get-noti')}}',
                method: 'GET',
                cache: false,
                success: function (data) {
                    if (data != '') {
                        var content = `<a href="{{route('balanceChangeCallbacks.index')}}">Bạn có 01 biến động có mới, nội dung: "${data.description}"</a>`;
                        iziToast.info({
                            theme: 'light',
                            messageLineHeight: '300px',
                            //backgroundColor:'#fe6703',
                            layout: 2,
                            messageColor: 'white',
                            balloon: true,
                            position: 'topCenter',
                            displayMode: 1,
                            transitionIn: 'flipInX',
                            transitionOut: 'flipOutX',
                            timeout: 20000,
                            title: 'Biến động số dư!',
                            message: content
                        });

                        function actionNewNoti() {
                            currentCount++;
                            $("#unseen_count").fadeIn().show()
                            countIndicator.innerText = currentCount;
                            countIndicator.classList.remove('unseen-count-animation');
                            setTimeout(function () {
                                countIndicator.classList.add('unseen-count-animation');
                            }, 50)
                            $.ajax({
                                url: '{{route('update-noti')}}',
                                method: 'GET',
                                cache: false,
                                success: function (data) {
                                    if (data != '') {
                                        var params = '';

                                        data.forEach(function (item, index, arr) {
                                            function pad2(n) {
                                                return (n < 10 ? '0' : '') + n;
                                            }

                                            var date = new Date(item['tranDate']);
                                            var month = pad2(date.getMonth() + 1);//months (0-11)
                                            var day = pad2(date.getDate());//day (1-31)
                                            var year = date.getFullYear();
                                            var hour = date.getHours();
                                            var minute = date.getMinutes();

                                            var formattedDate = day + "-" + month + "-" + year + " " + hour + ":" + minute;
                                            var number
                                            if (item.account != '') {
                                                number = item.account
                                            } else {
                                                number = item.numberOfBeneficiary
                                            }
                                            var background = '';
                                            if ((date.getTime()) - now >= 0) {
                                                background = 'background-color:#e9ecef'
                                            }
                                            params += '<p class="dropdown-item has-icon" style="white-space: inherit;' + background + '">' +
                                                '<a href="{{route('balanceChangeCallbacks.index')}}" style="font-size: 16px">Giao dịch thu hộ mới</a>' +
                                                ' đến số thẻ/tài khoản <b>' + number + '</b>,' +
                                                ' số tiền <b>' + formatter.format(item.amount) + '</b>,' +
                                                ' nội dung <b>"' + item.description + '"</b>' +
                                                ' vào lúc <b>' + formattedDate + '</b></p>'
                                        })
                                        $("#noti-display").html(params)
                                    }
                                }
                            })
                        }

                        actionNewNoti()
                        $("#callback-noti").on('click', function () {
                            countIndicator.innerText = 0;
                            countIndicator.classList.remove('unseen-count-animation');
                            $("#unseen_count").fadeOut().hide()
                            currentCount = 0
                        })

                    }

                }
            })
        }, 3000)

    }(jQuery));

</script>
</html>
