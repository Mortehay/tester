<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*en routes*/
Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
Route::get('/cabinet', 'CabinetController@index')->name('cabinet');
/*en routes*/

//Auth::routes();

// Authentication Routes...
//Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::get('login', function(){ return redirect('/');})->name('login');


Route::group([ 'prefix' => 'rest'] , function(){
    Route::get('login', 'Auth\LoginController@login')->name('user.login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('user.logout');

// Registration Routes...
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('user.register');
    Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// Email Verification Routes...
    Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
    Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
});
/*en redirect routes*/
Route::group([ 'prefix' => 'en', 'middleware' => 'locale'], function () {
    Route::get('/', function(){return redirect('/');})->name('login');
    Route::get('/cabinet',  function(){return redirect('/cabinet');})->name('cabinet');
});
/*en redirect routes*/

/*ru routes*/
Route::group([ 'prefix' => 'ru', 'middleware' => 'locale'], function () {
    Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
    Route::get('/cabinet', 'CabinetController@index')->name('cabinet');
});
/*ru routes*/

/*uk routes*/
Route::group([ 'prefix' => 'uk', 'middleware' => 'locale'], function () {
    Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
    Route::get('/cabinet', 'CabinetController@index')->name('cabinet');
});
/*uk routes*/