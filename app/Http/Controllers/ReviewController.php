<?php

namespace App\Http\Controllers;

use App\review;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
     {
       $review = review::all();

       return response()->json([
           'success' => true,
           'data' => $review
       ], 200);
     }

     /**
      * Show the form for creating a new resource.
      *
      * @return \Illuminate\Http\Response
      */
     public function create()
     {
         //
     }

     /**
      * Store a newly created resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */
     public function store(Request $request, $id )
     {
       try {
         $this->validate($request, array(
           'body'      => 'nullable'
         ));

         $user_id = JWTAuth::user()->id;

         $review = new review();
         $review->user_id = $user_id;
         $review->reviwed_user = $id->reviwed_user;
         $review->rating = $request->rating;
         $review->body = $request->body;
         $review->save();

         return response()->json([
             'success' => true,
             'data' => $review
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
