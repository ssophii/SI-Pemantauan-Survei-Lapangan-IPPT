<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permohonan;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Filter tanggal masuk (optional)
        $start = $request->input('start_date');
        $end = $request->input('end_date');

        $permohonans = Permohonan::query();

        if ($start && $end) {
            $permohonans->whereBetween('tanggal_masuk', [$start, $end]);
        }

        $filtered = $permohonans->get();

        // Statistik total dan per status
        $stats = [
            'total' => $filtered->count(),
            'diterima' => $filtered->where('status', 'diterima')->count(),
            'ditetapkan' => $filtered->where('status', 'ditetapkan')->count(),
            'survei' => $filtered->where('status', 'survei')->count(),
            'laporan' => $filtered->where('status', 'laporan')->count(),
            'selesai' => $filtered->where('status', 'selesai')->count(),
        ];

        // Breakdown per kecamatan (lokasi)
        $perKecamatan = $filtered->groupBy('lokasi_kecamatan')->map(function ($item) {
            return $item->count();
        });

        return view('dashboard.index', compact('stats', 'perKecamatan', 'start', 'end'));
    }
}
