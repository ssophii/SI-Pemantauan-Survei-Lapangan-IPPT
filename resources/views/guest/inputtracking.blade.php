<x-guest-layout>
    {{-- <link href="{{ asset('assets/css/font-awesome.min.css') }}" rel="stylesheet" /> --}}
    <section class="slider_section long_section d-flex align-items-center justify-content-center" style="min-height: 100vh; background-color: #f6faff;">
      <div class="text-center w-100">
        <img src="{{ asset('assets/images/logoril.png') }}" alt="Logo" style="height: 100px; margin-bottom: 20px;">
  
        <h2 class="mb-2" style="font-weight: 600; font-size: 28px;">Pemantauan Permohonan Anda</h2>
        <p style="color: #666; font-size: 16px;">Silakan masukkan <strong>nama lengkap</strong> dan <strong>nomor HP</strong> sesuai pengajuan untuk melacak status permohonan Anda.</p>
  
        @if(session('error'))
          <div class="alert alert-danger text-center mx-auto" style="max-width: 500px;">
              {{ session('error') }}
          </div>
        @endif
  
        <div class="d-flex justify-content-center mt-4">
          <form action="{{ route('guest.tracking') }}" method="POST" class="shadow p-4 bg-white rounded" style="width: 100%; max-width: 500px;">
            @csrf
            <div class="mb-3 text-start">
              <label class="form-label">ID Pendaftaran</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" name="id_pendaftaran" id="id_pendaftaran" class="form-control" placeholder="Contoh: sp20250505001" required>
              </div>
            </div>
            <div class="text-center">
              <button class="btn btn-primary px-4" style="background-color: #f89646; border: none;">
                Lihat Status Permohonan
              </button>
            </div>
          </form>
        </div>
      </div>
    </section>
    @push('styles')
    <style>
      .form-label {
        font-weight: 500;
        margin-bottom: 5px;
      }
  
      .input-group-text {
        background-color: #f3f3f3;
        border: 1px solid #ccc;
        font-size: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 45px; /* Agar ada cukup ruang untuk ikon */
      }
  
      .input-group-text img {
        width: 18px;
        height: 18px;
        object-fit: contain;
        display: block;
      }
  
  
      .form-control {
        font-family: 'Poppins', sans-serif;
        font-size: 16px;
      }
  
      .shadow-sm {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
      }
    </style>
    @endpush
  </x-guest-layout>
  