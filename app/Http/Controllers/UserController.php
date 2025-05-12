<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'no_hp' => $request->role == 'permohonan' ? ['required', 'string', 'max:20'] : ['nullable'],
            'role' => ['required', 'in:admin,pegawai,permohonan'],
            'email' => $request->role != 'permohonan' ? ['required', 'string', 'email', 'max:255', 'unique:users'] : ['nullable', 'email'],
            'password' => $request->role != 'permohonan' ? ['required', 'string', 'min:8'] : ['nullable'],
        ]);

        $user = User::create([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'role' => $request->role,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        $user = new User();
        $user->nama     = $request->nama;
        $user->no_hp    = $request->no_hp;
        $user->role     = $request->role;
        $user->email    = $request->email;

        // Kalau password diisi, baru hash dan simpan
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('user.index')->with('success', 'User berhasil dicreatekan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
