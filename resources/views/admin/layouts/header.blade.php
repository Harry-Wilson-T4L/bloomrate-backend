<div class="side-header">
    <div class="app-header header d-flex">
        <div class="container-fluid">
            <div class="d-flex">
                <a class="header-brand" href="{{ url('admin/dashboard') }}" style="color: white;">
                    {{ config('app.name') }}
                </a>
                <a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-toggle="sidebar" href="#"></a>
                <a href="#" data-toggle="search" class="nav-link icon navsearch"><i class="typcn typcn-zoom-outline"></i></a>
                <div class="d-flex order-lg-2 ml-auto header-rightnav">
                    <ul class="nav">
                        <li>
                            <div class="dropdown user-header">
                                <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
                                    <span class="avatar avatar-md brround"><img src="{{ asset('assets/images/brand/logo.png') }}" alt="Profile-img" class="avatar avatar-md brround"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow ">
                                    <div class="drop-heading">
                                        <div class="text-center">
                                            <h5 class="text-dark mb-1">{{ auth()->user()->full_name }}</h5>
                                            <small class="text-muted">Admin</small>
                                        </div>
                                    </div>
                                    {{--
                                    <div class="dropdown-divider m-0"></div>
                                    <a class="dropdown-item" href="#">
                                        <i class="dropdown-icon mdi mdi-account-outline "></i> Profile
                                    </a>
                                    --}}
                                    <div class="dropdown-divider m-0"></div>
                                    <div class="text-center">
                                        <a href="{{ url('admin/logout') }}" class=" btn btn-primary m-3">Logout </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>