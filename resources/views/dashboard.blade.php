<x-app-layout>

    <div class="col-7 align-self-center">
        <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Selamat Datang {{ Auth::user()->nama }}</h3>
        {{-- <h5>{{ Auth::user()->pegawai()->jabatan }}</h5> --}}
        <div class="d-flex align-items-center">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-0 p-0">
                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</x-app-layout>
