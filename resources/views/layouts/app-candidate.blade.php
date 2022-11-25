<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ trans('panel.site_title') }}">
    <meta name="keywords" content="Grupo Persona" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ trans('panel.site_title') }}</title>

    <!-- Styles -->
    @yield('styles')

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/config-style.css') }}" rel="stylesheet">

    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="{{ trans('panel.site_title') }}">

    <link rel="apple-touch-icon" sizes="57x57" href="/img/webapp/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/img/webapp/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/img/webapp/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/img/webapp/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/img/webapp/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/img/webapp/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/img/webapp/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/img/webapp/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/img/webapp/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/img/webapp/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/webapp/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/img/webapp/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/webapp/favicon-16x16.png">

    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ea7a1d">
    <meta name="msapplication-TileImage" content="/img/icons/icon-144x144.png">
    <meta name="theme-color" content="#ea7a1d">
    <link rel="icon" type="image/png" href="favicon.ico" sizes="32x32">
    <link rel="shortcut icon" href="img/favicon.ico">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    @guest
    <style>
       #appCapsule, .appHeader, .chatFooter {
            margin-left: 0 !important;
        }
    </style>
    @endguest

</head>

@php($unread = \App\Models\QaTopic::unreadCount())
<body>

    <!-- App Header -->
    <div class="appHeader">
    @section('app-header')
        @auth
        <div class="left">
            <a href="#" id="mobile-menu" class="headerButton" data-toggle="modal" data-target="#sidebarPanel">
                <i class="icon ion-ios-menu"></i>
                @if($unread > 0)
                <span class="badge badge-danger">{{ $unread }}</span>
                @endif
            </a>
        </div>
        <div class="pageTitle">
            @isset($title)
            {{ $title }}
            @else
            {{ Auth::user()->name }}
            @endisset
        </div>
        <div class="right">
            @isset($printBackBtn)
            <button type="button" class="btn btn-outline-primary" onclick="window.history.back();"><ion-icon name="chevron-back-outline"></ion-icon></button>
            @else
            <a href="{{ route('admin.candidate.profile.show') }}">
                <img src="{{ Auth::user()->photo_default->thumbnail }}" alt="{{ trans('global.my_profile') }}" class="logo rounded">
            </a>
            @endisset
        </div>
        @endauth
        @guest
        <div class="pageTitle">
            <img src="{{ asset('img/logo.png') }}" alt="Grupo Persona" class="logo">
        </div>
        @endguest
    @show
    </div>
    <!-- * App Header -->

    @auth
    <header id="header" class="no-sticky">
		<div id="header-wrap">
			<div class="container clearfix">
                <ul class="listview flush transparent image-listview">
                    @if(Auth::user()->candidate->program)
                    <li>
                        <a href="{{ route('admin.candidate.program.show') }}" class="item">
                            <div class="icon-box bg-primary"><ion-icon name="home-outline"></ion-icon></div>
                            <div class="in"><div>{{ __('global.home') }}</div></div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.candidate.calendar.show') }}" class="item">
                            <div class="icon-box bg-primary"><ion-icon name="calendar-number-outline"></ion-icon></div>
                            <div class="in"><div>{{ __('candidate.titles.calendar') }}</div></div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.candidate.messages.show') }}" class="item">
                            <div class="icon-box bg-primary"><ion-icon name="chatbox-ellipses-outline"></ion-icon></div>
                            <div class="in {{ $unread > 0 ? 'font-weight-bold' : '' }}"><div>{{ __('candidate.titles.communication') }}{{ $unread > 0 ? ' (' . $unread . ')' : '' }}</div></div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.candidate.analytics.show') }}" class="item">
                            <div class="icon-box bg-primary"><ion-icon name="analytics-outline"></ion-icon></div>
                            <div class="in"><div>{{ __('candidate.titles.analytics') }}</div></div>
                        </a>
                    </li>
                    @if(Auth::user()->candidate->program->program_type->outplacement)
                    <!-- li>
                        <a href="{{ route('admin.candidate.opportunities.show') }}" class="item">
                            <div class="icon-box bg-primary"><ion-icon name="sparkles-outline"></ion-icon></div>
                            <div class="in"><div>{{ __('candidate.titles.opportunities') }}</div></div>
                        </a>
                    </li -->
                    @endif
                    @else
                    <li>
                        <a href="/home" class="item">
                            <div class="icon-box bg-primary">
                                <i class="icon ion-ios-home"></i>
                            </div>
                            <div class="in">
                            {{ __('global.home') }}
                            </div>
                        </a>
                    </li>
                    @endif
                    <li>
                        <a href="{{ route('admin.candidate.profile.show') }}" class="item item-off">
                            <div class="icon-box bg-primary"><img src="{{ Auth::user()->photo_default->thumbnail }}" alt="{{ trans('global.my_profile') }}" class="imaged rounded w36"></div>
                            <div class="in"><div><strong>{{ Auth::user()->name }}</strong></div></div>
                        </a>
                    </li>
                </ul>
                @can('admin', Auth::user())
                    <a class="btn btn-secondary btn-sm mt-1" href="{{ route('dashboard') }}"><ion-icon name="swap-horizontal-outline" class="mx-1"></ion-icon> {{ __('buttons.user_switch.admin') }}</a>
                @endcan
                <a class="btn btn-secondary btn-sm mt-1" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('global.buttons.logout') }}</a>
			</div>
		</div>
	</header>
    @endauth

    <!-- App Capsule -->
    <div id="appCapsule">

        @yield('content')

        <!-- app footer -->
        <div class="appFooter">
            <div class="footer-title">
                {{ config('app.copyright', 'Copyright © Grupo Persona') }}.
            </div>
        </div>
        <!-- * app footer -->

    </div>
    <!-- * App Capsule -->

    @auth
    @if(Auth::user()->candidate->program)
    <!-- App Bottom Menu -->
    <div class="appBottomMenu">
        <a href="{{ route('admin.candidate.program.show') }}" class="item {{ Route::is('admin.candidate.program*') ? "active" : "" }}">
            <div class="col">
            <ion-icon name="home{{ Route::is('admin.home') ? "" : "-outline" }}"></ion-icon>
                <strong>{{ __('global.home') }}</strong>
            </div>
        </a>
        <a href="{{ route('admin.candidate.calendar.show') }}" class="item {{ Route::is('admin.candidate.calendar*') ? "active" : "" }}">
            <div class="col">
                <ion-icon name="calendar-number{{ Route::is('admin.candidate.calendar*') ? "" : "-outline" }}"></ion-icon>
                <strong>{{ __('candidate.titles.calendar') }}</strong>
            </div>
        </a>
        <a href="{{ route('admin.candidate.messages.show') }}" class="item {{ Route::is('admin.candidate.messages*') ? "active" : "" }}">
            <div class="col">
                <ion-icon name="chatbox-ellipses{{ Route::is('admin.candidate.messages*') ? "" : "-outline" }}"></ion-icon>
                <strong>{{ __('candidate.titles.communication') }}{{ $unread > 0 ? ' (' . $unread . ')' : '' }}</strong>
            </div>
        </a>
        @if(Auth::user()->candidate->program->program_type->outplacement)
        <!-- a href="{{ route('admin.candidate.opportunities.show') }}" class="item {{ Route::is('admin.candidate.opportunities*') ? "active" : "" }}">
            <div class="col">
                <ion-icon name="sparkles{{ Route::is('admin.candidate.opportunities*') ? "" : "-outline" }}"></ion-icon>
                <strong>{{ __('candidate.titles.opportunities') }}</strong>
            </div>
        </a -->
        @endif
        <a href="{{ route('admin.candidate.analytics.show') }}" class="item {{ Route::is('admin.candidate.analytics*') ? "active" : "" }}">
            <div class="col">
                <ion-icon name="analytics{{ Route::is('admin.candidate.analytics*') ? "" : "-outline" }}"></ion-icon>
                <strong>{{ __('candidate.titles.analytics') }}</strong>
            </div>
        </a>
    </div>
    <!-- * App Bottom Menu -->
    @endif

    <!-- App Sidebar -->
    <div class="modal fade panelbox panelbox-left" id="sidebarPanel" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">

                    <div class="mobile-pageTitle">
                        <img src="{{ asset('img/logo.png') }}" alt="{{ trans('panel.site_title') }}" class="logo">
			        </div>

                    <ul class="listview flush transparent no-line image-listview">
                        <li>
                            <a href="{{ route('admin.candidate.profile.show') }}" class="item item-off">
                                <div class="icon-box bg-primary"><img src="{{ Auth::user()->photo_default->thumbnail }}" alt="{{ trans('global.my_profile') }}" class="imaged rounded w36"></div>
                                <div class="in"><div><strong>{{ Auth::user()->name }}</strong></div></div>
                            </a>
                        </li>
                    </ul>

                    <div class="row">
                    <div class="col-12">
                        <a class="btn btn-secondary btn-sm mt-1 float-right mr-1" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('global.buttons.logout') }}</a>
                        @can('admin', Auth::user())
                        <a class="btn btn-secondary btn-sm mt-1 float-right mr-1" href="{{ route('dashboard') }}"><ion-icon name="swap-horizontal-outline" class="mx-1"></ion-icon> {{ __('buttons.user_switch.admin') }}</a>
                        @endcan
                    </div>
                    </div>

                    <ul class="listview flush transparent no-line image-listview">
                        @if(Auth::user()->candidate->program)
	                    <li>
	                        <a href="{{ route('admin.candidate.program.show') }}" class="item">
	                            <div class="icon-box bg-primary"><ion-icon name="home-outline"></ion-icon></div>
	                            <div class="in"><div>{{ __('global.home') }}</div></div>
	                        </a>
	                    </li>
                        <li>
                            <a href="{{ route('admin.candidate.calendar.show') }}" class="item">
                                <div class="icon-box bg-primary"><ion-icon name="calendar-number-outline"></ion-icon></div>
                                <div class="in"><div>{{ __('candidate.titles.calendar') }}</div></div>
                            </a>
                        </li>
                        <li>
	                        <a href="{{ route('admin.candidate.messages.show') }}" class="item">
	                            <div class="icon-box bg-primary"><ion-icon name="chatbox-ellipses-outline"></ion-icon></div>
	                            <div class="in {{ $unread > 0 ? 'font-weight-bold' : '' }}"><div>{{ __('candidate.titles.communication') }}{{ $unread > 0 ? ' (' . $unread . ')' : '' }}</div></div>
	                        </a>
	                    </li>
                        @if(Auth::user()->candidate->program->program_type->outplacement)
	                    <!-- li>
	                        <a href="{{ route('admin.candidate.opportunities.show') }}" class="item">
	                            <div class="icon-box bg-primary"><ion-icon name="sparkles-outline"></ion-icon></div>
	                            <div class="in"><div>{{ __('candidate.titles.opportunities') }}</div></div>
	                        </a>
	                    </li -->
                        @endif
                        <li>
	                        <a href="{{ route('admin.candidate.analytics.show') }}" class="item">
	                            <div class="icon-box bg-primary"><ion-icon name="analytics-outline"></ion-icon></div>
	                            <div class="in"><div>{{ __('candidate.titles.analytics') }}</div></div>
	                        </a>
	                    </li>
                        @else
                        <li>
	                        <a href="/home" class="item">
	                            <div class="icon-box bg-primary">
	                                <i class="icon ion-ios-home"></i>
	                            </div>
	                            <div class="in">
                                {{ __('global.home') }}
	                            </div>
	                        </a>
	                    </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- * App Sidebar -->

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    @endauth

    <script src="{{ asset('js/base.js') }}"></script>

    @yield('scripts')
</body>

</html>
