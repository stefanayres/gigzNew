<?php

namespace App\Http\Controllers;

use App\favourite;
use App\User;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class FavouriteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $users = favourite::all();

      return response()->json([
          'success' => true,
          'data' => $users
      ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id)
    {
      try {
        $favourite_id = $id;

        $favourite=  favourite::updateOrCreate(
            [
                'users_id' => $user_id = JWTAuth::user()->id,
                'favourite_id' => $favourite_id,
                //'fav' => 1
            ],
            [
                'users_id' => $user_id = JWTAuth::user()->id,
                'favourite_id' => $favourite_id,
                'fav' => 1
            ]
        );
        return response()->json([
            'success' => true,
            'data' => $favourite
        ], 200);
    } catch (JWTException $exception) {
      return response()->json([
          'success' => false,
          'message' => 'Sorry, something went wrong!',
          'ErrorException' => $exception
      ], 400);
    }
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
      public function showFavouritedUsersRecord()
      {
      try{
            $user_id = JWTAuth::user()->id;
            $result = favourite::where('users_id', $user_id)
                                  ->where('fav', 1)->get();

       return response()->json([
           'success' => true,
           'data' => $result
        ], 200);
        }catch (JWTException $exception) {
          return response()->json([
              'success' => false,
              'message' => 'Sorry',
              'ErrorException' => $exception
          ], 400);
        }
      }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function unFav($id)
    {
      try {
        $user_id = JWTAuth::user()->id;
        $fav = favourite::where('users_id', $user_id)->where('favourite_id', $id)->first();
        $fav->fav = 0;
        $fav->save();

        return response()->json([
            'success' => true,
            'data' => $fav,
            'message' => 'You have un-favourited this user.'
        ], 200);
      } catch (JWTException $exception) {
        return response()->json([
            'success' => false,
            'message' => 'catch error.'
        ], 400);
      }
    }
}
