<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required|unique:roles',
        ]);

        Role::create([
            'role' => $request->role,
        ]);

        return redirect()->route('roles.index');
    }

    public function assignRoleToUser(User $user, Request $request)
    {
        $user->roles()->attach($request->role_id);  // Assuming many-to-many relationship
        return redirect()->route('users.show', $user->id);
    }
}
