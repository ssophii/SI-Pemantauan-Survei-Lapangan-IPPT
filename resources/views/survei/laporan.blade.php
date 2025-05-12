<x-app-layout>
    <div class="card">
      <div class="card-body">
        <h4 class="card-title mb-3"><i class="fas fa-file-alt"></i> Daftar Permohonan Dengan Hasil Survei </h4>
  
        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif
  
        @if($surveis->isEmpty())
          <div class="alert alert-info">Tidak ada permohonan yang menunggu nomor LHP.</div>
        @else
          <table class="table table-bordered" id="lhp-table">
            <thead>
              <tr>
                <th class="text-center">ID Pendaftaran</th>
                <th class="text-center">Nama Pemohon</th>
                <th class="text-center">Lokasi</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($surveis as $survei)
                <tr>
                  <td class="text-center align-middle">{{ $survei->permohonan->id_pendaftaran }}</td>
                  <td class="text-center align-middle">{{ $survei->permohonan->user->nama }}</td>
                  <td>{{ $survei->permohonan->lokasi_jalan }}, <br>Kel. {{ $survei->permohonan->lokasi_kelurahan }}, Kec. {{ $survei->permohonan->lokasi_kecamatan }}</td>
                  <td class="text-center align-middle">
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalLHP{{ $survei->id }}">+ Nomor Berita Acara</button>
                  </td>
                </tr>
  
                <!-- Modal Tambah Nomor Laporan -->
                <div class="modal fade" id="modalLHP{{ $survei->id }}" tabindex="-1">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <form method="POST" action="{{ route('survei.updateLaporan', $survei->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                          <h5 class="modal-title">Tambah Nomor Laporan</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                          <div class="mb-3">
                            <label class="form-label">ID Pendaftaran</label>
                            <input type="text" name="id_pendaftaran" value="{{ $survei->permohonan->id_pendaftaran }}" class="form-control" readonly>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">No. Berita Acara</label>
                            <input type="text" name="no_ba" class="form-control" required>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">No. Laporan Hasil Pemeriksaan</label>
                            <input type="text" name="no_lhp" class="form-control" required>
                          </div>
                          <hr>
                          <div class="d-flex flex-column gap-2">
                            <div class="d-flex">
                              <div class="me-2" style="width: 150px;"><strong>No. Permohonan</strong></div>
                              <div>: {{ $survei->permohonan->no_surat }}</div>
                            </div>
                            <div class="d-flex">
                              <div class="me-2" style="width: 150px;"><strong>Nama Pemohon</strong></div>
                              <div>: {{ $survei->permohonan->user->nama }}</div>
                            </div>
                            <div class="d-flex">
                              <div class="me-2" style="width: 150px;"><strong>Topografi</strong></div>
                              <div>: {{ $survei->topografi }}</div>
                            </div>
                            <div class="d-flex">
                              <div class="me-2" style="width: 150px;"><strong>Luas Lahan</strong></div>
                              <div>: {{ $survei->luas_lahan }}</div>
                            </div>
                            <div class="d-flex">
                              <div class="me-2" style="width: 150px;"><strong>Jenis Lahan</strong></div>
                              <div>: {{ $survei->jenis_lahan }}</div>
                            </div>
                            <div class="d-flex">
                              <div class="me-2" style="width: 150px;"><strong>Pemanfaatan</strong></div>
                              <div>: {{ $survei->pemanfaatan }}</div>
                            </div>
                          </div>                          
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              @endforeach
            </tbody>
          </table>
        @endif
      </div>
    </div>
  
    <!-- Riwayat LHP -->
    <div class="card mt-4">
      <div class="card-body">
        <h4 class="card-title mb-3"><i class="fas fa-history"></i> Riwayat Laporan Hasil Pemeriksaan</h4>
  
        @if($riwayat->isEmpty())
          <div class="alert alert-info">Tidak ada riwayat Laporan Hasil Pemeriksaan.</div>
        @else
          <table class="table table-striped" id="riwayat-lhp-table">
            <thead>
              <tr>
                <th class="text-center">ID Pendaftaran</th>
                <th class="text-center">Nama Pemohon</th>
                <th class="text-center">Lokasi</th>
                <th class="text-center">No. BA</th>
                <th class="text-center">No. LHP</th>
                <th class="text-center">File Laporan</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($riwayat as $survei)
                <tr>
                  <td class="text-center align-middle">{{ $survei->permohonan->id_pendaftaran }}</td>
                  <td class="text-center align-middle">{{ $survei->permohonan->user->nama }}</td>
                  <td>{{ $survei->permohonan->lokasi_jalan }}, <br>Kel. {{ $survei->permohonan->lokasi_kelurahan }}, Kec. {{ $survei->permohonan->lokasi_kecamatan }}</td>
                  <td class="text-center align-middle">{{ $survei->no_ba }}</td>
                  <td class="text-center align-middle">{{ $survei->no_lhp }}</td>
                  <td class="text-center align-middle">
                    @php
                        $noSurat = $survei->permohonan->id_pendaftaran;
                        $fileManual = 'scan_laporan_' . $noSurat . '.pdf';
                        $fileAuto = 'laporan_' . $noSurat . '.pdf';
                        $pathManual = storage_path('app/public/laporan/' . $fileManual);
                    @endphp

                    @if (file_exists($pathManual))
                        <a href="{{ asset('storage/laporan/' . $fileManual) }}" target="_blank" class="btn btn-sm btn-success">
                            Lihat File (arsip)
                        </a>
                    @elseif (file_exists(storage_path('app/public/laporan/' . $fileAuto)))
                        <a href="{{ asset('storage/laporan/' . $fileAuto) }}" target="_blank" class="btn btn-sm btn-primary">
                            Lihat File
                        </a>
                    @else
                        <span class="text-muted">Belum ada file</span>
                    @endif
                  </td>
                
                  <td class="text-center align-middle">
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditLHP{{ $survei->id }}">Edit</button>
                  </td>
                </tr>
  
                <!-- Modal Edit LHP -->
                <div class="modal fade" id="modalEditLHP{{ $survei->id }}" tabindex="-1">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <form method="POST" action="{{ route('survei.updateLaporan', $survei->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                          <h5 class="modal-title">Edit Nomor Laporan</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                          <div class="mb-3">
                            <label class="form-label">ID Pendaftaran</label>
                            <input type="text" name="id_pendaftaran" class="form-control" value="{{ $survei->permohonan->id_pendaftaran }}" readonly>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">No. Berita Acara</label>
                            <input type="text" name="no_ba" class="form-control" value="{{ $survei->no_ba }}" required>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">No. Laporan Hasil Pemeriksaan</label>
                            <input type="text" name="no_lhp" class="form-control" value="{{ $survei->no_lhp }}" required>
                          </div>
                          <hr>
                          <div class="d-flex flex-column gap-2">
                            <div class="d-flex">
                              <div class="me-2" style="width: 150px;"><strong>No. Permohonan</strong></div>
                              <div>: {{ $survei->permohonan->no_surat }}</div>
                            </div>
                            <div class="d-flex">
                              <div class="me-2" style="width: 150px;"><strong>Nama Pemohon</strong></div>
                              <div>: {{ $survei->permohonan->user->nama }}</div>
                            </div>
                            <div class="d-flex">
                              <div class="me-2" style="width: 150px;"><strong>Topografi</strong></div>
                              <div>: {{ $survei->topografi }}</div>
                            </div>
                            <div class="d-flex">
                              <div class="me-2" style="width: 150px;"><strong>Luas Lahan</strong></div>
                              <div>: {{ $survei->luas_lahan }}</div>
                            </div>
                            <div class="d-flex">
                              <div class="me-2" style="width: 150px;"><strong>Jenis Lahan</strong></div>
                              <div>: {{ $survei->jenis_lahan }}</div>
                            </div>
                            <div class="d-flex">
                              <div class="me-2" style="width: 150px;"><strong>Pemanfaatan</strong></div>
                              <div>: {{ $survei->pemanfaatan }}</div>
                            </div>
                          </div>             
                          <hr>             
                          <div class="mb-3">
                            <label class="form-label">Unggah Arsip Dokumen Laporan</label>
                            <input type="file" name="file_laporan" class="form-control" accept=".pdf">
                            <div class="form-text">Unggah hasil scan Berita Acara dan LHP</div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-success">Perbarui</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              @endforeach
            </tbody>
          </table>
        @endif
      </div>
    </div>
    @push('scripts')
      <script>
        $(document).ready(function() {
            $('#lhp-table').DataTable();
        });
        $(document).ready(function() {
            $('#riwayat-lhp-table').DataTable();
        });
      </script>
    @endpush
  </x-app-layout>
  