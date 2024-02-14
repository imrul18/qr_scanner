<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        if (auth()->user()) {
            return view('pages.dashboard.index');
        }
        return redirect()->route('login-page');
    }
}
