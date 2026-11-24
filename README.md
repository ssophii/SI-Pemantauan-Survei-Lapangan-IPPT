# SI Pemantauan Survei Lapangan IPPT

Sistem informasi berbasis web untuk memantau proses survei lapangan Izin Penggunaan Pemanfaatan Tanah (IPPT) pada Bidang Pertanahan, Dinas Perumahan, Kawasan Permukiman, dan Pertanahan (Disperkimtan) Kota Bengkulu.

Proses IPPT yang sebelumnya dicatat manual, mulai dari pemasukan berkas, penerbitan Surat Perintah Tugas (SPT), survei lapangan, sampai laporan hasil pemeriksaan, kini terdokumentasi dalam satu sistem. Pemohon juga bisa melacak status permohonannya sendiri tanpa datang ke kantor. Pengguna sistem: **Admin**, **Pegawai**, dan **Pemohon**.

> Dikembangkan sebagai proyek Kerja Praktik, Program Studi Teknik Informatika, Universitas Bengkulu (2025).

## Fitur

**Pemohon (tanpa login)**
- Pelacakan status permohonan dengan memasukkan ID Pendaftaran
- Lima tahap progres: Diterima, Penetapan Survei, Survei, Penyusunan Laporan, Selesai
- Unduh dokumen laporan survei (Berita Acara dan Laporan Hasil Pemeriksaan) setelah permohonan selesai

**Admin dan Pegawai (login dengan email dan password)**
- Autentikasi dan pembagian hak akses berdasarkan peran
- Dashboard: total permohonan, rekap per status, rekap per kecamatan, dan filter tanggal
- Manajemen data permohonan: tambah, lihat, ubah, hapus (Admin)
- Manajemen Surat Perintah Tugas (SPT) dan data pegawai: Admin mengelola, Pegawai hanya melihat
- Input hasil survei lapangan (topografi, luas dan jenis lahan, pemanfaatan, kondisi sekitar, koordinat, peruntukan, gambar lahan) oleh Admin dan Pegawai yang tertera di SPT, plus riwayat survei
- Pembuatan dokumen Berita Acara dan Laporan Hasil Pemeriksaan (LHP) otomatis dalam format PDF setelah nomor laporan diisi
- Unggah hasil scan dokumen final, dan status permohonan otomatis menjadi "Selesai"

## Teknologi

- **Backend:** Laravel 11 (PHP), Composer
- **Frontend:** Vite, Tailwind CSS, PostCSS
- **Database:** MySQL
- **PDF:** DomPDF
- **Pengujian:** PHPUnit, black-box testing
- **Lingkungan pengembangan:** Laragon, Visual Studio Code

## Prasyarat

- PHP 8.2 
- Composer
- Node.js 
- MySQL 

## Instalasi

```bash
git clone https://github.com/ssophii/SI-Pemantauan-Survei-Lapangan-IPPT.git
cd SI-Pemantauan-Survei-Lapangan-IPPT

composer install
copy .env.example .env          # Mac/Linux: cp .env.example .env
php artisan key:generate
```

Buat database kosong di MySQL, lalu isi pengaturan database di file `.env`:

```env
DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=
```

Lanjutkan:

```bash
php artisan migrate --seed
npm install
npm run dev
php artisan serve               # buka http://127.0.0.1:8000
```

<!-- ISI jika ada: akun demo, mis. email/password admin dari seeder -->

## Alur Proses

1. **Diterima**: Admin menginput permohonan dan sistem menerbitkan ID Pendaftaran.
2. **Penetapan Survei**: Admin menerbitkan SPT dan menugaskan pegawai.
3. **Survei**: Pegawai atau Admin menginput hasil survei lapangan.
4. **Penyusunan Laporan**: Admin mengisi nomor Berita Acara dan LHP, lalu dokumen PDF tergenerate otomatis.
5. **Selesai**: Hasil scan dokumen diunggah, dan pemohon bisa mengunduh laporan lewat halaman pelacakan.




Sophina Shafa Salsabila - [@ssophii](https://github.com/ssophii)
Proyek pembelajaran/portofolio (Kerja Praktik).
