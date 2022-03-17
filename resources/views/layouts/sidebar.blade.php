<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <img class="navbar-brand-full app-header-logo"
             @if(isset(Auth::user()->logo))
             src="{{asset(Auth::user()->logo)}}"
             @else
             src="{{asset('img/logo.png')}}"
             @endif
             width="65"
             alt="Infyom Logo">
        <a href="{{ route('home') }}"></a>
        @if(\Illuminate\Support\Facades\Auth::user()->is_sub_merchant==1)
            <br>
            <div class="badge badge-primary">HQPAY Merchant</div>
            <br>
        @endif
    </div>
    <div class="sidebar-brand sidebar-brand-sm">

        <a href="{{ route('home') }}" class="small-sidebar-text">
            <img class="navbar-brand-full"
                 @if(isset(Auth::user()->logo))
                 src="{{asset(Auth::user()->logo)}}"
                 @else
                 src="{{asset('img/logo.png')}}"
                 @endif
                 width="45px" alt=""/>
        </a>
    </div>
    <hr>
    <ul class="sidebar-menu">
        @include('layouts.menu')
    </ul>
</aside>
