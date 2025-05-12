 <x-guest-layout>
  <section class="slider_section layout_padding long_section">
    <div class="container py-5">
      <div class="row align-items-center">
        <div class="col-md-5">
          <div class="detail-box">
            <h1>
              Pantau Sekarang!
            </h1>
            <p>
              Mau tahu sampai di mana proses Survei Lahan untuk permohonan IPPT Anda? <br>Cukup klik disinii
            </p>
            <div class="btn-box">
              <a href="{{ url('/guest/inputtracking') }}" class="btn1">
                Pemantauan
              </a>
            </div>
          </div>
        </div>
        <div class="col-md-7 d-flex justify-content-center align-items-center">
          <div class="img-box text-center">
            <img src="{{ asset('assets/images/logobengkulu.png') }}" style="width: 70%" alt="Logo" class="img-fluid">
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- about section -->

  <section class="about_section layout_padding long_section">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <div class="img-box">
            <img src="{{ asset('assets/images/about-img.jpg') }}" alt="">
          </div>
        </div>
        <div class="col-md-6">
          <div class="detail-box">
            <div class="heading_container">
              <h2>
                Dinas Perumahan, Kawasan Pemukiman, dan Pertanahan
              </h2>
            </div>
            <p>
              Dinas Perumahan Rakyat dan Kawasan Permukiman dan Pertanahan Kota Bengkulu 
              mempunyai tugas pokok membantu Walikota dalam melaksanakan Urusan Pemerintah 
              yang menjadi Kewenangan Daerah dan Tugas Pembantuan di bidang Perumahan Rakyat, 
              Kawasan Permukiman dan Pertanahan.
            </p>
            <a href="https://perkim.bengkulukota.go.id/tugas-pokok-dan-fungsi/" target="_blank">
              Selengkapnya
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end about section -->

  <!-- blog section -->

  <section class="blog_section layout_padding">
    <div class="container">
      <div class="heading_container">
        <h2>
          Pelayanan Dinas Perkimtan
        </h2>
      </div>
      <div class="row">
        <div class="col-md-6 col-lg-4 mx-auto">
          <div class="box">
            <div class="img-box">
              <img src="images/b1.jpg" alt="">
            </div>
            <div class="detail-box">
              <h5>
                Pantau dan Pengawas
              </h5>
              <p>
                Pemantauan dan pengawasan pembangunan perumahan di Kota Bengkulu
              </p>
              <a href="https://perkim.bengkulukota.go.id/" target="_blank">
                Selengkapnya
              </a>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-4 mx-auto">
          <div class="box">
            <div class="img-box">
              <img src="images/b2.jpg" alt="">
            </div>
            <div class="detail-box">
              <h5>
                Penyediaan lahan
              </h5>
              <p>
                Penyediaan lahan untuk pembangunan perumahan rakyat Kota Bengkulu
              </p>
              <a href="https://perkim.bengkulukota.go.id/" target="_blank">
                Selengkapnya
              </a>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-4 mx-auto">
          <div class="box">
            <div class="img-box">
              <img src="images/b3.jpg" alt="">
            </div>
            <div class="detail-box">
              <h5>
                Pembinaan
              </h5>
              <p>
                Pembinaan dan pengembangan kawasan permukiman di Kota Bengkulu
              </p>
              <a href="https://perkim.bengkulukota.go.id/" target="_blank">
                Selengkapnya
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end blog section -->
</x-guest-layout>
