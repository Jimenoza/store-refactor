<?php

namespace tiendaVirtual\Http\Controllers\Common;

use tiendaVirtual\Http\Requests\RegisterFormRequest;
use tiendaVirtual\Http\Controllers\Controller;
use Illuminate\Http\Request;
use tiendaVirtual\User;
use Auth;
use Session;
use DB;
use Hash;

class UserController extends Controller
{
  
    public static function login($data) {
      // $data = $request->validated();
      // $user = User::where('email',$data['email'])->first();
      // if(!$user || !Hash::check($data['password'], $user->password)){
      //   return null;
      // }
      // else {
      //   return $user;
      // }
      if(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password']])) {
        // User::loginUser($data['correo']);
        return Auth::user();
      }else {
        return null;
      }
    }

    public static function register($data) {
      // $data = $request->validated();
      $existingUser = User::where('email', $data['email'])->count();
      if ($existingUser > 0) {
        return false;
      } else {
        $user = new User;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->admin = 0;
        return $user->save();
      }
    }

    public static function checkEmail($data) {
      $existingUser = User::where('email', $data['email'])->count();
      return $existingUser;
    }
}
