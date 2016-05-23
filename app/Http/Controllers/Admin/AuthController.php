<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

use App\Http\Requests;

class AuthController extends Controller
{

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin/surveys-taken';

    public function login()
    {
        return view('admin.login');
    }

    public function postLogin(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        if (Auth::attempt(['username' => $username, 'password' => $password, 'type' => 'admin'])) {

            return redirect()->route('admin-surveys-taken');
            } else {
            return back();
        }

//        if($username && $password) {
//            $user = User::where('username', '=', $username)
//                ->where('password', '=', bcrypt($password))
//                ->where('type', '=', 'admin')
//                ->first();
//            if($user) {
//                Auth::login($user);
//            }
//
//        }
//        return redirect()->route('admin-home');

    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin-login');
    }
}
