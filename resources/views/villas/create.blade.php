<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Vila Baru | VilaGo</title>
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
    .form-label {
      color: #495057;
      font-size: 0.9rem;
    }
    .form-control, .form-select {
      border-radius: 8px;
      padding: 0.6rem 0.9rem;
      border: 1px solid #ced4da;
    }
    .form-control:focus, .form-select:focus {
      border-color: #0d6efd;
      box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
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
        <div class="card card-custom">
          
          <!-- Header Card -->
          <div class="card-header-custom d-flex align-items-center justify-content-between">
            <h5 class="mb-0 fw-bold"><i class="bi bi-building-add me-2"></i>Tambah Data Vila Baru</h5>
            <span class="badge bg-white text-primary rounded-pill px-3 py-2">VilaGo System</span>
          </div>

          <div class="card-body p-4 p-md-5">

            <!-- Alert Notifikasi Error -->
            @if ($errors->any())
              <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i>
                  <strong class="fs-6">Gagal Menyimpan Data</strong>
                </div>
                <ul class="mb-0 ps-3 small">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif

            <form action="{{ route('villas.store') }}" method="POST">
              @csrf

              <!-- Informasi Utama -->
              <div class="row g-3 mb-3">
                <div class="col-md-8">
                  <label class="form-label fw-semibold">Nama Vila <span class="text-danger">*</span></label>
                  <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="Contoh: Vila Luxury Sunset" required>
                </div>
                <div class="col-md-4">
                  <label class="form-label fw-semibold">Status Vila <span class="text-danger">*</span></label>
                  <select name="status" class="form-select" required>
                    <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Tersedia (Available)</option>
                    <option value="booked" {{ old('status') == 'booked' ? 'selected' : '' }}>Tersewa (Booked)</option>
                    <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                  </select>
                </div>
              </div>

              <!-- Lokasi dan Alamat -->
              <div class="row g-3 mb-3">
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Lokasi (Kota/Area) <span class="text-danger">*</span></label>
                  <input type="text" name="location" class="form-control" value="{{ old('location') }}" placeholder="Contoh: Batu, Malang" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Alamat Lengkap <span class="text-danger">*</span></label>
                  <input type="text" name="address" class="form-control" value="{{ old('address') }}" placeholder="Contoh: Jl. Raya Oro-Oro Ombo No. 12" required>
                </div>
              </div>

              <!-- Harga dan Kapasitas -->
              <div class="row g-3 mb-3">
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Harga per Malam (Rp) <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <span class="input-group-text bg-light text-muted fw-semibold">Rp</span>
                    <input type="number" name="price_per_night" class="form-control" value="{{ old('price_per_night') }}" placeholder="1500000" min="0" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Kapasitas Maksimal <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <input type="number" name="capacity" class="form-control" value="{{ old('capacity') }}" placeholder="6" min="1" required>
                    <span class="input-group-text bg-light text-muted">Orang</span>
                  </div>
                </div>
              </div>

              <!-- Deskripsi -->
              <div class="mb-4">
                <label class="form-label fw-semibold">Deskripsi & Fasilitas Vila <span class="text-danger">*</span></label>
                <textarea name="description" class="form-control" rows="4" placeholder="Jelaskan fasilitas utama seperti jumlah kamar tidur, kolam renang, WiFi, dll..." required>{{ old('description') }}</textarea>
              </div>

              <hr class="my-4 text-muted opacity-25">

              <!-- Tombol Aksi -->
              <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-action">
                  <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary btn-action shadow-sm">
                  <i class="bi bi-check-circle me-1"></i> Simpan Data Vila
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