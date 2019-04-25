<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class LangController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $langs = Config::get('app.locales');
        return response()->json($langs);
    }

    /**
     * @param Request $request
     * @param $lang
     * @return \Illuminate\Http\JsonResponse
     */
    public function change(Request $request, $lang)
    {
        if(in_array($lang, Config::get('app.locales'))){
            Session::put('locale', $lang);
            $data = ['type' => 'success', 'lang' => $lang];
            return response()->json($data);
        } else {
            $data = ['type' => 'error'];
            return response()->json($data);
        }

    }
}
