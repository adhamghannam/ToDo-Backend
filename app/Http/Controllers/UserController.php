<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Auth;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function login(Request $loginRequest)
    {
       $this->validate($loginRequest, [
           'email' => 'required|email',
           'password' => 'required'
          ]);
       $email = $loginRequest->input('email');
       $password = $loginRequest->input('password');

       // get the user if exists
       $user = User::where('email', $email)->first();

       // check if the user password matches the request password
       if(Hash::check($password, $user->password)){
            // generate token
            $token = base64_encode(Str::random(45));
            User::where('id', $user->id)->update(['token' => $token]);
            return response()->json(['status' => 'success','token' => $token]);
       }else{
            return response()->json(['status' => 'fail'],401);
       }
    }

    public function logout(Request $logoutRequest)
    {
      User::where('id', Auth::user()->id)->update(['token' => null]);
      return response()->json(['status' => 'success']);
    }

    public function register(Request $addRequest){
        $this->validate($addRequest, [
          'firstname' => 'required',
          'lastname' => 'required',
          'gender' => 'required|integer|min:0|max:1',
          'email' => 'required|email',
          'password' => 'required',
          'mobile' => 'required',
          'date_of_birth' => 'required|date|before:now|date_format:Y-m-d',
         ]);
        $data = $addRequest->all();
        $data["password"] = app('hash')->make($data["password"]);
        if(User::create($data)){
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'failed']);
    }
}

?>
