@extends('layouts.app')
@section('headScriptsAdditional')
    {{--<link rel="stylesheet" type="text/css" href="{{mix('css/11111.css')}}"/>--}}
@endsection
@section('right_panel')
    @include('layouts.left_panel')
@endsection
@section('content')
    @include('layouts.login_menu')
    <div class="uk-flex uk-flex-center">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        You are logged in!
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
