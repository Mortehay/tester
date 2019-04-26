<div id="app">
    <button class="uk-button uk-button-default" type="button">
        <span uk-icon="more-vertical"></span>
    </button>
    <div uk-dropdown>
        <ul class="uk-nav uk-dropdown-nav">
            @guest
            <li>
                <a class="" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
            @if (Route::has('register'))
                <li class="">
                    <a class="" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
            @endif
            @else
                <li class="">
                    <a href="#" role="button">
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                </li>
            @endguest
        </ul>
    </div>
</div>