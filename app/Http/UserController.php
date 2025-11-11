<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // View all users
    public function index()
    {
        $users = User::all();
        return view('admin.adminUsers', compact('users'));
    }

    // Edit user form
    public function edit(User $user)
    {
        return view('admin.editUser', compact('user'));
    }

    // Update user
    public function update(Request $request, User $user)
    {
        $user->update($request->all());
        return redirect()->route('users.index')->with('success', 'User updated.');
    }

    // Delete user
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'User deleted.');
    }

    // Verify user
    public function verify(User $user)
    {
        $user->is_verified = true;
        $user->save();
        return redirect()->back()->with('success', 'User verified.');
    }
}
