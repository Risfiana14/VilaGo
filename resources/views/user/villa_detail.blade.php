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

  <!-- Navbar Clean & Modern -->
  <nav class="navbar navbar-expand-lg bg-white shadow-sm py-2 sticky-top border-bottom border-light">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center fw-bold text-primary fs-4 me-4" href="{{ route('user.dashboard') }}">
        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 38px; height: 38px;">
          <i class="bi bi-house-door-fill fs-5"></i>
        </div>
        <span>Vila<span class="text-dark">Go</span></span>
      </a>

      <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#userNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="userNavbar">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-1">
          <li class="nav-item">
            <a class="nav-link px-3 rounded-pill fw-medium text-secondary" href="{{ route('user.dashboard') }}">
              <i class="bi bi-grid-fill me-1"></i> Daftar Vila
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link px-3 rounded-pill fw-medium text-secondary" href="{{ route('user.my_bookings') }}">
              <i class="bi bi-journal-check me-1"></i> Riwayat saya
            </a>
          </li>
        </ul>

        <div class="d-flex align-items-center gap-3 pt-2 pt-lg-0 border-top border-lg-0 border-light mt-2 mt-lg-0">
          <div class="d-flex align-items-center bg-light border rounded-pill px-3 py-1 shadow-sm">
            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2 fw-semibold" style="width: 28px; height: 28px; font-size: 0.85rem;">
              {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <span class="fw-semibold text-dark small">{{ Auth::user()->name }}</span>
          </div>

          <form action="{{ route('logout') }}" method="POST" class="m-0">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
              <i class="bi bi-box-arrow-right me-1"></i> Logout
            </button>
          </form>
        </div>
      </div>
    </div>
  </nav>

  <div class="container py-4">
    <!-- Breadcrumb Navigasi -->
    <nav aria-label="breadcrumb" class="mb-3">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}" class="text-decoration-none">Daftar Vila</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $villa->title }}</li>
      </ol>
    </nav>

    <div class="row g-4">
      <!-- Kolom Kiri: Gambar, Detail, Fasilitas, & Ulasan -->
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

            @forelse($villa->facilities ?? [] as $fac)
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

        <!-- Section Ulasan Tamu -->
        <div class="card border-0 shadow-sm rounded-3 p-4">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="fw-bold mb-0"><i class="bi bi-chat-square-text-fill text-primary me-2"></i>Ulasan Pengunjung</h5>
            
            @php
              // Pengamanan: Jika relasi reviews null, gunakan collection kosong agar tidak error
              $reviewsList = $villa->reviews ?? collect();
              $avgRating = method_exists($villa, 'averageRating') ? $villa->averageRating() : round($reviewsList->avg('rating') ?? 0, 1);
              $reviewCount = $reviewsList->count();
            @endphp
            
            <div class="badge bg-warning text-dark fs-6 px-3 py-2 rounded-pill">
              <i class="bi bi-star-fill me-1"></i>{{ $avgRating }} / 5.0 ({{ $reviewCount }} Ulasan)
            </div>
          </div>

          <div class="review-list">
            @forelse($reviewsList as $review)
              <div class="border-bottom py-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                  <strong class="text-dark">{{ optional($review->user)->name ?? 'Tamu VilaGo' }}</strong>
                  <small class="text-muted">{{ $review->created_at->format('d M Y') }}</small>
                </div>
                <div class="text-warning mb-2" style="font-size: 0.85rem;">
                  @for($i = 1; $i <= 5; $i++)
                    <i class="bi bi-star-fill{{ $i <= $review->rating ? '' : ' text-muted opacity-25' }}"></i>
                  @endfor
                </div>
                <p class="mb-0 text-secondary small">{{ $review->comment }}</p>
              </div>
            @empty
              <div class="text-center py-4 text-muted">
                <i class="bi bi-chat-left-dots fs-3 d-block mb-1 opacity-50"></i>
                <small>Belum ada ulasan untuk vila ini.</small>
              </div>
            @endforelse
          </div>
        </div>

      </div>

      <!-- Kolom Kanan: Card Harga & Pemesanan -->
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