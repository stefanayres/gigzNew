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


Route::middleware('jwt.refresh')->get('/token/refresh', 'AuthController@refresh');

    Route::post('login', 'ApiController@login');
    Route::post('register', 'ApiController@register');
    Route::get('details', 'ApiController@details');
    //test
    Route::get('show', function(){ return "POST SUCCESS!";});

    Route::group(['middleware' => 'auth.jwt'], function () {
    Route::get('logout', 'ApiController@logout');
    Route::get('user', 'ApiController@getAuthUser');
});
