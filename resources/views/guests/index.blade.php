<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Tamu | VilaGo</title>
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
    }
  </style>
</head>
<body>
  <div class="container py-5">
    
    <!-- Header Navigation -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h3 class="mb-1 fw-bold text-dark">Data Tamu VilaGo</h3>
        <p class="text-muted mb-0">Daftar rekapitulasi pelanggan yang pernah memesan vila.</p>
      </div>
      <div>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
          <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
        </a>
      </div>
    </div>

    <!-- Filter Pencarian -->
    <div class="row g-2 mb-3">
      <div class="col-md-6">
        <form action="{{ route('guests.index') }}" method="GET" class="d-flex gap-2">
          <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama atau nomor HP tamu..." value="{{ request('search') }}">
          <button type="submit" class="btn btn-sm btn-secondary"><i class="bi bi-search me-1"></i> Cari</button>
          @if(request('search'))
            <a href="{{ route('guests.index') }}" class="btn btn-sm btn-outline-danger"><i class="bi bi-x-circle"></i> Reset</a>
          @endif
        </form>
      </div>
    </div>

    <!-- Tabel Data Tamu -->
    <div class="card card-custom">
      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th class="ps-4">No</th>
              <th>Nama Tamu</th>
              <th>Nomor Telepon/WA</th>
              <th>Total Transaksi</th>
              <th>Total Pengeluaran (Selesai)</th>
              <th class="text-center pe-4">Aktivitas Terakhir</th>
            </tr>
          </thead>
          <tbody>
            @forelse($guests as $index => $guest)
              <tr>
                <td class="ps-4">{{ $loop->iteration }}</td>
                <td>
                  <strong class="text-dark"><i class="bi bi-person-circle me-1 text-primary"></i> {{ $guest->customer_name }}</strong>
                </td>
                <td>
                  <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $guest->customer_phone) }}" target="_blank" class="text-decoration-none text-success fw-semibold">
                    <i class="bi bi-whatsapp me-1"></i>{{ $guest->customer_phone }}
                  </a>
                </td>
                <td>
                  <span class="badge bg-info text-dark px-2 py-1">{{ $guest->total_bookings }} kali booking</span>
                </td>
                <td class="fw-bold text-primary">
                  Rp {{ number_format($guest->total_spent, 0, ',', '.') }}
                </td>
                <td class="text-center pe-4 text-muted small">
                  {{ \Carbon\Carbon::parse($guest->last_booking)->translatedFormat('d M Y, H:i') }} WIB
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center py-5 text-muted">
                  <i class="bi bi-people fs-2 d-block mb-2"></i>
                  Belum ada data tamu terdaftar.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>