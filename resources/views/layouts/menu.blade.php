
<li class="side-menus {{ Request::is('home') ? 'active' : '' }}">
    <a class="nav-link" href="{{route('home')}}">
        <i class=" fa fa-building"></i><span>@lang('Bảng điều khiển')</span>
    </a>
</li>
<hr>

{{--<li class="side-menus {{ Request::is('testCallbacks*') ? 'active' : '' }}">--}}
{{--    <a class="nav-link" href="{{ route('testCallbacks.index') }}"><i class="fas fa-building"></i><span>Test Callbacks</span></a>--}}
{{--</li>--}}

