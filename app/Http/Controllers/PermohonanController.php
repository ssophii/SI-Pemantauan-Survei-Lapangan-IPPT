<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Permohonan;



class PermohonanController extends Controller
{
    public function index()
    {
        // $permohonan = Permohonan())->get();
        $permohonan = Permohonan::with('user')->get();    
        return view('permohonan.index', compact('permohonan'));
    }

    public function edit(Permohonan $permohonan)
    {
        $users = User::all();
        return view('permohonan.edit', compact('permohonan', 'users'));
    }

    public function show($id)
    {
        // misal: hanya redirect atau dummy view
        return redirect()->route('permohonan.index');
    }


    public function update(Request $request, Permohonan $permohonan)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            // 'nama' => 'required',
            'atas_nama' => 'nullable',
            // 'no_hp' => 'required',
            'alamat_jalan' => 'required',
            'alamat_kelurahan' => 'required',
            'alamat_kecamatan' => 'required',
            'lokasi_jalan' => 'required',
            'lokasi_kelurahan' => 'required',
            'lokasi_kecamatan' => 'required',
            'luas_lahan' => 'required|numeric',
            'penggunaan' => 'required',
            'kepemilikan' => 'required',
            'status' => 'nullable',
            'no_surat' => 'nullable',
            'file_surat' => 'nullable|max:2048|mimes:pdf,png,jpg,jpeg',
        ]);

        $user = $permohonan->user;
        $user->update([
            'nama' => $request->user->nama,
            'no_hp' => $request->user->no_hp,
        ]);

        $data = $request->only([
            'atas_nama',
            'alamat_jalan',
            'alamat_kelurahan',
            'alamat_kecamatan',
            'lokasi_jalan',
            'lokasi_kelurahan',
            'lokasi_kecamatan',
            'luas_lahan',
            'penggunaan',
            'kepemilikan',
            'status',
            'no_surat',
        ]);

        if ($request->hasFile('file_surat')) {
            if ($permohonan->file_surat && Storage::disk('public')->exists($permohonan->file_surat)) {
                Storage::disk('public')->delete($permohonan->file_surat);
            }

            $data['file_surat'] = $request->file('file_surat')->store('surat', 'public');
        }

        $permohonan->update($data);

        return redirect()->route('permohonan.index')->with('success', 'Data berhasil diupdate.');
    }

    public function destroy(Permohonan $permohonan)
    {
        $permohonan->delete();
        return redirect()->route('permohonan.index')->with('success', 'Data berhasil dihapus.');
    }

    
    
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'no_hp' => 'required|string',
            'atas_nama' => 'nullable|string',
            'alamat_jalan' => 'required|string',
            'alamat_kelurahan' => 'required|string',
            'alamat_kecamatan' => 'required|string',
            'lokasi_jalan' => 'required|string',
            'lokasi_kelurahan' => 'required|string',
            'lokasi_kecamatan' => 'required|string',
            'luas_lahan' => 'required|numeric',
            'penggunaan' => 'required|string',
            'kepemilikan' => 'required|string',
            'status' => 'required|string',
            'no_surat' => 'required|string|unique:permohonans,no_surat',
            'file_surat' => 'nullable|max:2048|mimes:pdf,png,jpg,jpeg',
        ]);

        // dd($request->all());

        $user = User::create([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
        ]);

        $filePath = null;
        if($request->hasFile('file_surat')){
            $filePath = $request->file('file_surat')->store('surat', 'public');
        }

        // Generate ID Pendaftaran
        $tanggal = now()->format('Ymd'); // contoh: 20250507
        $urutan = Permohonan::whereDate('created_at', now()->toDateString())->count() + 1;
        $id_pendaftaran = 'sp' . $tanggal . str_pad($urutan, 3, '0', STR_PAD_LEFT); // ex: sp20250507001

        Permohonan::create([
            'user_id'=> $user->id,
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'id_pendaftaran' => $id_pendaftaran,
            'atas_nama' => $request->atas_nama,
            'alamat_jalan' => $request->alamat_jalan,
            'alamat_kelurahan' => $request->alamat_kelurahan,
            'alamat_kecamatan' => $request->alamat_kecamatan,
            'lokasi_jalan' => $request->lokasi_jalan,
            'lokasi_kelurahan' => $request->lokasi_kelurahan,
            'lokasi_kecamatan' => $request->lokasi_kecamatan,
            'luas_lahan' => $request->luas_lahan,
            'penggunaan' => $request->penggunaan,
            'kepemilikan' => $request->kepemilikan,
            'status' => $request->status,
            'no_surat' => $request->no_surat,
            'file_surat' => $filePath,
            'tanggal_masuk' => now(),
        ]);

        // $permohonan = new Permohonan([
        //     'nama' => $request->nama,
        //     'no_hp' => $request->no_hp,
        //     'id_pendaftaran' => $id_pendaftaran,
        //     'atas_nama' => $request->atas_nama,
        //     'alamat_jalan' => $request->alamat_jalan,
        //     'alamat_kelurahan' => $request->alamat_kelurahan,
        //     'alamat_kecamatan' => $request->alamat_kecamatan,
        //     'lokasi_jalan' => $request->lokasi_jalan,
        //     'lokasi_kelurahan' => $request->lokasi_kelurahan,
        //     'lokasi_kecamatan' => $request->lokasi_kecamatan,
        //     'luas_lahan' => $request->luas_lahan,
        //     'penggunaan' => $request->penggunaan,
        //     'kepemilikan' => $request->kepemilikan,
        //     'status' => $request->status,
        //     'no_surat' => $request->no_surat,
        //     'file_surat' => $filePath,
        //     'tanggal_masuk' => now(),
        // ]);

        // $permohonan->save();

        // dd($permohonan->id); 

        return redirect()->route('permohonan.index')->with('success', 'Data permohonan berhasil dibuat.');
    }
    public function create()
    {
        return view('permohonan.create');
    }

}
