@extends('layouts.app')

@section('content')
<div class="uk-section">
    <div class="uk-container">
        <div data-uk-grid>
            <div class="uk-width-1-3@s uk-width-large@l">
                @include('layouts.left_panel')
            </div>
            <div class="uk-width-2-3@s uk-width-expand@l">
                <div class="uk-margin">
                    <div class="uk-card uk-card-default uk-card-body" data-uk-height-viewport="expand: true">
                        <div class="uk-card uk-card-primary uk-text-center uk-width-large uk-margin-auto uk-padding">
                            <div class="uk-h2 uk-margin">
                                Welcome
                            </div>
                            <div>
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                You are logged in!
                            </div>
                        </div>
                        <div class="uk-margin">
                            <domains></domains>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection




