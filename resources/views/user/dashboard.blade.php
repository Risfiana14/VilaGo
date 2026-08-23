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
  
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg bg-white shadow-sm py-3 sticky-top">
    <div class="container">
      <a class="navbar-brand fw-bold text-primary fs-4" href="{{ route('user.dashboard') }}"><i class="bi bi-house-door-fill me-2"></i>VilaGo</a>
      <div class="d-flex align-items-center gap-3">
        <span class="fw-semibold text-dark"><i class="bi bi-person-circle me-1 text-primary"></i> {{ Auth::user()->name }}</span>
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-box-arrow-right me-1"></i> Logout</button>
        </form>
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
      <span class="text-muted small">Pilih vila dan lakukan pemesanan secara langsung</span>
    </div>

    <!-- Alert Notifikasi -->
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    
    <!-- Katalog Vila -->
    <div class="row g-4">
      @php
        $villas = \App\Models\Villa::with('facilities')->where('status', 'available')->latest()->get();
      @endphp

      @forelse($villas as $index => $villa)
        @php
          // Penentuan file gambar lokal di public/assets/images/
          $localImage = 'vila-' . (($index % 4) + 1) . '.jpg'; 
          $imagePath = $villa->image && file_exists(public_path('assets/images/' . $villa->image)) 
                        ? $villa->image 
                        : $localImage;
        @endphp

        <div class="col-md-6 col-lg-4">
          <div class="card card-villa h-100">
            
            <!-- Gambar Vila & Badge Overlays -->
            <div class="villa-img-container">
              <img src="{{ asset('assets/images/' . $imagePath) }}" class="villa-img" alt="{{ $villa->title }}">
              <span class="badge bg-success badge-status">Tersedia</span>
              <span class="badge-capacity"><i class="bi bi-people-fill me-1"></i>Kapasitas: {{ $villa->capacity }} Orang</span>
            </div>

            <!-- Body Card -->
            <div class="card-body p-4 d-flex flex-column justify-content-between">
              <div>
                <h5 class="fw-bold text-dark mb-1">{{ $villa->title }}</h5>
                <p class="text-muted small mb-2"><i class="bi bi-geo-alt me-1 text-danger"></i>{{ $villa->location }}</p>
                <p class="text-secondary small mb-3">{{ Str::limit($villa->description, 85) }}</p>
                
                <!-- Fasilitas Utama -->
                <div class="mb-3">
                  <small class="fw-semibold text-muted d-block mb-2">Fasilitas Utama:</small>
                  <div class="d-flex flex-wrap gap-1">
                    @forelse($villa->facilities as $fac)
                      <span class="badge bg-light text-dark border"><i class="bi {{ $fac->icon }} text-primary me-1"></i> {{ $fac->name }}</span>
                    @empty
                      <span class="text-muted small">-</span>
                    @endforelse
                  </div>
                </div>
              </div>

              <!-- Footer Harga & Aksi Booking Langsung -->
              <div>
                <hr class="my-3 opacity-25">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <small class="text-muted d-block small">Harga per malam</small>
                    <span class="fw-bold text-primary fs-5">Rp {{ number_format($villa->price_per_night, 0, ',', '.') }}</span>
                  </div>
                  
                  <!-- Tombol Booking Diarahkan ke Form Pemesanan Aplikasi -->
                  <a href="{{ route('bookings.create', ['villa_id' => $villa->id]) }}" class="btn btn-primary fw-semibold btn-sm px-3 shadow-sm">
                    <i class="bi bi-journal-plus me-1"></i> Pesan Vila
                  </a>
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
</body>
</html>