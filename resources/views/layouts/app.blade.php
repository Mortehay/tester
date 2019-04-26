<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="uk-background-muted">
<head>
    @include('layouts.metaTags')
    @include('layouts.headScripts')
    @yield('headScriptsAdditional')
    @include('layouts.micro')
</head>

<body>
    @include('layouts.topScripts')
    <div class="tm-page" uk-height-viewport="offset-top: true; offset-bottom: true">
        <div uk-sticky="media: 960" class="uk-navbar-container tm-navbar-container uk-light">
            <div class="uk-container uk-container-expand">
                <nav class="uk-navbar">
                    <div class="uk-navbar-left">
                        <a class="uk-navbar-item uk-logo" href="{{ url('/') }}">
                            {{ config('app.name', 'Tester') }}
                        </a>
                    </div>
                    <div class="uk-navbar-right">
                        <div id="app">
                            <lang-switcher></lang-switcher>
                        </div>
                        @include('layouts.login_menu')
                    </div>
                </nav>
            </div>
        </div>
        @yield('content')
    </div>
    @include('layouts.footer')
    @include('layouts.bottomScripts')
    @yield('bottomScriptsAdditional')
</body>
</html>

