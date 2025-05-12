<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survei;
use App\Models\Permohonan;
use App\Models\SPT;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable;


// class SurveiController extends Controller
// {
//     public function index()
//     {
        
    
//         // /** @var \App\Models\User $user */
//         $user = auth::user();
//         $pegawai = $user->pegawai;

//         if ($user->role === 'pegawai' && $pegawai) {
//             // Hanya ambil permohonan yang SPT-nya berisi pegawai yang login
//             $permohonans = Permohonan::whereHas('spt.pegawais', function ($q) use ($pegawai) {
//                 $q->where('pegawais.id', $pegawai->id);
//             })->whereDoesntHave('survei')
//             ->with(['user', 'spt.pegawais'])
//             ->get();
//         } else {
//             $permohonans = Permohonan::whereHas('spt', function($q) {
//                 $q->where('status', 'ditetapkan');
//             })->whereDoesntHave('survei')->with('user')->get();

//             // Admin bisa lihat semua
//             // $permohonans = Permohonan::whereHas('spt', function ($q) {
//             //     $q->where('status', 'ditetapkan');
//             // })->whereDoesntHave('survei')
//             // ->with(['user', 'spt.pegawais'])
//             // ->get();
        
//         }


//         $riwayat = Survei::with('permohonan.user')->get();

//         // Otomatis update status permohonan
//         foreach ($riwayat as $survei) {
//             $permohonan = $survei->permohonan;

//             if ($permohonan) {
//                 // Jika hasil survei sudah diisi, tapi belum ada no_ba dan no_lhp
//                 if ($survei->no_ba == null && $survei->no_lhp == null) {
//                     $permohonan->update(['status' => 'laporan']);
//                 }

//                 elseif (
//                     $survei->topografi && $survei->luas_lahan && $survei->jenis_lahan &&
//                     $survei->pemanfaatan && $survei->kondisi_sekitar && $survei->peruntukan &&
//                     $survei->koor_a && $survei->koor_b && $survei->koor_c && $survei->koor_d &&
//                     $survei->no_ba && $survei->no_lhp &&
//                     $survei->file_laporan &&
//                     pathinfo($survei->file_laporan, PATHINFO_FILENAME) === 'scan_laporan_' . $survei->permohonan->id_pendaftaran
//                 ) {
//                     $permohonan->update(['status' => 'selesai']);
//                 }
                
//                 // Jika sudah ada semua (kecuali arsip)
//                 // elseif (
//                 //     $survei->topografi && $survei->luas_lahan && $survei->jenis_lahan &&
//                 //     $survei->pemanfaatan && $survei->kondisi_sekitar && $survei->peruntukan &&
//                 //     $survei->koor_a && $survei->koor_b && $survei->koor_c && $survei->koor_d &&
//                 //     $survei->no_ba && $survei->no_lhp
//                 // ) {
//                 //     $permohonan->update(['status' => 'selesai']);
//                 // }
//             }
//         }

//         return view('survei.index', compact('permohonans', 'riwayat'));
//     }

//     public function create($permohonan_id)
//     {
//         $permohonan = Permohonan::with('user')->findOrFail($permohonan_id);
//         return view('survei.create', compact('permohonan'));
//     }

//     public function update(Request $request, Survei $survei)
//     {
//         $request->validate([
//             'topografi' => 'required',
//             'luas_lahan' => 'required',
//             'jenis_lahan' => 'required',
//             'pemanfaatan' => 'required',
//             'kondisi_sekitar' => 'required',
//             'peruntukan' => 'required',
//             'koor_a' => 'required',
//             'koor_b' => 'required',
//             'koor_c' => 'required',
//             'koor_d' => 'required',
//             'gambar_lahan' => 'nullable|image'
//         ]);

