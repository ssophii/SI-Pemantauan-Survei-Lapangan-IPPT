<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permohonan;
use Carbon\Carbon;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
     public function index()
    {
        return view('guest.index');
    }
    
     public function inputtracking()
    {
        return view('guest.inputtracking');
    }
    
    //  public function tracking()
    // {
    //     return view('guest.tracking');
    // }

    public function tracking(Request $request)
    {
        $request->validate([
            'id_pendaftaran' => 'required|string',
            // 'nama' => 'required|string',
            // 'no_hp' => 'required|string',
        ]);

        // Ambil semua permohonan yang cocok
        // $permohonans = Permohonan::whereRaw('LOWER(id_pendaftaran) = ?', [strtolower($request->id_pendaftaran)])->get();
        $permohonans = Permohonan::with(['spt','survei'])
        ->whereRaw('LOWER(id_pendaftaran) = ?', [strtolower($request->id_pendaftaran)])
        ->get();



        if ($permohonans->isEmpty()) {
            return view('guest.notfound');
        }

        // // Pisahkan menjadi yang masih aktif tracking dan yang sudah selesai lebih dari 7 hari
        // $aktif = $permohonans->filter(function($permohonan) {
        //     if ($permohonan->status != 'selesai') {
        //         return true;
        //     }

        //     $selesaiAt = $permohonan->updated_at; // Anggap updated_at saat selesai
        //     return $selesaiAt->diffInDays(now()) <= 7;
        // });

        // $riwayat = $permohonans->filter(function($permohonan) {
        //     if ($permohonan->status == 'selesai') {
        //         $selesaiAt = $permohonan->updated_at;
        //         return $selesaiAt->diffInDays(now()) > 7;
        //     }
        //     return false;
        // });

        return view('guest.tracking', compact('permohonans'));
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
        //
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
