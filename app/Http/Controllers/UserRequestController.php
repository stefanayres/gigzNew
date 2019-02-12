<?php

namespace App\Http\Controllers;

use App\UserRequest;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


class UserRequestController extends Controller
{

protected $user;

public function __construct()
{
    $this->user = JWTAuth::parseToken()->authenticate();
}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      // get all requrest
      $allRequests = UserRequest::all();

        // return success and json data
        return response()->json([
            'success' => true,
            'data' => $allRequests
        ], 200);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, Request $request)
    {
      try{
        $this->validate($request, array(
          //'requestingUser_id'   => 'required',
          //'requestedUser_id'    => 'required',
          'location'            => 'max:255',
          'details'             => 'max:255',
          'price'               => 'max:255',
          'requestDate'         => 'required',
          'status'              => 'required'

        ));
        //JWTAuth::setToken($user_token);
        //$user_id = JWTAuth::authenticate()->id;
        $user_id = JWTAuth::user()->id;
        $userid = $id;

        $userRequest = new UserRequest();
        $userRequest->requestingUser_id = $user_id;
        $userRequest->requestedUser_id = $userid;  //$request->requestedUser_id;
        $userRequest->location = $request->location;
        $userRequest->details = $request->details;
        $userRequest->price = $request->price;
        $userRequest->requestDate = $request->requestDate;
        $userRequest->status = $request->status;
        $userRequest->save();

        return response()->json([
            'success' => true,
            'data' => $userRequest
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
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      try {
        $request = UserRequest::find(intval($id));

        return response()->json([
            'success' => true,
            'data' => $request
        ], 200);
      } catch (JWTException $exception) {
        return response()->json([
            'success' => false,
            'message' => 'Sorry, no bookings set by you'
        ], 400);
      }
  }

    /**
     *
     *
     * @param  \App\UserRequest  $userRequest
     * @return \Illuminate\Http\Response
     */
    public function showRequestsByUser()
    {

        try {
            $user_id = JWTAuth::user()->id;
            $userRequest = UserRequest::where('requestingUser_id', $user_id)->get();

            return response()->json([
                'success' => true,
                'data' => $userRequest
            ]);
        } catch (JWTException $exception) {
          return response()->json([
              'success' => false,
              'message' => 'Sorry, no bookings for you at the moment'
          ], 400);
        }
    }

    /**
     *
     *
     * @param  \App\UserRequest  $userRequest
     * @return \Illuminate\Http\Response
     */
    public function showRequestedFromUser()
    {

        try {
            $user_id = JWTAuth::user()->id;
            $userRequest = UserRequest::where('requestedUser_id', $user_id)->get();

            return response()->json([
                'success' => true,
                'data' => $userRequest
            ]);
        } catch (JWTException $exception) {
          return response()->json([
              'success' => false,
              'message' => 'Sorry, no bookings set by you'
          ], 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
      try {
        $request = UserRequest::find(intval($id));

        return response()->json([
            'success' => true,
            'data' => $request
        ], 200);
      } catch (JWTException $exception) {
        return response()->json([
            'success' => false,
            'message' => 'Sorry, no bookings found.'
        ], 400);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserRequest  $userRequest
     * @return \Illuminate\Http\Response
     */
    public function updateStatus($id, Request $request) // user can update own status (0=pending, 1=accepted, 2=denined)
    {
      $userRequest = UserRequest::find($id);
      $userRequest->fill($request->only(['status']));
      $userRequest->save();

      return response()->json([
          'success' => true,
          'data' => $userRequest
      ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserRequest  $userRequest
     * @return \Illuminate\Http\Response
     */
    public function acceptRequest($id) // user can update own status (0=pending, 1=accepted, 2=denined)decline
    {
      $userRequest = UserRequest::find($id);
      $userRequest->status = 1;
      $userRequest->save();

      return response()->json([
          'success' => true,
          'data' => $userRequest,
          'message' => 'You have accepted this booking.'
      ], 200);
    }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \App\UserRequest  $userRequest
         * @return \Illuminate\Http\Response
         */
        public function declineRequest($id) // user can update own status (0=pending, 1=accepted, 2=denined)decline
        {
          $userRequest = UserRequest::find($id);
          $userRequest->status = 2;
          $userRequest->save();

          return response()->json([
              'success' => true,
              'data' => $userRequest,
              'message' => 'You have declined this booking.'
          ], 200);
        }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserRequest  $userRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserRequest $userRequest)
    {
        $userRequest->delete();

        return response()->json([
            'success' => true,
            'message' => 'Booking deleted successfully.'
        ], 200);
    }
}
