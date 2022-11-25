<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ trans('panel.site_title') }}</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet" />
    <!-- link href="{{ asset('css/adminltev3.css') }}" rel="stylesheet" / -->
    <!-- link href="{{ asset('css/custom.css') }}" rel="stylesheet" / -->
    @yield('styles')

    <style>
        body {
            font-family: "Source Sans Pro",-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            text-align: left;
        }
        .content-wrapper {
            background: #f4f6f9;
        }
        .content-wrapper > .content {
            padding: 0 .5rem;
            padding-top: 0px;
        }
        article, aside, dialog, figcaption, figure, footer, header, hgroup, main, nav, section {
            display: block;
        }
        .bg-primary, .bg-primary a, .label-primary, .label-primary a {
            color: #fff !important;
        }
        .bg-primary, .label-primary {
            background-color: #007bff !important;
        }
        .card-header {
            padding: .75rem 1.25rem;
            margin-bottom: 0;
            background-color: rgba(0,0,0,.03);
            border-bottom: 0 solid rgba(0,0,0,.125);
        }
    </style>
</head>

<body class="sidebar-mini layout-fixed sidebar-collapse" style="height: auto;">
    <div class="wrapper">
        <div class="content-wrapper" style="margin:0 !important">
            <section class="content" style="padding-top: 15px">
                <div class="card mb-3">
                    <div class="card-body text-center">
                        <img src="{{ asset('img/logo.png') }}" style="float:right; width:125px; margin-top:15px">
                        @yield('header')
                    </div>
                </div>

                <!-- Main content -->
                @yield('content')
                <!-- /.content -->
            </section>
        </div>
        <footer class="main-footer text-muted">
            <div class="float-right d-none d-sm-block">

            </div>
            <strong> &copy;</strong> {{ trans('global.allRightsReserved') }}
        </footer>
    </div>

</body>

</html>
