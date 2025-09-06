<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Pendataan Lansia Desa</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
        background-color: #7C3AED; /* ungu */
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
      .btn-google {
        border: 1px solid #ccc;
        background-color: #fff;
      }
      .btn-google img {
        height: 20px;
        margin-right: 8px;
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
          <!-- Logo Desa (opsional ganti sesuai kebutuhan) -->
          <h4 class="mb-4 fw-bold">Pendataan Lansia Desa</h4>

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
              <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required>
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-3">Masuk</button>
          </form>
        </div>
      </div>

      <!-- Right Side -->
      <div class="login-right">
        <div class="text-center">
          <!-- Ilustrasi bisa diganti dengan SVG sendiri -->
          <img src="{{ asset('assets/images/login/2.webp') }}" alt="Ilustrasi Login" class="img-fluid" style="max-width: 80%;">
        </div>
      </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
