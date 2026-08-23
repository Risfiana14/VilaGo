<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | VilaGo</title>
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
  <style>
    body { background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    .card-auth { border: none; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
    .auth-header { background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%); color: white; border-radius: 12px 12px 0 0; padding: 2rem; }
  </style>
</head>
<body class="d-flex align-items-center min-vh-100">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <div class="card card-auth">
          <div class="auth-header text-center">
            <h4 class="fw-bold mb-1"><i class="bi bi-house-door-fill me-2"></i>VilaGo</h4>
            <p class="mb-0 small opacity-75">Masuk ke Akun Anda</p>
          </div>
          <div class="card-body p-4 p-md-5">
            @if(session('success'))
              <div class="alert alert-success small mb-3">{{ session('success') }}</div>
            @endif
            @if(session('error'))
              <div class="alert alert-danger small mb-3">{{ session('error') }}</div>
            @endif

            <form action="{{ route('login') }}" method="POST">
              @csrf
              <div class="mb-3">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus placeholder="nama@email.com">
                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
              </div>
              <div class="mb-4">
                <label class="form-label fw-semibold">Password</label>
                <input type="password" name="password" class="form-control" required placeholder="******">
              </div>
              <button type="submit" class="btn btn-primary w-100 fw-bold py-2 mb-3">Masuk Sekarang</button>
            </form>
            <div class="text-center small">
              Belum punya akun? <a href="{{ route('register') }}" class="text-primary text-decoration-none fw-semibold">Daftar Akun Baru</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>