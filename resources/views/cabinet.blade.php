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
                    <domain></domain>
                </div>
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
                            <div data-uk-grid>
                                <div class="uk-width-1-3@m">
                                    <a class="uk-cover-container uk-transition-toggle uk-display-block uk-link-reset" href="#" target="_blank">
                                        <img src="screen/1.jpg">
                                        <div class="uk-overlay-primary uk-transition-fade uk-position-cover"></div>
                                        <div class="uk-position-center">
                                            <div class="uk-overlay uk-transition-fade uk-light">
                                                Visit web-site
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="uk-width-2-3@m">
                                    <div class="uk-flex-middle uk-grid-small" data-uk-grid>
                                        <div class="uk-text-bold uk-h4"><a class="uk-link-reset" href="#" target="_blank">damaim.com</a></div>
                                        <div><a class="uk-link-muted" href="#" target="_blank">(хостинг)</a></div>
                                    </div>
                                    <div class="uk-text-meta">
                                        Additional domains: <a href="#" class="uk-link-muted" target="_blank">site.com</a>
                                    </div>
                                    <div class="uk-margin">
                                        <div class="uk-child-width-1-1 uk-grid-collapse" data-uk-grid>
                                            <div>
                                                Login: 111111
                                            </div>
                                            <div>
                                                Password: 22222
                                            </div>
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        Some comments
                                    </div>
                                </div>
                            </div>
                            <div class="uk-card uk-card-primary uk-card-body uk-padding-small uk-margin uk-text-small">
                                <h5 class="uk-card-title">
                                    Latest Events
                                </h5>
                                <div>
                                    <table class="uk-table uk-table-small uk-table-divider uk-table-hover">
                                        <thead>
                                        <tr>
                                            <th>event</th>
                                            <th>data/time</th>
                                            <th>duration</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td class="uk-dark"><span class="uk-label uk-label-success uk-margin-small-right">on</span></td>
                                            <td>16:54:01 02-05-2019</td>
                                            <td>63 hrs, 16 mins</td>
                                        </tr>
                                        <tr>
                                            <td><span class="uk-label uk-label-danger uk-margin-small-right">off</span></td>
                                            <td>16:54:01 02-05-2019</td>
                                            <td>6 hrs, 59 mins</td>
                                        </tr>
                                        <tr>
                                            <td><span class="uk-label tm-label-stoped uk-margin-small-right">stoped</span></td>
                                            <td>16:54:01 02-05-2019</td>
                                            <td>63 hrs, 16 mins</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="uk-margin">
                            {{--<domains></domains>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection




