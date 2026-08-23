<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Akun | VilaGo</title>
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
  <style>
    body { background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    .card-auth { border: none; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
    .auth-header { background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%); color: white; border-radius: 12px 12px 0 0; padding: 2rem; }
  </style>
</head>
<body class="d-flex align-items-center min-vh-100">
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card card-auth">
          <div class="auth-header text-center">
            <h4 class="fw-bold mb-1"><i class="bi bi-house-door-fill me-2"></i>VilaGo</h4>
            <p class="mb-0 small opacity-75">Buat Akun Pelanggan Baru</p>
          </div>
          <div class="card-body p-4 p-md-5">
            <form action="{{ route('register') }}" method="POST">
              @csrf
              <div class="mb-3">
                <label class="form-label fw-semibold">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required placeholder="Contoh: Nabila Rahmasari">
              </div>
              <div class="mb-3">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="nama@email.com">
                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
              </div>
              <div class="row g-2 mb-4">
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Password</label>
                  <input type="password" name="password" class="form-control" required placeholder="Minimal 6 karakter">
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Konfirmasi Password</label>
                  <input type="password" name="password_confirmation" class="form-control" required placeholder="Ulangi password">
                </div>
              </div>
              <button type="submit" class="btn btn-primary w-100 fw-bold py-2 mb-3">Daftar Sekarang</button>
            </form>
            <div class="text-center small">
              Sudah memiliki akun? <a href="{{ route('login') }}" class="text-primary text-decoration-none fw-semibold">Login disini</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>