<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// debugging log actions
\Event::listen('Illuminate\Database\Events\QueryExecuted', function ($query) {
    Log::info( json_encode($query->sql) );
    Log::info( json_encode($query->bindings) );
    Log::info( json_encode($query->time)   );
});

    //Route::middleware('jwt.refresh')->get('/token/refresh', 'AuthController@refresh');//test
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
    Route::get('edit/{id}', 'ApiController@editUser'); // admin edit showAuthUserDetails
    Route::patch('update/{id}', 'ApiController@updateUser'); // admin update
    Route::get('showAuthUserDetails', 'ApiController@showAuthUserDetails'); // get auth user details
    Route::get('showAuthUserAndDetails', 'ApiController@showFullAuthUserDetails'); // get auth user info and details
    Route::get('showUserAndDetails', 'ApiController@showAllUserDetails');// show user info and the user details for all users
    Route::get('showUserAndDetails/{id}', 'ApiController@showFullUserById'); // show user info and details by id
    Route::get('authsRequestedUsers', 'ApiController@showUsersRequestedByAuthUser');// users details of users making a request
    Route::get('requestingUsersToAuth', 'ApiController@showRequestingUserToAuthPending'); // users details of users requesting auth user pending
    Route::get('requestingUsersToAuthAccept', 'ApiController@showRequestingUserToAuthAccepted'); // users details of users requesting auth user accepted
    Route::get('requestingUsersToAuthDecline', 'ApiController@showRequestingUserToAuthDeclined'); // users details of users requesting auth user declined
Route::get('showRequestedUserToAuthDeclined', 'ApiController@showRequestedUserToAuthDeclined');

// logged in user-request end-points
    Route::get('showAllRequests', 'UserRequestController@index'); // show all booking requests
    Route::post('storeRequest/{id}', 'UserRequestController@store'); // send & save booking request(auto fills auth user and needs recieving user id in URL)
    Route::get('showRequest/{id}', 'UserRequestController@show'); // show booking request by id
    Route::get('showRequestsByUser', 'UserRequestController@showRequestsByUser'); // show booking requests user made
    Route::get('showRequestedFromUser', 'UserRequestController@showRequestedFromUser'); // show bookings made to user
    Route::get('showRequestedFromUserPending', 'UserRequestController@showRequestedFromUserPending'); // return accepted requests
    Route::get('showRequestedFromUserAccepted', 'UserRequestController@showRequestedFromUserAccepted'); // return accepted requests
    Route::get('showRequestedFromUserDeclined', 'UserRequestController@showRequestedFromUserDeclined'); // return declined requests
    Route::get('showPendingCount', 'UserRequestController@showRequestedPendingCount'); //return count of requests pending
    Route::get('showAcceptedCount', 'UserRequestController@showRequestedAcceptedCount'); // return count of request accepted
    Route::get('editRequest/{id}/edit', 'UserRequestController@edit'); // get edit booking request by id -- todo
    Route::patch('acceptRequest/{id}', 'UserRequestController@acceptRequest'); // accept a booking request by its id
    Route::patch('declineRequest/{id}', 'UserRequestController@declineRequest'); // decline booking request by its id
    Route::get('showRequestsToAuth/{id}', 'UserRequestController@showRequestsToAuth');
// end-points for user-details table
    Route::get('showAllUserDetails', 'UserDetailsController@index'); // shows user details of all users
    Route::post('storeUserDetails', 'UserDetailsController@store'); // stores user details for auth user
    Route::get('showUserDetails/{id}', 'UserDetailsController@show'); // show user details by details id
    Route::get('editDetals/{id}', 'UserDetailsController@edit'); // edit user details by details id
    Route::patch('updateDetals/{id}', 'UserDetailsController@update'); // update user details by details id
    Route::get('editAuthUserDetails', 'UserDetailsController@editAuthUserDetails'); // edit the user details of auth user
    Route::patch('updateAuthUserDetails', 'UserDetailsController@updateAuthUserDetails'); // update the user details of auth user
    Route::post('update_avatar', 'UserDetailsController@update_avatar');// still in test mode
// end-points for user reviws
    Route::post('storeReview/{id}', 'ReviewController@store'); // auth user reviews other user by
    Route::get('showReviews', 'ReviewController@index'); //show all reviews from all users.
    Route::get('showReviews/{id}','ReviewController@show'); // show reviewed user by id
    Route::get('myReviews','ReviewController@showAuthReviews'); //show all auth users reviews
    Route::get('editReview/{id}','ReviewController@edit'); //show all users reviews by id
    Route::patch('updateReview/{id}','ReviewController@update'); //update reviews by id
    Route::delete('deleteReview/{id}','ReviewController@destroy');// delete review by id
// end-point for favourites
    Route::post('storeFav/{id}','FavouriteController@store');// store new fav user OR update unFavourite back to favourite
    Route::get('showAllFav', 'FavouriteController@index');//show every favourite record
    Route::get('favoritedUsers', 'ApiController@showFavouritedUsers');// show all auth users favourite users
    Route::patch('unFavorite/{id}','FavouriteController@unFav'); // unFavourite a user by the users id
    Route::get('showFavRecordsByAuth','FavouriteController@showFavouritedUsersRecord'); // show favorite records for auth user
    Route::get('favoritedUsersTrue', 'ApiController@showFavouritedUsersTrue'); // show users & details that are favourited by auth user
    Route::get('favoritedUsersFalse', 'ApiController@showFavouritedUsersFalse'); // show users & details that are NOT favourited by auth user



});
