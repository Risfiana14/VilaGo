<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pengaturan Akun | VilaGo</title>
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
  <style>
    body { background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    .card-settings { border: none; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
    .avatar-box { width: 64px; height: 64px; background: #0d6efd; color: white; font-size: 1.5rem; font-weight: 700; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
  </style>
</head>
<body class="bg-light">

  <div class="container py-4" style="max-width: 800px;">
    
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h3 class="fw-bold mb-1"><i class="bi bi-gear-fill me-2 text-primary"></i>Pengaturan Akun</h3>
        <p class="text-muted small mb-0">Kelola informasi profil, email, dan kata sandi akun Anda.</p>
      </div>
      <!-- Tombol Kembali Dinamis Sesuai Role -->
      <a href="{{ auth()->user()->role === 'admin' ? route('home') : route('user.dashboard') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
      </a>
    </div>

    <!-- Alert Sukses -->
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <!-- Alert Error Validasi -->
    @if($errors->any())
      <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        <ul class="mb-0 ps-3">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <!-- Card Form Pengaturan Profil -->
    <div class="card card-settings p-4">
      
      <!-- Info Singkat Akun -->
      <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
        <div class="avatar-box shadow-sm">
          {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div>
          <h5 class="fw-bold mb-0 text-dark">{{ $user->name }}</h5>
          <small class="text-muted"><i class="bi bi-envelope me-1"></i>{{ $user->email }}</small>
        </div>
      </div>

      <form action="{{ route('settings.update') }}" method="POST">
        @csrf
        @method('PUT')

        <h6 class="fw-bold text-primary mb-3"><i class="bi bi-person-fill me-1"></i> Informasi Profil</h6>

        <div class="mb-3">
          <label class="form-label fw-semibold">Nama Pengguna</label>
          <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-4">
          <label class="form-label fw-semibold">Alamat Email</label>
          <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <hr class="my-4 opacity-25">

        <h6 class="fw-bold text-primary mb-3"><i class="bi bi-shield-lock-fill me-1"></i> Keamanan & Ubah Password</h6>
        <p class="small text-muted mb-3">Kosongkan bagian password jika Anda tidak ingin mengubahnya.</p>

        <div class="mb-3">
          <label class="form-label fw-semibold">Kata Sandi Baru</label>
          <input type="password" name="password" class="form-control" placeholder="Masukkan kata sandi baru (minimal 6 karakter)">
        </div>

        <div class="mb-4">
          <label class="form-label fw-semibold">Konfirmasi Kata Sandi Baru</label>
          <input type="password" name="password_confirmation" class="form-control" placeholder="Ketik ulang kata sandi baru">
        </div>

        <div class="d-flex justify-content-end gap-2">
          <button type="reset" class="btn btn-secondary btn-sm">Batal</button>
          <button type="submit" class="btn btn-primary btn-sm px-4 fw-semibold shadow-sm">
            <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
          </button>
        </div>
      </form>
    </div>

  </div>

  <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>