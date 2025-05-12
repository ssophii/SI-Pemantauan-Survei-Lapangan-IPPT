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
            size: 21cm 33cm;
            margin: 1cm;
        }
    
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 11pt;
            line-height: 1.05;
            text-align: justify;
        }
    
        .title {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            font-size: 13pt;
            margin-bottom: 0;
        }
    
        .nomor {
            text-align: center;
            font-size: 11pt;
            margin-top: 0;
            margin-bottom: 0.6cm;
        }
    
        p {
            margin: 0.2cm 0;
        }
    
        .bold {
            font-weight: bold;
        }
    
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0.3cm 0;
        }
    
        td {
            vertical-align: top;
            padding: 1px 4px;
        }
    
        .image-container {
            text-align: center;
            margin: 0.4cm 0;
        }
    
        .gambar-lahan {
            width: 100%;
            height: auto;
            max-height: 7cm; /* DIKURANGI agar muat satu halaman */
            object-fit: cover;
        }

        
        
        .ttd-table td {
            line-height: 1.1;
            padding: 0px 5px;
            vertical-align: top;
            font-size: 10.5pt;
        }

        /* .ttd-table td br {
            line-height: 0;
        } */

        .ttd-table td div {
            line-height: 1;
            margin: 0;
            padding: 0;
        }

        
        
        .paraf {
            text-align: right;
            width: 30%;
        }
        
        .ttd-table {
            width: auto;
            margin-left: auto; /* membuat tabel tanda tangan berada di sisi kanan */
            border-spacing: 0cm; /* Jarak horizontal antar kolom */
            border-collapse: separate; /* WAJIB agar spacing antar kolom jalan */
        }
        
            .ttd-table tr td {
            padding-top: 1px;
            padding-bottom: 1px;
        }
        .section {
            page-break-inside: avoid;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
    
    
    <div class="section">
        <p class="title">BERITA ACARA SURVEI LAPANGAN</p>
        <p class="nomor">Nomor: {{ $survei->no_ba }}</p>
    
        <p>
            Pada Hari ini, <span class="bold">{{ \Carbon\Carbon::parse($survei->tanggal)->translatedFormat('l') }}</span> 
            Tanggal <span class="bold">{{ \Carbon\Carbon::parse($survei->tanggal)->translatedFormat('d') }}</span> 
            Bulan <span class="bold">{{ \Carbon\Carbon::parse($survei->tanggal)->translatedFormat('F') }}</span> 
            Tahun <span class="bold">{{ \Carbon\Carbon::parse($survei->tanggal)->translatedFormat('Y') }}</span>, 
            telah dilaksanakan Survei Lapangan Untuk Proses Permohonan Izin Perubahan Tanah (IPPT) 
            Nomor Permohonan: <span class="bold">{{ $survei->permohonan->no_registrasi }}</span>
        </p>
    
        <table>
            <tr><td width="30%">1. Pemohon</td><td>: {{ $survei->permohonan->user->nama }}</td></tr>
            <tr><td>2. Bertindak Atas Nama</td><td>: {{ $survei->permohonan->atas_nama }}</td></tr>
            <tr><td>3. Lokasi Lahan</td><td>: {{ $survei->permohonan->lokasi_jalan }}, Kel. {{ $survei->permohonan->lokasi_kelurahan }}, Kec. {{ $survei->permohonan->lokasi_kecamatan }}, Kota Bengkulu</td></tr>
            <tr><td>4. Luas Yang Dimohon</td><td>: {{ $survei->permohonan->luas_lahan }} m²</td></tr>
            <tr><td>5. Status Kepemilikan</td><td>: {{ $survei->permohonan->kepemilikan }}</td></tr>
        </table>
    
        <div class="image-container">
            @php
                $namaFile = 'gambar_'.$survei->permohonan->id_pendaftaran.'.jpg';
            @endphp
            <img src="{{ public_path('storage/gambar_lahan/' . $namaFile) }}" class="gambar-lahan">

            {{-- <img src="{{ asset('storage/gambar_lahan/' . $namaFile) }}" class="gambar-lahan"> --}}
        </div>
    
        <table>
            <tr><td width="5%">A.</td><td colspan="2"><strong>Hasil Survei</strong></td></tr>
            <tr><td></td><td width="30%">1. Peta Situasi</td><td>: Ada / Tidak Ada</td></tr>
            <tr><td></td><td>2. Koordinat</td><td>:</td></tr>
            <tr><td></td><td></td><td>A: {{ $survei->koor_a }}</td></tr>
            <tr><td></td><td></td><td>B: {{ $survei->koor_b }}</td></tr>
            <tr><td></td><td></td><td>C: {{ $survei->koor_c }}</td></tr>
            <tr><td></td><td></td><td>D: {{ $survei->koor_d }}</td></tr>
        </table>
    
        <table>
            <tr><td width="5%">B.</td><td colspan="2"><strong>Eksisting Lahan</strong></td></tr>
            <tr><td></td><td width="30%">Topografi</td><td>: {{ $survei->topografi }}</td></tr>
            <tr><td></td><td>Jenis Lahan</td><td>: {{ $survei->jenis_lahan }}</td></tr>
            <tr><td></td><td>Pemanfaatan Lahan Saat Ini</td><td>: {{ $survei->pemanfaatan }}</td></tr>
            <tr><td></td><td>Kondisi Sekitar Lahan</td><td>: {{ $survei->kondisi_sekitar }}</td></tr>
        </table>
    
        <p>Demikian Berita Acara Survei Lapangan ini dibuat untuk dipergunakan seperlunya.</p>
        <div>
            {{-- <div style="align-items: center">
                <p style="text-align: center;"><strong>Tim IPPT Disperkimtan</strong></p>
            </div> --}}
            <table class="ttd-table"> 
                <tr>
                    <td colspan="3" style="text-align: center; font-weight: bold; padding-bottom: 0.3cm;">
                        Tim IPPT Disperkimtan
                    </td>
                </tr>
                @foreach($sortedPegawais as $index => $pegawai)
                <tr>
                    <td valign="top">{{ $index + 1 }}.</td>
                    <td>
                        <div>{{ $pegawai->user->nama }}</div>
                        <div>NIP. {{ $pegawai->nip }}</div>
                        {{-- {{ $pegawai->user->nama }}<br>
                        NIP. {{ $pegawai->nip }} --}}
                    </td>
                    <td>
                        <div>{{ $index + 1 }}.</div>
                        <div>&nbsp;&nbsp;&nbsp;............................................</div>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
        
        {{-- <div style="width: fit-content; margin-left: auto;">
            <table class="ttd-table">
                <p style="text-align: center;"><strong>Tim IPPT Disperkimtan</strong></p>
                @foreach($sortedPegawais as $index => $pegawai)
                <tr>
                    <td valign="top" class="pr-2">{{ $index + 1 }}.</td>
                    <td style="white-space: nowrap;">
                        <div style="padding-right: 1cm">
                            {{ $pegawai->user->nama }}<br>
                            NIP. {{ $pegawai->nip }}
                        </div>
                    </td>
                    <td style="text-align: left; white-space: nowrap;" >
                        {{ $index + 1 }}.<br>&nbsp;&nbsp;&nbsp;............................................
                    </td>
                </tr>
                @endforeach
            </table>
        </div> --}}
        
        {{-- <table class="ttd-table">
            @foreach($sortedPegawais as $index => $pegawai)
            <tr>
                <td width="3%" valign="top">{{ $index + 1 }}.</td>
                <td width="65%">
                    {{ $pegawai->user->nama }}<br>
                    NIP. {{ $pegawai->nip }}
                </td>
                <td style="text-align: left; white-space: nowrap;" width="32%">
                    {{ $index + 1 }}.<br>&nbsp;&nbsp;&nbsp;............................................
                </td>
            </tr>
            @endforeach
        </table> --}}

    </div>
    

<div class="page-break"></div>
{{-- Halaman 2 --}}
<p class="text-center"><strong>LAMPIRAN 1 - FOTO LAHAN</strong></p>
@php
    $namaFile = 'gambar_'.$survei->permohonan->id_pendaftaran.'.jpg';
@endphp
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