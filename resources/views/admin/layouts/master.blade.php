<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ config('app.name') }}</title>

    <!--Favicon -->
    <link rel="icon" href="{{ asset('assets/images/brand/logo.png') }}" type="image/x-icon"/>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/brand/logo.png') }}" />

    <!-- Dashboard css -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />

    <!-- WYSIWYG Editor css -->
    <link href="{{ asset('assets/plugins/jquery.richtext/jquery.richtext.css') }}" rel="stylesheet" />

    <!-- C3 Charts css -->
    <!-- <link href="{{ asset('assets/plugins/charts-c3/c3-chart.css') }}" rel="stylesheet" /> -->

    <!--  Table css -->
    <link href="{{ asset('assets/plugins/tables/style.css') }}" rel="stylesheet" />

    <!-- Custom scroll bar css-->
    <link href="{{ asset('assets/plugins/jquery.mCustomScrollbar/jquery.mCustomScrollbar.css') }}" rel="stylesheet" />

    <!-- Sidemenu css -->
    <link href="{{ asset('assets/plugins/toggle-sidemenu/fullwidth/fullwidth-sidemenu.css') }}" rel="stylesheet" />

    <!---Font icons css-->
    <link  href="{{ asset('assets/fonts/fonts/font-awesome.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/web-fonts/plugin.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/web-fonts/icons.css') }}" rel="stylesheet" />

    <!-- Siderbar css-->
    <link href="{{ asset('assets/plugins/sidebar/sidebar.css') }}" rel="stylesheet">

    <!-- Data table css -->
    <link href="{{ asset('assets/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/datatable/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
</head>
<body class="app sidebar-mini rtl">
    <!---Global-loader-->
    <div id="global-loader" >
        <img src="{{ asset('assets/images/svgs/loader.svg') }}" alt="loader">
    </div>

    <div class="page">
        <div class="page-main">
            @include('admin.layouts.header')
            @include('admin.layouts.sidebar')

            <div class="app-content  toggle-content">
                <div class="side-app">
                    <div class="page-header">
                        <h4 class="page-title">{{ $title }}</h4>
                    </div>
                    @if(Session::has('success')) <div class="alert alert-success">{{ Session::get('success') }}</div>@endif
                    @if(Session::has('error')) <div class="alert alert-danger">{{ Session::get('error') }}</div>@endif
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Back to top -->
    <a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>
    @include('admin.layouts.footer')
</body>
</html>