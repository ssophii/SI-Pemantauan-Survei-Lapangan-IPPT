<x-app-layout>
    <div class="card">
      <div class="card-body">
        <h4 class="card-title mb-3"><i class="fas fa-map"></i> Daftar Permohonan untuk Disurvei</h4>
  
        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif
  
        @if($permohonans->isEmpty())
          <div class="alert alert-info">Tidak ada permohonan yang menunggu untuk disurvei.</div>
        @else
          <table class="table table-bordered" id="permohonan-table">
            <thead>
              <tr>
                <th class="text-center">ID Pendaftaran</th>
                <th class="text-center">Nama Pemohon</th>
                <th class="text-center">Lokasi</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($permohonans as $permohonan)
                <tr>
                  <td class="text-center align-middle">{{ $permohonan->id_pendaftaran }}</td>
                  <td class="text-center align-middle">{{ $permohonan->user->nama }}</td>
                  <td>{{ $permohonan->lokasi_jalan}}, <br>Kel. {{ $permohonan->lokasi_kelurahan }}, Kec. {{ $permohonan->lokasi_kecamatan }}</td>
                  <td class="text-center align-middle">
                    <a href="{{ route('survei.create', $permohonan->id) }}" class="btn btn-primary btn-sm">
                      Tambah Hasil Survei
                    </a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @endif
      </div>
    </div>
  
    {{-- Riwayat Survei --}}
    <div class="card mt-4">
      <div class="card-body">
        <h4 class="card-title mb-3"><i class="fas fa-history"></i> Riwayat Survei</h4>
  
        @if($riwayat->isEmpty())
          <div class="alert alert-secondary">Belum ada hasil survei yang tercatat.</div>
        @else
          <table class="table table-striped" id="riwayat-table">
            <thead>
              <tr>
                <th class="text-center">ID Pendaftaran</th>
                <th class="text-center">Nama Pemohon</th>
                <th class="text-center">Lokasi</th>
                <th class="text-center">Detail</th>
              </tr>
            </thead>
            <tbody>
              @foreach($riwayat as $survei)
                <tr>
                  <td class="text-center align-middle">{{ $survei->permohonan->id_pendaftaran }}</td>
                  <td class="text-center align-middle">{{ $survei->permohonan->user->nama }}</td>
                  <td>{{ $survei->permohonan->lokasi_jalan }}, <br>Kel. {{ $survei->permohonan->lokasi_kelurahan }}, Kec. {{ $survei->permohonan->lokasi_kecamatan }}
                  </td>                  
                  <td class="text-center align-middle">
                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailSurvei{{ $survei->id }}">
                      Lihat Detail
                    </button>
                  </td>
                </tr>
  
                {{-- Modal Edit Detail Survei --}}
                @php
                    $readonly = Auth::user()->role === 'pegawai' ? 'readonly' : '';
                    $disabled = Auth::user()->role === 'pegawai' ? 'disabled' : '';
                @endphp

                <div class="modal fade" id="detailSurvei{{ $survei->id }}" tabindex="-1" aria-labelledby="detailSurveiLabel{{ $survei->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form action="{{ route('survei.update', $survei->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Detail Hasil Survei</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Id Pendaftaran</label>
                                <input type="text" name="id_pendaftaran" class="form-control" value="{{ $survei->id_pendaftaran }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Topografi</label>
                                <input type="text" name="topografi" class="form-control" value="{{ $survei->topografi }}" required {{ $readonly }} {{ $readonly }}>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Luas Lahan</label>
                                <input type="text" name="luas_lahan" class="form-control" value="{{ $survei->luas_lahan }}" required {{ $readonly }}>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jenis Lahan</label>
                                <input type="text" name="jenis_lahan" class="form-control" value="{{ $survei->jenis_lahan }}" required {{ $readonly }}>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Pemanfaatan</label>
                                <input type="text" name="pemanfaatan" class="form-control" value="{{ $survei->pemanfaatan }}" required {{ $readonly }}>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Kondisi Sekitar</label>
                                <input type="text" name="kondisi_sekitar" class="form-control" value="{{ $survei->kondisi_sekitar }}" required {{ $readonly }}>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Peruntukan</label>
                                <input type="text" name="peruntukan" class="form-control" value="{{ $survei->peruntukan }}" required {{ $readonly }}>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Koordinat A</label>
                                <input type="text" name="koor_a" class="form-control" value="{{ $survei->koor_a }}" required {{ $readonly }}>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Koordinat B</label>
                                <input type="text" name="koor_b" class="form-control" value="{{ $survei->koor_b }}" required {{ $readonly }}>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Koordinat C</label>
                                <input type="text" name="koor_c" class="form-control" value="{{ $survei->koor_c }}" required {{ $readonly }}>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Koordinat D</label>
                                <input type="text" name="koor_d" class="form-control" value="{{ $survei->koor_d }}" required {{ $readonly }}>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Gambar Lahan</label><br>
                                @if ($survei->gambar_lahan)
                                <img src="{{ asset('storage/' . $survei->gambar_lahan) }}" alt="Gambar Lahan" class="img-fluid mb-2" style="max-height: 200px;">
                                @else
                                <p class="text-muted">Belum ada gambar</p>
                                @endif
                                <input type="file" name="gambar_lahan" class="form-control mt-2" accept="image/*" {{ $disabled }}>
                            </div>
                            </div>
                        </div>
                        @if (Auth::user()->role == 'admin')
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-warning">Update</button>
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                        @endif
                        </form>
                        {{-- @if ($survei->updated_by) --}}
                            {{-- <p class="text-muted">
                                Terakhir diubah oleh: {{ $survei->editor->name }} ({{ $survei->editor->pegawai->nama ?? '-' }})
                            </p> --}}
                        {{-- @endif --}}

                    </div>
                    </div>
                </div>
  
              @endforeach
            </tbody>
          </table>
        @endif

        @push('scripts')
              <script>
                  $(document).ready(function() {
                      $('#permohonan-table').DataTable();
                  });

                  $(document).ready(function() {
                      $('#riwayat-table').DataTable();
                  });
              </script>
        @endpush
      </div>
    </div>
  </x-app-layout>
  