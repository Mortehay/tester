<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="uk-background-muted">
<head>
    @yield('layouts.metaTags')
    @include('layouts.headScripts')
    @yield('layouts.micro')
</head>

<body>
<div id="app">
    <div class="tm-page" uk-height-viewport="offset-top: true; offset-bottom: true">
        <div uk-sticky="media: 960" class="uk-navbar-container tm-navbar-container uk-light">
            <div class="uk-container uk-container-expand">
                <nav class="uk-navbar">
                    <div class="uk-navbar-left">
                        <a class="uk-navbar-item uk-logo" href="{{ url('/') }}">
                            @if(!Auth::guest())
                                {{ Auth::user()->name }}
                            @endif
                        </a>
                    </div>
                    <div class="uk-navbar-right">

                            <lang-switcher></lang-switcher>

                        @if(!Auth::guest())
                            @include('layouts.login_menu')
                        @endif
                    </div>
                </nav>
            </div>
        </div>
        @yield('content')
    </div>

    @include('layouts.footer')
</div>
    @include('layouts.bottomScripts')
</body>
</html>