//         $path = $survei->gambar_lahan;
//         if ($request->hasFile('gambar_lahan')) {
//             // Hapus file lama
//             if ($path && Storage::disk('public')->exists($path)) {
//                 Storage::disk('public')->delete($path);
//             }
//             $path = $request->file('gambar_lahan')->store('gambar_lahan', 'public');
//         }

        
//         $data = [
//             'topografi' => $request->topografi,
//             'luas_lahan' => $request->luas_lahan,
//             'jenis_lahan' => $request->jenis_lahan,
//             'pemanfaatan' => $request->pemanfaatan,
//             'kondisi_sekitar' => $request->kondisi_sekitar,
//             'peruntukan' => $request->peruntukan,
//             'koor_a' => $request->koor_a,
//             'koor_b' => $request->koor_b,
//             'koor_c' => $request->koor_c,
//             'koor_d' => $request->koor_d,
//             'gambar_lahan' => $path,
//             'updated_by' => auth::user()->nama,
//         ];

//         // Tambahkan tanggal_selesai jika semua kolom penting sudah ada
//         if (
//             $request->topografi &&
//             $request->luas_lahan &&
//             $request->jenis_lahan &&
//             $request->pemanfaatan &&
//             $request->kondisi_sekitar &&
//             $request->peruntukan &&
//             $request->koor_a &&
//             $request->koor_b &&
//             $request->koor_c &&
//             $request->koor_d
//         ) {
//             $data['selesai_at'] = now();
//         }

//         $survei->update($data);

//         $survei->refresh(); // refresh data setelah update

//         if (
//             $survei->topografi &&
//             $survei->luas_lahan &&
//             $survei->jenis_lahan &&
//             $survei->pemanfaatan &&
//             $survei->kondisi_sekitar &&
//             $survei->peruntukan &&
//             $survei->koor_a &&
//             $survei->koor_b &&
//             $survei->koor_c &&
//             $survei->koor_d &&
//             $survei->gambar_lahan &&
//             $survei->no_ba &&
//             $survei->no_lhp &&
//             $survei->selesai_at
//         ) {
//             $survei->permohonan()->update(['status' => 'selesai']);
//         }


//         return redirect()->route('survei.index')->with('success', 'Hasil survei berhasil diperbarui');
//     }

//     public function store(Request $request)
//     {
//         $request->validate([
//             'permohonan_id' => 'required|exists:permohonans,id',
//             'topografi' => 'required',
//             'gambar_lahan' => 'nullable|image',
//             'luas_lahan' => 'required',
//             'jenis_lahan' => 'required',
//             'pemanfaatan' => 'required',
//             'kondisi_sekitar' => 'required',
//             'koor_a' => 'required',
//             'koor_b' => 'required',
//             'koor_c' => 'required',
//             'koor_d' => 'required',
//             'peruntukan' => 'required'
//         ]);

//         $path = $request->hasFile('gambar_lahan') ? $request->file('gambar_lahan')->store('gambar_lahan', 'public') : null;

//         Survei::create(array_merge($request->only([
//             'permohonan_id', 
//             'topografi', 
//             'luas_lahan', 
//             'jenis_lahan', 
//             'pemanfaatan', 
//             'kondisi_sekitar', 
//             'koor_a', 
//             'koor_b', 
//             'koor_c', 
//             'koor_d', 
//             'peruntukan'
//         ]), 
//         [
//             'gambar_lahan' => $path,
//             'updated_by' => auth::user()->id,
//             'selesai_at' => now()
//         ]));

//         return redirect()->route('survei.index')->with('success', 'Data survei berhasil disimpan');
//     }

//     public function indexLaporan()
// {
//     $surveis = Survei::whereNotNull('topografi') // Sudah ada hasil survei
//                     ->whereNull('no_ba')
//                     ->whereNull('no_lhp')
//                     ->get();

//     $riwayat = Survei::whereNotNull('no_ba')
//                     ->whereNotNull('no_lhp')
//                     ->get();

//     return view('survei.laporan', compact('surveis', 'riwayat'));
// }


