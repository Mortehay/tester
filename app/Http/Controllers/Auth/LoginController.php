<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
/**
 * Class LoginController
 * @package App\Http\Controllers\Auth
 */
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/home';


    /**
     * @var array
     */
    public $data = [];

    /**
     * LoginController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->data = [
            'route' => Route::currentRouteName(),
            'text' => 'texts.'. Route::currentRouteName(),
        ];
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login', $this->data);
    }

    /**
     * @return string
     */
    public function redirectTo()
    {
        $locale_prefix = '';
        $locale = Config::get('app.locale');
        if(Session::get('locale') && Session::get('locale') != 'en'){
            $locale_prefix = '/'.Session::get('locale');
        }
        return $locale_prefix.'/home';
    }

    public function logout(Request $request)
    {
        $logout ='/';
        if(Session::get('locale') && Session::get('locale') != 'en'){

            $logout = '/'.Session::get('locale');

        }
        $this->guard()->logout();

        $request->session()->flush();
        $request->session()->regenerate();
        return redirect($logout);
    }
}
