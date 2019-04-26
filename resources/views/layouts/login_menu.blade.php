<div id="app">
    <a title="Logout" class="uk-margin-small-left" uk-icon="sign-out" href="{{ route('user.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"></a>
    <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</div>