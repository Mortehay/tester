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


{{--<div class="uk-flex uk-flex-center">--}}
    {{--<div class="row justify-content-center">--}}
        {{--<div class="col-md-8">--}}
            {{--<div class="card">--}}
                {{--<div class="card-header">{{__($text.'.title')}}</div>--}}
                {{--<div class="card-body">--}}
                    {{--<form method="POST" action="{{ route('login') }}">--}}
                        {{--@csrf--}}
                        {{--<div class="form-group row">--}}
                            {{--<label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>--}}

                            {{--<div class="col-md-6">--}}
                                {{--<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>--}}

                                {{--@if ($errors->has('email'))--}}
                                    {{--<span class="invalid-feedback" role="alert">--}}
                                        {{--<strong>{{ $errors->first('email') }}</strong>--}}
                                    {{--</span>--}}
                                {{--@endif--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="form-group row">--}}
                            {{--<label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>--}}

                            {{--<div class="col-md-6">--}}
                                {{--<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required autocomplete="current-password">--}}

                                {{--@if ($errors->has('password'))--}}
                                    {{--<span class="invalid-feedback" role="alert">--}}
                                        {{--<strong>{{ $errors->first('password') }}</strong>--}}
                                    {{--</span>--}}
                                {{--@endif--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="form-group row">--}}
                            {{--<div class="col-md-6 offset-md-4">--}}
                                {{--<div class="form-check">--}}
                                    {{--<input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>--}}

                                    {{--<label class="form-check-label" for="remember">--}}
                                        {{--{{ __('Remember Me') }}--}}
                                    {{--</label>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="form-group row mb-0">--}}
                            {{--<div class="col-md-8 offset-md-4">--}}
                                {{--<button type="submit" class="btn btn-primary">--}}
                                    {{--{{ __('Login') }}--}}
                                {{--</button>--}}

                                {{--@if (Route::has('password.request'))--}}
                                    {{--<a class="btn btn-link" href="{{ route('password.request') }}">--}}
                                        {{--{{ __('Forgot Your Password?') }}--}}
                                    {{--</a>--}}
                                {{--@endif--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</form>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}
@endsection
