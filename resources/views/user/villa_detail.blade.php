<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail {{ $villa->title }} | VilaGo</title>
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
  <style>
    body { background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    .hero-img { width: 100%; max-height: 420px; object-fit: cover; border-radius: 16px; }
    .facility-box { background: white; border-radius: 10px; padding: 12px 16px; border: 1px solid #e9ecef; }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg bg-white shadow-sm py-3 sticky-top">
    <div class="container">
      <a class="navbar-brand fw-bold text-primary fs-4" href="{{ route('user.dashboard') }}"><i class="bi bi-house-door-fill me-2"></i>VilaGo</a>
      <div class="d-flex align-items-center gap-3">
        <a href="{{ route('user.my_bookings') }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-journal-check me-1"></i> Riwayat Saya</a>
      </div>
    </div>
  </nav>

  <div class="container py-4">
    

    <div class="row g-4">
      <!-- Kolom Kiri: Gambar & Detail -->
      <div class="col-lg-8">
        @php
          $imagePath = $villa->image && file_exists(public_path('assets/images/' . $villa->image)) 
                        ? asset('assets/images/' . $villa->image) 
                        : asset('assets/images/vila-1.jpg');
        @endphp
        
        <img src="{{ $imagePath }}" class="hero-img shadow-sm mb-4" alt="{{ $villa->title }}">

        <div class="card border-0 shadow-sm rounded-3 p-4 mb-4">
          <h3 class="fw-bold text-dark mb-2">{{ $villa->title }}</h3>
          <p class="text-danger fw-semibold mb-3"><i class="bi bi-geo-alt-fill me-1"></i>{{ $villa->location }}</p>
          
          <h5 class="fw-bold text-dark mb-2">Deskripsi Vila</h5>
          <p class="text-secondary leading-relaxed mb-4" style="white-space: pre-line;">{{ $villa->description }}</p>

          <h5 class="fw-bold text-dark mb-3">Fasilitas Lengkap</h5>
          <div class="row g-3">
            <div class="col-6 col-md-4">
              <div class="facility-box d-flex align-items-center">
                <i class="bi bi-people-fill fs-4 text-primary me-3"></i>
                <div>
                  <small class="text-muted d-block">Kapasitas</small>
                  <strong>{{ $villa->capacity }} Orang</strong>
                </div>
              </div>
            </div>

            @forelse($villa->facilities as $fac)
              <div class="col-6 col-md-4">
                <div class="facility-box d-flex align-items-center">
                  <i class="bi {{ $fac->icon }} fs-4 text-primary me-3"></i>
                  <div>
                    <small class="text-muted d-block">Fasilitas</small>
                    <strong>{{ $fac->name }}</strong>
                  </div>
                </div>
              </div>
            @empty
              <div class="col-12">
                <span class="text-muted small">Tidak ada informasi fasilitas khusus.</span>
              </div>
            @endforelse
          </div>
        </div>
      </div>

      <!-- Kolom Kanan: Card Harga & Form Pemesanan -->
      <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-3 p-4 sticky-top" style="top: 90px;">
          <small class="text-muted d-block">Harga Sewa / Malam</small>
          <h2 class="fw-bold text-primary mb-3">Rp {{ number_format($villa->price_per_night, 0, ',', '.') }}</h2>

          <div class="mb-3 p-3 bg-light rounded-3">
            <div class="d-flex justify-content-between mb-2">
              <span class="text-muted">Status Unit</span>
              <span class="badge bg-success">Tersedia Siap Sewa</span>
            </div>
            <div class="d-flex justify-content-between">
              <span class="text-muted">Kapasitas Maksimal</span>
              <span class="fw-semibold">{{ $villa->capacity }} Tamu</span>
            </div>
          </div>

          <a href="{{ route('bookings.create', ['villa_id' => $villa->id]) }}" class="btn btn-primary fw-semibold btn-lg w-100 shadow-sm mb-2">
            <i class="bi bi-journal-plus me-1"></i> Pesan Vila Sekarang
          </a>
          <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary w-100">
            Lihat Vila Lainnya
          </a>
        </div>
      </div>

    </div>
  </div>

  <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>