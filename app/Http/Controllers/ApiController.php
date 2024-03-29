<?php
namespace App\Http\Controllers;

use App\Http\Requests\RegisterAuthRequest;
use App\User;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
 use Illuminate\Support\Facades\Validator;

use lluminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ApiController extends Controller
{
   public $loginAfterSignUp = true;

   public function register(RegisterAuthRequest $request)
   {
     $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users', // checks for unique email address
                'password' => 'required|string|min:6|confirmed',     // password & password_confirmation in form
            ]);

            if($validator->fails()){
                    //return response()->json($validator->errors()->toJson(), 400);
                    return response()->json([
                        'success' => false,
                        'data' => $validator
                    ], 400);
            }

       $user = new User();
       $user->name = $request->name;
       $user->email = $request->email;
       $user->role = $request->role;
       $user->password = bcrypt($request->password);
       $user->save();

       if ($this->loginAfterSignUp) {
           return $this->login($request);
       }

       return response()->json([
           'success' => true,
           'data' => $user
       ], 200);
   }

   public function login(Request $request)
   {
       $input = $request->only('email', 'password');
       $jwt_token = null;

       if (!$jwt_token = JWTAuth::attempt($input)) {
           return response()->json([
               'success' => false,
               'message' => 'Invalid Email or Password',
           ], 401);
       }

       return response()->json([
           'success' => true,
           'token' => $jwt_token
       ]);
   }

   public function logout(Request $request)
   {
       $this->validate($request, [
           'token' => 'required'
       ]);

       try {
           JWTAuth::invalidate($request->token);

           return response()->json([
               'success' => true,
               'message' => 'User logged out successfully'
           ]);
       } catch (JWTException $exception) {
           return response()->json([
               'success' => false,
               'message' => 'Sorry, the user cannot be logged out'
           ], 500);
       }
   }

   /**
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
     public function getAuthUser(Request $request)
     {
         $user = JWTAuth::authenticate($request->token);
         return response()->json(['user' => $user]);
     }

     /**
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */
     public function showAllUsers(Request $request)
     {
       // get all users
       $allUsers = User::all();
       return response()->json(['user' => $allUsers]);
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
       $user = User::find($id);

       return response()->json([
           'success' => true,
           'data' => $user
       ], 200);
     } catch (JWTException $exception) {
       return response()->json([
           'success' => false,
           'message' => 'Sorry, Can not find user'
       ], 400);
     }
   }

   /**
    *
    * @return \Illuminate\Http\Response
    */
   public function edit() // edit logged in user
   {
     $user_id = JWTAuth::user()->id;
     $user = User::find($user_id);

      return response()->json([
         'success' => true,
         'data' => $user
      ], 200);
  }

  /**
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
   public function update(Request $request) // update logged in user
   {
     try{
       $this->validate($request, array(
         'name'  => 'max:255',
         'email' => 'max:255',
       ));
        $user_id = JWTAuth::user()->id;

        $user = User::find($user_id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json([
           'success' => true,
           'data' => $user
        ], 200);
      } catch (JWTException $exception) {
        return response()->json([
            'success' => false,
            'message' => 'Sorry',
            'ErrorException' => $exception
        ], 400);
      }
  }

  /**
   *
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
   public function editUser($id) // admin can edit any user by id
   {
      $user = User::find($id);

      return response()->json([
         'success' => true,
         'data' => $user
      ], 200);
    }

  /**
   * @param int $id
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
   public function updateUser(Request $request, $id) // admin can update any user by id
   {
    try{
      $this->validate($request, array(
        'name'  => 'max:255',
        'email' => 'max:255',
      ));

     $user = User::find(intval($id));
     $user->name = $request->name;
     $user->email = $request->email;
     $user->password = bcrypt($request->password);
     $user->save();

     return response()->json([
        'success' => true,
        'data' => $user
     ], 200);
   } catch (JWTException $exception) {
     return response()->json([
         'success' => false,
         'message' => 'Sorry',
         'ErrorException' => $exception
     ], 400);
   }
}

  /**
   *
   * @return \Illuminate\Http\Response
   */
    public function showAuthUserDetails()
    {
    try{
      $user_id = JWTAuth::user()->id;
      $user = User::findOrFail($user_id)->userDetails;

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
     *
     * @return \Illuminate\Http\Response
     */
      public function showFullAuthUserDetails()
      {
      try{
        $user_id = JWTAuth::user()->id;
        $user = User::with('userDetails')->where('id', $user_id)->get();

          if ( is_null($user) ) {
            return response()->json([
               'success' => true,
               'message' => 'Sorry, you have not filled in your details.'
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
     *
     * @return \Illuminate\Http\Response
     */
      public function showFullUserById($id)
      {
      try{
        $user = User::with('userDetails')->where('id', $id)->get();

          if ( is_null($user) ) {
            return response()->json([
               'success' => true,
               'message' => 'Sorry, no details for this user.'
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
     *
     * @return \Illuminate\Http\Response
     */
      public function showAllUserDetails()
      {
      try{
          $user = User::with('userDetails')->get();

          if ( is_null($user) ) {
            return response()->json([
               'success' => true,
               'message' => 'Sorry, no user details saved yet.'
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
     *
     * @return \Illuminate\Http\Response
     */
    public function showRole0()
    {
      try {

        $users = User::whereHas('UserDetails', function($q) {
            $q->where('role', 0);
        })->with('UserDetails')->orderBy('id', 'desc')->get();

        if ( is_null($users) ) {
          return response()->json([
             'success' => true,
             'message' => 'Sorry, no user signed up yet.'
          ], 200);
        }
        return response()->json([
           'success' => true,
           'data' => $users
        ], 200);
        }catch (JWTException $exception) {
          return response()->json([
              'success' => false,
              'message' => 'Sorry something went wrong',
              'ErrorException' => $exception
          ], 400);
      }
    }
    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function showRole1()
    {
      try {

        $users = User::whereHas('UserDetails', function($q) {
            $q->where('role', 1);
        })->with('UserDetails')->orderBy('id', 'desc')->get();

        if ( is_null($users) ) {
          return response()->json([
             'success' => true,
             'message' => 'Sorry, no user signed up yet.'
          ], 200);
        }
        return response()->json([
           'success' => true,
           'data' => $users
        ], 200);
        }catch (JWTException $exception) {
          return response()->json([
              'success' => false,
              'message' => 'Sorry something went wrong',
              'ErrorException' => $exception
          ], 400);
      }
    }

    public function showUsersRequestedByAuthUser()
    {

        try {

          $userRequest = User::whereHas('UserRequest', function($q) {
             $q->where('requestingUser_id', $id = JWTAuth::user()->id); // ->where('status', 0)
          })->with('userDetails')->orderBy('id', 'desc')->get();  // send back request with user details

          //$user = User::with('userDetails')->where('id', $user_id)->get();  ->with('userRequest')


          if ( is_null($userRequest) ) {
            return response()->json([
               'success' => true,
               'message' => 'Sorry, you have not booked any users.'
            ], 200);
          }
          return response()->json([
             'success' => true,
             'data' => $userRequest
          ], 200);
          }catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry something went wrong',
                'ErrorException' => $exception
            ], 400);
        }
    }

    /**
     *
     *
     * @param  \App\UserRequest  $userRequest
     * @return \Illuminate\Http\Response
     */
    public function showRequestingUserToAuthPending()
    {

        try {
          $userRequest = User::whereHas('UserRequests', function($q) {
             $q->where('requestedUser_id', $id = JWTAuth::user()->id)->where('status', 0);
          })->with('userDetails')->orderBy('id', 'desc')->get();

          if ( is_null($userRequest) ) {
            return response()->json([
               'success' => true,
               'message' => 'Sorry, you have no requests.'
            ], 200);
          }
          return response()->json([
             'success' => true,
             'data' => $userRequest
          ], 200);
          }catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry something went wrong',
                'ErrorException' => $exception
            ], 400);
        }
    }
    /**
     *
     *
     * @param  \App\UserRequest  $userRequest
     * @return \Illuminate\Http\Response
     */
    public function showRequestingUserToAuthAccepted()
    {

        try {
          $userRequest = User::whereHas('UserRequests', function($q) {
             $q->where('requestedUser_id', $id = JWTAuth::user()->id)->where('status', 1);
          })->with('userDetails')->orderBy('id', 'desc')->get();

          if ( is_null($userRequest) ) {
            return response()->json([
               'success' => true,
               'message' => 'Sorry, you have no requests.'
            ], 200);
          }
          return response()->json([
             'success' => true,
             'data' => $userRequest
          ], 200);
          }catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry something went wrong',
                'ErrorException' => $exception
            ], 400);
        }
    }

    /**
     *
     *
     * @param  \App\UserRequest  $userRequest
     * @return \Illuminate\Http\Response
     */
    public function showRequestingUserToAuthDeclined()
    {

        try {
          $userRequest = User::whereHas('UserRequests', function($q) {
             $q->where('requestedUser_id', $id = JWTAuth::user()->id)->where('status', 2);
          })->with('userDetails')->orderBy('id', 'desc')->get();

          if ( is_null($userRequest) ) {
            return response()->json([
               'success' => true,
               'message' => 'Sorry, you have no requests.'
            ], 200);
          }
          return response()->json([
             'success' => true,
             'data' => $userRequest
          ], 200);
          }catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry something went wrong',
                'ErrorException' => $exception
            ], 400);
        }
    }

    /**
     *
     *
     * @param  \App\UserRequest  $userRequest
     * @return \Illuminate\Http\Response
     */
    public function showRequestedUserToAuthDeclined()
    {

        try {
          $userRequest = User::whereHas('UserRequests', function($q) {
             $q->where('requestedUser_id', $id = JWTAuth::user()->id)->where('status', 2);
          })->with('userDetails')->orderBy('id', 'desc')->get();

          if ( is_null($userRequest) ) {
            return response()->json([
               'success' => true,
               'message' => 'Sorry, you have no requests.'
            ], 200);
          }
          return response()->json([
             'success' => true,
             'data' => $userRequest
          ], 200);
          }catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry something went wrong',
                'ErrorException' => $exception
            ], 400);
        }
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
      public function showFavouritedUsers()
      {
      try{
        $favourite = User::whereHas('favourite', function($q) {
           $q->where('users_id', $id = JWTAuth::user()->id);
        })->orderBy('id', 'desc')->get();

          if ( is_null($favourite) ) {
            return response()->json([
               'success' => true,
               'message' => 'Sorry, you have not have any favorite users.'
            ], 200);
          }
        return response()->json([
           'success' => true,
           'data' => $favourite
        ], 200);
        }catch (JWTException $exception) {
          return response()->json([
              'success' => false,
              'message' => 'Sorry something went wrong',
              'ErrorException' => $exception
          ], 400);
        }
      }

      /**
       *
       * @return \Illuminate\Http\Response
       */
        public function showFavouritedUsersTrue()
        {
        try{
          $favourite = User::whereHas('favourite', function($q) {
             $q->where('users_id', $id = JWTAuth::user()->id)->where('fav', 1);
          })->with('userDetails')->orderBy('id', 'desc')->get();

            if ( is_null($favourite) ) {
              return response()->json([
                 'success' => true,
                 'message' => 'Sorry, you have not have any favorite users.'
              ], 200);
            }
          return response()->json([
             'success' => true,
             'data' => $favourite
          ], 200);
          }catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry something went wrong',
                'ErrorException' => $exception
            ], 400);
          }
        }

        /**
         *
         * @return \Illuminate\Http\Response
         */
          public function showFavouritedUsersFalse()
          {
          try{
            $favourite = User::whereHas('favourite', function($q) {
               $q->where('users_id', $id = JWTAuth::user()->id)->where('fav', 0);
                  })->with('userDetails')->orderBy('id', 'desc')->get();

              if ( is_null($favourite) ) {
                return response()->json([
                   'success' => true,
                   'message' => 'Sorry, you have not have any favorite users.'
                ], 200);
              }
            return response()->json([
               'success' => true,
               'data' => $favourite
            ], 200);
            }catch (JWTException $exception) {
              return response()->json([
                  'success' => false,
                  'message' => 'Sorry something went wrong',
                  'ErrorException' => $exception
              ], 400);
            }
          }




}
