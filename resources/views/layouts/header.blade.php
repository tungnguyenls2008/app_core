<form class="form-inline mr-auto" action="#">
    <ul class="navbar-nav mr-3">
        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        <li>
            @include('language_switcher')
        </li>
    </ul>
</form>
<ul class="navbar-nav navbar-right">

    @if(\Illuminate\Support\Facades\Auth::user())
        <style>

            .unseen-count {
                width: 25px;
                height: 25px;
                background: #2092c3;
                border-radius: 50%;
                top: -0.5rem;
                left: -0.5rem;
                position: absolute;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
                text-align: center;
                font-size: 14px;
                font-family: sans-serif;
                color: #fff;
                /*line-height: 2rem;*/
            }

            @keyframes bounce {
                0% {
                    transform: translateY(0);
                }
                7% {
                    transform: translateY(-1.5rem);
                }
                10% {
                    transform: translateY(0);
                }
                15% {
                    transform: translateY(-0.7rem);
                }
                18% {
                    transform: translateY(0);
                }
                21% {
                    transform: translateY(-0.3rem);
                }
                23% {
                    transform: translateY(0);
                }
                100% {
                    transform: translateY(0);
                }
            }

            .unseen-count-animation {
                animation-name: bounce;
                animation-timing-function: ease;
                animation-duration: 3s;
                animation-iteration-count: infinite;
            }

            .controls {
                text-align: center;
            }

            .controls > .add {
                background: #ccc;
                border: 2px solid #777;
                padding: 0.25rem;
                border-radius: 0.5rem;

            }
        </style>
        @if(\Illuminate\Support\Facades\Auth::user()->is_sub_merchant!=1)
            <div class="">
                <a class="badge badge-primary balance_info" style="color: white" id="balance_info">@lang('Số dư'): ...</a>
                <button class="btn btn-outline-primary check-account" id="check-account" data-toggle="tooltip"
                        data-placement="bottom" title="Cập nhật"><i class="fas fa-sync-alt"></i>
                </button>
            </div>
            <script>
                var formatter = new Intl.NumberFormat('vi-VN', {
                    style: 'currency',
                    currency: 'VND',

                });

            </script>
        @else
            <div class="">

            </div>
        @endif
        <li class="dropdown" id="callback-dropdown">

            <a href="#" data-toggle="dropdown"
               class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <div class="d-sm-none d-lg-inline-block item" id="callback-noti">
                    <div class="unseen-count" id="unseen_count">0</div>&nbsp;&nbsp;&nbsp;@lang('Biến động')</div>

                <div class="d-sm-none d-lg-inline-block">
                    {{\Illuminate\Support\Facades\Auth::user()->first_name}}</div>
            </a>

            <div class="dropdown-menu dropdown-menu-right" style="width: 450px;height: 700px;overflow: scroll">
                <div class="dropdown-title">
                    @lang('Biến động số dư')</div>

            </div>
        </li>
        <li class="dropdown">

            <a href="#" data-toggle="dropdown"
               class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image"
                     @if(isset(Auth::user()->logo))
                     src="{{asset(Auth::user()->logo)}}"
                     @else
                     src="{{asset('img/logo.png')}}"
                     @endif

                     class="rounded-circle mr-1 thumbnail-rounded user-thumbnail ">
                <div class="d-sm-none d-lg-inline-block">
                    {{\Illuminate\Support\Facades\Auth::user()->first_name}}</div>
            </a>

            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">
                    @lang('Xin chào'), {{\Illuminate\Support\Facades\Auth::user()->name}}</div>
                <a class="dropdown-item has-icon edit-profile" href="#" data-id="{{ \Auth::id() }}">
                    <i class="fa fa-user"></i>@lang('Thông tin tài khoản')</a>
                <a class="dropdown-item has-icon" data-toggle="modal" data-target="#changePasswordModal" href="#"
                   data-id="{{ \Auth::id() }}"><i
                        class="fa fa-lock"> </i>@lang('Đổi mật khẩu')</a>
                <a href="{{ url('logout') }}" class="dropdown-item has-icon text-danger"
                   onclick="event.preventDefault(); localStorage.clear();  document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> @lang('Đăng xuất')
                </a>
                <form id="logout-form" action="{{ url('/logout') }}" method="POST" class="d-none">
                    {{ csrf_field() }}
                </form>
            </div>
        </li>
    @else
        <li class="dropdown"><a href="#" data-toggle="dropdown"
                                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                {{--                <img alt="image" src="#" class="rounded-circle mr-1">--}}
                <div class="d-sm-none d-lg-inline-block">{{ __('messages.common.hello') }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">@lang('Đăng nhập')</div>
                <a href="{{ route('login') }}" class="dropdown-item has-icon">
                    <i class="fas fa-sign-in-alt"></i> @lang('Đăng nhập')
                </a>
            <!--                <div class="dropdown-divider"></div>
                <a href="{{ route('register') }}" class="dropdown-item has-icon">
                    <i class="fas fa-user-plus"></i> {{ __('messages.common.register') }}
                </a>-->
            </div>
        </li>
    @endif
</ul>
