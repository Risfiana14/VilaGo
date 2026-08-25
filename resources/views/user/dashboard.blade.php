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
      background-color: #f8fafc; 
      font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; 
    }
    
    /* Navbar Custom Styles */
    .custom-navbar {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      border-bottom: 1px solid #e2e8f0;
    }
    .brand-logo {
      width: 40px;
      height: 40px;
      background: linear-gradient(135deg, #0d6efd, #0a58ca);
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      box-shadow: 0 4px 10px rgba(13, 110, 253, 0.25);
    }
    .nav-pill-custom {
      color: #64748b;
      font-weight: 600;
      font-size: 0.9rem;
      padding: 8px 16px;
      border-radius: 30px;
      transition: all 0.2s ease;
    }
    .nav-pill-custom:hover {
      color: #0d6efd;
      background-color: #f1f5f9;
    }
    .nav-pill-custom.active {
      color: #0d6efd !important;
      background-color: #eff6ff !important;
    }
    .user-profile-badge {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      padding: 4px 12px 4px 6px;
      border-radius: 30px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
    }
    .user-avatar {
      width: 32px;
      height: 32px;
      background: linear-gradient(135deg, #2563eb, #1d4ed8);
      color: white;
      font-weight: 700;
      font-size: 0.85rem;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    /* Card & Banner Custom */
    .hero-banner { 
      background: linear-gradient(135deg, #0d6efd 0%, #06b6d4 100%); 
      color: white; 
      border-radius: 16px; 
    }
    .card-villa { 
      border: none; 
      border-radius: 16px; 
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04); 
      transition: all 0.3s ease; 
      overflow: hidden;
      background: #ffffff;
    }
    .card-villa:hover { 
      transform: translateY(-6px); 
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
    }
    .villa-img-container {
      position: relative;
      height: 210px;
      overflow: hidden;
      background-color: #f1f5f9;
    }
    .villa-img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.4s ease;
    }
    .card-villa:hover .villa-img {
      transform: scale(1.06);
    }
    .badge-status {
      position: absolute;
      top: 14px;
      right: 14px;
      padding: 6px 14px;
      border-radius: 30px;
      font-weight: 600;
      font-size: 0.75rem;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .badge-capacity {
      position: absolute;
      bottom: 14px;
      left: 14px;
      background: rgba(15, 23, 42, 0.75);
      color: #fff;
      backdrop-filter: blur(6px);
      padding: 5px 12px;
      border-radius: 8px;
      font-size: 0.75rem;
      font-weight: 500;
    }
  </style>
</head>
<body>
  
  <!-- Navbar Sleek & Clean -->
  <nav class="navbar navbar-expand-lg sticky-top custom-navbar py-2 shadow-sm">
    <div class="container">
      
      <!-- Logo Brand -->
      <a class="navbar-brand d-flex align-items-center me-4" href="{{ route('user.dashboard') }}">
        <div class="brand-logo me-2">
          <i class="bi bi-house-door-fill fs-5"></i>
        </div>
        <span class="fw-bold fs-4 text-dark tracking-tight">Vila<span class="text-primary">Go</span></span>
      </a>

      <!-- Mobile Toggle Button -->
      <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#userNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Nav Items -->
      <div class="collapse navbar-collapse" id="userNavbar">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-1">
          <li class="nav-item">
            <a class="nav-link nav-pill-custom active" href="{{ route('user.dashboard') }}">
              <i class="bi bi-grid-fill me-1"></i> Daftar Vila
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-pill-custom" href="{{ route('user.my_bookings') }}">
              <i class="bi bi-journal-check me-1"></i> Riwayat saya
            </a>
          </li>
        </ul>

        <!-- Profil & Logout Action -->
        <div class="d-flex align-items-center gap-3 pt-2 pt-lg-0 border-top border-lg-0 border-light mt-2 mt-lg-0">
          <div class="user-profile-badge d-flex align-items-center me-1">
            <div class="user-avatar me-2">
              {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <span class="fw-semibold text-dark small pe-1">{{ Auth::user()->name }}</span>
          </div>

          <form action="{{ route('logout') }}" method="POST" class="m-0">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3 py-1 font-semibold d-flex align-items-center">
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
      <p class="mb-0 opacity-90">Temukan pilihan vila terbaik dan nikmati liburan nyaman di Malang & Batu.</p>
    </div>

    <!-- Header Section (Tanpa Sub-Header) -->
    <div class="d-flex align-items-center mb-4">
      <h4 class="fw-bold mb-0 text-dark"><i class="bi bi-building me-2 text-primary"></i>Daftar Vila Tersedia</h4>
    </div>

    <!-- Alert Notifikasi -->
    @if(session('success'))
      <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif
    
    <!-- Catalog Grid Vila -->
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
                    <a href="{{ route('villas.show', $itemVilla->id) }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-semibold">
                      <i class="bi bi-eye me-1"></i> Detail
                    </a>
                    <a href="{{ route('bookings.create', ['villa_id' => $itemVilla->id]) }}" class="btn btn-primary btn-sm rounded-pill px-3 fw-semibold shadow-sm">
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