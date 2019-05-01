<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
/*lang switcher*/
Route::get('langs', 'Api\LangController@index');
Route::get('langs/{lang}', 'Api\LangController@change');
/*lang switcher*/

/*domain api routs*/
//list domains
Route::get('domains', 'Api\DomainController@getAll');
//list single domain
Route::get('domain/{id}', 'Api\DomainController@show');
//create new domain
Route::post('domain','Api\DomainController@store');
//update domain
Route::put('domain','Api\DomainController@store');
//delete domain
Route::delete('domain/{id}', 'Api\DomainController@destroy');
/*domain api routs*/

