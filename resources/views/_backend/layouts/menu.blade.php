
<li class="side-menus {{ Request::is('*home') ? 'active' : '' }}" {{checkOperatorPermission('backend-home')??'hidden'}}>
    <a class="nav-link" href="{{route('backend-home')}}">
        <i class=" fa fa-building"></i><span>Trang chủ</span>
    </a>
</li>
<hr>
<li class="{{ Request::is('*/merchants*') ? 'active' : '' }}" {{checkOperatorPermission('merchants.index')??'hidden'}}>
    <a href="{{ route('merchants.index') }}"><i class="fa fa-edit"></i><span>@lang('models/merchants.plural')</span></a>
</li>
<li class="{{ Request::is('*sub-merchants*') ? 'active' : '' }}" {{checkOperatorPermission('sub-merchants.index')??'hidden'}}>
    <a href="{{ route('sub-merchants.index') }}"><i class="fa fa-edit"></i><span>HQPAY Merchants</span></a>
</li>
<hr>


<li class="{{ Request::is('feeConfigs*') ? 'active' : '' }}" {{checkOperatorPermission('feeConfigs.index')??'hidden'}}>
    <a href="{{ route('feeConfigs.index') }}"><i class="fa fa-edit"></i><span>Cấu hình phí</span></a>
</li>

<li class="{{ Request::is('*operatorLogs*') ? 'active' : '' }}" {{checkOperatorPermission('operatorLogs.index')??'hidden'}}>
    <a class="nav-link" href="{{ route('operatorLogs.index') }}"><i class="fa fa-book"></i><span>Lịch sử vận hành</span></a>
</li>
@if(\Illuminate\Support\Facades\Auth::guard('backend')->user()->is_superadmin==1)
    <hr>
    <li class="{{ Request::is('*users*') ? 'active' : '' }}">
        <a href="{!! route('users.index') !!}" class="nav-link "><i class="fa fa-user-cog"></i><span>Tài khoản Backend</span></a>
    </li>
    <li class="{{ Request::is('*roles*') ? 'active' : '' }}">
        <a href="{{ route('roles.index') }}" class="nav-link "><i class="fa fa-pencil-ruler"></i><span>Danh sách phân quyền</span></a>
    </li>
@endif
