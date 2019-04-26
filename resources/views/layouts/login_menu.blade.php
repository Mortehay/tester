<div id="app">
    <button class="uk-button uk-button-default uk-button-small" type="button">
        <span uk-icon="more-vertical"></span>
    </button>
    <div uk-dropdown="pos: bottom-justify">
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
                    <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            @endguest
        </ul>
    </div>

</div>