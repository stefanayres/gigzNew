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
         $reviewed_user = $id;

         $review = new review();
         $review->user_id = $user_id;
         $review->reviewed_user = $reviewed_user;
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
      try {
        $user_id = $id;
        $userReview = review::where('reviewed_user', $user_id)->get();

        return response()->json([
            'success' => true,
            'data' => $userReview
        ]);
    } catch (JWTException $exception) {
      return response()->json([
          'success' => false
      ], 400);
    }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAuthReviews()
    {
      try {
        $user_id = JWTAuth::user()->id;
        $userReview = review::where('reviewed_user', $user_id)->get();

        return response()->json([
            'success' => true,
            'data' => $userReview
        ]);
    } catch (JWTException $exception) {
      return response()->json([
          'success' => false
      ], 400);
    }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $review = review::find(intval($id));

       return response()->json([
          'success' => true,
          'data' => $review
       ], 200);
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
      try {
        $this->validate($request, array(
          'body'      => 'nullable'
        ));

        $user_id = JWTAuth::user()->id;

        $review = review::find($id);
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      try {
        $review = review::find($id);
        $review->delete();

      return response()->json([
          'success' => true,
          'msg' => 'Record deleted successfully',
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


}
