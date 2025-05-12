<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/LOGOBKL.png') }}">
    <title>Survei Tanah - IPPT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- Custom CSS -->
    <link href="{{ asset('assets/extra-libs/c3/c3.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/libs/chartist/dist/chartist.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/extra-libs/jvector/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />
    <!-- Custom CSS -->
    <link href="{{ asset('assets/css/style.min.css') }}" rel="stylesheet">
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar" data-navbarbg="skin6">
            <nav class="navbar top-navbar navbar-expand-md">
                <div class="navbar-header" data-logobg="skin6">
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                            class="ti-menu ti-close"></i></a>
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <div class="navbar-brand">
                        <!-- Logo icon -->
                        <a href="{{ url('/dashboard') }}">
                            {{-- <img src="assets/images/KIMTAN.png" alt="homepage" class="dark-logo" /> --}}
                            <b class="logo-icon">
                                <!-- Dark Logo icon -->
                                <img src="{{ asset('assets/images/logo.png') }}" alt="homepage" class="dark-logo" />
                                <!-- Light Logo icon -->
                                {{-- <img src="assets/images/logo.png" alt="homepage" class="light-logo" /> --}}
                            </b>
                            <!--End Logo icon -->
                            <!-- Logo text -->
                            <span class="logo-text">
                                <!-- dark Logo text -->
                                <img src="{{ asset('assets/images/text.png') }}" alt="homepage" class="dark-logo" />
                                <!-- Light Logo text -->
                                {{-- <img src="assets/images/text.png" class="light-logo" alt="homepage" /> --}}
                            </span>
                        </a>
                    </div>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Toggle which is visible on mobile only -->
                    <!-- ============================================================== -->
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                        data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i
                            class="ti-more"></i></a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav float-right ml-auto mr-3 pr-1">
                        @php
                            $unreadCount = \App\Models\Notification::where('user_id', Auth::id())->where('is_read', false)->count();
                            $notifications = \App\Models\Notification::where('user_id', Auth::id())->latest()->take(5)->get();
                        @endphp

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle position-relative" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i data-feather="bell"></i>
                                @if ($unreadCount > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $unreadCount }}
                                    </span>
                                @endif
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notifDropdown" style="width: 300px;">
                                <li class="dropdown-header fw-bold">Notifikasi</li>
                                @forelse ($notifications as $notif)
                                    <li>
                                        <a href="{{ route('notifications.read', $notif->id) }}" class="dropdown-item small {{ $notif->is_read ? '' : 'fw-bold' }}">
                                            {{ $notif->title }}
                                            <div class="text-muted small">{{ \Illuminate\Support\Str::limit($notif->message, 50) }}</div>
                                        </a>
                                    </li>
                                @empty
                                    <li><span class="dropdown-item small text-muted">Tidak ada notifikasi</span></li>
                                @endforelse
                                <li><hr class="dropdown-divider"></li>
                                <li><a href="{{ route('notifications.index') }}" class="dropdown-item text-center">Lihat Semua</a></li>
                            </ul>
                        </li>       

                        <li class="nav-item d-flex align-items-center">
                            <span class="nav-link d-none d-lg-inline-block">
                                Halo, <span class="text-dark fw-semibold">{{ Auth::user()->nama }}</span>
                            </span>
                            <form method="POST" action="{{ route('logout') }}" class="ms-2">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger">Logout</button>
                            </form>
                        </li>
                    </ul>
                    
                    
                </div>
                
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar" data-sidebarbg="skin6">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar" data-sidebarbg="skin6">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="/dashboard"
                                aria-expanded="false"><i data-feather="home" class="feather-icon"></i><span
                                    class="hide-menu">Dashboard</span></a>
                        </li>

                        @if (Auth::user()->role == 'admin')
                        <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                            aria-expanded="false"><i data-feather="file-text" class="feather-icon"></i><span
                            class="hide-menu">Permohonan</span></a>
                            <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                <li class="sidebar-item"><a href="/permohonan/create" class="sidebar-link"><span
                                    class="hide-menu"> Tambah Permohonan
                                    </span></a>
                                </li>
                                <li class="sidebar-item"><a href="/permohonan" class="sidebar-link"><span
                                    class="hide-menu"> Data Permohonan
                                    </span></a>
                                </li>
                            </ul>
                        </li>
                        @endif

                        <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                aria-expanded="false"><i data-feather="file-text" class="feather-icon"></i><span
                                    class="hide-menu">Perintah Tugas</span></a>
                            <ul aria-expanded="false" class="collapse  first-level base-level-line">
                                <li class="sidebar-item"><a href="/spt/index" class="sidebar-link"><span
                                            class="hide-menu"> Surat Perintah Tugas
                                        </span></a>
                                </li>
                                @if (Auth::user()->role == 'admin')
                                <li class="sidebar-item"><a href="/pegawai" class="sidebar-link"><span
                                    class="hide-menu"> Data Pegawai
                                    </span></a>
                                </li>
                                @endif
                            </ul>
                        </li>

                        <li class="sidebar-item"> <a class="sidebar-link has-arrow" href="javascript:void(0)"
                            aria-expanded="false"><i data-feather="file-text" class="feather-icon"></i><span
                                class="hide-menu">Dokumentasi <br> Lapangan</span></a>
                        <ul aria-expanded="false" class="collapse  first-level base-level-line">
                            <li class="sidebar-item"><a href="/survei" class="sidebar-link"><span
                                        class="hide-menu"> Hasil Survei
                                    </span></a>
                            </li>
                            {{-- @if (Auth::user()->role == 'admin')
                            <li class="sidebar-item"><a href="/survei/berita-acara" class="sidebar-link"><span
                                class="hide-menu"> Berita Acara
                                </span></a>
                            </li> --}}
                            <li class="sidebar-item"><a href="/survei/laporan" class="sidebar-link"><span
                                class="hide-menu"> Dokumen Laporan
                                </span></a>
                            </li>
                            {{-- @endif --}}
                            {{-- <li class="sidebar-item"><a href="/survei/arsip" class="sidebar-link"><span
                                        class="hide-menu"> Arsip
                                    </span></a>
                            </li> --}}
                        </ul>
                    </li>

                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            
            <div class="container-fluid">
                {{ $slot }}
            </div>
            <footer class="footer text-center text-muted">
                Bidang Pertanahan • Dinas Perumahan, Kawasan Pemukiman, dan Pertanahan Kota Bengkulu</a>.
            </footer>
        </div>
    </div>

    
    <!-- jQuery CDN harus pertama -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Bootstrap Bundle (dengan Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
        <!-- DataTables -->
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    
        <!-- Plugins & Custom JS -->
        <script src="{{ asset('assets/js/app-style-switcher.js') }}"></script>
        <script src="{{ asset('assets/js/feather.min.js') }}"></script>
        <script src="{{ asset('assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
        <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
        <script src="{{ asset('assets/js/custom.min.js') }}"></script>
        
        <!-- Dashboard Charts & Maps -->
        <script src="{{ asset('assets/extra-libs/c3/d3.min.js') }}"></script>
        <script src="{{ asset('assets/extra-libs/c3/c3.min.js') }}"></script>
        <script src="{{ asset('assets/libs/chartist/dist/chartist.min.js') }}"></script>
        <script src="{{ asset('assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js') }}"></script>
        <script src="{{ asset('assets/extra-libs/jvector/jquery-jvectormap-2.0.2.min.js') }}"></script>
        <script src="{{ asset('assets/extra-libs/jvector/jquery-jvectormap-world-mill-en.js') }}"></script>
        <script src="{{ asset('assets/js/pages/dashboards/dashboard1.min.js') }}"></script>
        
        
    @stack('scripts')
    </body>
    
    </html>