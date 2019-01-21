<?php


namespace App\Http\Controllers;

use App\Http\Requests\RegisterAuthRequest;
use App\User;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use lluminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ApiController extends Controller
{
   public $loginAfterSignUp = true;

   public function register(RegisterAuthRequest $request)
   {
     $this->validate($request, array(
       'name'  => 'max:255',
       'email' => 'max:255',
     ));

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

   public function getAuthUser(Request $request)
   {
       $user = JWTAuth::authenticate($request->token);
       return response()->json(['user' => $user]);
   }

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

   public function edit(Request $request) // edit logged in user
   {

     $user = JWTAuth::authenticate($request->token);

      return response()->json([
         'success' => true,
         'data' => $user
      ], 200);
  }

   public function update(Request $request) // update logged in user
   {
     $this->validate($request, array(
       'name'  => 'max:255',
       'email' => 'max:255',
     ));

      $user = JWTAuth::authenticate($request->token);
      $user->name = $request->name;
      $user->email = $request->email;
      $user->password = bcrypt($request->password);
      $user->save();

      return response()->json([
         'success' => true,
         'data' => $user
      ], 200);
  }

   public function editUser($id) // admin can edit any user by id
   {
      $user = User::find($id);

      return response()->json([
         'success' => true,
         'data' => $user
      ], 200);
  }

   public function updateUser(Request $request, $id) // admin can update any user by id
   {
     $this->validate($request, array(
       'name'  => 'max:255',
       'email' => 'max:255',
     ));

     $user = User::find($id);
     $user->name = $request->name;
     $user->email = $request->email;
     $user->password = bcrypt($request->password);
     $user->save();

     return response()->json([
        'success' => true,
        'data' => $user
     ], 200);
  }



}
