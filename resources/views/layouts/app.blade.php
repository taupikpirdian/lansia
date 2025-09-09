<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>IKET DATALANG</title>
  <link href="{{ asset('vendor/bootstrap-5.3.0/bootstrap.min.css') }}" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css"/>
  <style>
     html, body {
        height: 100%;
    }
    body {
        display: flex;
        flex-direction: column;
    }
    main {
        flex: 1; /* Mengisi ruang kosong di antara header dan footer */
    }
    .nav-link {
      font-weight: 500;
      font-size: 1.1rem;
    }
    .hero-section {
      background-image: url('https://via.placeholder.com/1200x300'); /* ganti dengan gambar kantor */
      background-size: cover;
      background-position: center;
      color: #fff;
      padding: 4rem 2rem;
      text-align: center;
    }
    .hero-section h1 {
      font-size: 2rem;
      font-weight: bold;
    }
    .content-section {
      /* padding: 2rem; */
    }
    footer {
      background-color: #f8f9fa;
      padding: 1.5rem;
    }
  </style>

  <style>
    .navbar {
      background: linear-gradient(90deg, #212529, #343a40, #212529);
    }

    .navbar-brand {
      font-size: 1.5rem;
      letter-spacing: 1px;
      transition: transform 0.3s ease;
    }

    .navbar-brand:hover {
      transform: scale(1.05);
      color: #dc3545 !important; /* merah bootstrap */
    }

    .nav-link {
      position: relative;
      margin: 0 8px;
      transition: color 0.3s ease;
    }

    .nav-link::after {
      content: "";
      position: absolute;
      left: 0;
      bottom: -4px;
      width: 0%;
      height: 2px;
      background-color: #dc3545; /* garis underline merah */
      transition: width 0.3s ease;
    }

    .nav-link:hover::after,
    .nav-link.active::after {
      width: 100%;
    }

    .nav-link:hover {
      color: #dc3545 !important; /* teks merah */
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a class="navbar-brand fw-bold" href="#">
        <i class="bi bi-heart-pulse-fill text-danger" style="font-size: 2rem;"></i> IKET DALANG
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="/dashboard">Dashboard</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <section class="content-section bg-white">
      @yield('content')
  </section>

  <!-- Footer -->
  <footer class="bg-dark text-light pt-4 mt-auto border-top">
    <div class="container">
      <div class="row">
        <!-- Kolom 1: Branding -->
        <div class="col-md-4 mb-3">
          <h5 class="fw-bold">IKET DALANG</h5>
          <p class="small">
            Sistem Informasi Pendataan Lansia adalah platform digital yang dikembangkan untuk membantu pemerintah desa dalam mendata, memantau, dan memberikan pelayanan terbaik kepada warga lanjut usia.
          </p>
        </div>
  
        <!-- Kolom 2: Link Terkait -->
        <div class="col-md-4 mb-3">
          <h6 class="fw-bold">Link Terkait</h6>
          <ul class="list-unstyled">
            <li>
              <a href="https://www.tasikmalayakota.go.id/" target="_blank" class="text-light text-decoration-none">
                <i class="bi bi-link-45deg"></i> tasikmalayakota.go.id
              </a>
            </li>
          </ul>
        </div>
  
        <!-- Kolom 3: Kontak -->
        <div class="col-md-4 mb-3">
          <h6 class="fw-bold">Kontak</h6>
          <p class="small mb-1">
            <i class="bi bi-geo-alt"></i> Jl. Ir. H Juanda No. 191 - Kota Tasikmalaya
          </p>
          <p class="small mb-0">
            <i class="bi bi-envelope"></i> kominfo@tasikmalayakota.go.id
          </p>
        </div>
      </div>
  
      <hr class="border-light">
      <div class="text-center pb-2 small">
        &copy; 2025 IKET DALANG. All rights reserved.
      </div>
    </div>
  </footer>

  <script src="{{ asset('vendor/bootstrap-5.3.0/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
