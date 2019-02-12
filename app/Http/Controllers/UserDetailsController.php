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
          'genre'           => 'nullable',
          'bios'            => 'nullable',
          'avatarURL'       => 'nullable',
          'contactNumber'   => 'nullable',
          'locationId'      => 'nullable'
        ));

        //$user_id = JWTAuth::user()->id;
        $user_id = JWTAuth::authenticate()->id;

        $userDetails = new UserDetail();
        $userDetails->user_id = $user_id;
        $userDetails->genre = $request->genre;
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
          'genre'           => 'nullable',
          'bios'            => 'nullable',
          'avatarURL'       => 'nullable',
          'contactNumber'   => 'nullable',
          'locationId'      => 'nullable'
        ));

        $userDetails = userDetail::find($id);
        $userDetails->user_id = $user_id;
        $userDetails->genre = $request->genre;
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
   *
   * @return \Illuminate\Http\Response
   */
    public function editAuthUserDetails()
    {
    try{
      $user_id = JWTAuth::user()->id;
      $user = userDetail::where('User_id', $user_id)->get();

      if ( is_null($user) ) {
        return response()->json([
           'success' => true,
           'message' => 'Sorry, you have not filled out your details yet.'
        ], 200);
      }
      return response()->json([
         'success' => true,
         'data' => $user
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\userDetail  $userDetails
     * @return \Illuminate\Http\Response
     */
    public function updateAuthUserDetails(Request $request)
    {
      try {
        $this->validate($request, array(
          'genre'           => 'nullable',
          'bios'            => 'nullable',
          'avatarURL'       => 'nullable',
          'contactNumber'   => 'nullable',
          'locationId'      => 'nullable'
        ));
        $user_id = JWTAuth::user()->id;

        $userDetails = userDetail::select('id')->where('User_id', $user_id)->first();
        $userDetails->user_id = $user_id;
        $userDetails->genre = $request->genre;
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_avatar(Request $request) // not tested need to make blade temp
    {
      if($request->hasFile('avatar')){
      $avatar = $request->file('avatar');
      $fileName = time() . '.' . $avatar->getClientOriginalExtension();
      Image::make($avatar)->resize(300, 300)->save( public_path('/uploads/avatars/' . $fileName));
      }

      $userDetail = JWTAuth::user();
      $userDetail->avatarURL = $fileName;
      $userDetail->save();

      return response()->json([
          'success' => true,
          'data' => $userDetail,
          'file_location' => $fileName
      ], 200);
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
