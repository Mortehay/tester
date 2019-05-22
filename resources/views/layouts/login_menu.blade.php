@if(!Auth::guest())
<div id="logout">
    <a title="Logout" class="uk-margin-small-left" uk-icon="sign-out" href="{{ route('user.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"></a>
    <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</div>
@elseif(Auth::guest())
    <div class="uk-inline" id="login">
        <button class="uk-button uk-button-default uk-button-small" type="button">{{__('texts.login.title')}}</button>
        <div uk-dropdown="pos: bottom-left">
            <div class="uk-dropdown-grid uk-width-medium" >
                <div>
                    <form class="" method="POST" action="{{ route('user.login') }}">
                        @csrf
                        <fieldset class="uk-fieldset">
                            <div class="uk-child-width-1-1 uk-grid-small" data-uk-grid>
                                <div>
                                    <input class="uk-input {{ $errors->has('email') ? 'uk-form-danger' : '' }}" placeholder="{{__('texts.login.form_email_ph')}}" id="email" type="email" name="email" value="{{ old('email') }}" required>
                                    @if ($errors->has('email'))
                                        <div class="uk-text-danger uk-text-small" role="alert">
                                            {{ $errors->first('email') }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <input class="uk-input {{ $errors->has('password') ? 'uk-form-danger' : '' }}" placeholder="{{__('texts.login.form_password_ph')}}" id="password" type="password" name="password" value="{{ old('password') }}" required>
                                    @if ($errors->has('password'))
                                        <div class="uk-text-danger uk-text-small" role="alert">
                                            {{ $errors->first('password') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="uk-text-center">
                                    <div class="uk-margin-small">
                                        <input class="uk-button uk-button-default uk-button-primary" type="submit" value="{{__('texts.login.form_btn')}}" name="login_btn"/>
                                    </div>
                                    <div class="uk-margin-small">
                                        <label><input class="uk-checkbox" type="checkbox" {{ old('remember') ? 'checked' : '' }}> {{__('texts.login.form_remember')}}</label>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif