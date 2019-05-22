@extends('layouts.app')
@section('headScriptsAdditional')
@endsection
@section('content')
    <div class="uk-section uk-position-relative uk-width-1-1 uk-flex uk-flex-column uk-flex-middle uk-flex-center" data-uk-height-viewport="expand: true">
        <div class="uk-container tm-container-xsmall">
            <div class="uk-card uk-card-default uk-card-body" data-uk-scrollspy="cls:uk-animation-slide-bottom-medium">



                        @if(!empty($domains_to_display))
                        <div class="uk-child-width-1-1@m" uk-grid uk-scrollspy="cls: uk-animation-slide-bottom; target: .uk-card; delay: 300; repeat: true">
                                @foreach($domains_to_display as $domain)
                                @php
                                    $image_path = array_key_exists('screen', $domain) && !empty($domain['screen']) && $domain['screen']['image_path'] != null ? $domain['screen']['image_path'] : 'screen/test.jpg';
                                @endphp
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-body" uk-scrollspy-class="uk-animation-slide-top">
                                            <div class="uk-grid-small uk-child-width-expand@s" uk-grid>
                                                <div>
                                                    <img src="{{$image_path}}" alt="none">
                                                </div>
                                                <div>
                                                    <div class="uk-panel">{{$domain['name']}}</div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                @endforeach
                        </div>
                        @endif

            </div>
        </div>
    </div>
@endsection
