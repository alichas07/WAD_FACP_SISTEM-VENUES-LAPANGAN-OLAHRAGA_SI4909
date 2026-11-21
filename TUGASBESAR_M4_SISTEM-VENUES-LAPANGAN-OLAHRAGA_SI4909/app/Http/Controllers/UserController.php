<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $data['role'] = 'user';

        User::create($data);

        return redirect()->route('login')
            ->with('success', 'Akun ' . $data['name'] . ' berhasil dibuat sebagai User! Silakan login.');
    }
}