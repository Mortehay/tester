@extends('layouts.app')
@section('headScriptsAdditional')
@endsection
@section('content')
    <div class="uk-section uk-position-relative uk-width-1-1">
        <div class="uk-flex uk-flex-column uk-flex-middle uk-flex-center" data-uk-height-viewport="expand: true">
            <div class="uk-container">
                <div class="uk-card uk-card-default uk-card-body uk-width-large uk-margin-auto" data-uk-scrollspy="cls:uk-animation-slide-bottom-medium">
                    <h3 class="uk-text-center">
                        {{__($text.'.title')}}
                    </h3>
                    <form class="" method="POST" action="{{ route('user.login') }}">
                        @csrf
                        <fieldset class="uk-fieldset">
                            <div class="uk-child-width-1-1 uk-grid-small" data-uk-grid>
                                <div>
                                    <input class="uk-input {{ $errors->has('email') ? 'uk-form-danger' : '' }}" placeholder="{{__($text.'.form_email_ph')}}" id="email" type="email" name="email" value="{{ old('email') }}" required>
                                    @if ($errors->has('email'))
                                        <div class="uk-text-danger uk-text-small" role="alert">
                                            {{ $errors->first('email') }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <input class="uk-input {{ $errors->has('password') ? 'uk-form-danger' : '' }}" placeholder="{{__($text.'.form_password_ph')}}" id="password" type="password" name="password" value="{{ old('password') }}" required>
                                    @if ($errors->has('password'))
                                        <div class="uk-text-danger uk-text-small" role="alert">
                                            {{ $errors->first('password') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="uk-text-center">
                                    <div class="uk-margin-small">
                                        <input class="uk-button uk-button-default uk-button-primary" type="submit" value="{{__($text.'.form_btn')}}" name="login_btn"/>
                                    </div>
                                    <div class="uk-margin-small">
                                        <label><input class="uk-checkbox" type="checkbox" {{ old('remember') ? 'checked' : '' }}> {{__($text.'.form_remember')}}</label>
                                    </div>
                                </div>
                            </div>

                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="app">
        <lang-switcher></lang-switcher>
    </div>
@endsection
