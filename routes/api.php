<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('jwt.refresh')->get('/token/refresh', 'AuthController@refresh');//test

    Route::post('login', 'ApiController@login');
    Route::post('register', 'ApiController@register');
    Route::get('details', 'ApiController@details');

    //requests routes
    Route::post('storeRequest/{token}', 'UserRequestController@store');

    //todo
    Route::get('showUser', 'ApiController@showUser');

    //test
    Route::get('show', function(){ return "POST SUCCESS!";});

    Route::group(['middleware' => 'auth.jwt'], function () {
    Route::get('logout', 'ApiController@logout');
    Route::get('user', 'ApiController@getAuthUser');




});
