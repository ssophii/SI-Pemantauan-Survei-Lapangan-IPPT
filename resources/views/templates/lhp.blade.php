<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lembar Hasil Pemeriksaan</title>
    <style>
        @page {
            size: 21.6cm 33cm; /* F4 */
            margin: 2cm 2.5cm 2cm 2.5cm;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            line-height: 1.5;
        }

        .text-center { text-align: center; }
        .kop p { margin: 0; padding: 0; }

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

        .indent { text-indent: 1.5em; text-align: justify; }

        h4 { margin-bottom: 0.2cm; }

        ul, ol {
            margin-top: 0;
            margin-bottom: 1cm;
        }

        table {
            width: 100%;
        }

        .ttd {
            width: 100%;
            margin-top: 3cm;
            overflow: hidden;
        }

        .signature-block {
            width: 50%;
            float: right;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- KOP -->
    <table>
        <tr>
            <td style="width: 80px; text-align: center;">
                <img src="{{ public_path('assets/images/logoril.png') }}" style="height: 80px;">
            </td>
            <td class="text-center">
                <p style="font-size: 14pt; font-weight: bold;">PEMERINTAH KOTA BENGKULU</p>
                <p style="font-size: 16pt; font-weight: bold;">DINAS PERUMAHAN DAN KAWASAN PERMUKIMAN</p>
                <p style="font-size: 16pt; font-weight: bold;">DAN PERTANAHAN KOTA BENGKULU</p>
                <p style="font-size: 11pt; font-style: italic;">Jl. Dua Jalur Pos dan Giro Kel. Pematang Gubernur Kec. Muara Bangkahulu</p>
            </td>
        </tr>
    </table>

    <hr style="border: none; border-top: 2px solid black; margin: 0;">
    <hr style="border: none; border-top: 1px solid black; margin-top: 1px; margin-bottom: 20px;">

    <!-- Judul -->
    <p class="text-center title">LEMBAR HASIL PEMERIKSAAN (LHP)</p>
    <p class="text-center nomor">Nomor: {{ $survei->no_lhp }}</p>

    <!-- Pendahuluan -->
    <h4>PENDAHULUAN</h4>
    <p class="indent">Menindaklanjuti Surat Permohonan Nomor: {{ $survei->permohonan->no_surat }} Izin Perubahan Penggunaan Tanah (IPPT)</p>

    <h4>Umum / Latar Belakang</h4>
    <table>
        <tr><td style="width: 35%;">Nama Pemohon</td><td>: {{ $survei->permohonan->user->nama }}</td></tr>
        <tr><td>Bertindak Atas Nama</td><td>: {{ $survei->permohonan->atas_nama }}</td></tr>
        <tr><td>Alamat Pemohon</td><td>: {{ $survei->permohonan->alamat_jalan }}, Kelurahan {{ $survei->permohonan->alamat_kelurahan }}, Kecamatan {{ $survei->permohonan->alamat_kecamatan }}</td></tr>
        <tr><td>Lokasi Lahan</td><td>: Kelurahan {{ $survei->permohonan->lokasi_kelurahan }}, Kecamatan {{ $survei->permohonan->lokasi_kecamatan }}</td></tr>
        <tr><td>Luas Lahan</td><td>: {{ $survei->luas_lahan }} m<sup>2</sup></td></tr>
    </table>

    <!-- Landasan Hukum -->
    <h4>LANDASAN HUKUM</h4>
    <ul>
        <li>Undang-undang Nomor 26 Tahun 2007 tentang Penataan Ruangan</li>
        <li>Undang-undang Nomor 23 Tahun 2014 tentang Pemerintahan Daerah sebagaimana telah diubah dengan Undang-undang Nomor 9 Tahun 2015</li>
        <li>Peraturan Pemerintah Nomor 21 Tahun 2021 tentang Penyelenggaraan Penataan Ruang</li>
        <li>Peraturan Daerah Nomor 4 Tahun 2021 tentang Rencana Tata Ruang Wilayah Kota Bengkulu 2021–2041</li>
    </ul>

    <!-- Maksud dan Tujuan -->
    <h4>MAKSUD DAN TUJUAN</h4>
    <p class="indent">
        Melakukan pemeriksaan terhadap Permohonan IPPT (Izin Perubahan Penggunaan Tanah) dalam rangka perubahan penggunaan tanah untuk pemanfaatan sesuai Rencana Tata Ruang Wilayah Kota Bengkulu.
    </p>

    <!-- Kegiatan -->
    <h4>KEGIATAN YANG DILAKSANAKAN</h4>
    <ul>
        <li>Melakukan pemeriksaan berkas</li>
        <li>Melaksanakan survei lokasi lahan untuk mengetahui kondisi eksisting, geografis serta pengambilan koordinat dan dokumentasi</li>
        <li>Membuat BA Hasil Survei</li>
    </ul>

    <!-- Hasil -->
    <h4>HASIL YANG DIPEROLEH</h4>
    <table>
        <tr><td style="width: 35%;">Eksisting Lahan</td><td>: {{ $survei->eksisting }}</td></tr>
        <tr><td>Topografi</td><td>: {{ $survei->topografi }}</td></tr>
        <tr><td>Jenis Lahan</td><td>: {{ $survei->jenis_lahan }}</td></tr>
        <tr><td>Pemanfaatan Saat Ini</td><td>: {{ $survei->pemanfaatan }}</td></tr>
        <tr><td>Kondisi Sekitar Lahan</td><td>: {{ $survei->kondisi_sekitar }}</td></tr>
        <tr><td>Kesesuaian Tata Ruang</td><td>: {{ $survei->kesesuaian_tataruang }}</td></tr>
        <tr><td>Koordinat</td><td>:
            A: {{ $survei->koordinat_a }}<br>
            B: {{ $survei->koordinat_b }}<br>
            C: {{ $survei->koordinat_c }}<br>
            D: {{ $survei->koordinat_d }}
        </td></tr>
        <tr><td>Peruntukan</td><td>: {{ $survei->peruntukan }}</td></tr>
    </table>

    <!-- Kesimpulan -->
    <h4>KESIMPULAN</h4>
    <p class="indent">
        Berdasarkan hasil pemeriksaan administrasi dan tinjauan lapangan dengan berpedoman kepada Risalah Pertimbangan Teknis Pertanahan Nomor: {{ $survei->no_ba }} dan Peraturan Daerah RTRW Kota Bengkulu Nomor 4 Tahun 2022, maka Permohonan IPPT atas nama {{ $survei->permohonan->nama_pemohon }} <strong>{{ $survei->rekomendasi }}</strong>, dengan ketentuan:
    </p>
    <ul>
        <li>Penggunaan tanah tidak boleh bertentangan dengan arahan tata ruang</li>
        <li>Menjaga kelestarian lingkungan sekitar</li>
        <li>Membuat sistem drainase yang baik untuk mencegah banjir</li>
    </ul>

    <!-- Penutup -->
    <h4>PENUTUP</h4>
    <p class="indent">
        Demikianlah Lembar Hasil Pemeriksaan ini disampaikan untuk dapat dipergunakan sebagaimana mestinya. Jika di kemudian hari terdapat kekeliruan atau kesalahan atas rekomendasi Izin Perubahan Penggunaan Tanah ini akan diperbaiki sebagaimana mestinya.
    </p>

    <!-- TTD -->
    <div class="ttd">
        <div class="signature-block">
            <p>Bengkulu, {{ \Carbon\Carbon::parse($survei->tanggal_survei)->translatedFormat('d F Y') }}</p>
            <p>Kepala Dinas</p>
            <p>Perumahan Rakyat dan Kawasan</p>
            <p>Permukiman dan Pertanahan</p>
            <p style="margin-bottom: 60px;">Kota Bengkulu</p>

            <p style="font-weight: bold; text-decoration: underline; margin: 0;">TONI HARISMAN, S.Sos., M.Si.</p>
            <p style="margin: 0;">Pembina Utama Muda / IV.c</p>
            <p style="margin: 0;">NIP. 19700310 199703 1 004</p>
        </div>
    </div>

</body>
</html>
