@extends('layouts.app')
@section('headScriptsAdditional')
@endsection



<div class="uk-container">
    <div data-uk-grid>
        <div class="uk-width-medium">111
            @section('right_panel')
                @include('layouts.left_panel')
            @endsection
        </div>
        <div class="uk-width-expand">222
            @section('content')

                <div class="uk-card uk-card-default uk-text-center uk-width-large uk-margin-auto uk-padding">
                    <div class="uk-h2">
                        Welcome
                    </div>
                    <div class="uk-margin">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        You are logged in!
                    </div>
                </div>
            @endsection
        </div>
    </div>
</div>




