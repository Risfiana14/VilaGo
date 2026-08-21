<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="VilaGo - Dashboard Sistem Booking Vila">
  <title>Dashboard | VilaGo</title>

  <!-- CSS Asset Laravel Helper -->
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body>
  <div class="admin-shell">
    <div class="sidebar-backdrop" data-sidebar-close></div>

    <aside class="admin-sidebar" id="adminSidebar" aria-label="Main navigation">
      <div class="sidebar-header">
        <a class="brand-mark" href="{{ route('home') }}" aria-label="VilaGo dashboard">
          <span class="brand-icon"><i class="bi bi-house-door-fill" aria-hidden="true"></i></span>
          <span class="brand-copy">
            <span class="brand-title">VilaGo</span>
            <span class="brand-subtitle">Admin Booking Vila</span>
          </span>
        </a>
      </div>

      <nav class="sidebar-nav">
        <a class="nav-link active" href="{{ route('home') }}" aria-current="page">
          <span class="nav-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
          <span class="nav-text">Dashboard</span>
        </a>
        <a class="nav-link" href="{{ route('villas.create') }}">
          <span class="nav-icon"><i class="bi bi-building-add" aria-hidden="true"></i></span>
          <span class="nav-text">Tambah Vila</span>
        </a>
        <a class="nav-link" href="{{ route('bookings.index') }}">
          <span class="nav-icon"><i class="bi bi-journal-check" aria-hidden="true"></i></span>
          <span class="nav-text">Reservasi / Booking</span>
        </a>
        <a class="nav-link" href="#">
          <span class="nav-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
          <span class="nav-text">Data Tamu</span>
        </a>
        <a class="nav-link" href="#">
          <span class="nav-icon"><i class="bi bi-bar-chart-line" aria-hidden="true"></i></span>
          <span class="nav-text">Laporan Keuangan</span>
        </a>
        <a class="nav-link" href="#">
          <span class="nav-icon"><i class="bi bi-grid-3x3-gap" aria-hidden="true"></i></span>
          <span class="nav-text">Fasilitas</span>
        </a>
        <a class="nav-link" href="#">
          <span class="nav-icon"><i class="bi bi-gear" aria-hidden="true"></i></span>
          <span class="nav-text">Pengaturan</span>
        </a>
      </nav>

      <div class="sidebar-user">
        <img class="avatar-img avatar-md sidebar-user-avatar" src="{{ asset('assets/images/avatar/avatar.jpg') }}" alt="Admin VilaGo">
        <strong>{{ Auth::user()->name ?? 'Admin VilaGo' }}</strong>
        <small>Pengelola Sistem</small>
      </div>

      <div class="sidebar-footer">
        <span class="status-dot"></span>
        <span class="sidebar-footer-text">Sistem Berjalan Lancar</span>
      </div>
    </aside>

    <div class="admin-main">
      <nav class="navbar admin-navbar navbar-expand bg-white">
        <div class="container-fluid px-3 px-lg-4">
          <button class="sidebar-toggle" type="button" data-sidebar-toggle aria-controls="adminSidebar" aria-expanded="true" aria-label="Toggle sidebar">
            <span></span>
            <span></span>
            <span></span>
          </button>

          <form class="d-none d-md-flex ms-3 flex-grow-1" role="search">
            <input class="form-control search-input" type="search" placeholder="Cari data vila, pemesanan, atau tamu..." aria-label="Search">
          </form>

          <div class="navbar-actions ms-auto">
            <button class="icon-button theme-toggle" type="button" data-theme-toggle aria-label="Switch color theme" title="Switch color theme">
              <i class="bi bi-moon-stars" data-theme-icon aria-hidden="true"></i>
            </button>
            <div class="dropdown">
              <button class="icon-button" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Notifications">
                <span class="notification-dot"></span>
                <i class="bi bi-bell" aria-hidden="true"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end notification-menu">
                <div class="dropdown-header fw-bold text-body">Notifikasi Masuk</div>
                <a class="dropdown-item" href="#">
                  <span class="notification-title">Booking baru: Vila Luxury Sunset</span>
                  <span class="notification-time">4 menit lalu</span>
                </a>
                <a class="dropdown-item" href="#">
                  <span class="notification-title">Pembayaran diterima #VG-881</span>
                  <span class="notification-time">32 menit lalu</span>
                </a>
              </div>
            </div>

            <div class="dropdown">
              <button class="profile-button dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img class="avatar-img avatar-sm" src="{{ asset('assets/images/avatar/avatar.jpg') }}" alt="Admin VilaGo">
                <span class="profile-name d-none d-sm-inline">{{ Auth::user()->name ?? 'Admin VilaGo' }}</span>
              </button>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#">Profil Saya</a></li>
                <li><a class="dropdown-item" href="#">Pengaturan Akun</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#">Keluar</a></li>
              </ul>
            </div>
          </div>
        </div>
      </nav>

      <main class="dashboard-content">
        <div class="container-fluid px-3 px-lg-4 py-4">

          <!-- Alert Notifikasi Sukses -->
          @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
              <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          <div class="page-heading">
            <div class="page-heading-copy">
              <span class="page-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
              <div>
                <p class="eyebrow mb-1">Ringkasan Operasional</p>
                <h1 class="h3 mb-1">Dashboard VilaGo</h1>
                <p class="text-muted mb-0">Pantau performa sewa vila, reservasi, dan transaksi tamu dalam satu tempat.</p>
              </div>
            </div>
            <div class="heading-actions">
              <button class="btn btn-outline-secondary btn-sm" type="button"><i class="bi bi-download" aria-hidden="true"></i> Ekspor Data</button>
              <button class="btn btn-primary btn-sm" type="button"><i class="bi bi-file-earmark-plus" aria-hidden="true"></i> Buat Laporan</button>
            </div>
          </div>

          <!-- Section Metrics / Card Ringkasan Dinamis -->
          <section class="row g-3 mt-1" aria-label="Dashboard metrics">
            <div class="col-12 col-sm-6 col-xl-3">
              <article class="metric-card metric-primary">
                <div class="metric-top">
                  <span class="metric-label">Total Pendapatan</span>
                  <span class="metric-icon"><i class="bi bi-wallet2" aria-hidden="true"></i></span>
                </div>
                <div class="metric-value">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</div>
                <div class="metric-meta">
                  <span class="text-success">Transaksi Selesai</span>
                </div>
              </article>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
              <article class="metric-card metric-success">
                <div class="metric-top">
                  <span class="metric-label">Vila Tersedia</span>
                  <span class="metric-icon"><i class="bi bi-building-check" aria-hidden="true"></i></span>
                </div>
                <div class="metric-value">{{ $availableVillas ?? 0 }} Unit</div>
                <div class="metric-meta">
                  <span class="text-success">Siap Disewa</span>
                </div>
              </article>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
              <article class="metric-card metric-warning">
                <div class="metric-top">
                  <span class="metric-label">Total Unit Vila</span>
                  <span class="metric-icon"><i class="bi bi-building" aria-hidden="true"></i></span>
                </div>
                <div class="metric-value">{{ $totalVillas ?? $villas->count() }} Unit</div>
                <div class="metric-meta">
                  <span class="text-primary">Terdaftar di Sistem</span>
                </div>
              </article>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
              <article class="metric-card metric-danger">
                <div class="metric-top">
                  <span class="metric-label">Reservasi Aktif</span>
                  <span class="metric-icon"><i class="bi bi-journal-bookmark" aria-hidden="true"></i></span>
                </div>
                <div class="metric-value">{{ $activeBookings ?? 0 }} Pesanan</div>
                <div class="metric-meta">
                  <span class="text-warning">Pending & Confirmed</span>
                </div>
              </article>
            </div>
          </section>

          <!-- Section Grafik dan Aktivitas -->
          <section class="row g-3 mt-1">
            <div class="col-12 col-xl-8">
              <div class="panel">
                <div class="panel-header">
                  <div>
                    <h2 class="h5 mb-1 section-title"><i class="bi bi-graph-up-arrow" aria-hidden="true"></i><span>Grafik Penjualan</span></h2>
                    <p class="text-muted mb-0">Statistik pendapatan sewa bulanan tahun ini.</p>
                  </div>
                  <a class="btn btn-light btn-sm" href="#">Lihat Rincian</a>
                </div>

                <div class="chart-bars" aria-label="Sales performance chart">
                  <div class="chart-column bar-42"><span></span><small>Jan</small></div>
                  <div class="chart-column bar-58"><span></span><small>Feb</small></div>
                  <div class="chart-column bar-51"><span></span><small>Mar</small></div>
                  <div class="chart-column bar-72"><span></span><small>Apr</small></div>
                  <div class="chart-column bar-66"><span></span><small>Mei</small></div>
                  <div class="chart-column bar-83"><span></span><small>Jun</small></div>
                </div>
              </div>
            </div>

            <div class="col-12 col-xl-4">
              <div class="panel h-100">
                <div class="panel-header">
                  <div>
                    <h2 class="h5 mb-1 section-title"><i class="bi bi-activity" aria-hidden="true"></i><span>Aktivitas Terbaru</span></h2>
                    <p class="text-muted mb-0">Pembaruan operasional sistem.</p>
                  </div>
                </div>

                <div class="activity-list">
                  <div class="activity-item"><span class="activity-dot bg-primary"></span><div><p class="mb-1 fw-semibold">Vila Baru Didaftarkan</p><p class="text-muted small mb-0">Data vila berhasil ditambahkan ke database.</p></div></div>
                  <div class="activity-item"><span class="activity-dot bg-success"></span><div><p class="mb-1 fw-semibold">Pembayaran Lunas</p><p class="text-muted small mb-0">Transaksi reservasi terverifikasi.</p></div></div>
                  <div class="activity-item"><span class="activity-dot bg-warning"></span><div><p class="mb-1 fw-semibold">Permintaan Check-out</p><p class="text-muted small mb-0">Tamu melakukan proses check-out.</p></div></div>
                </div>
              </div>
            </div>
          </section>

          <div class="row g-2 mb-3">
          <!-- Section Tabel Daftar Vila -->
          <section class="panel mt-3">
            <div class="row g-2 mb-3">
              <div class="col-md-8">
                <form action="{{ route('home') }}" method="GET" class="d-flex gap-2">
                  <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama atau lokasi vila..." value="{{ request('search') }}">
                  
                  <select name="status" class="form-select form-select-sm" style="max-width: 160px;">
                    <option value="">Semua Status</option>
                    <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Tersedia</option>
                    <option value="booked" {{ request('status') == 'booked' ? 'selected' : '' }}>Tersewa</option>
                    <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                  </select>

                  <button type="submit" class="btn btn-sm btn-secondary"><i class="bi bi-search me-1"></i> Cari</button>
                  @if(request('search') || request('status'))
                    <a href="{{ route('home') }}" class="btn btn-sm btn-outline-danger"><i class="bi bi-x-circle"></i> Reset</a>
                  @endif
                </form>
              </div>
            </div>

            <div class="panel-header d-flex justify-content-between align-items-center">
              <div>
                <h2 class="h5 mb-1 section-title"><i class="bi bi-building" aria-hidden="true"></i><span>Daftar Vila Terdaftar</span></h2>
                <p class="text-muted mb-0">Data vila yang tersedia dalam database VilaGo.</p>
              </div>
              <a class="btn btn-primary btn-sm" href="{{ route('villas.create') }}">
                <i class="bi bi-plus-lg me-1"></i> Tambah Vila Baru
              </a>
            </div>
            <div class="table-responsive">
              <table class="table align-middle mb-0">
                <thead>
                  <tr>
                    <th scope="col">Nama Vila</th>
                    <th scope="col">Lokasi</th>
                    <th scope="col">Kapasitas</th>
                    <th scope="col">Harga / Malam</th>
                    <th scope="col">Status</th>
                    <th scope="col" class="text-end">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($villas as $villa)
                    <tr>
                      <td>
                        <div class="d-flex align-items-center gap-2">
                          <img class="avatar-img avatar-sm rounded" src="{{ asset('assets/images/' . ($villa->image ?? 'avatar/avatar-1.jpg')) }}" alt="{{ $villa->title }}">
                          <div>
                            <p class="fw-semibold mb-0">{{ $villa->title }}</p>
                            <p class="text-muted small mb-0">{{ Str::limit($villa->description, 30) }}</p>
                          </div>
                        </div>
                      </td>
                      <td>{{ $villa->location }}</td>
                      <td>{{ $villa->capacity }} Orang</td>
                      <td>Rp {{ number_format($villa->price_per_night, 0, ',', '.') }}</td>
                      <td>
                        @if($villa->status == 'available')
                          <span class="badge text-bg-success">Tersedia</span>
                        @elseif($villa->status == 'booked')
                          <span class="badge text-bg-warning">Tersewa</span>
                        @else
                          <span class="badge text-bg-secondary">Maintenance</span>
                        @endif
                      </td>
                      <td class="text-end">
                        <div class="btn-group btn-group-sm">
                          <a class="btn btn-outline-warning" href="{{ route('villas.edit', $villa->id) }}">
                            <i class="bi bi-pencil"></i> Edit
                          </a>
                          <form action="{{ route('villas.destroy', $villa->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus vila ini?')" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">
                              <i class="bi bi-trash"></i> Hapus
                            </button>
                          </form>
                        </div>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="6" class="text-center py-4 text-muted">Belum ada data vila. Klik tombol <strong>Tambah Vila Baru</strong> untuk memasukkan data.</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </section>

        </div>
      </main>

      <footer class="admin-footer">
        <div class="container-fluid px-3 px-lg-4">
          <span>Hak Cipta &copy; 2026 VilaGo. Hak Cipta Dilindungi Undang-Undang.</span>
          <span>Sistem Manajemen Booking Vila.</span>
        </div>
      </footer>
    </div>
  </div>

  <!-- JS Asset Laravel Helper -->
  <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>