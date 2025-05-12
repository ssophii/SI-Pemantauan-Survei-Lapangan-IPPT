<x-app-layout>
    <div class="card w-100">
        <div class="card-body">
            <div>
                <div>
                    <h4><i class="fas fa-archive"></i> Arsip Dokumentasi Laporan</h4>
                </div>
            </div>
    
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
    
            <table class="table table-bordered" id="arsip-table">
                <thead>
                    <tr>
                        <th class="text-center">No. Surat</th>
                        <th class="text-center">Nama Pemohon</th>
                        <th class="text-center">Lokasi Permohonan</th>
                        <th class="text-center">No. Berita Acara</th>
                        <th class="text-center">No. LHP</th>
                        <th class="text-center">File Arsip</th>
                        @if (Auth::user()->role == 'admin')
                        <th class="text-center">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($surveis as $survei)
                        <tr>
                            <td class="text-center align-middle">{{ $survei->permohonan->no_surat }}</td>
                            <td class="text-center align-middle">{{ $survei->permohonan->user->nama }}</td>
                            <td class="align-middle">{{ $survei->permohonan->lokasi_jalan }}, <br>Kel. {{ $survei->permohonan->lokasi_kelurahan }}, Kec. {{ $survei->permohonan->lokasi_kecamatan }}</td>
                            <td class="text-center align-middle">{{ $survei->no_ba }}</td>
                            <td class="text-center align-middle">{{ $survei->no_lhp }}</td>
                            <!-- Kolom Tambah Arsip -->
                            <td class="text-center align-middle">
                                @if ($survei->arsip)
                                    {{-- <a href="{{ asset('storage/' . $survei->arsip) }}" target="_blank" class="btn btn-sm btn-primary">Lihat File</a> --}}
                                    <a href="{{ asset('storage/' . Str::after($survei->arsip, 'public/')) }}" target="_blank" class="btn btn-sm btn-primary">Lihat File</a>
                                @else
                                    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalTambahArsip{{ $survei->id }}">Tambah Arsip</button>
    
                                    <!-- Modal Tambah -->
                                    <div class="modal fade" id="modalTambahArsip{{ $survei->id }}" tabindex="-1" aria-labelledby="modalTambahArsipLabel{{ $survei->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form action="{{ route('survei.storeArsip', $survei->id) }}" method="POST" enctype="multipart/form-data" class="modal-content">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalTambahArsipLabel{{ $survei->id }}">Tambah Arsip</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="file" name="arsip" class="form-control" required>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">Simpan</button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            </td>
    
                            @if (Auth::user()->role == 'admin')
                            <td class="text-center align-middle">
                                @if ($survei->arsip)
                                    <!-- Tombol Edit (modal) -->
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditArsip{{ $survei->id }}">Edit</button>
                            
                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="modalEditArsip{{ $survei->id }}" tabindex="-1" aria-labelledby="modalEditArsipLabel{{ $survei->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form action="{{ route('survei.updateArsip', $survei->id) }}" method="POST" enctype="multipart/form-data" class="modal-content">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalEditArsipLabel{{ $survei->id }}">Ganti Arsip</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="file" name="arsip" class="form-control" required>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-warning">Ganti</button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                            
                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('survei.destroyArsip', $survei->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus arsip ini?')">Hapus</button>
                                    </form>
                                @else
                                    <button class="btn btn-sm btn-secondary" disabled>Edit</button>
                                    <button class="btn btn-sm btn-secondary" disabled>Hapus</button>
                                @endif
                            </td>   
                            @endif                 
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    

    @push('scripts')
    <script>
        $(document).ready(function() {
            $('#arsip-table').DataTable();
        });
    </script>
    @endpush
</x-app-layout>