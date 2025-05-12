<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
    <title>Login - Survei Tanah IPPT</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/LOGOBKL.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('assets/css/style.min.css') }}" rel="stylesheet">
</head>

<body style="background-color: #f4f6f9;">
    <div class="container d-flex align-items-center justify-content-center vh-100">
        <div class="card shadow-lg p-4" style="width: 100%; max-width: 400px; border-radius: 1rem;">
            <div class="text-center mb-4">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" width="60">
                <h4 class="mt-3">Login Pegawai</h4>
                <p class="text-muted mb-0">Survei Tanah - IPPT Kota Bengkulu</p>
            </div>
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email / Username</label>
                    <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Kata Sandi</label>
                    <input id="password" class="form-control" type="password" name="password" required>
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3 form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Ingat saya</label>
                </div>

                <div class="d-grid mb-2">
                    <button type="submit" class="btn btn-primary">Masuk</button>
                </div>

                {{-- @if (Route::has('password.request'))
                    <div class="text-center">
                        <a class="text-decoration-none" href="{{ route('password.request') }}">
                            Lupa kata sandi?
                        </a>
                    </div>
                @endif --}}
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
