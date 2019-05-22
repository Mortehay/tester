<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Domain;

class MainController extends Controller
{
    /**
     * @var array
     */
    public $data = [];

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->data = [
            'route' => Route::currentRouteName(),
            'text' => 'texts.'. Route::currentRouteName(),
        ];
    }
    public function index()
    {
        $domains = Domain::with(['screen'])->where('display','=', 'show')->get()->toArray();
        //dd($domains);
        $this->data['domains_to_display'] =  $domains;
        return view('pages.main', $this->data);
    }
}
