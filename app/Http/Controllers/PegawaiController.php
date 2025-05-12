<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\User;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pegawai = Pegawai::all();
        return view('pegawai.index', compact('pegawai'));
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
            'nama' => 'required|string',
            'nip' => 'nullable|string',
            'jabatan' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        Pegawai::create([
            'user_id' => $user->id,
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
        ]);

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil ditambahkan.');
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

     public function update(Request $request, Pegawai $pegawai)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string',
            'nip' => 'nullable|string',
            'jabatan' => 'required|string',
            'email' => 'required|email',
            'password' => 'nullable|string|min:8',
        ]);

        // Update data user
        $user = $pegawai->user;
        $user->nama = $request->nama;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        // Update data pegawai
        $pegawai->update([
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
        ]);

        return redirect()->back()->with('success', 'Data pegawai berhasil diperbarui.');
    }

   

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pegawai $pegawai)
    {
        $pegawai->delete();
        return redirect()->route('pegawai.index')->with('success', 'Data berhasil dihapus');
    }
}
