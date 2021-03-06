<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Kle&#720;s</title>

    <link rel="icon" type="image/png" href="{{ asset('images/favicon-16x16.png') }}" sizes="16x16"/>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon-32x32.png') }}" sizes="32x32"/>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon-96x96.png') }}" sizes="96x96"/>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/vendor/bootstrap-iconpicker.min.css" rel="stylesheet">

    <!-- JavaScripts -->
    <script src="/js/vendor.js" type="text/javascript" language="javascript"></script>
    <script src="/js/vendor/iconset-fontawesome-4.2.0.min.js" type="text/javascript" language="javascript"></script>
    <script src="/js/vendor/bootstrap-iconpicker.min.js" type="text/javascript" language="javascript"></script>
    <script src="/js/app.js" type="text/javascript" language="javascript"></script>
</head>
<body id="app-layout">
    <nav class="navbar navbar-default"></nav>
    <nav class="navbar navbar-default navbar-fixed-top" id="app-navbar">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">@lang('app.toggle-navigation')</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                @if (Auth::user())
                    <a class="navbar-brand" href="{{ url('/home') }}">
                @else
                    <a class="navbar-brand" href="{{ url('/') }}">
                    <!-- <a class="navbar-brand" href="{{ url('/') }}">Kleis</a> -->
                @endif
                    <span><img src="/images/kleis.png" alt="K" style="max-height:20px;vertical-align:middle;position:relative;top:-2px;">le&#720;s</span></a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    @if (Auth::user())
                        <li><a href="{{ url('/home') }}">@lang('app.home')</a></li>
                        <li><a href="{{ url('/accounts') }}">@lang('app.accounts')</a></li>
                        @if (Auth::user()->level >= 5)
                            <li><a href="{{ url('/groups') }}">@lang('app.groups')</a></li>
                            @if (Auth::user()->level == 9)
                                <li><a href="{{ url('/categories') }}">@lang('app.categories')</a></li>
                            @endif
                            <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">@lang('app.whitelists') <span class="caret"></span></a>
                              <ul class="dropdown-menu">
                                <li><a href="{{ url('/whitelist/domains') }}"><i class="fa fa-btn fa-globe"></i>@lang('app.domains')</a></li>
                                <li><a href="{{ url('/whitelist/urls') }}"><i class="fa fa-btn fa-link"></i>@lang('app.urls')</a></li>
                              </ul>
                            </li>
                        @endif
                        @if (Auth::user()->level == 9)
                            <li><a href="{{ url('/administrators') }}">@lang('app.administrators')</a></li>
                        @endif
                    @endif
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::user())
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->firstname }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/profile') }}"><i class="fa fa-btn fa-user"></i>@lang('app.profile')</a></li>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>@lang('app.logout')</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
        @if (file_exists(public_path('images/'.config('kleis.logo_org')) ))
        <div class="logo-brand">
            <img src="{{ '/images/'.config('kleis.logo_org') }}" style="max-height:40px;">
        </div>
        @endif
    </nav>

    <div class="content container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                @yield('content')
            </div>
        </div>
    </div>

    <footer class="footer navbar-fixed-bottom hidden-print">
      <div class="container">
        <p class="text-muted">
            version {{ config('kleis.version') }}
            <br>
            <a href="https://github.com/edno/kleis"><i class="fa fa-github"></i></a>
        </p>
      </div>
    </footer>
</body>
</html>
