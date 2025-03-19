<?php

namespace App\Http\Controllers;

use App\Helpers\helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect('/home');
        }
        return view('login.index');
    }

    public function login(Request $request)
    {
        if (Auth::attempt([
            'username'      => $request->username,
            'password'      => $request->password,
            'is_deleted'    => 0,
        ])) {
            return response()->json([200, 'home']);
        }

        else if (Auth::attempt([
            'username'      => $request->username,
            'password'      => $request->password,
            'is_deleted'    => 0,
        ])) {
            Auth::logout();
            abort(401, 'No login permission is set to your account. Contact admin for support');
        }

        else {
            abort(401, 'Username and password do not match.');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
