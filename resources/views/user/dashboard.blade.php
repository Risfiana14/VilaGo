<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portal Tamu | VilaGo</title>
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
  <style>
    body { 
      background-color: #f4f6f9; 
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
    }
    .hero-banner { 
      background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%); 
      color: white; 
      border-radius: 12px; 
    }
    .card-villa { 
      border: none; 
      border-radius: 12px; 
      box-shadow: 0 5px 15px rgba(0,0,0,0.05); 
      transition: transform 0.2s, box-shadow 0.2s; 
      overflow: hidden;
    }
    .card-villa:hover { 
      transform: translateY(-5px); 
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    .villa-img-container {
      position: relative;
      height: 200px;
      overflow: hidden;
      background-color: #e9ecef;
    }
    .villa-img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.3s ease;
    }
    .card-villa:hover .villa-img {
      transform: scale(1.05);
    }
    .badge-status {
      position: absolute;
      top: 12px;
      right: 12px;
      padding: 6px 12px;
      border-radius: 20px;
      font-weight: 600;
      font-size: 0.75rem;
      box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    }
    .badge-capacity {
      position: absolute;
      bottom: 12px;
      left: 12px;
      background: rgba(0, 0, 0, 0.65);
      color: #fff;
      backdrop-filter: blur(4px);
      padding: 4px 10px;
      border-radius: 6px;
      font-size: 0.75rem;
    }
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
            <a class="nav-link px-3 rounded-pill fw-semibold active bg-primary text-white" href="{{ route('user.dashboard') }}">
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
    <!-- Hero Banner -->
    <div class="hero-banner p-4 p-md-5 mb-4 shadow-sm">
      <h2 class="fw-bold mb-2">Selamat Datang di VilaGo!</h2>
      <p class="mb-0 opacity-75">Temukan pilihan vila terbaik dan nikmati liburan nyaman di Malang & Batu.</p>
    </div>

    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold mb-0 text-dark"><i class="bi bi-building me-2 text-primary"></i>Daftar Vila Tersedia</h4>
      <span class="text-muted small">Pilih vila untuk melihat detail informasi dan pemesanan</span>
    </div>

    <!-- Alert Notifikasi -->
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif
    
    <!-- Daftar Vila -->
    <div class="row g-4">
      @php
        $villas = \App\Models\Villa::with('facilities')->where('status', 'available')->latest()->get();
      @endphp

      @forelse($villas as $index => $itemVilla)
        @php
          $localImage = 'vila-' . (($index % 4) + 1) . '.jpg'; 
          $imagePath = $itemVilla->image && file_exists(public_path('assets/images/' . $itemVilla->image)) 
                        ? $itemVilla->image 
                        : $localImage;
        @endphp

        <div class="col-md-6 col-lg-4">
          <div class="card card-villa h-100">
            <a href="{{ route('villas.show', $itemVilla->id) }}" class="villa-img-container d-block">
              <img src="{{ asset('assets/images/' . $imagePath) }}" class="villa-img" alt="{{ $itemVilla->title }}">
              <span class="badge bg-success badge-status">Tersedia</span>
              <span class="badge-capacity"><i class="bi bi-people-fill me-1"></i>Kapasitas: {{ $itemVilla->capacity }} Orang</span>
            </a>

            <div class="card-body p-4 d-flex flex-column justify-content-between">
              <div>
                <h5 class="fw-bold mb-1">
                  <a href="{{ route('villas.show', $itemVilla->id) }}" class="text-dark text-decoration-none">
                    {{ $itemVilla->title }}
                  </a>
                </h5>
                <p class="text-muted small mb-2"><i class="bi bi-geo-alt me-1 text-danger"></i>{{ $itemVilla->location }}</p>
                <p class="text-secondary small mb-3">{{ Str::limit($itemVilla->description, 85) }}</p>
                
                <div class="mb-3">
                  <small class="fw-semibold text-muted d-block mb-2">Fasilitas Utama:</small>
                  <div class="d-flex flex-wrap gap-1">
                    @forelse($itemVilla->facilities as $fac)
                      <span class="badge bg-light text-dark border"><i class="bi {{ $fac->icon }} text-primary me-1"></i> {{ $fac->name }}</span>
                    @empty
                      <span class="text-muted small">-</span>
                    @endforelse
                  </div>
                </div>
              </div>

              <div>
                <hr class="my-3 opacity-25">
                <div class="d-flex justify-content-between align-items-center gap-2">
                  <div>
                    <small class="text-muted d-block small">Harga per malam</small>
                    <span class="fw-bold text-primary fs-6">Rp {{ number_format($itemVilla->price_per_night, 0, ',', '.') }}</span>
                  </div>
                  
                  <div class="d-flex gap-1">
                    <a href="{{ route('villas.show', $itemVilla->id) }}" class="btn btn-outline-primary btn-sm fw-semibold">
                      <i class="bi bi-eye me-1"></i> Detail
                    </a>
                    <a href="{{ route('bookings.create', ['villa_id' => $itemVilla->id]) }}" class="btn btn-primary btn-sm fw-semibold px-2 shadow-sm">
                      <i class="bi bi-journal-plus me-1"></i> Pesan
                    </a>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      @empty
        <div class="col-12">
          <div class="alert alert-light text-center py-5 border rounded-3">
            <i class="bi bi-building-x fs-1 d-block mb-2 text-muted"></i>
            <p class="mb-0 text-muted">Belum ada unit vila yang tersedia saat ini.</p>
          </div>
        </div>
      @endforelse
    </div>

  </div>

  <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>