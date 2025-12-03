<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar toggle-sidebar">
    <div class="app-sidebar__user">
        <div class="user-body">
            <span class="avatar avatar-xl brround text-center cover-image" data-image-src="{{ asset('assets/images/brand/logo.png') }}"></span>
        </div>
        <div class="user-info">
            <a href="#" class="ml-2"><span class="app-sidebar__user-name font-weight-semibold">{{ auth()->user()->full_name }} </span><br>
                <span class="text-muted app-sidebar__user-name text-sm">Admin</span>
            </a>
        </div>
    </div>
    <ul class="side-menu toggle-menu">
        <li>
            <a class="side-menu__item" href="{{ url('admin/dashboard') }}"><i class="side-menu__icon typcn typcn-device-laptop"></i><span class="side-menu__label">Dashboard</span></a>
        </li>
        <li>
            <a class="side-menu__item" href="{{ url('admin/users') }}"><i class="side-menu__icon typcn typcn-group-outline"></i><span class="side-menu__label">Users</span></a>
        </li>
        <li>
            <a class="side-menu__item" href="{{ url('admin/status') }}"><i class="side-menu__icon typcn typcn-puzzle-outline"></i><span class="side-menu__label">Status</span></a>
        </li>
        <li>
            <a class="side-menu__item" href="{{ url('admin/interests') }}"><i class="side-menu__icon typcn typcn-infinity-outline"></i><span class="side-menu__label">Interest</span></a>
        </li>
        <li>
            <a class="side-menu__item" href="{{ url('admin/reported/posts') }}"><i class="side-menu__icon typcn typcn-lock-closed-outline"></i><span class="side-menu__label">Reported Posts</span></a>
        </li>
        <li>
            <a class="side-menu__item" href="{{ url('admin/help-and-feedback') }}"><i class="side-menu__icon typcn typcn-messages"></i><span class="side-menu__label">Help and Feedback</span></a>
        </li>
        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#"><i class="side-menu__icon typcn typcn-book"></i><span class="side-menu__label">Content</span><i class="angle fa fa-angle-right"></i></a>
            <ul class="slide-menu">
                <li><a href="{{ url('admin/content/pp') }}" class="slide-item">Privacy Policy</a></li>
                <li><a href="{{ url('admin/content/tc') }}" class="slide-item">Terms and Conditions</a></li>
                <li><a href="{{ url('admin/content/au') }}" class="slide-item">About Us</a></li>
            </ul>
        </li>
    </ul>
</aside>
<!--sidemenu end-->