<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="uk-background-muted">
<head>
    @include('layouts.metaTags')
    @include('layouts.headScripts')
    @yield('headScriptsAdditional')
    @include('layouts.micro')
</head>

<body class="uk-container {{Route::is('home')?'home-page':''}} {{ str_replace('_', '-', app()->getLocale()) }}" data-lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.topScripts')
<div class="tm-page" id="lay_content">
    @yield('right_panel')
    @yield('content')
    @include('layouts.footer')
</div>
@include('layouts.bottomScripts')
@yield('bottomScriptsAdditional')
</body>
</html>

