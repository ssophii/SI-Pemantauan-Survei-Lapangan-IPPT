<!DOCTYPE html>
@php
    $jabatanOrder = [
        'kadis' => 1,
        'kabid' => 2,
        'penata' => 3,
        'analis' => 4,
        'pengelola' => 5,
        'ptt' => 6,
    ];

    $sortedPegawais = $spt->pegawais->sortBy(function($pegawai) use ($jabatanOrder) {
        return [
            $jabatanOrder[$pegawai->jabatan] ?? 99,
            $pegawai->nip,
        ];
    })->values();

    $jabatanMapping = [
        'kadis' => 'Kepala Dinas',
        'kabid' => 'Kepala Bidang',
        'penata' => 'Penata Pertanahan',
        'analis' => 'Analis Pertanahan',
        'pengelola' => 'Pengelola Pemanfaatan Barang Milik Negara',
        'ptt' => 'Pegawai Tidak Tetap',
    ];
@endphp
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Survei</title>
    <style>
        @page {
            size: 21.6cm 33cm; /* F4 */
            margin: 1cm;
        }
    
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            line-height: 1.15;
            text-align: justify;
        }
    
        .text-center {
            text-align: center;
        }
    
        .text-justify {
            text-align: justify;
        }
    
        .title {
            font-size: 14pt;
            font-weight: bold;
            text-decoration: underline;
            margin-top: 0.5cm;
            margin-bottom: 0;
            text-align: center;
        }
    
        .nomor {
            text-align: center;
            margin-top: 0;
            margin-bottom: 1cm;
        }
    
        .section {
            margin-top: 1cm;
        }
    
        .image-container {
            text-align: center;
            margin: 0.5cm 0;
        }
    
        .gambar-lahan {
            width: 100%;
            height: auto;
            max-height: 11cm;
            object-fit: contain;
        }
    
        .ttd-table {
            width: 100%;
            margin-top: 1cm;
            border-collapse: collapse;
        }
    
        .ttd-table td {
            vertical-align: top;
            padding: 0.5cm 0;
        }
    
        .ttd-table td:nth-child(3) {
            text-align: right;
            width: 40%;
        }
    
        .paraf {
            height: 2.5cm;
        }
    
        .page-break {
            page-break-after: always;
        }
    </style>
    
    {{-- <style>
        @page {
            size: 21.6cm 33cm; /* F4 */
            margin: 2.5cm;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            line-height: 1.5;
        }

        .text-center {
            text-align: center;
        }

        .text-justify {
            text-align: justify;
        }

        .header p {
            margin: 0;
            padding: 0;
        }

        .kop {
            font-weight: bold;
        }

        .title {
            font-size: 14pt;
            font-weight: bold;
            text-decoration: underline;
            margin-top: 0.5cm;
            margin-bottom: 0;
        }

        .nomor {
            margin-top: 0;
            margin-bottom: 1cm;
        }

        .subtitle {
            margin-top: 0;
        }

        .section {
            margin-top: 1cm;
        }

        .image-container {
            text-align: center;
            margin: 0.5cm 0;
        }

        .gambar-lahan {
            width: 100%;
            height: auto;
            max-height: 11cm;
            object-fit: contain;
        }

        .ttd-table {
            width: 100%;
            margin-top: 1cm;
        }

        .ttd-table td {
            vertical-align: top;
            padding: 0.5cm 0;
        }

        .paraf {
            height: 2.5cm;
        }

        .page-break {
            page-break-after: always;
        }
    </style> --}}
