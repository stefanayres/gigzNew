<?php

namespace App\Http\Controllers;

use App\UserRequest;
use Illuminate\Http\Request;


use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


class UserRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
    public function store(Request $request, $user_token)
    {
        $this->validate($request, array(
          //'requestingUser_id'   => 'required',
          'requestedUser_id'    => 'required',
          'location'            => 'max:255',
          'details'             => 'max:255',
          'price'               => 'max:255',
          'requestDate'         => 'required',
          'status'              => 'required'

        ));
        JWTAuth::setToken($user_token);
        $user_id = JWTAuth::authenticate()->id;


        $userRequest = new UserRequest();

        //$userRequest->requestingUser_id = $request->requestingUser_id;
        $userRequest->requestingUser_id = $user_id;

        $userRequest->requestedUser_id = $request->requestedUser_id;
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserRequest  $userRequest
     * @return \Illuminate\Http\Response
     */
    public function show(UserRequest $userRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserRequest  $userRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(UserRequest $userRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserRequest  $userRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserRequest $userRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserRequest  $userRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserRequest $userRequest)
    {
        //
    }
}
