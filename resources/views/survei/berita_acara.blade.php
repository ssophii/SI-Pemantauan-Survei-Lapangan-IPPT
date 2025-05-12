<x-app-layout>
    <div class="card">
      <div class="card-body">
        <h4 class="card-title mb-3"><i class="fas fa-file-alt"></i> Daftar Permohonan Dengan Hasil Survei </h4>
  
        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif
  
        @if($surveisBelumAdaBA->isEmpty())
          <div class="alert alert-info">Tidak ada permohonan yang menunggu nomor BA.</div>
        @else
          <table class="table table-bordered" id="ba-table">
            <thead>
              <tr>
                <th class="text-center">No. Permohonan</th>
                <th class="text-center">Nama Pemohon</th>
                <th class="text-center">Lokasi</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($surveisBelumAdaBA as $survei)
                <tr>
                  <td class="text-center align-middle">{{ $survei->permohonan->no_surat }}</td>
                  <td class="text-center align-middle">{{ $survei->permohonan->user->nama }}</td>
                  <td>{{ $survei->permohonan->lokasi_jalan }}, <br>Kel. {{ $survei->permohonan->lokasi_kelurahan }}, Kec. {{ $survei->permohonan->lokasi_kecamatan }}</td>
                  <td class="text-center align-middle">
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalBA{{ $survei->id }}">+ Nomor Berita Acara</button>
                  </td>
                </tr>
  
                <!-- Modal Tambah Nomor BA -->
                <div class="modal fade" id="modalBA{{ $survei->id }}" tabindex="-1">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <form method="POST" action="{{ route('survei.updateBA', $survei->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                          <h5 class="modal-title">Tambah Nomor Berita Acara</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                          <div class="mb-3">
                            <label class="form-label">No. Berita Acara</label>
                            <input type="text" name="no_ba" class="form-control" required>
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
  
    <!-- Riwayat BA -->
    <div class="card mt-4">
      <div class="card-body">
        <h4 class="card-title mb-3"><i class="fas fa-history"></i> Riwayat Berita Acara</h4>
        
        @if($surveisSudahAdaBA->isEmpty())
          <div class="alert alert-info">Tidak ada riwayat Berita Acara.</div>
        @else
          <table class="table table-striped" id="riwayat-ba-table">
            <thead>
              <tr>
                <th class="text-center">No. Permohonan</th>
                <th class="text-center">Nama Pemohon</th>
                <th class="text-center">Lokasi</th>
                <th class="text-center">No. BA</th>
                <th class="text-center">File BA</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($surveisSudahAdaBA as $survei)
                <tr>
                  <td class="text-center align-middle">{{ $survei->permohonan->no_surat }}</td>
                  <td class="text-center align-middle">{{ $survei->permohonan->user->nama }}</td>
                  <td>{{ $survei->permohonan->lokasi_jalan }}, Kel. {{ $survei->permohonan->lokasi_kelurahan }}, Kec. {{ $survei->permohonan->lokasi_kecamatan }}</td>
                  <td class="text-center align-middle">{{ $survei->no_ba }}</td>
                  <td class="text-center align-middle">
                    @php
                        $filename = 'ba_' . $survei->permohonan->no_surat . '.pdf';
                    @endphp
                    <a href="{{ asset('storage/ba/' . $filename) }}" target="_blank" class="btn btn-sm btn-primary">
                        Lihat File
                    </a>
                  </td>
                
                  <td class="text-center align-middle">
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditBA{{ $survei->id }}">Edit</button>
                  </td>
                </tr>
  
                <!-- Modal Edit BA -->
                <div class="modal fade" id="modalEditBA{{ $survei->id }}" tabindex="-1">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <form method="POST" action="{{ route('survei.updateBA', $survei->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                          <h5 class="modal-title">Edit Nomor Berita Acara</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                          <div class="mb-3">
                            <label class="form-label">No. Berita Acara</label>
                            <input type="text" name="no_ba" class="form-control" value="{{ $survei->no_ba }}" required>
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
            $('#ba-table').DataTable();
        });
        $(document).ready(function() {
            $('#riwayat-ba-table').DataTable();
        });
      </script>
    @endpush
  </x-app-layout>
  