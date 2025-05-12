<x-app-layout>
    {{-- <div class="container py-4"> --}}
        <h2 class="mb-4" style="color: #6474e4; font-family: sans-serif">SI Pemantauan Proses Survei Lapangan IPPT</h2>
    
        {{-- Total Permohonan --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="card text-bg-dark shadow-lg rounded-4">
                    <div class="card-body text-center">
                        <h5 class="card-title text-uppercase" style="color: #fff; font-size: large;">Total Permohonan</h5>
                        <p class="display-4 fw-bold mb-0">{{ $stats['total'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    
        {{-- Status Breakdown --}}
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-3 mb-5">
            @foreach(['diterima', 'ditetapkan', 'survei', 'laporan', 'selesai'] as $status)
            <div class="col">
                <div class="card border-start border-4 shadow-sm h-100 rounded-3 border-primary-subtle">
                    <div class="card-body text-center d-flex flex-column justify-content-center">
                        <h5 class="text-capitalize text-secondary mb-2" style="font-weight: 600;">{{ $status }}</h5>
                        <p class="display-6 fw-bold text-primary mb-0">{{ $stats[$status] ?? 0 }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
    
        {{-- Filter Form --}}
        <form method="GET" action="{{ route('dashboard.index') }}" class="mb-4">
            <div class="row g-3 align-items-end">
                <div class="col-sm-4">
                    <label for="start_date" class="form-label">Mulai Tanggal</label>
                    <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="form-control">
                </div>
                <div class="col-sm-4">
                    <label for="end_date" class="form-label">Sampai Tanggal</label>
                    <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="form-control">
                </div>
                <div class="col-sm-4 d-grid">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>
    
        {{-- Breakdown per Kecamatan --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-body-secondary fw-bold">Jumlah Permohonan per Kecamatan</div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse ($perKecamatan as $kecamatan => $jumlah)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{{ $kecamatan }}</span>
                        <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">{{ $jumlah }}</span>
                    </li>
                    @empty
                    <li class="list-group-item text-muted text-center">Tidak ada data.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    {{-- </div> --}}
    {{-- <div class="container py-4">
        <h1 class="mb-4">📊 Dashboard Permohonan</h1>
    
        <!-- Filter tanggal -->
        <form method="GET" class="row g-3 align-items-end mb-4">
            <div class="col-md-3">
                <label for="start_date" class="form-label">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ $start }}" class="form-control">
            </div>
            <div class="col-md-3">
                <label for="end_date" class="form-label">Tanggal Selesai</label>
                <input type="date" name="end_date" value="{{ $end }}" class="form-control">
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100" type="submit">Filter</button>
            </div>
        </form>
    
        <!-- Statistik Status -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-dark text-white shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title fs-5">Total Permohonan</h5>
                        <p class="display-6 fw-bold">{{ $stats['total'] }}</p>
                    </div>
                </div>
            </div>
    
            @foreach (['diterima', 'ditetapkan', 'survei', 'laporan', 'selesai'] as $status)
                <div class="col-md-2">
                    <div class="card shadow-sm border-start border-4 border-{{ 
                        $status === 'selesai' ? 'success' : 
                        ($status === 'laporan' ? 'info' : 
                        ($status === 'survei' ? 'warning' : 
                        ($status === 'ditetapkan' ? 'primary' : 'secondary')))
                    }}">
                        <div class="card-body text-center">
                            <h6 class="text-capitalize mb-1">{{ $status }}</h6>
                            <p class="h5">{{ $stats[$status] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    
        <!-- Breakdown per Kecamatan -->
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">📍 Breakdown Permohonan per Kecamatan</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Kecamatan</th>
                            <th scope="col">Jumlah Permohonan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($perKecamatan as $kecamatan => $jumlah)
                            <tr>
                                <td>{{ $kecamatan }}</td>
                                <td>{{ $jumlah }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted">Tidak ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div> --}}
</x-app-layout>