<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Church;
use App\Models\District;
use App\Models\State;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Show a list of users (for admin purposes)
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        // Show the form to create a new user
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        // Validate and store the user data
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role_id' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => $request->role_id,
        ]);

        // Assign additional roles or permissions as needed
        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        // Show the form to edit a user's details
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        // Update the user details
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
            'role_id' => 'required',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('users.index');
    }

    public function destroy(User $user)
    {
        // Delete the user
        $user->delete();
        return redirect()->route('users.index');
    }

    // Additional logic for user-specific operations (like assigning auxiliary roles)
    public function assignRole(User $user, $roleId)
    {
        $role = Role::findOrFail($roleId);
        $user->roles()->attach($role);  // Assuming many-to-many relationship
        return redirect()->route('users.show', $user->id);
    }

    public function viewReports(User $user)
    {
        // View the reports assigned to the user (based on their role)
        $reports = $user->reports;  // Assuming a relationship with reports
        return view('users.reports', compact('reports'));
    }
}