</head>
<body>

    {{-- Halaman 1 --}}
    <p class="text-center title">BERITA ACARA SURVEI LAPANGAN</p>
    <p class="text-center nomor">Nomor: {{ $survei->no_ba }}</p>

    <p>
        Pada Hari ini, <strong>{{ \Carbon\Carbon::parse($survei->tanggal)->translatedFormat('l') }}</strong> 
        Tanggal {{ \Carbon\Carbon::parse($survei->tanggal)->translatedFormat('d') }} 
        Bulan {{ \Carbon\Carbon::parse($survei->tanggal)->translatedFormat('F') }} 
        Tahun {{ \Carbon\Carbon::parse($survei->tanggal)->translatedFormat('Y') }}, telah dilaksanakan Survei Lapangan 
        Untuk Proses Permohonan Izin Perubahan Tanah (IPPT) Nomor Permohonan: 
        <strong>{{ $survei->permohonan->no_registrasi }}</strong>
    </p>

    <table>
        <tr><td>Pemohon</td><td>:</td><td>{{ $survei->permohonan->user->nama }}</td></tr>
        <tr><td>Bertindak Atas Nama</td><td>:</td><td>{{ $survei->permohonan->atas_nama }}</td></tr>
        <tr><td>Lokasi Lahan</td><td>:</td><td>{{ $survei->permohonan->lokasi_jalan }}, Kel. {{ $survei->permohonan->lokasi_kelurahan }}, Kec. {{ $survei->permohonan->lokasi_kecamatan }}, Kota Bengkulu</td></tr>
        <tr><td>Luas Yang Dimohon</td><td>:</td><td>{{ $survei->permohonan->luas_lahan }}</td></tr>
        <tr><td>Status Kepemilikan</td><td>:</td><td>{{ $survei->permohonan->kepemilikan }}</td></tr>
    </table>

    <div class="image-container">
        @php
            // $gambarPath = public_path('storage/gambar_lahan/' . $survei->gambar_lahan);
            $namaFile = $survei->gambar_lahan;
        @endphp

        {{-- @if (file_exists($gambarPath)) --}}
        <img src="{{ asset('storage/gambar_lahan/' . $namaFile) }}" width="400">
    
        {{-- <img src="{{ $gambarPath }}" style="width: 400px;"> --}}
        {{-- @endif --}}
    </div>

    <div class="section">
        <table>
            <tr><td>A.</td><td>Hasil Survei</td></tr>
            <tr><td></td><td>1. Peta Situasi</td><td>: Ada / Tidak Ada</td></tr>
            <tr><td></td><td>2. Koordinat</td><td>:</td></tr>
            <tr><td></td><td></td><td>A: {{ $survei->koor_a }}</td></tr>
            <tr><td></td><td></td><td>B: {{ $survei->koor_b }}</td></tr>
            <tr><td></td><td></td><td>C: {{ $survei->koor_c }}</td></tr>
            <tr><td></td><td></td><td>D: {{ $survei->koor_d }}</td></tr>
        </table>
    </div>

    <div class="section">
        <table>
            <tr><td>B.</td><td>Eksisting Lahan</td></tr>
            <tr><td></td><td>Topografi</td><td>: {{ $survei->topografi }}</td></tr>
            <tr><td></td><td>Jenis Lahan</td><td>: {{ $survei->jenis_lahan }}</td></tr>
            <tr><td></td><td>Pemanfaatan Lahan Saat Ini</td><td>: {{ $survei->pemanfaatan }}</td></tr>
            <tr><td></td><td>Kondisi Sekitar Lahan</td><td>: {{ $survei->kondisi_sekitar }}</td></tr>
        </table>
    </div>

    <p>Demikian Berita Acara Survei Lapangan ini dibuat untuk dipergunakan seperlunya.</p>

    <div class="section">
        <p><strong>Tim IPPT Disepakati:</strong></p>
        <table class="ttd-table">
            @foreach($sortedPegawais as $index => $pegawai)
            <tr>
                <td>{{ $index + 1 }}.</td>
                <td>
                    {{ strtoupper(explode(',', $pegawai->user->nama)[0]) }}
                    @if (isset(explode(',', $pegawai->user->nama)[1]))
                        ,{{ explode(',', $pegawai->user->nama)[1] }}
                    @endif
                    <br>NIP. {{ $pegawai->nip }}
                </td>
                <td class="paraf">___________________</td>
            </tr>
            @endforeach
        </table>
    </div>

    <div class="page-break"></div>

    {{-- Halaman 2 --}}
    <p class="text-center"><strong>LAMPIRAN 1 - FOTO LAHAN</strong></p>
    <div class="image-container">
        <img src="{{ asset('storage/gambar_lahan/' . $namaFile) }}" width="400">

        {{-- <img src="{{ public_path('storage/' . $survei->gambar_lahan) }}" class="gambar-lahan"> --}}
    </div>

    <div class="page-break"></div>

    {{-- Halaman 3 --}}
    <p class="text-center"><strong>LAMPIRAN 2 - PETA SITUASI</strong></p>
    <div class="image-container">
        <img src="{{ asset('storage/gambar_lahan/' . $namaFile) }}" width="400">
        {{-- <img src="{{ public_path('storage/' . $survei->peta_situasi_file) }}" class="gambar-lahan"> --}}
    </div>

</body>
</html>
