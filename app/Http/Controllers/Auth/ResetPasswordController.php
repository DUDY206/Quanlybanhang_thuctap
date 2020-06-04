<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\User;
class ResetPasswordController extends Controller
{
    public function resetPassword($id){
        $user = User::find($id);
        $user->password = Hash::make('password');

        return redirect('userinfo')->with('success','Reset thanh password cho '.$user->ten.' thanh cong ');

    }

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
}
