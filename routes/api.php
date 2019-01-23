<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('jwt.refresh')->get('/token/refresh', 'AuthController@refresh');//test
//Route::get('show', function(){ return "POST SUCCESS!";});

    Route::post('login', 'ApiController@login');
    Route::post('register', 'ApiController@register');
    Route::get('details', 'ApiController@details');
    Route::get('show', 'ApiController@showAllUsers');

//logged in user end-points
    Route::group(['middleware' => 'auth.jwt'], function () { // add header (Authorization : Bearer {Token}. for all routes without token pram)
    Route::get('logout', 'ApiController@logout');
    Route::get('user', 'ApiController@getAuthUser'); // get auth user by token
    Route::get('show/{id}', 'ApiController@show'); // show user by id
// edit and update users for auth user and admin
    Route::get('edit', 'ApiController@edit'); // user edit
    Route::patch('update', 'ApiController@update'); // user update
    Route::get('edit/{id}', 'ApiController@editUser'); // admin edit
    Route::patch('update/{id}', 'ApiController@updateUser'); // admin update
// logged in user-request end-points
    Route::get('showAllRequests', 'UserRequestController@index'); // show all booking requests
    Route::post('storeRequest/{id}', 'UserRequestController@store'); // send & save booking request(auto fills auth user and needs recieving user id in URL)
    Route::get('showRequest/{id}', 'UserRequestController@show'); // show booking request by id
    Route::get('showRequestsByUser', 'UserRequestController@showRequestsByUser'); // show booking requests user made
    Route::get('showRequestedFromUser', 'UserRequestController@showRequestedFromUser'); // show bookings made to user
    Route::get('editRequest/{id}/edit', 'UserRequestController@edit'); // get edit booking request by id -- todo
    Route::put('updateStatus/{id}', 'UserRequestController@updateStatus'); // update booking requests status (0=pending,1=accept,2=decline)
    Route::patch('acceptRequest/{id}', 'UserRequestController@acceptRequest');
    Route::patch('declineRequest/{id}', 'UserRequestController@declineRequest');
// end-points for user-details table
    Route::get('showAllUserDetails', 'UserDetailsController@index');// shows user details of all users
    Route::post('storeUserDetails', 'UserDetailsController@store'); // stores user details for auth user
    Route::get('showUserDetails/{id}', 'UserDetailsController@show');//
    Route::get('editDetals/{id}', 'UserDetailsController@edit');
    Route::patch('editDetals/{id}', 'UserDetailsController@update');
















});
