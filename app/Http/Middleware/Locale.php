<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Request;
use App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;

class Locale
{


    /**
     * @var
     */
    public $mainLocaleLang;
    /**
     * @var
     */
    public $localeLangs;

    /**
     * Locale constructor.
     */
    public function __construct()
    {
        $this->mainLocalLang = Config::get('app')['locale'];
        $this->localeLangs = Config::get('app')['locales'];
        if(!Session::has('locale')) Session::put('locale', $this->mainLocaleLang);
    }

    /**
     * @return mixed
     */
    public function getLangFromURL()
    {
        $uri = Request::path();
        $segmentsURI = explode('/',$uri);
        if (!empty($segmentsURI[0]) && in_array($segmentsURI[0], $this->localeLangs)) {
            Session::put('locale', $segmentsURI[0]);
            if ($segmentsURI[0] != $this->mainLocalLang) {
                Session::put('locale', $segmentsURI[0]);
                return $segmentsURI[0];
            }
        }
        return $this->mainLocalLang;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $localeFromUrl = $this->getLangFromURL();
        $locale = Session::get('locale');
        if(isset($locale) && in_array($locale, $this->localeLangs)){
            if(isset($localeFromUrl) && ($localeFromUrl  != $locale)){
                Session::put('locale', $localeFromUrl);
                App::setLocale($localeFromUrl);
            } else {
                App::setLocale($locale);
            }
        } else {
            App::setLocale($this->mainLocalLang);
        }

        return $next($request);
    }
}
