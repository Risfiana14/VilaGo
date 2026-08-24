<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Tamu | VilaGo Admin</title>
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
</head>
<body class="bg-light">

  <div class="container py-4">
    
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h3 class="fw-bold mb-1">Data Tamu VilaGo</h3>
        <p class="text-muted small mb-0">Daftar rekapitulasi akun pendaftar dan nama tamu pemesan vila.</p>
      </div>
      <a href="{{ route('home') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard</a>
    </div>

    <!-- Form Pencarian -->
    <div class="card border-0 shadow-sm rounded-3 mb-4">
      <div class="card-body p-3">
        <form action="{{ route('guests.index') }}" method="GET" class="row g-2">
          <div class="col-md-5">
            <input type="text" name="search" class="form-control" placeholder="Cari nama tamu, nama akun, email, atau HP..." value="{{ request('search') }}">
          </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search me-1"></i> Cari</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Tabel Data Tamu -->
    <div class="card border-0 shadow-sm rounded-3">
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th class="ps-3">No</th>
                <th>Akun Pemesan (Pendaftar)</th>
                <th>Nama Tamu Menginap</th>
                <th>Nomor Telepon/WA</th>
                <th>Total Transaksi</th>
                <th>Total Pengeluaran (Selesai)</th>
                <th>Aktivitas Terakhir</th>
              </tr>
            </thead>
            <tbody>
              @forelse($guests as $index => $guest)
                <tr>
                  <td class="ps-3 fw-semibold">{{ $index + 1 }}</td>
                  
                  <!-- Kolom Akun Pendaftar (Nama Akun + Email) -->
                  <td>
                    <div class="d-flex align-items-center">
                      <i class="bi bi-person-badge fs-4 text-primary me-2"></i>
                      <div>
                        <strong class="d-block text-dark">{{ $guest->user->name ?? 'Guest/Offline' }}</strong>
                        <small class="text-primary"><i class="bi bi-envelope me-1"></i>{{ $guest->user->email ?? '-' }}</small>
                      </div>
                    </div>
                  </td>

                  <!-- Kolom Nama Tamu Yang Didatangkan/Menginap -->
                  <td>
                    <span class="fw-semibold text-dark"><i class="bi bi-person-fill me-1 text-secondary"></i>{{ $guest->customer_name }}</span>
                  </td>

                  <!-- Nomor Telepon / WA -->
                  <td>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $guest->customer_phone) }}" target="_blank" class="text-success text-decoration-none fw-semibold">
                      <i class="bi bi-whatsapp me-1"></i>{{ $guest->customer_phone }}
                    </a>
                  </td>

                  <td>
                    <span class="badge bg-info text-dark">1 kali booking</span>
                  </td>

                  <td class="fw-bold text-primary">
                    Rp {{ $guest->status == 'completed' ? number_format($guest->total_price, 0, ',', '.') : '0' }}
                  </td>

                  <td class="small text-muted">
                    {{ $guest->created_at ? $guest->created_at->format('d M Y, H:i') . ' WIB' : '-' }}
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="7" class="text-center py-4 text-muted">Belum ada data rekapitulasi tamu.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>

  <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>