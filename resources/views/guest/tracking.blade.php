<x-guest-layout>
    <div class="container mt-5 pt-5">
        <h2 class="text-center mb-5">Tracking Permohonan Anda</h2>

        {{-- @if ($aktif->count() > 0) --}}
            <h4 class="mb-4">Permohonan Aktif</h4>

            @foreach ($permohonans as $permohonan)
                <div class="card mb-5 p-4">
                    {{-- <h5 class="text-center mb-4">Permohonan No: {{ $permohonan->no_surat }}</h5> --}}
                    <h5 class="text-center mb-4">ID Pendaftaran No: {{ $permohonan->id_pendaftaran }}</h5>

                    <div class="steps d-flex justify-content-between mb-4">
                        <div class="step {{ in_array($permohonan->status, ['diterima','ditetapkan','survei','laporan','selesai']) ? 'completed' : '' }}">
                            <div class="circle">1</div>
                            <div class="label">Diterima</div>
                        </div>
                        <div class="step {{ in_array($permohonan->status, ['ditetapkan','survei','laporan','selesai']) ? 'completed' : '' }}">
                            <div class="circle">2</div>
                            <div class="label">Penetapan Survei</div>
                        </div>
                        <div class="step {{ in_array($permohonan->status, ['survei','laporan','selesai']) ? 'completed' : '' }}">
                            <div class="circle">3</div>
                            <div class="label">Survei</div>
                        </div>
                        <div class="step {{ in_array($permohonan->status, ['laporan','selesai']) ? 'completed' : '' }}">
                            <div class="circle">4</div>
                            <div class="label">Penyusunan Laporan</div>
                        </div>
                        <div class="step {{ $permohonan->status == 'selesai' ? 'completed' : '' }}">
                            <div class="circle">5</div>
                            <div class="label">Selesai</div>
                        </div>
                    </div>

                    <div class="card p-3 text-center">
                        @if ($permohonan->status == 'diterima')
                            <p>Berkas permohonan <strong>{{ $permohonan->no_surat }}</strong> atas nama <strong>{{ $permohonan->user->nama }}</strong> telah diterima oleh Bidang Pertanahan PERKIMTAN Kota Bengkulu.</p>
                        @elseif ($permohonan->status == 'ditetapkan')
                            <p>Survei untuk permohonan dengan infomasi:</p>
                            <table>
                                <tr><td>ID Pendaftaran</td><td>:</td><td>{{ $permohonan->id_pendaftaran }}</td></tr>
                                <tr><td>Nama Pemohon</td><td>:</td><td>{{ $permohonan->user->nama }}</td></tr>
                                <tr><td>Lokasi</td><td>:</td><td>{{ $permohonan->lokasi_jalan }}, Kelurahan {{ $permohonan->lokasi_kelurahan }}, Kecamatan {{ $permohonan->lokasi_kecamatan }}</td></tr>
                            </table>
                            <p></p>
                                telah dijadwalkan pada <strong>{{ \Carbon\Carbon::parse($permohonan->spt->pelaksanaan)->translatedFormat('l, d F Y') }}</strong>. Mohon menunggu pelaksanaan survei.
                        @elseif ($permohonan->status == 'survei')
                            <p>Survei untuk permohonan dengan infomasi:</p>
                            <table>
                                <tr><td>ID Pendaftaran</td><td>:</td><td>{{ $permohonan->id_pendaftaran }}</td></tr>
                                <tr><td>Nama Pemohon</td><td>:</td><td>{{ $permohonan->user->nama }}</td></tr>
                                <tr><td>Lokasi</td><td>:</td><td>{{ $permohonan->lokasi_jalan }}, Kelurahan {{ $permohonan->lokasi_kelurahan }}, Kecamatan {{ $permohonan->lokasi_kecamatan }}</td></tr>
                            </table>
                            <p><strong>sedang dilaksanakan oleh tim survei.</strong></p> 
                        @elseif ($permohonan->status == 'laporan')
                            <p>Survei untuk permohonan dengan infomasi:</p>
                            <table>
                                <tr><td>ID Pendaftaran</td><td>:</td><td>{{ $permohonan->id_pendaftaran }}</td></tr>
                                <tr><td>Nama Pemohon</td><td>:</td><td>{{ $permohonan->user->nama }}</td></tr>
                                <tr><td>Lokasi</td><td>:</td><td>{{ $permohonan->lokasi_jalan }}, Kelurahan {{ $permohonan->lokasi_kelurahan }}, Kecamatan {{ $permohonan->lokasi_kecamatan }}</td></tr>
                            </table>
                            <p><strong>telah selesai dilaksanakan.</strong> Laporan sedang disusun oleh tim kami. Silakan cek kembali dalam beberapa hari.</p>                        
                        @elseif ($permohonan->status == 'selesai')
                        <p>Permohonan dengan ID Pendaftaran: <strong>{{ $permohonan->id_pendaftaran }}</strong> telah selesai.</p>
                            @if ($permohonan->survei && $permohonan->survei->file_laporan)
                                <p>Dokumen laporan survei telah tersedia. Silakan unduh melalui tombol di bawah ini:</p>
                                <a href="{{ asset('storage/laporan/scan_laporan_' . $permohonan->id_pendaftaran . '.pdf') }}" class="btn btn-primary" style="background-color: #f89646; border: none;" target="_blank">
                                    Download Laporan Survei
                                </a>
                            @else
                                <p><em>Laporan survei belum diunggah.</em></p>
                            @endif
                            {{-- <p>Permohonan dengan ID Pendaftaran: <strong>{{ $permohonan->id_pendaftaran }}</strong> telah selesai.</p> --}}
                        @endif
                    </div>
                </div>
            @endforeach

        <div class="text-center mt-5">
            <a href="{{ route('guest.inputtracking') }}" class="btn btn-secondary">Cek Permohonan Lain</a>
        </div>
    </div>

    <style>
        .steps {
            display: flex;
            align-items: center;
        }
        .step {
            text-align: center;
            width: 23%;
            position: relative;
        }
        .step::after {
            content: '';
            position: absolute;
            top: 20px;
            right: -50%;
            height: 2px;
            width: 100%;
            background-color: #ccc;
            z-index: -1;
        }
        .step:last-child::after {
            display: none;
        }
        .circle {
            width: 40px;
            height: 40px;
            background: #ccc;
            border-radius: 50%;
            line-height: 40px;
            color: white;
            margin: auto;
        }
        .completed .circle {
            background: #28a745;
        }
        .completed::after {
            background-color: #28a745;
        }
        .label {
            margin-top: 8px;
            font-size: 14px;
        }
    </style>
</x-guest-layout>
