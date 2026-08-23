<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portal Tamu | VilaGo</title>
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
</head>
<body class="bg-light">
  <nav class="navbar navbar-expand-lg bg-white shadow-sm py-3">
    <div class="container">
      <a class="navbar-brand fw-bold text-primary fs-4" href="#"><i class="bi bi-house-door-fill me-2"></i>VilaGo</a>
      <div class="d-flex align-items-center gap-3">
        <span class="fw-semibold text-dark">Halo, {{ Auth::user()->name }}</span>
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-box-arrow-right me-1"></i> Logout</button>
        </form>
      </div>
    </div>
  </nav>

  <div class="container py-5">
    <div class="row mb-4">
      <div class="col-12">
        <div class="bg-primary text-white p-4 rounded-3 shadow-sm">
          <h3>Selamat Datang di VilaGo!</h3>
          <p class="mb-0">Temukan dan pesan vila impian Anda di Malang & Batu dengan mudah.</p>
        </div>
      </div>
    </div>
  </div>
</body>
</html>