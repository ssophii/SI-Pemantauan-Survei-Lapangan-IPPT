<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <link rel="icon" href="{{ asset('assets/images/LOGOBKL.png') }}" type="image/png" />
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>Survei Tanah - IPPT</title>

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <!-- Font Awesome (versi gratis) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-papYh9G8syXoRSXZ1V8p0Fey99VbhKx0oQFHr+O5Vx2BZ0gf0e2AgNa6vvfTVMk+u3oWWKvWzAoJZx8OKLb4Gg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <style>
  html {
    scroll-behavior: smooth;
  }

    .nav-link.active {
      font-weight: bold;
      color: #eb9c53 !important; 
    }

    .fixed-navbar {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      z-index: 1000;
    }

  </style>
    

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.css') }}" />

  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700&display=swap" rel="stylesheet" />

  <!-- font awesome style -->
  <link href="{{ asset('assets/css/font-awesome.min.css') }}" rel="stylesheet" />
  <!-- Custom styles for this template -->
  <link href="{{ asset('assets/css/styleguest.css') }}" rel="stylesheet" />
  <!-- responsive style -->
  <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet" />

</head>

<body>

  <div class="hero_area">
    <!-- header section strats -->
    <header class="header_section long_section px-0 fixed-navbar">
      <nav class="navbar navbar-expand-lg custom_nav-container ">
        <a class="navbar-brand" href="{{ url('/') }}">
          <span>
            <img src="{{ asset('assets/images/DISPERKIM.png') }}" alt="">
          </span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class=""> </span>
        </button>

        <div class="collapse navbar-collapse container" id="navbarSupportedContent">
          <div class="d-flex mx-auto flex-column flex-lg-row align-items-center">
            <ul class="navbar-nav  ">
              <li class="nav-item ">
                <a class="nav-link {{ Request::is('/') || Request::path() == '' ? 'active' : '' }}" href="{{ url('/') }}">
                  Tentang Kami <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ Request::is('guest/inputtracking') || Request::is('guest/tracking') ? 'active' : '' }}" 
                   href="{{ url('/guest/inputtracking') }}">
                  Pemantauan
                  <span class="sr-only">(current)</span>
                </a>
              </li>              
              <li class="nav-item">
                <a class="nav-link {{ Request::is('guest#contact') ? 'active' : '' }}" href="#contact">Kontak<span class="sr-only">(current)</span></a>
              </li>
            </ul>
          </div>
          <div class="quote_btn-container">
            <a href="{{ url('/login') }}">
              <span>
                Login
              </span>
            </a>
          </div>
        </div>
      </nav>
    </header>
    <!-- end header section -->
    <!-- slider section -->
    {{ $slot }}
    
    <!-- end slider section -->
  </div>

  <!-- info section -->
  <section class="info_section long_section" id="contact">

    <div class="container">
      <div class="contact_nav">
        <a href="">
          <i class="bi bi-telephone-fill"></i>
          <span>
            Call : +01 123455678990
          </span>
        </a>
        <a href="">
          <i class="bi bi-envelope-fill"></i>
          <span>
            Email : demo@gmail.com
          </span>
        </a>
        <a href="">
          <i class="bi bi-map-fill"></i>
          <span>
            Location
          </span>
        </a>
      </div>
    </div>
  </section>
  <!-- end info_section -->


  <!-- footer section -->
  <footer class="footer_section">
    <div class="container">
      <p>
        Bidang Pertanahan • Dinas Perumahan, Kawasan Pemukiman, dan Pertanahan Kota Bengkulu.
      </p>
    </div>
  </footer>
  <!-- footer section -->


  <!-- jQery -->
  <script src="{{ asset('assets/js/jquery-3.4.1.min.js') }}"></script>
  <!-- bootstrap js -->
  <script src="{{ asset('assets/js/bootstrap.js') }}"></script>
  <!-- custom js -->
  <script src="{{ asset('assets/js/customguest.js') }}"></script>
  <!-- Google Map -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap"></script>
  <!-- End Google Map -->

</body>

</html>