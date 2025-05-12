<x-app-layout>
    <div class="card w-100">
        <div class="card-body">
            {{-- <h4 class="card-title"><i class="fas fa-user"></i>Data Pegawai</h4> --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title mb-0">
                    <i class="fas fa-user"></i> Data Pegawai
                </h4>
                <!-- Tombol trigger modal -->
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahPegawai">
                    <i class="fas fa-plus"></i> Tambah Anggota
                </button>
            </div>
            
            
            <!-- Modal Tambah -->
            <div class="modal fade" id="modalTambahPegawai" tabindex="-1" aria-labelledby="modalTambahPegawaiLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form action="{{ route('pegawai.store') }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalTambahPegawaiLabel">Tambah Data Pegawai</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="">Nama Pegawai</label>
                                    <input type="text" name="nama" class="form-control" placeholder="masukkan nama pegawai" required>
                                    <div class="invalid-feedback">Nama pegawai wajib diisi</div>
                                </div>
                                <div class="mb-3">
                                    <label for="">NIP</label>
                                    <input type="text" name="nip" class="form-control" placeholder="masukkan nip pegawai" nullable>
                                    {{-- <div class="invalid-feedback">NIP pegawai wajib diisi</div> --}}
                                </div>
                                <div class="mb-3">
                                    <label for="">Jabatan</label>
                                    <select name="jabatan" class="form-control" required>
                                        <option value="">---Pilih--</option>
                                        <option value="kadis">Kepala Dinas</option>
                                        <option value="kabid">Kepala Bidang</option>
                                        <option value="penata">Penata Pertanahan</option>
                                        <option value="analis">Analis Pertanahan</option>
                                        <option value="pengelola">Pengelola Pemanfaatan Barang Milik Negara</option>
                                        <option value="ptt">PTT</option>
                                    </select>
                                    <div class="invalid-feedback"> Jabatan pegawai wajib diisi</div>
                                </div>
                                <div class="mb-3">
                                    <label for="">Email</label>
                                    <input type="mail" name="email" class="form-control" placeholder="masukkan email pegawai" required>
                                    <div class="invalid-feedback">email pegawai wajib diisi</div>
                                </div>
                                <div class="mb-3">
                                    <label for="">password</label>
                                    <input type="text" name="password" class="form-control" placeholder="masukkan password pegawai" required>
                                    <div class="invalid-feedback">password pegawai wajib diisi</div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @php
                $jabatanLabels = [
                    'kadis' => 'Kepala Dinas',
                    'kabid' => 'Kepala Bidang',
                    'penata' => 'Penata Pertanahan',
                    'analis' => 'Analis Pertanahan',
                    'pengelola' => 'Pengelola Pemanfaatan Barang Milik Negara',
                    'ptt' => 'PTT',
                ];
            @endphp

            <table id="pegawai" class="ui celled table" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>Jabatan</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pegawai as $data)
                    <tr>
                        <td>{{ $data->id }}</td>
                        <td>{{ $data->user->nama }}</td>
                        <td>{{ $data->nip }}</td>
                        <td>{{ $jabatanLabels[$data->jabatan] ?? $data->jabatan }}</td>
                        <td>
                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal{{ $data->id }}">Lihat Detail</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- Modal Detail --}}
            @foreach ($pegawai as $data)
            <div class="modal fade" id="detailModal{{ $data->id }}" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form action="{{ route('pegawai.update', $data) }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title" id="detailModalLabel">Detail Pegawai</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label>Nama Pegawai</label>
                                    <input type="text" name="nama" class="form-control" value="{{ $data->user->nama }}" required>
                                    <div class="invalid-feedback">Nama pegawai wajib diisi</div>
                                </div>
                                <div class="mb-3">
                                    <label for="">NIP</label>
                                    <input type="text" name="nip" class="form-control" value="{{ $data->nip }}" placeholder="masukkan nip pegawai" nullable>
                                    {{-- <div class="invalid-feedback">NIP pegawai wajib diisi</div> --}}
                                </div>
                                <div class="mb-3">
                                    <label for="">Jabatan</label>
                                    <select name="jabatan" class="form-control" required>
                                        <option value="">---Pilih--</option>
                                        <option value="kadis" {{ $data->jabatan == 'kadis' ? 'selected' : '' }}>Kepala Dinas</option>
                                        <option value="kabid" {{ $data->jabatan == 'kabid' ? 'selected' : '' }}>Kepala Bidang</option>
                                        <option value="penata" {{ $data->jabatan == 'penata' ? 'selected' : '' }}>Penata Pertanahan</option>
                                        <option value="analis" {{ $data->jabatan == 'analis' ? 'selected' : '' }}>Analis Pertanahan</option>
                                        <option value="pengelola" {{ $data->jabatan == 'pengelola' ? 'selected' : '' }}>Pengelola Pemanfaatan Barang Milik Negara</option>
                                        <option value="ptt" {{ $data->jabatan == 'ptt' ? 'selected' : '' }}>PTT</option>
                                    </select>
                                    <div class="invalid-feedback"> Jabatan pegawai wajib diisi</div>
                                </div>
                                <div class="mb-3">
                                    <label for="">Email</label>
                                    <input type="mail" name="email" value="{{ $data->user->email }}" class="form-control" placeholder="masukkan email pegawai" required>
                                    <div class="invalid-feedback">email pegawai wajib diisi</div>
                                </div>
                                <div class="mb-3">
                                    <label for="">Ganti password</label>
                                    <input type="text" name="password" class="form-control" placeholder="kosongkan jika tidak ingin mengganti password">
                                    <div class="form-text">Kosongkan jika tidak ingin mengganti password</div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                                </form>
                                <form action="{{ route('pegawai.destroy', $data->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type= "submit" class="btn btn-danger">Hapus</button>
                                </form>
                                <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            @endforeach

            {{-- datatables --}}
            @push('scripts')
            <script>
                $(document).ready(function() {
                    $('#pegawai').DataTable();
                    
                });
                </script>
            @endpush
        </div>
    </div>
</x-app-layout>