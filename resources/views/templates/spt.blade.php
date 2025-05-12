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
            $jabatanOrder[$pegawai->jabatan] ?? 99,  // kalau jabatan tidak dikenali, taruh di bawah
            $pegawai->nip,                           // lalu urutkan berdasarkan nip kecil ke besar
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
    <title>Surat Perintah Tugas</title>
    <style>
        @page {
            size: 21.6cm 33cm; /* F4 */
            margin: 2cm 2.5cm 2cm 2.5cm;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            line-height: 1.15;
        }

        .text-center {
            text-align: center;
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

        .section {
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0.2cm;
            margin-bottom: 0.5cm;
        }

        .table-bordered th, .table-bordered td {
            border: 1px solid black;
            padding: 6px;
            vertical-align: top;
            font-size: 12pt;
        }

        .ttd {
            width: 100%;
            margin-top: 1.5cm;
        }

        .right {
            width: 100%;
            text-align: left;
        }

        .right p {
            margin: 0;
        }

        .jabatan-footer {
            margin-top: 0.5cm;
            font-weight: bold;
        }

        .nama-footer {
            margin-top: 2cm;
            font-weight: bold;
            text-decoration: underline;
        }

        .nip-footer {
            margin-top: 0;
        }
    </style>
</head>
<body>

    <table style="width: 100%; margin-bottom: 5px;">
        <tr>
            <td style="width: 80px; text-align: center;">
                <img src="{{ public_path('assets/images/logoril.png') }}" style="height: 80px;">
            </td>
            <td style="text-align: center;">
                <p style="margin: 0; font-size: 14pt; font-weight: bold;">PEMERINTAH KOTA BENGKULU</p>
                <p style="margin: 0; font-size: 16pt; font-weight: bold;">DINAS PERUMAHAN DAN KAWASAN PERMUKIMAN</p>
                <p style="margin: 0; font-size: 16pt; font-weight: bold;">DAN PERTANAHAN KOTA BENGKULU</p>
                <p style="margin: 0; font-size: 11pt;"><i>Jl. Dua Jalur Pos dan Giro Kelurahan Pematang Gubernur Kecamatan Muara Bangkahulu</i></p>
            </td>
        </tr>
    </table>
    
    <!-- Garis bawah ganda -->
    <hr style="border: none; border-top: 2px solid black; margin: 0;">
    <hr style="border: none; border-top: 1px solid black; margin-top: 1px; margin-bottom: 20px;">

    <p class="text-center title">SURAT PERINTAH TUGAS</p>
    <p class="text-center nomor">Nomor: {{ $spt->no_surat }}</p>

    <p><strong>Dasar</strong> : Permohonan Izin Perubahan Penggunaan Tanah (IPPT)</p>

    <p class="text-center"><strong>MEMERINTAHKAN</strong></p>

    <table class="table-bordered">
        <thead>
            <tr>
                <th style="width:5%;">NO</th>
                <th style="width:45%;">NAMA/NIP</th>
                <th style="width:30%;">JABATAN</th>
                <th style="width:20%;">PARAF</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sortedPegawais as $index => $pegawai)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ strtoupper(explode(',', $pegawai->user->nama)[0]) }},{{ isset(explode(',', $pegawai->user->nama)[1]) ? explode(',', $pegawai->user->nama)[1] : '' }}<br> NIP. {{ $pegawai->nip }}</td>
                <td class="text-center">{{ $jabatanMapping[$pegawai->jabatan] ?? $pegawai->jabatan }}</td>
                <td></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table>
        <tr>
            <td><strong>Tujuan<strong></td>
            <td>:</td>
            <td>Melakukan Survei IPPT di Kelurahan {{ $spt->permohonan->lokasi_kelurahan }}, Kecamatan {{ $spt->permohonan->lokasi_kecamatan }}</td>
        </tr>
        <tr>
            <td><strong>TMT<strong></td>
            <td>:</td>
            <td>{{ \Carbon\Carbon::parse($spt->pelaksanaan)->translatedFormat('d F Y') }} s/d selesai</p></td>
        </tr>
        <tr>
            <td><strong>Waktu<strong></td>
            <td>:</td>
            <td>Pukul {{ \Carbon\Carbon::parse($spt->pelaksanaan)->format('H:i') }} WIB s/d selesai</td>
        </tr>
        <tr>
            <td><strong>Keterangan<strong></td>
            <td>:</td>
            <td>Demikianlah Surat Perintah Tugas ini, untuk dilaksanakan dengan penuh tanggung</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>jawab.</td>
        </tr>
    </table>
    
    <div style="width: 100%; margin-top: 1cm;">
        <div style="width: 50%; margin-left: auto; margin-right: 0; text-align: center;">
            <p style="margin: 0;">Ditetapkan di : Bengkulu</p>
            <p style="margin: 0 0 20px 0;">Pada Tanggal : {{ \Carbon\Carbon::parse($spt->penetapan)->translatedFormat('d F Y') }}</p>
    
            <p style="margin: 0;">Kepala Dinas</p>
            <p style="margin: 0;">Perumahan Rakyat dan Kawasan</p>
            <p style="margin: 0;">Pemukiman dan Pertanahan</p>
            <p style="margin: 0 0 80px 0;">Kota Bengkulu</p>
    
            <p style="margin: 0; font-weight: bold; text-decoration: underline;">TONI HARISMAN, S.Sos., M.Si.</p>
            <p style="margin: 0;">Pembina Utama Muda/IV.c</p>
            <p style="margin: 0;">NIP. 19700310 199703 1 004</p>
        </div>
    </div>

</body>
</html>
