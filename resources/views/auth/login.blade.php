<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Pendataan Lansia Desa</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
      body {
        height: 100vh;
        margin: 0;
      }
      .login-container {
        display: flex;
        height: 100vh;
      }
      .login-left {
        flex: 1;
        padding: 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
      }
      .login-right {
        flex: 1;
        background: linear-gradient(135deg, #e57373, #c62828);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
      }
      .login-card {
        max-width: 400px;
        width: 100%;
        margin: auto;
      }
      .btn-primary {
        background-color: #e57373;
        border-color: #e57373;
        transition: all 0.3s ease;
      }
      .btn-primary:hover {
        background-color: #c62828;
        border-color: #c62828;
      }
      .btn-outline-secondary:hover {
        background-color: #e57373;
        border-color: #e57373;
        color: #fff;
      }
      .form-control:focus {
        border-color: #e57373;
        box-shadow: 0 0 0 0.25rem rgba(229, 115, 115, 0.4);
      }
      .form-check-label {
        font-size: 0.9rem;
      }
      @media (max-width: 768px) {
        .login-container {
          flex-direction: column;
        }
        .login-right {
          display: none; /* hide gambar di mobile */
        }
      }
    </style>
  </head>
  <body>
    <div class="login-container">
      <!-- Left Side -->
      <div class="login-left">
        <div class="login-card">
          <h4 class="mb-4 fw-bold text-danger" style="color:#e57373 !important;">Pendataan Lansia Desa</h4>

          <h2 class="mb-2">Selamat Datang Kembali</h2>
          <p class="text-muted mb-4">Silakan login untuk melanjutkan</p>

          @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong>Login Gagal!<br></strong> Periksa kembali username dan password Anda.
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          <!-- Form -->
          <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" id="username" name="login" placeholder="Masukkan username" required>
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
            </div>

            <!-- Tombol Login -->
            <button type="submit" class="btn btn-primary w-100 mb-2">
              <i class="bi bi-box-arrow-in-right"></i> Masuk
            </button>

            <!-- Tombol Home -->
            <a href="{{ url('/') }}" class="btn btn-outline-secondary w-100">
              <i class="bi bi-house-door"></i> Home
            </a>
          </form>
        </div>
      </div>

      <!-- Right Side -->
      <div class="login-right">
        <div class="text-center">
          <img src="{{ asset('assets/images/login/2.webp') }}" alt="Ilustrasi Login" class="img-fluid" style="max-width: 80%;">
        </div>
      </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
