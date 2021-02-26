<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controllers;
use App\Models\User;
use illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Auth\Events\Verified;

class UserApiController extends Controller
{
  use VerifiesEmails;
  public $successStatus = 200;
  /**
  * login api
  *
  * @return \Illuminate\Http\Response
  */
  public function login(){
    if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
      $user = Auth::user();
      if($user->email_verified_at !== NULL){
        $success['message'] = 'Login successfull';
        $success['message'] = 'Login successfull';
          return response()->json([
            'token' => $success,
            'message' => 'Berhasil login',
            'user' => $user
          ], $this->successStatus);
      }else{
        return response()->json(['error'=>'Please Verify Email'], 401);
      }
    }
    else{
      return response()->json(['error'=>'Unauthorised'], 401);
    }
  }
  /**
  * Register api
  *
  * @return \Illuminate\Http\Response
  */
  public function register(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required',
      'email' => 'required|email',
      'password' => 'required',
      'role' => 'required',
    ]);
    if ($validator->fails()) {
    return response()->json(['error'=>$validator->errors()], 401);
    }
    $input = $request->all();
    $input['password'] = bcrypt($input['password']);
    $user = User::create($input);
    $user->sendApiEmailVerificationNotification();
    $success['token'] =  $user->createToken('nApp')->accessToken;
    $success['message'] = 'Tolong konfirmasi email kamu di mail box!';
    $success['name'] =  $user->name;
    return response()->json(['success'=>$success], $this-> successStatus);
  }
  /**
  * details api
  *
  * @return \Illuminate\Http\Response
  */
  public function details()
  {
    $user = Auth::user();
    return response()->json(['success' => $user], $this-> successStatus);
  }
  /**
  * logout api
  *
  * @return \Illuminate\Http\Response
  */
  public function logout(Request $request) {
    $logout = $request->user()->token()->revoke();
      if($logout) {
          return response()->json([
              'message' => 'Berhasil logout!'
          ]);
      } else {
          return response()->json([
              'message' => 'Gagal logout!'
          ]);
      }
  }
}