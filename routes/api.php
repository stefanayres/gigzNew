<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('jwt.refresh')->get('/token/refresh', 'AuthController@refresh');//test
//Route::get('show', function(){ return "POST SUCCESS!";});

    Route::get('showRole1','ApiController@showRole1'); // show details of user with role 1 - venue
    Route::get('showRole0','ApiController@showRole0');// show details of user with role 0 - band

    Route::post('login', 'ApiController@login');
    Route::post('register', 'ApiController@register');
    Route::get('details', 'ApiController@details');
    Route::get('show', 'ApiController@showAllUsers');
//logged in user end-points
    Route::group(['middleware' => 'auth.jwt'], function () { // add header (Authorization : Bearer {Token}. for all routes without token pram)
    Route::get('logout', 'ApiController@logout');
    Route::get('user', 'ApiController@getAuthUser'); // get auth user by token
    Route::get('show/{id}', 'ApiController@show'); // show user by id
    Route::get('edit', 'ApiController@edit'); // user edit
    Route::patch('update', 'ApiController@update'); // user update
    Route::get('edit/{id}', 'ApiController@editUser'); // admin edit
    Route::patch('update/{id}', 'ApiController@updateUser'); // admin update
    Route::get('showAuthUserDetails', 'ApiController@showAuthUserDetails'); // get auth user details

// logged in user-request end-points
    Route::get('showAllRequests', 'UserRequestController@index'); // show all booking requests
    Route::post('storeRequest/{id}', 'UserRequestController@store'); // send & save booking request(auto fills auth user and needs recieving user id in URL)
    Route::get('showRequest/{id}', 'UserRequestController@show'); // show booking request by id
    Route::get('showRequestsByUser', 'UserRequestController@showRequestsByUser'); // show booking requests user made
    Route::get('showRequestedFromUser', 'UserRequestController@showRequestedFromUser'); // show bookings made to user
    Route::get('editRequest/{id}/edit', 'UserRequestController@edit'); // get edit booking request by id -- todo
    Route::put('updateStatus/{id}', 'UserRequestController@updateStatus'); // update booking requests status (0=pending,1=accept,2=decline)
    Route::patch('acceptRequest/{id}', 'UserRequestController@acceptRequest'); // accept a booking request by its id
    Route::patch('declineRequest/{id}', 'UserRequestController@declineRequest'); // decline booking request by its id
// end-points for user-details table
    Route::get('showAllUserDetails', 'UserDetailsController@index'); // shows user details of all users
    Route::post('storeUserDetails', 'UserDetailsController@store'); // stores user details for auth user
    Route::get('showUserDetails/{id}', 'UserDetailsController@show'); // show user details by details id
    Route::get('editDetals/{id}', 'UserDetailsController@edit'); // edit user details by details id
    Route::patch('updateDetals/{id}', 'UserDetailsController@update'); // update user details by details id
    Route::get('editAuthUserDetails', 'UserDetailsController@editAuthUserDetails'); // edit the user details of auth user
    Route::patch('updateAuthUserDetails', 'UserDetailsController@updateAuthUserDetails'); // update the user details of auth user
    Route::post('update_avatar', 'UserDetailsController@update_avatar');













});
