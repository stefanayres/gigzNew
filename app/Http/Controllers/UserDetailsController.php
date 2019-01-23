<?php

namespace App\Http\Controllers;

use App\UserDetail;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


class UserDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\userDetail  $userDetail
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = userDetail::all();

        return response()->json([
            'success' => true,
            'data' => $users
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\userDetail  $userDetail
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      try {
        $this->validate($request, array(
          'bios'            => 'nullable',
          'avatarURL'       => 'nullable',
          'contactNumber'   => 'nullable',
          'locationId'      => 'nullable'
        ));

        //$user_id = JWTAuth::user()->id;
        $user_id = JWTAuth::authenticate()->id;

        $userDetails = new UserDetail();
        $userDetails->user_id = $user_id;
        $userDetails->bios = $request->bios;
        $userDetails->avatarURL = $request->avatarURL;
        $userDetails->contactNumber = $request->contactNumber;
        $userDetails->locationId = $request->locationId;
        $userDetails->save();

        return response()->json([
            'success' => true,
            'data' => $userDetails,
            'test' => $user_id
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
     * @param  \App\userDetail  $userDetail
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      try {
        $users = userDetail::find(intval($id));

        return response()->json([
            'success' => true,
            'data' => $users
        ], 200);
      } catch (JWTException $exception) {
        return response()->json([
            'success' => false,
            'message' => 'No user details for this user.'
        ], 400);
      }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @param  \App\userDetail  $userDetail
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      //$userDetails = userDetail::find($id);
      $users = userDetail::find(intval($id));

       return response()->json([
          'success' => true,
          'data' => $users
       ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\userDetail  $userDetails
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      try {
        $this->validate($request, array(
          'bios'            => 'nullable',
          'avatarURL'       => 'nullable',
          'contactNumber'   => 'nullable',
          'locationId'      => 'nullable'
        ));

        $userDetails = userDetail::find($id);
        $userDetails->user_id = $user_id;
        $userDetails->bios = $request->bios;
        $userDetails->avatarURL = $request->avatarURL;
        $userDetails->contactNumber = $request->contactNumber;
        $userDetails->locationId = $request->locationId;
        $userDetails->save();

        return response()->json([
            'success' => true,
            'data' => $userDetails
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
     * @param  \App\userDetail  $userDetails
     * @return \Illuminate\Http\Response
     */
    public function destroy(userDetails $userDetails)
    {
        //
    }


// where user_id = $user_id query
// $users = userDetail::where('User_id', $user_id)->get();





}
