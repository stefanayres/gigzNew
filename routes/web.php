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

Route::view('/{path?}', 'home');

Route::get('{all?}', function(){
    return view('home');
})->where(x'all', '([A-z\d-\/_.]+)?');


Route::get( '/{any}', function () {
    return view('home');
})->where('any', '.*');

*/


Route::get('/', function () {
    return view('home');
});
Route::get('/welcome', function () {
    return view('welcome');
});
Route::get('/image', function () {
    return view('uploadImage');
});
