<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Nette\Utils\Random;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query();
        if ($request->has('search')) {
            $users = $users->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        }
        $users = $users->paginate('10');
        return view('pages.users.list', compact('users', 'request'));
    }

    public function userAdd()
    {
        return view('pages.users.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'type' => 'required',
            'password' => 'required|min:6'
        ]);
        $data = $request->only(['name', 'email', 'type']);
        $data['password'] = Hash::make($request->password);
        $user = User::create($data);
        if ($user) {
            return redirect('/users');
        }
        return redirect()->back()->with('error', 'Something wents wrong!')->withInput();
    }

    public function userEdit($user_id)
    {
        $user = User::find($user_id);
        return view('pages.users.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'type' => 'required',
            'status' => 'required',
        ]);
        $data = $request->only(['name', 'email', 'type']);
        $data['password'] = Hash::make($request->password);
        $user = User::create($data);
        if ($user) {
            return redirect('/users');
        }
        return redirect()->back()->with('error', 'Something wents wrong!')->withInput();
    }

    public function userDelete($user_id)
    {
        $user = User::find($user_id)->delete();
        return redirect()->back();
    }
}
