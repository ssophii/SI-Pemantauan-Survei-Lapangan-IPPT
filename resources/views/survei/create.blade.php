<x-app-layout>
    <div class="card">
      <div class="card-body">
        <h4 class="card-title mb-4"><i class="fas fa-plus-circle"></i> Tambah Hasil Survei</h4>
  
        <form action="{{ route('survei.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="permohonan_id" value="{{ $permohonan->id }}">
  
          <div class="mb-3">
            <label>ID_Pendaftaran</label>
            <input type="text" name="id_pendaftaran" value="{{ $permohonan->id_pendaftaran }}" class="form-control" readonly>
          </div>
  
          <div class="mb-3">
            <label>Nama Pemohon</label>
            <input type="text" name="nama" value="{{ $permohonan->user->nama }}" class="form-control" readonly>
          </div>
  
          <div class="mb-3">
            <label>Topografi</label>
            <input type="text" name="topografi" class="form-control" required>
          </div>
  
          <div class="mb-3">
            <label>Gambar Lahan</label>
            <input type="file" name="gambar_lahan" class="form-control" accept="image/*">
          </div>
  
          <div class="row">
            <div class="col-md-6 mb-3">
              <label>Luas Lahan</label>
              <input type="number" name="luas_lahan" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
              <label>Jenis Lahan</label>
              <input type="text" name="jenis_lahan" class="form-control" required>
            </div>
          </div>
  
          <div class="mb-3">
            <label>Pemanfaatan</label>
            <input type="text" name="pemanfaatan" class="form-control" required>
          </div>
  
          <div class="mb-3">
            <label>Kondisi Sekitar</label>
            <input type="text" name="kondisi_sekitar" class="form-control" required>
          </div>
  
          <div class="row">
            <div class="col-md-3 mb-3">
              <label>Koordinat A</label>
              <input type="text" name="koor_a" class="form-control" required>
            </div>
            <div class="col-md-3 mb-3">
              <label>Koordinat B</label>
              <input type="text" name="koor_b" class="form-control" required>
            </div>
            <div class="col-md-3 mb-3">
              <label>Koordinat C</label>
              <input type="text" name="koor_c" class="form-control" required>
            </div>
            <div class="col-md-3 mb-3">
              <label>Koordinat D</label>
              <input type="text" name="koor_d" class="form-control" required>
            </div>
          </div>
  
          <div class="mb-3">
            <label>Peruntukan</label>
            <input type="text" name="peruntukan" class="form-control" required>
          </div>
  
          <div class="text-end">
            <button type="submit" class="btn btn-success">Simpan Survei</button>
            <a href="{{ route('survei.index') }}" class="btn btn-secondary">Kembali</a>
          </div>
        </form>
      </div>
    </div>
  </x-app-layout>
  