// /*******  7be8c85b-aebf-4238-ba78-71b9d2980113  *******/
// public function updateLaporan(Request $request, $id)
// {
//     $request->validate([
//         'no_ba' => 'required|string',
//         'no_lhp' => 'required|string',
//         'file_laporan' => 'nullable|file|mimes:pdf|max:2048',
//     ]);

//     $survei = Survei::findOrFail($id);
//     $spt = Spt::where('permohonan_id', $survei->permohonan_id)->with('pegawais.user')->first();

//     if (!$spt) {
//         return redirect()->back()->with('error', 'Data SPT tidak ditemukan.');
//     }

//     $noSurat = $survei->permohonan->id_pendaftaran;

//     // Simpan nilai lama sebelum update
//     $lamaFile = $survei->file_laporan;
//     $old_no_ba = $survei->no_ba;
//     $old_no_lhp = $survei->no_lhp;

//     // SIMPAN DULU
//     $survei->no_ba = $request->no_ba;
//     $survei->no_lhp = $request->no_lhp;
//     $survei->save();

//     if ($request->hasFile('file_laporan')) {
//         if ($lamaFile && Storage::exists('public/laporan/' . $lamaFile)) {
//             Storage::delete('public/laporan/' . $lamaFile);
//         }

//         $uploaded = $request->file('file_laporan');
//         $uploadName = 'scan_laporan_' . $noSurat . '.' . $uploaded->getClientOriginalExtension();
//         $uploaded->storeAs('public/laporan', $uploadName);

//         $survei->file_laporan = $uploadName;
//         $survei->save();
//     } elseif (
//         ($request->no_ba !== $old_no_ba) || ($request->no_lhp !== $old_no_lhp)
//     ) {
//         if ($lamaFile && Storage::exists('public/laporan/' . $lamaFile)) {
//             Storage::delete('public/laporan/' . $lamaFile);
//         }

//         $pdf = Pdf::loadView('templates.laporan', [
//             'survei' => $survei,
//             'spt' => $spt,
//         ]);

//         $generatedName = 'laporan_' . $noSurat . '.pdf';
//         Storage::put('public/laporan/' . $generatedName, $pdf->output());

//         $survei->file_laporan = $generatedName;
//         $survei->save();
//     }

//     // Cek ulang apakah semua komponen sudah lengkap
// if (
//     $survei->topografi &&
//     $survei->luas_lahan &&
//     $survei->jenis_lahan &&
//     $survei->pemanfaatan &&
//     $survei->kondisi_sekitar &&
//     $survei->peruntukan &&
//     $survei->koor_a &&
//     $survei->koor_b &&
//     $survei->koor_c &&
//     $survei->koor_d &&
//     $survei->no_ba &&
//     $survei->no_lhp &&
//     $survei->file_laporan &&
//     pathinfo($survei->file_laporan, PATHINFO_FILENAME) === 'scan_laporan_' . $survei->permohonan->id_pendaftaran
// ) {
//     $survei->permohonan()->update(['status' => 'selesai']);
// }


//     return redirect()->back()->with('success', 'Laporan berhasil diperbarui.');
// }

// public function storeLaporan(Request $request, $id)
// {
//     $request->validate([
//         'no_ba' => 'required|string',
//         'no_lhp' => 'required|string',
//         'file_laporan' => 'nullable|file|mimes:pdf|max:2048',
//     ]);

//     $survei = Survei::where('permohonan_id', $id)->firstOrFail();
//     $spt = Spt::where('permohonan_id', $survei->permohonan_id)->with('pegawais.user')->first();
//     $noSurat = $survei->permohonan->id_pendaftaran;

//     // Hapus file lama jika ada
//     if ($survei->file_laporan && Storage::exists('public/laporan/' . $survei->file_laporan)) {
//         Storage::delete('public/laporan/' . $survei->file_laporan);
//     }

//     $survei->no_ba = $request->no_ba;
//     $survei->no_lhp = $request->no_lhp;

