<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pengaturan Sistem | VilaGo</title>
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
  <style>
    body {
      background-color: #f4f6f9;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .card-custom {
      border: none;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
      overflow: hidden;
    }
    .card-header-custom {
      background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
      color: #fff;
      padding: 1.25rem 1.75rem;
    }
    .btn-action {
      border-radius: 8px;
      padding: 0.6rem 1.4rem;
      font-weight: 600;
    }
  </style>
</head>
<body>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-lg-8 col-md-10">
        
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
          <div>
            <h3 class="mb-1 fw-bold text-dark">Pengaturan Sistem</h3>
            <p class="text-muted mb-0">Kelola identitas dan informasi operasional aplikasi VilaGo.</p>
          </div>
          <a href="{{ route('home') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Dashboard
          </a>
        </div>

        <!-- Alert Notifikasi -->
        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <div class="card card-custom">
          <div class="card-header-custom d-flex align-items-center justify-content-between">
            <h5 class="mb-0 fw-bold"><i class="bi bi-gear me-2"></i>Konfigurasi Profil Aplikasi</h5>
            <span class="badge bg-white text-primary rounded-pill px-3 py-2">VilaGo System</span>
          </div>

          <div class="card-body p-4 p-md-5">
            <form action="{{ route('settings.update', $setting->id) }}" method="POST">
              @csrf
              @method('PUT')

              <div class="row g-3 mb-3">
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Nama Aplikasi / Bisnis <span class="text-danger">*</span></label>
                  <input type="text" name="app_name" class="form-control" value="{{ old('app_name', $setting->app_name) }}" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Email Customer Service <span class="text-danger">*</span></label>
                  <input type="email" name="app_email" class="form-control" value="{{ old('app_email', $setting->app_email) }}" required>
                </div>
              </div>

              <div class="row g-3 mb-3">
                <div class="col-md-6">
                  <label class="form-label fw-semibold">No. Whatsapp / Kontak Admin <span class="text-danger">*</span></label>
                  <input type="text" name="app_phone" class="form-control" value="{{ old('app_phone', $setting->app_phone) }}" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Biaya Layanan / Pajak (%) <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <input type="number" step="0.01" name="service_fee" class="form-control" value="{{ old('service_fee', $setting->service_fee) }}" required>
                    <span class="input-group-text bg-light text-muted">%</span>
                  </div>
                </div>
              </div>

              <div class="mb-4">
                <label class="form-label fw-semibold">Alamat Kantor / Operasional <span class="text-danger">*</span></label>
                <textarea name="app_address" class="form-control" rows="3" required>{{ old('app_address', $setting->app_address) }}</textarea>
              </div>

              <hr class="my-4 text-muted opacity-25">

              <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary btn-action shadow-sm">
                  <i class="bi bi-save me-1"></i> Simpan Pengaturan
                </button>
              </div>

            </form>
          </div>
        </div>

      </div>
    </div>
  </div>
</body>
</html>