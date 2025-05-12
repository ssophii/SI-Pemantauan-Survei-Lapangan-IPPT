<x-app-layout>
    <div class="card w-100">
        <div class="card-body">
            @if(session('success'))
              <div class="alert alert-success">{{ session('success') }}</div>
          @endif
            <h4 class="card-title"><i class="fas fa-user"></i> Form Penambahan Data Permohonan</h4>
            {{-- <h5 class="card-subtitle mb-4 mt-3">DATA permohonan</h5> --}}
            <form class="needs-validation" novalidate action="{{ route('permohonan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label>Nama *</label>
                    <input type="text" name="nama" class="form-control" placeholder="masukkan nama pemohon" required>
                    <div class="invalid-feedback"> Nama wajib diisi. </div>
                </div>
                <div class="form-group">
                    <label>Atas Nama</label>
                    <input type="text" name="atas_nama" class="form-control" placeholder="kosongkan jika tidak mewakili siapapun" nullable>
                    {{-- <div class="invalid-feedback"> Nama wajib diisi. </div> --}}
                </div>
                <div class="form-group">
                    <label for="">No. Telepon *</label>
                    <input type="number" name="no_hp" class="form-control" placeholder="masukkan nomor telepon pemohon" required>
                    <div class="invalid-feedback"> Nomor telepon wajib diisi. </div>
                </div>
                <div class="form-group">
                    <label>Alamat Pemohon*</label>
                    <input name="alamat_jalan" class="form-control"  placeholder="* isikan nama jalan alamat pemohon" required></input>
                    <select name="alamat_kecamatan" class="form-control" id="kecamatan_pemohon" onchange="loadKelurahan('pemohon')" required>
                        <option value="">Pilih Kecamatan</option>
                        <option value="Gading Cempaka">Gading Cempaka</option>
                        <option value="Kampung Melayu">Kampung Melayu</option>
                        <option value="Muara Bangkahulu">Muara Bangkahulu</option>
                        <option value="Ratu Agung">Ratu Agung</option>
                        <option value="Ratu Samban">Ratu Samban</option>
                        <option value="Selebar">Selebar</option>
                        <option value="Singaran Pati">Singaran Pati</option>
                        <option value="Sungai Serut">Sungai Serut</option>
                        <option value="Teluk Segara">Teluk Segara</option>
                    </select>
                    <select name="alamat_kelurahan" class="form-control" id="kelurahan_pemohon" required>
                        <option value="">Pilih Kelurahan</option>
                    </select>
                    <div class="invalid-feedback"> Alamat pemohon wajib diisi. </div>
                </div>
                <div class="form-group">
                    <label>Lokasi Lahan *</label>
                    <input type="text" name="lokasi_jalan" class="form-control" placeholder="isikan nama jalan lokasi lahan" required>
                    <select name="lokasi_kecamatan" class="form-control" id="kecamatan_lahan" onchange="loadKelurahan('lahan')" required>
                        <option value="">Pilih Kecamatan</option>
                        <option value="Gading Cempaka">Gading Cempaka</option>
                        <option value="Kampung Melayu">Kampung Melayu</option>
                        <option value="Muara Bangkahulu">Muara Bangkahulu</option>
                        <option value="Ratu Agung">Ratu Agung</option>
                        <option value="Ratu Samban">Ratu Samban</option>
                        <option value="Selebar">Selebar</option>
                        <option value="Singaran Pati">Singaran Pati</option>
                        <option value="Sungai Serut">Sungai Serut</option>
                        <option value="Teluk Segara">Teluk Segara</option>
                    </select>
                    <select name="lokasi_kelurahan" class="form-control" id="kelurahan_lahan" required>
                        <option value="">Pilih Kelurahan</option>
                    </select>
                    <div class="invalid-feedback"> Lokasi lahan wajib diisi. </div>
                </div>
                <div class="form-group">
                    <label>Luas Lahan *</label>
                    <input name="luas_lahan" type="number" class="form-control" placeholder="m2" required>
                    <div class="invalid-feedback"> Luas lahan wajib diisi. </div>
                </div>
                <div class="form-group">
                    <label>Penggunaan Lahan Saat Ini*</label>
                    <input type="text" name="penggunaan" class="form-control" placeholder="masukkan penggunaan lahan saat ini" required>
                    <div class="invalid-feedback"> Penggunaan lahan saat ini wajib diisi. </div>
                </div>
                <div class="form-group">
                    <label>kepemilikan*</label>
                    <input type="text" name="kepemilikan" class="form-control" placeholder="masukkan penggunaan lahan saat ini" required>
                    <div class="invalid-feedback"> Penggunaan lahan saat ini wajib diisi. </div>
                </div>
                <div class="form-group">
                    <label>Status Permohonan</label>
                    <select name="status" class="form-control" required>
                        <option value="">--Pilih--</option>
                        <option value="diterima">Diterima</option>
                        <option value="ditetapkan">Ditetapkan</option>
                        <option value="survei">Survei</option>
                        <option value="laporan">Laporan</option>
                        <option value="selesai">Selesai</option>
                    </select>
                    <div class="invalid-feedback"> Status permohonan wajib diisi. </div>
                </div>
                <div class="form-group">
                    <label>No. Surat Permohonan</label>
                    <input type="text"  name="no_surat" class="form-control" required>
                    <div class="invalid-feedback"> Nomor surat permohonan wajib diisi. </div>
                </div>
                <div>
                    <label for="file" class="block mb-2">Upload File</label>
                    <input type="file" name="file_surat" class="w-full p-2 border rounded" required>
                    <div class="invalid-feedback"> File surat permohonan wajib diunggah. </div>
                </div>
                
                <button type="submit" class="btn btn-primary">create</button>
            </form>
        </div>
    </div>    

    <script>
        // Bootstrap 5 form validation
        (() => {
          'use strict'
    
          const forms = document.querySelectorAll('.needs-validation')
    
          Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
              if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
              }
    
              form.classList.add('was-validated')
            }, false)
          })
        })()

        function loadKelurahan(type) {
            const kelurahanData = {
                "Gading Cempaka": ["Cempaka Permai", "Jalan Gedang", "Lingkar Barat", "Padang Harapan", "Sido Mulyo"],
                "Kampung Melayu": ["Kandang", "Kandang Mas", "Muara Dua", "Padang Serai", "Sumber Jaya", "Teluk Sepang"],
                "Muara Bangkahulu": ["Bentiring", "Bentiring Permai", "Bentiring Raya", "Kandang Limun", "Pematang Gubernur", "Rawa Makmur", "Rawa Makmur Permai"],
                "Ratu Agung": ["Kebun Beler", "Kebun Kenanga", "Lempuing", "Nusa Indah", "Sawah Lebar", "Sawah Lebar Baru", "Tanah Patah"],
                "Ratu Samban": ["Anggut Atas", "Anggut Bawah", "Anggut Dalam", "Belakang Pondok", "Kebun Dahri", "Kebun Geran", "Padang Jati", "Penggantungan", "Penurunan"],
                "Selebar": ["Betungan", "Bumi Ayu", "Pagar Dewa", "Pekan Sabtu", "Sukarami", "Sumur Dewa"],
                "Singaran Pati": ["Dusun Besar", "Jembatan Kecil", "Lingkar Timur", "Padang Nangka", "Panorama", "Timur Indah"],
                "Sungai Serut": ["Kampung Kelawi", "Pasar Bengkulu", "Semarang", "Surabaya", "Suka Merindu", "Tanjung Agung", "Tanjung Jaya"],
                "Teluk Segara": ["Bajak", "Berkas", "Jitra" , "Kampung Bali", "Kebun Keling", "Kebun Ros", 'Malabero', "Pasar Baru", "Pasar Melintang", "Pintu Batu", "Pondok Besi", "Sumur Melele", "Tengah Padang"]
            };

            let kecamatan = document.getElementById('kecamatan_' + type).value;
            let kelurahanSelect = document.getElementById('kelurahan_' + type);

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
    
</x-app-layout>