//     if ($request->hasFile('file_laporan')) {
//         $path = $request->file('file_laporan')->store('public/laporan');
//         $survei->file_laporan = basename($path);
//     } else {
//         $pdf = Pdf::loadView('templates.laporan', [
//             'survei' => $survei,
//             'spt' => $spt,
//         ]);
//         $generatedName = 'laporan_' . $noSurat . '.pdf';
//         Storage::put('public/laporan/' . $generatedName, $pdf->output());

//         $survei->file_laporan = $generatedName;
//     }

//     $survei->save();

//     return redirect()->back()->with('success', 'Laporan berhasil ditambahkan.');
// }


// // public function storeLaporan(Request $request, $id)
// // {
// //     $request->validate([
// //         'no_ba' => 'required|string',
// //         'no_lhp' => 'required|string',
// //         'file_laporan' => 'nullable|file|mimes:pdf|max:2048',
// //     ]);

// //     $survei = Survei::where('permohonan_id', $id)->firstOrFail();

// //     // Hapus file lama jika ada
// //     if ($survei->file_laporan && Storage::exists($survei->file_laporan)) {
// //         Storage::delete($survei->file_laporan);
// //     }

// //     // Jika user upload file manual
// //     if ($request->hasFile('file_laporan')) {
// //         $path = $request->file('file_laporan')->store('laporan');
// //         $survei->update([
// //             'no_ba' => $request->no_ba,
// //             'no_lhp' => $request->no_lhp,
// //             'file_laporan' => $path,
// //         ]);
// //     } else {
// //         // Auto generate PDF dari template
// //         $pdf = Pdf::loadView('templates.laporan', compact('survei'));
// //         $filename = 'laporan/' . uniqid() . '.pdf';
// //         Storage::put($filename, $pdf->output());

// //         $survei->update([
// //             'no_ba' => $request->no_ba,
// //             'no_lhp' => $request->no_lhp,
// //             'file_laporan' => $filename,
// //         ]);
// //     }

// //     return redirect()->back()->with('success', 'Laporan berhasil disimpan.');
// // }



// public function destroyLaporan($id)
// {
//     $survei = Survei::where('permohonan_id', $id)->firstOrFail();

//     if ($survei->file_laporan && Storage::exists($survei->file_laporan)) {
//         Storage::delete($survei->file_laporan);
//     }

//     $survei->update([
//         'no_ba' => null,
//         'no_lhp' => null,
//         'file_laporan' => null,
//     ]);

//     return redirect()->back()->with('success', 'Laporan berhasil dihapus.');
// }

// private function generateLaporanPDF(Survei $survei, Spt $spt)
// {
//     $oldFile = $survei->file_laporan;
//     if ($oldFile && Storage::exists('public/laporan/' . $oldFile)) {
//         Storage::delete('public/laporan/' . $oldFile);
//     }

//     $noSurat = $survei->permohonan->id_pendaftaran;
//     $generatedName = 'laporan_' . $noSurat . '.pdf';

//     $pdf = Pdf::loadView('templates.laporan', [
//         'survei' => $survei,
//         'spt' => $spt,
//     ]);

//     Storage::put('public/laporan/' . $generatedName, $pdf->output());
//     $survei->file_laporan = $generatedName;
//     $survei->save();
// }

// private function handleAdminUpload(Request $request, Survei $survei)
// {
//     $oldFile = $survei->file_laporan;
//     if ($oldFile && Storage::exists('public/laporan/' . $oldFile)) {
//         Storage::delete('public/laporan/' . $oldFile);
//     }

//     $noSurat = $survei->permohonan->id_pendaftaran;
//     $upload = $request->file('file_laporan');
//     $uploadName = 'scan_laporan_' . $noSurat . '.' . $upload->getClientOriginalExtension();
//     $upload->storeAs('public/laporan', $uploadName);

//     $survei->file_laporan = $uploadName;
//     $survei->save();
// }

// }
