<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function userList(Request $request)
    {
        $users = User::query();
        if ($request->has('search')) {
            $users = $users->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        }
        $users = $users->paginate('10');
        return view('pages.users.list', compact('users', 'request'));
    }

    public function userAddPage()
    {
        return view('pages.users.add');
    }

    public function userAdd(Request $request)
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
            return redirect()->route('user-list-page')->with('success', 'User added successfully!');
        }
        return redirect()->back()->with('error', 'Something wents wrong!')->withInput();
    }

    public function userEditPage($user_id)
    {
        $user = User::find($user_id);
        return view('pages.users.edit', compact('user'));
    }

    public function userEdit(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|min:3',
            'type' => 'required',
            'status' => 'required',
        ]);
        $data = $request->only(['name', 'type', 'status']);
        if ($request->has('password') && $request->password != null) {
            $data['password'] = Hash::make($request->password);
        }
        $user = User::find($id)->update($data);
        if ($user) {
            return redirect()->route('user-list-page')->with('success', 'User update successfully!');
        }
        return redirect()->back()->with('error', 'Something wents wrong!')->withInput();
    }

    public function userDelete($user_id)
    {
        $user = User::find($user_id)->delete();
        if (!$user) {
            return redirect()->back()->with('error', 'Something wents wrong!');
        }
        return redirect()->route('user-list-page')->with('success', 'User delete successfully!');
    }
}
