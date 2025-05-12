<x-guest-layout>
    <div class="container text-center my-5">
        <img src="{{ asset('assets/images/notfound.png') }}" alt="Not Found" style="max-width: 300px;">
        <h2 class="mt-4">Data Tidak Ditemukan</h2>
        <p class="text-muted mb-4">Kami tidak dapat menemukan permohonan berdasarkan nama dan nomor HP yang Anda masukkan. <br> Pastikan data Anda sudah benar, atau ajukan kembali permohonan jika diperlukan.</p>
        
        <a href="{{ url('/about') }}" class="btn btn-primary">Coba Lagi</a>
    </div>

    <style>
        img {
            opacity: 0.8;
        }
    </style>
</x-guest-layout>
