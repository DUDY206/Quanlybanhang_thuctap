<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
class LoginController2 extends Controller
{
  function index(){
     if(isset(Auth::user()->id)){
        return view('welcome');
     }else{
        return view('pages.login');
     }
  }

  function checkLogin(Request $request){
    $this->validate($request,[
      'sdt' => 'required',
      'password' => 'required',
    ]);

    $user_data = array(
      'sdt' => $request->get('sdt'),
      'password' => $request->get('password')
    );

    if(Auth::attempt($user_data)){
      return redirect('login/successLogin');
    }else{
      return back()->with('error','Sai tai khoan va mat khau');
    }
  }

  function successLogin(){
    return view('welcome');
  }
  function logout(){
    Auth::logout();
    return redirect('login');
  }
}
