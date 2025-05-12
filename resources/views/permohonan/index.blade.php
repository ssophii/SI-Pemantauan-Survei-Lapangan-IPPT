<x-app-layout>
    <div class="card w-100">
        <div class="card-body">
          @if(session('success'))
              <div class="alert alert-success">{{ session('success') }}</div>
          @endif
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h4 class="card-title"><i class="fas fa-user"></i> Data Permohonan</h4>
              <a href="{{ route('permohonan.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Permohonan
            </a>
            </div>
            <table id="permohonan" class="ui celled table" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">ID Pendaftaran</th>
                        <th class="text-center">No. Permohonan</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">No. Telepon</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permohonan as $data)
                    <tr>
                        <td class="text-center align-middle">{{ $data->id_pendaftaran }}</td>
                        <td class="text-center align-middle">{{ $data->no_surat }}</td>
                        <td class="text-center align-middle">{{ $data->user->nama }}</td>
                        <td class="text-center align-middle">{{ $data->user->no_hp }}</td>
                        <td class="text-center align-middle">{{ $data->status }}</td>
                        <td class="text-center align-middle">
                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal{{ $data->id }}">Lihat Detail</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- Modal Detail --}}
            @foreach ($permohonan as $data)
            <div class="modal fade" id="detailModal{{ $data->id }}" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <form action="{{ route('permohonan.update', $data->id) }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
                      @csrf
                      @method('PUT')
                      <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel">Detail Permohonan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      </div>
                      <div class="modal-body">
                        {{-- <input type="hidden" name="user_id" value="{{ $data->user_id }}"> --}}
                        <div class="mb-3">
                          <label>No. Surat Permohonan</label>
                          <input type="text" name="no_surat" class="form-control" value="{{ $data->no_surat }}" required>
                          <div class="invalid-feedback">Nomor surat permohonan wajib diisi.</div>
                        </div>
                        <div class="mb-3">
                          <label>Nama Pemohon</label>
                          <input type="text" name="nama" class="form-control" value="{{ $data->user->nama }}" required>
                          <div class="invalid-feedback">Nama pemohon wajib diisi.</div>
                        </div>
                        <div class="mb-3">
                          <label>Atas Nama</label>
                          <input type="text" name="atas_nama" class="form-control" value="{{ $data->atas_nama }}" nullable>
                          {{-- <div class="invalid-feedback">Atas nama wajib diisi.</div> --}}
                        </div>
                        <div class="mb-3">
                          <label>No. Telepon Pemohon</label>
                          <input type="text" name="no_hp" class="form-control" value="{{ $data->user->no_hp }}" required>
                          <div class="invalid-feedback">Nama pemohon wajib diisi.</div>
                        </div>
                        <div class="mb-3">
                          <label>Alamat Pemohon</label>
                          <input type="text" name="alamat_jalan" class="form-control" value="{{ $data->alamat_jalan }}" required>
                          <select name="alamat_kecamatan" id="kecamatan_pemohon_{{ $data->id }}" class="form-control" onchange="loadKelurahan({{ $data->id }}, 'pemohon')" required>
                            <option value="">--Pilih Kecamatan--</option>
                            <option value="Gading Cempaka" {{ $data->alamat_kecamatan == 'Gading Cempaka' ? 'selected' : '' }}>Gading Cempaka</option>
                            <option value="Kampung Melayu" {{ $data->alamat_kecamatan == 'Kampung Melayu' ? 'selected' : '' }}>Kampung Melayu</option>
                            <option value="Muara Bangkahulu" {{ $data->alamat_kecamatan == 'Muara Bangkahulu' ? 'selected' : '' }}>Muara Bangkahulu</option>
                            <option value="Ratu Agung" {{ $data->alamat_kecamatan == 'Ratu Agung' ? 'selected' : '' }}>Ratu Agung</option>
                            <option value="Ratu Samban" {{ $data->alamat_kecamatan == 'Ratu Samban' ? 'selected' : '' }}>Ratu Samban</option>
                            <option value="Selebar" {{ $data->alamat_kecamatan == 'Selebar' ? 'selected' : '' }}>Selebar</option>
                            <option value="Singaran Pati" {{ $data->alamat_kecamatan == 'Singaran Pati' ? 'selected' : '' }}>Singaran Pati</option>
                            <option value="Sungai Serut" {{ $data->alamat_kecamatan == 'Sungai Serut' ? 'selected' : '' }}>Sungai Serut</option>
                            <option value="Teluk Segara" {{ $data->alamat_kecamatan == 'Teluk Segara' ? 'selected' : '' }}>Teluk Segara</option>
                          </select>
                          <select name="alamat_kelurahan" id="kelurahan_pemohon_{{ $data->id }}" class="form-control" required>
                            <option value="{{ $data->alamat_kelurahan }}">{{ $data->alamat_kelurahan }}</option>
                          </select>
                          <div class="invalid-feedback">Alamat pemohon wajib diisi.</div>
                        </div>
                        <div class="mb-3">
                          <label>Lokasi Lahan</label>
                          <input type="text" name="lokasi_jalan" class="form-control" value="{{ $data->lokasi_jalan }}" required>
                          <select name="lokasi_kecamatan" id="kecamatan_lahan_{{ $data->id }}" class="form-control" onchange="loadKelurahan({{ $data->id }}, 'lahan')" required>
                            <option value="">--Pilih Kecamatan--</option>
                            <option value="Gading Cempaka" {{ $data->lahan_kecamatan == 'Gading Cempaka' ? 'selected' : '' }}>Gading Cempaka</option>
                            <option value="Kampung Melayu" {{ $data->lahan_kecamatan == 'Kampung Melayu' ? 'selected' : '' }}>Kampung Melayu</option>
                            <option value="Muara Bangkahulu" {{ $data->lahan_kecamatan == 'Muara Bangkahulu' ? 'selected' : '' }}>Muara Bangkahulu</option>
                            <option value="Ratu Agung" {{ $data->lahan_kecamatan == 'Ratu Agung' ? 'selected' : '' }}>Ratu Agung</option>
                            <option value="Ratu Samban" {{ $data->lahan_kecamatan == 'Ratu Samban' ? 'selected' : '' }}>Ratu Samban</option>
                            <option value="Selebar" {{ $data->lahan_kecamatan == 'Selebar' ? 'selected' : '' }}>Selebar</option>
                            <option value="Singaran Pati" {{ $data->lahan_kecamatan == 'Singaran Pati' ? 'selected' : '' }}>Singaran Pati</option>
                            <option value="Sungai Serut" {{ $data->lahan_kecamatan == 'Sungai Serut' ? 'selected' : '' }}>Sungai Serut</option>
                            <option value="Teluk Segara" {{ $data->lahan_kecamatan == 'Teluk Segara' ? 'selected' : '' }}>Teluk Segara</option>
                          </select>
                          <option value="{{ $data->lokasi_kelurahan }}">{{ $data->lokasi_kelurahan }}</option>
                          <div class="invalid-feedback">Lokasi lahan wajib diisi.</div>
                        </div>
                        <div class="mb-3">
                          <label>Luas Lahan</label>
                          <input type="text" name="luas_lahan" class="form-control" value="{{ $data->luas_lahan }}" required>
                          <div class="invalid-feedback">Luas lahan wajib diisi.</div>
                        </div>
                        <div class="mb-3">
                          <label>Penggunaan</label>
                          <input type="text" name="penggunaan" class="form-control" value="{{ $data->penggunaan }}" required>
                          <div class="invalid-feedback">Penggunaan wajib diisi.</div>
                        </div>
                        <div class="mb-3">
                          <label>Status Permohonan</label>
                          <select name="status" class="form-control" required>
                            <option value="">--Pilih--</option>
                            <option value="diterima" {{ $data->status == 'diterima' ? 'selected' : '' }}>Diterima</option>
                            <option value="ditetapkan" {{ $data->status == 'ditetapkan' ? 'selected' : '' }}>Ditetapkan</option>
                            <option value="survei" {{ $data->status == 'survei' ? 'selected' : '' }}>Survei</option>
                            <option value="laporan" {{ $data->status == 'laporan' ? 'selected' : '' }}>Laporan</option>
                            <option value="selesai" {{ $data->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                          </select>
                          <div class="invalid-feedback">Status wajib dipilih.</div>
                        </div>
                        @if ($data->file_surat)
                            <div class="mb-3">
                                <label>File Surat Saat Ini</label><br>
                                <a href="{{ asset('storage/' . $data->file_surat) }}" target="_blank" class="btn btn-sm btn-primary">
                                    Lihat File
                                </a>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label>Ganti File Surat (Opsional)</label>
                            <input type="file" name="file_surat" class="form-control" accept=".pdf,.png,.jpg,.jpeg">
                            <div class="form-text">Biarkan kosong jika tidak ingin mengganti file.</div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                      </form>
                      <form action="{{ route('permohonan.destroy', $data->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                      </form>
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach

            {{-- datatables --}}
            @push('scripts')
            <script>
                $(document).ready(function() {
                    $('#permohonan').DataTable();
                    
                });
                </script>
            @endpush

            <script>
              function loadKelurahan(id, type) {
                  const kelurahanData = {
                      "Gading Cempaka": ["Padang Harapan", "Lingkar Timur", "Kebun Tebeng"],
                      "Selebar": ["Sumber Jaya", "Pagar Dewa", "Sumber Sari"],
                  };
              
                  let kecamatan = document.getElementById('kecamatan_' + type + '_' + id).value;
                  let kelurahanSelect = document.getElementById('kelurahan_' + type + '_' + id);
              
                  kelurahanSelect.innerHTML = '<option value="">Pilih Kelurahan</option>'; // reset
              
                  if (kelurahanData[kecamatan]) {
                      kelurahanData[kecamatan].forEach(function(kel) {
                          var option = document.createElement('option');
                          option.value = kel;
                          option.text = kel;
                          kelurahanSelect.appendChild(option);
                      });
                  }
              }
            </script>
              
        </div>
    </div>
</x-app-layout>