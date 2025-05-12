<x-app-layout>
    <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    @if (Auth::user()->role == 'admin')
    <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
              <h4 class="card-title mb-0">
                  <i class="fas fa-file-alt"></i> Data SPT
              </h4>
              <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahSPT">
                  <i class="fas fa-plus"></i> Tambah SPT
              </button>
          </div>

          @if(session('success'))
              <div class="alert alert-success">{{ session('success') }}</div>
          @endif

          @if($spts->isEmpty())
              <div class="alert alert-info">Tidak SPT yang perlu ditetapkan.</div>
          @else
            <table class="table table-bordered" id="spt-table">
                <thead>
                    <tr>
                        <th class="text-center">ID Pendaftaran</th>
                        <th class="text-center">No. SPT</th>
                        <th class="text-center">Nama Pemohon</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">File SPT</th>
                        {{-- <th class="text-center">Arsip</th> --}}
                        <th class="text-center">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($spts as $spt)
                        <tr>
                            <td class="text-center align-middle">{{ $spt->permohonan->id_pendaftaran }}</td>
                            <td class="text-center align-middle">{{ $spt->no_surat }}</td>
                            <td class="text-center align-middle">{{ $spt->permohonan->user->nama }}</td>
                            <td class="text-center align-middle">{{ ucfirst($spt->status) }}</td>
                            <td class="text-center align-middle">
                                @if ($spt->file_spt)
                                    <a href="{{ asset($spt->file_spt) }}" class="btn btn-sm btn-success" target="_blank">Lihat File</a>
                                @else
                                    <span class="text-danger">Belum Ada File</span>
                                @endif
                            </td>
                            {{-- <td class="text-center align-middle">
                                @if ($spt->arsip_spt)
                                    <a href="{{ asset($spt->arsip_spt) }}" class="btn btn-sm btn-success" target="_blank">Lihat File</a>
                                @else
                                    <span class="text-danger">Belum Ada File</span>
                                @endif
                            </td> --}}
                            <td class="text-center align-middle">
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditSPT{{ $spt->id }}">Edit</button>
                                <form action="{{ route('spt.destroy', $spt->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Yakin ingin menghapus SPT ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
          @endif
          @if ($errors->any())
              <div class="alert alert-danger">
                  <ul class="mb-0">
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif


          <!-- Modal Edit SPT -->
          @foreach ($spts as $spt)
          <div class="modal fade" id="modalEditSPT{{ $spt->id }}" tabindex="-1" aria-labelledby="modalEditSPTLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{ route('spt.update', $spt->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Edit SPT</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>ID Pendaftaran</label>
                                <input type="text" name="no_surat" value="{{ $spt->permohonan->id_pendaftaran }}" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label>No Surat</label>
                                <input type="text" name="no_surat" value="{{ $spt->no_surat }}" class="form-control" required>
                            </div>
                            <div class="mb-3">
                              <label>Status</label>
                              <select name="status" class="form-control" required>
                                  <option value="peninjauan" {{ $spt->status === 'peninjauan' ? 'selected' : '' }}>Peninjauan</option>
                                  <option value="ditetapkan" {{ $spt->status === 'ditetapkan' ? 'selected' : '' }}>Ditetapkan</option>
                                  <option value="ditolak" {{ $spt->status === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                              </select>
                            </div>    
                            <div class="mb-3">
                                <label>Tanggal Pelaksanaan</label>
                                <input type="date" name="pelaksanaan" value="{{ $spt->pelaksanaan }}" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="penetapan" class="form-label">Tanggal Penetapan (Opsional)</label>
                                <input type="date" name="penetapan" class="form-control" value="{{ old('penetapan', isset($spt) ? $spt->penetapan : '') }}">
                                <small class="form-text text-muted">Biarkan kosong jika ingin otomatis ditetapkan saat status diubah ke <strong>ditetapkan</strong>.</small>
                            </div>
                              
                            <div class="mb-3">
                                <label>Pilih Pegawai</label>
                                <div class="row">
                                    @foreach ($pegawais as $pegawai)
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input type="checkbox" name="pegawai[]" value="{{ $pegawai->id }}" class="form-check-input" id="pegawaiEdit{{ $spt->id }}{{ $pegawai->id }}"
                                                    {{ $spt->pegawais && $spt->pegawais->contains($pegawai->id) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="pegawaiEdit{{ $spt->id }}{{ $pegawai->id }}">{{ $pegawai->user->nama }} ({{ $pegawai->jabatan }})</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            {{-- @if ($spt->arsip_spt)
                                <div class="mb-3">
                                    <label>File Arsip Saat Ini</label><br>
                                    <a href="{{ asset('storage/' . $spt->arsip_spt) }}" target="_blank" class="btn btn-sm btn-primary">
                                        Lihat File
                                    </a>
                                </div>
                            @endif --}}
                            <div class="mb-3">
                                <label>Unggah Arsip SPT</label>
                                <input type="file" name="file_spt" class="form-control" accept=".pdf,.png,.jpg,.jpeg">
                                <div class="form-text">Unggah hasil scan SPT</div>
                                <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti file SPT.</small>
                            </div>
                        </div>
                        <div class="alert alert-info small">
                            Jika status dipilih <strong>ditetapkan</strong> dan Anda tidak mengisi tanggal penetapan, maka sistem akan otomatis menggunakan tanggal hari ini.
                        </div>
                          
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-warning">Update</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
          </div>
          @endforeach

          <!-- Modal Tambah SPT -->
          <div class="modal fade" id="modalTambahSPT" tabindex="-1" aria-labelledby="modalTambahSPTLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                      <form action="{{ route('spt.store') }}" method="POST">
                          @csrf
                          <div class="modal-header">
                              <h5 class="modal-title">Tambah SPT</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                          </div>
                          <div class="modal-body">
                              <div class="mb-3">
                                  <label>No. SPT</label>
                                  <input type="text" name="no_surat" class="form-control" required>
                              </div>
                              <div class="mb-3">
                                <label>Status</label>
                                <select name="status" class="form-control" required>
                                    <option value="peninjauan">Peninjauan</option>
                                    <option value="ditetapkan">Ditetapkan</option>
                                    <option value="ditolak">Ditolak</option>
                                </select>
                              </div>            
                              <div class="mb-3">
                                  <label>Tanggal Pelaksanaan</label>
                                  <input type="date" name="pelaksanaan" class="form-control" required>
                              </div>
                              <div class="mb-3">
                                  <label>Permohonan</label>
                                  <select name="permohonan_id" class="form-control" required>
                                    <option value="">-- Pilih Permohonan --</option>
                                    @foreach ($permohonans as $permohonan)
                                        @if (!$spts->contains('permohonan_id', $permohonan->id))
                                            <option value="{{ $permohonan->id }}">
                                                {{ $permohonan->user->nama }} - {{ $permohonan->id_pendaftaran }}
                                            </option>
                                        @endif
                                    @endforeach
                                    {{-- @foreach ($permohonans as $permohonan)
                                        @php
                                            $sudahAdaSpt = $spts->contains('permohonan_id', $permohonan->id);
                                        @endphp
                                        <option value="{{ $permohonan->id }}" {{ $sudahAdaSpt ? 'disabled' : '' }}>
                                            {{ $permohonan->user->nama }} - {{ $permohonan->no_surat }} {{ $sudahAdaSpt ? '(Sudah ada SPT)' : '' }}
                                        </option>
                                    @endforeach --}}
                                </select>                         
                              </div>
                              <div class="mb-3">
                                  <label>Pilih Pegawai</label>
                                  <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="checkAll">
                                    <label class="form-check-label" for="checkAll">Pilih Semua</label>
                                  </div>
                                  <div class="row">
                                    @foreach ($pegawais as $pegawai)
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input type="checkbox" name="pegawai[]" value="{{ $pegawai->id }}" class="form-check-input pegawai-checkbox" id="pegawai{{ $pegawai->id }}">
                                                <label class="form-check-label" for="pegawai{{ $pegawai->id }}">{{ $pegawai->user->nama }} ({{ $pegawai->jabatan }})</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                
                                  {{-- <div class="row">
                                      @foreach ($pegawais as $pegawai)
                                          <div class="col-md-6">
                                              <div class="form-check">
                                                  <input type="checkbox" name="pegawai[]" value="{{ $pegawai->id }}" class="form-check-input" id="pegawai{{ $pegawai->id }}">
                                                  <label class="form-check-label" for="pegawai{{ $pegawai->id }}">{{ $pegawai->user->nama }} ({{ $pegawai->jabatan }})</label>
                                              </div>
                                          </div>
                                      @endforeach
                                  </div> --}}
                              </div>
                          </div>
                          <div class="modal-footer">
                              <button type="submit" class="btn btn-primary">Buat SPT</button>
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                          </div>
                      </form>
                  </div>
              </div>
        </div>
    </div>

          @push('scripts')
              <script>
                  $(document).ready(function() {
                      $('#spt-table').DataTable();
                  });

                  document.getElementById('checkAll').addEventListener('change', function() {
                        const checkboxes = document.querySelectorAll('.pegawai-checkbox');
                        checkboxes.forEach(cb => cb.checked = this.checked);
                    });
              </script>
          @endpush

        {{-- TAMPILAN KADIS --}}
        @elseif ($user->role === 'pegawai' && $jabatan === 'kadis')
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title mb-0">
                    <i class="bi bi-bookmark-x-fill"></i></i> Data SPT yang Belum Ditetapkan
                </h4>
            </div>
            <table class="table table-bordered" id="spt-belum-ditetapkan-table">
                <thead>
                    <tr>
                        <th class="text-center">ID Pendaftaran</th>
                        <th class="text-center">No. SPT</th>
                        <th class="text-center">Nama Pemohon</th>
                        <th class="text-center">Lokasi</th>
                        <th class="text-center">File</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($spts->where('status', 'peninjauan') as $spt)
                        <tr>
                            <td class="text-center align-middle">{{ $spt->permohonan->id_pendaftaran }}</td>
                            <td class="text-center align-middle">{{ $spt->no_surat }}</td>
                            <td class="text-center align-middle">{{ $spt->permohonan->user->nama }}</td>
                            <td >{{ $spt->permohonan->lokasi_jalan}}, <br>Kel. {{ $spt->permohonan->lokasi_kelurahan }}, Kec. {{ $spt->permohonan->lokasi_kecamatan }}</td>
                            <td class="text-center align-middle">
                                @if ($spt->file_spt)
                                    <a href="{{ asset($spt->file_spt) }}" class="btn btn-sm btn-success" target="_blank">Lihat File</a>
                                @else
                                    <span class="text-danger">Belum Ada File</span>
                                @endif
                            </td>
                            <td class="text-center align-middle">
                                <form action="{{ route('spt.ditetapkan', $spt->id) }}" method="POST" onsubmit="return confirm('Tetapkan SPT ini?')">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-primary btn-sm">Tetapkan SPT</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title mb-0">
                    <i class="bi bi-bookmark-check-fill"></i> Data SPT yang Sudah Ditetapkan
                </h4>
            </div>
            <table class="table table-striped" id="spt-ditetapkan-table">
                <thead>
                    <tr>
                        <th class="text-center">ID Pendaftaran</th>
                        <th class="text-center">No. Surat</th>
                        <th class="text-center">Nama Pemohon</th>
                        <th class="text-center">Lokasi</th>
                        <th class="text-center">File</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($spts->where('status', 'ditetapkan') as $spt)
                        <tr>
                            <td class="text-center align-middle">{{ $spt->permohonan->id_pendaftaran }}</td>
                            <td class="text-center align-middle">{{ $spt->no_surat }}</td>
                            <td class="text-center align-middle">{{ $spt->permohonan->user->nama }}</td>
                            <td >{{ $spt->permohonan->lokasi_jalan}}, <br>Kel. {{ $spt->permohonan->lokasi_kelurahan }}, Kec. {{ $spt->permohonan->lokasi_kecamatan }}</td>
                            <td class="text-center align-middle">
                                @if ($spt->file_spt)
                                    <a href="{{ asset($spt->file_spt) }}" class="btn btn-sm btn-success" target="_blank">Lihat File</a>
                                @else
                                    <span class="text-danger">Belum Ada File</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
          </div>
        </div>
            @push('scripts')
              <script>
                  $(document).ready(function() {
                      $('#spt-belum-ditetapkan-table').DataTable();
                  });
                  $(document).ready(function() {
                      $('#spt-ditetapkan-table').DataTable();
                  });
              </script>
            @endpush

        {{-- TAMPILAN PEGAWAI EXP. KADIS --}}
        @elseif ($user->role === 'pegawai' && $jabatan !== 'kadis')
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title mb-0">
                    <i class="fas fa-file-alt"></i> Data SPT yang Ditugaskan
                </h4>
            </div>
            <table class="table table-bordered" id="spt-pegawai-table">
                <thead>
                    <tr>
                        <th class="text-center">ID Pendaftaran</th>
                        <th class="text-center">No. Surat</th>
                        <th class="text-center">Nama Pemohon</th>
                        <th class="text-center">Lokasi</th>
                        <th class="text-center">File</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($spts->where('status', 'ditetapkan') as $spt)
                        @if ($spt->pegawais->contains('id', $user->pegawai->id))
                            <tr>
                                <td>{{ $spt->permohonan->id_pendaftaran }}</td>
                                <td>{{ $spt->no_surat }}</td>
                                <td>{{ $spt->permohonan->user->nama }}</td>
                                <td>{{ $spt->permohonan->lokasi_jalan}}, <br>Kel. {{ $spt->permohonan->lokasi_kelurahan }}, Kec. {{ $spt->permohonan->lokasi_kecamatan }}</td>
                                <td>
                                    @if ($spt->file_spt)
                                        <a href="{{ asset($spt->file_spt) }}" class="btn btn-sm btn-success" target="_blank">Lihat File</a>
                                    @else
                                        <span class="text-danger">Belum Ada File</span>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            @push('scripts')
              <script>
                  $(document).ready(function() {
                      $('#spt-pegawai-table').DataTable();
                  });
              </script>
            @endpush
          </div>
        </div>
        @endif
</x-app-layout>
