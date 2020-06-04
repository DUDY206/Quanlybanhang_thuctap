<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use Illuminate\Support\Facades\Hash;

class ChangePassword extends Controller
{
    public function index(){
        return view('userinfo/changePassword');
    }

    public function update(Request $request,$id){

        $user_data = array(
          'id' => $id,
          'password' => $request->get('old_password')
        );

        if(Auth::attempt($user_data)){
          $this->validate($request,[
            'old_password'=>'required',
            'new_password'=>'required',
            'confirm_password'=>'required',
          ]);

          if($request->new_password != $request->confirm_password){
            return redirect('changePassword')->with('error','Mat khau moi khong khop');
          }
          $user = User::find($id);
          $user->password = Hash::make($request->new_password);
          $user->save();
          return redirect("/userinfo/".$id)->with('success','Doi mat khau thanh cong');
        }else{
          return redirect('changePassword')->with('error','Mat khau cu khong dung');
        }
        //

      }
}
