<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SPT;
use App\Models\Pegawai;
use App\Models\User;
use App\Models\Permohonan;
use App\Mail\SptApprovedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SptPeninjauanNotification;
use Barryvdh\DomPDF\Facade\Pdf;
// use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SptController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $jabatan = $user->pegawai ? $user->pegawai->jabatan : null;
        $spts = Spt::with('permohonan.user')->get();
        $permohonans = Permohonan::with('user')->get();
        $pegawais = Pegawai::with('user')->get();

        foreach ($spts as $spt) {
            if ($spt->pelaksanaan && now()->greaterThanOrEqualTo($spt->pelaksanaan)) {
                if (in_array($spt->permohonan->status, ['diterima', 'ditetapkan'])) {
                    $spt->permohonan->update(['status' => 'survei']);
                }
            }
        }

        return view('spt.index', compact('spts', 'user','jabatan','permohonans', 'pegawais'));
    }

    public function create() {}

    public function store(Request $request)
    {
        $request->validate([
            'permohonan_id' => 'required|exists:permohonans,id',
            'no_surat' => 'required|string|unique:spts,no_surat',
            'pelaksanaan' => 'required|date',
            'penetapan' => 'nullable|date',
            'status' => 'required|in:peninjauan,ditetapkan,ditolak',
            'file_spt' => 'nullable|mimes:pdf,jpg,jpeg,png',
            'pegawai' => 'required|array|min:1',
            'pegawai.*' => 'exists:pegawais,id',
        ]);

        // $arsipPath = null;
        // if ($request->hasFile('arsip_spt')) {
        //     $arsipPath = $request->file('arsip_spt')->store('arsip_spt', 'public');
        // }

        if (Spt::where('permohonan_id', $request->permohonan_id)->exists()) {
            return redirect()->back()->with('error', 'Permohonan ini sudah memiliki SPT.');
        }

        $penetapanDate = $request->penetapan;
        if ($request->status === 'ditetapkan' && !$penetapanDate) {
            $penetapanDate = now();
        }

        // $penetapanDate = $request->status === 'ditetapkan' && !$request->penetapan ? now() : $request->penetapan;


        $spt = Spt::create([
            'permohonan_id' => $request->permohonan_id,
            'no_surat' => $request->no_surat,
            'pelaksanaan' => $request->pelaksanaan,
            'penetapan' => $request->penetapan,
            'status' => $request->status,
            // 'arsip_spt' => $arsipPath ?? null,
        ]);

        // $spt->permohonan->update(['status' => 'diterima']);
        if ($request->status === 'ditetapkan') {
            $spt->permohonan->update(['status' => 'ditetapkan']);
        } else {
            $spt->permohonan->update(['status' => 'diterima']);
        }
        
        $spt->pegawais()->sync($request->pegawai);

        $filePath = $this->generateSptFile($spt);
        $spt->update(['file_spt' => $filePath]);

        if ($request->status === 'peninjauan') {
            $kadis = User::whereHas('pegawai', fn($q) => $q->where('jabatan', 'kadis'))->first();
            if ($kadis) {
                Notification::route('mail', $kadis->email)->notify(new SptPeninjauanNotification($spt));
            }
        } elseif ($request->status === 'ditetapkan') {
            foreach ($spt->pegawais as $pegawai) {
                Mail::to($pegawai->user->email)->send(new SptApprovedMail($spt, $pegawai));
            }
        }

        return redirect()->route('spt.index')->with('success', 'SPT berhasil dibuat dan dikirim ke Kadis untuk ditinjau.');
    }

    public function show(string $id) {}

    public function edit(string $id) {}

    public function update(Request $request, Spt $spt)
    {
        $request->validate([
            'no_surat' => 'required|string|unique:spts,no_surat,' . $spt->id,
            'pelaksanaan' => 'required|date',
            'penetapan' => 'nullable|date',
            'pegawai' => 'required|array|min:1',
            'pegawai.*' => 'exists:pegawais,id',
            'status' => 'required|in:peninjauan,ditetapkan,ditolak',
            'file_spt' => 'nullable|mimes:pdf,jpg,jpeg,png',
        ]);

        // $arsipPath = $spt->arsip_spt;
        // if ($request->hasFile('arsip_spt')) {
        //     $arsipPath = $request->file('arsip_spt')->store('arsip_spt', 'public');
        // }

        $dataChanged = (
            $spt->no_surat !== $request->no_surat ||
            $spt->pelaksanaan !== $request->pelaksanaan ||
            $spt->penetapan !== $request->penetapan ||
            $spt->status !== $request->status ||
            // $spt->arsip_spt !== $arsipPath ||
            array_diff($request->pegawai, $spt->pegawais->pluck('id')->toArray()) ||
            array_diff($spt->pegawais->pluck('id')->toArray(), $request->pegawai)
        );

        $penetapanDate = $request->penetapan;
        if ($request->status === 'ditetapkan' && !$spt->penetapan && !$penetapanDate) {
            $penetapanDate = now();
        }

        $spt->update([
            'no_surat' => $request->no_surat,
            'pelaksanaan' => $request->pelaksanaan,
            'penetapan' => $penetapanDate,
            'status' => $request->status,
            'file_spt' => $spt->file_spt,
        ]);

        $spt->pegawais()->sync($request->pegawai);
        $spt->load('pegawais.user');

        // Handle upload file jika ada
        if ($request->hasFile('file_spt')) {
            // Hapus file lama jika ada
            if ($spt->file_spt && file_exists(public_path($spt->file_spt))) {
                unlink(public_path($spt->file_spt));
            }

            $file = $request->file('file_spt');
            $filename = 'scan_spt_' .  $spt->permohonan->id_pendaftaran . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/spt', $filename);
            $filePath = 'storage/spt/' . $filename;

            $spt->file_spt = $filePath;
        } elseif (!$spt->file_spt || $dataChanged) {
            // Hapus file lama jika perlu regenerasi
            if ($spt->file_spt && file_exists(public_path($spt->file_spt))) {
                unlink(public_path($spt->file_spt));
            }

            // Regenerasi file dari template
            $filePath = $this->generateSptFile($spt);
            $spt->file_spt = $filePath;
        }

        

        // if (!$spt->file_spt || $dataChanged) {
        //     if ($spt->file_spt && file_exists(public_path($spt->file_spt))) {
        //         unlink(public_path($spt->file_spt));
        //     }

        //     $filePath = $this->generateSptFile($spt);
        //     $spt->update(['file_spt' => $filePath]);
        // }

        // }

        // if (!$spt->file_spt || $dataChanged) {
        //     if ($spt->file_spt && file_exists(public_path($spt->file_spt))) {
        //         unlink(public_path($spt->file_spt));
        //     }

        //     $filePath = $this->generateSptFile($spt);
        //     $spt->update(['file_spt' => $filePath]);
        // }

        if ($request->status === 'ditetapkan' && $spt->status !== 'ditetapkan') {
            foreach ($spt->pegawais as $pegawai) {
                Mail::to($pegawai->user->email)->send(new SptApprovedMail($spt, $pegawai));
            }
        }

        // $spt->permohonan->update(['status' => 'ditetapkan']);
        if ($request->status === 'ditetapkan') {
            $spt->permohonan->update(['status' => 'ditetapkan']);
        } elseif ($request->status === 'peninjauan') {
            $spt->permohonan->update(['status' => 'diterima']);
        }
        

        return redirect()->route('spt.index')->with('success', 'SPT berhasil diperbarui.');
    }

    public function destroy(Spt $spt)
    {
        if ($spt->file_spt && file_exists(public_path($spt->file_spt))) {
            unlink(public_path($spt->file_spt));
        }
        $spt->delete();
        return redirect()->route('spt.index')->with('success', 'Data berhasil dihapus');
    }

    protected function generateSptFile(Spt $spt)
    {
        $template = view('templates.spt', compact('spt'))->render();
        $pdf = Pdf::loadHTML($template);

        $safeNoSurat = str_replace(['/', '\\'], '-', $spt->permohonan->id_pendaftaran);
        $filename = 'spt_' . $safeNoSurat . '.pdf';

        $relativePath = 'storage/spt/' . $filename;
        $fullPath = storage_path('app/public/spt/' . $filename);

        if (!file_exists(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0777, true);
        }

        $pdf->save($fullPath);

        return $relativePath;
    }

    public function ditetapkan($id)
{
    $spt = Spt::with('pegawais.user', 'permohonan')->findOrFail($id);

    // Update status dan tanggal penetapan
    $spt->update([
        'status' => 'ditetapkan',
        'penetapan' => now(),
    ]);

    // Update status permohonan
    $spt->permohonan->update(['status' => 'ditetapkan']);

    // Kirim email ke pegawai
    // foreach ($spt->pegawais as $pegawai) {
    //     Mail::to($pegawai->user->email)->send(new SptApprovedMail($spt, $pegawai));
    // }

    return redirect()->back()->with('success', 'SPT berhasil ditetapkan.');
}

}
