<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function loginPage()
    {
        $pageConfigs = ['blankPage' => true];
        return view('pages.auth.login', ['pageConfigs' => $pageConfigs]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            if (Auth::user()->status != 1) {
                return redirect()->route('login')
                    ->with('loginError', 'Account is deactived')->withInput();
            }
            return redirect()->route('dashboard');
        }
        return redirect()->route('login')
            ->with('loginError', 'Invalid login credentials')->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect()->route('login');
    }
}
