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

class UserController extends Controller
{
    use verifiesEmails;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $user = User::with('lesson')->get();
    // $user = User::get();
      return $user;
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
    public function store(Request $request)
    {
      // 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $user = Auth::user();
      return response()->json([
        'success' => $user,
      ],200);
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
      $user = User::where('id', $id)->first();
      $user -> name = $request -> name;
      $user -> email = $request -> email;
      $user -> password = $request -> password;
      $user -> role = $request -> role;
      if($user->update()) {
        return response()->json([
          'success' => false,
          'message' => 'Berhasil Update data',
        ],201);
      }
      // $user = Validator::make(
      //   $request->all(), [
      //     'name' => 'required',
      //     'email' => 'required',
      //     'password' => 'required',
      //     'role' => 'required',
      //   ],
      //   [
      //     'name.required' => 'Masukkan nama depan!',
      //     'email.required' => 'Masukkan email!',
      //     'password.required' => 'Masukkan password!',
      //     'role.required' => 'Masukkan role!',
      //   ]
      // );
      // if($user->fails()) {
      //   return response()->json([
      //     'success' => false,
      //     'message' => 'Silahkan isi bagian yang kosong',
      //     'data' => $user->errors()
      //   ],401);
      // }else {
      //   $post = User::where('id', $request->id)->update([
      //     'name' => $request->input('name'),
      //     'email' => $request->input('email'),
      //     'password' => $request->input('password'),
      //     'role' => $request->input('role'),
      //   ]);
      //   if ($post) {
      //     return response()->json([
      //       'success' => true,
      //       'message' => 'Data berhasil diupdate!',
      //     ], 200);
      //   } else {
      //     return response()->json([
      //       'success' => false,
      //       'message' => 'Data gagal diupdate!',
      //     ], 401);
      //   }
      // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $user = User::findOrFail($id);
      if($user) {
        $user->delete();
        return response()->json([
          'success' => true,
          'message' => 'Data berhasil dihapus!',
        ], 200);
      } else {
        return response()->json([
          'success' => false,
          'message' => 'Data gagal dihapus!',
        ], 401);
      }
    }

    public function login(){
      if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
        $user = Auth::user();
        $success['token'] =  $user->createToken('nApp')->accessToken;
        $success['message'] = 'Login successfull';
        // return response()->json([
        //   'token' => $success,
        //   'message' => 'Berhasil login',
        //   'user' => $user
        // ], $this->successStatus);
        if ($user->email_verified_at !== NULL) {
          $success['message'] = 'Login successfull';
          return response()->json([
            'token' => $success,
            'message' => 'Berhasil login',
            'user' => $user
          ], 200);
        } else {
          return response()->json(['message'=>'Tolong konfirmasi email kamu di mail box!'], 403);
        }
      } else {
        return response()->json([
            'message' => 'Email dan Password salah'
        ], 401);
      }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'role' => 'required',
        ]);

        if ($validator->fails()) {
          return response()->json([
            'message' => "Email sudah terdaftar silahkan login"
          ], 401);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $user->sendApiEmailVerificationNotification();
        $success['message'] = 'Tolong konfirmasi email kamu di mail box!';
        $success['token'] =  $user->createToken('nApp')->accessToken;
        $success['name'] =  $user->name;

        return response()->json([
          'token' => $success,
          'message' => 'Berhasil mendaftar',
          'user' => $user
        ], 200);
    }

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
