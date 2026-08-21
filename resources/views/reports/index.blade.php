<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laporan Keuangan | VilaGo</title>
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
    @media print {
      .no-print {
        display: none !important;
      }
      body {
        background-color: #fff;
      }
      .card-custom {
        box-shadow: none;
        border: 1px solid #ddd;
      }
    }
  </style>
</head>
<body>
  <div class="container py-5">
    
    <!-- Header Navigation -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h3 class="mb-1 fw-bold text-dark">Laporan Keuangan VilaGo</h3>
        <p class="text-muted mb-0">Rekapitulasi pendapatan dari transaksi sewa vila yang telah selesai.</p>
      </div>
      <div class="no-print d-flex gap-2">
        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
          <i class="bi bi-arrow-left me-1"></i> Dashboard
        </a>
        <button onclick="window.print()" class="btn btn-primary">
          <i class="bi bi-printer me-1"></i> Cetak Laporan
        </button>
      </div>
    </div>

    <!-- Filter Rentang Tanggal -->
    <div class="card card-custom p-3 mb-4 no-print">
      <form action="{{ route('reports.index') }}" method="GET" class="row g-3 align-items-end">
        <div class="col-md-4">
          <label class="form-label fw-semibold small">Dari Tanggal Check-in</label>
          <input type="date" name="start_date" class="form-control form-control-sm" value="{{ request('start_date') }}">
        </div>
        <div class="col-md-4">
          <label class="form-label fw-semibold small">Sampai Tanggal Check-in</label>
          <input type="date" name="end_date" class="form-control form-control-sm" value="{{ request('end_date') }}">
        </div>
        <div class="col-md-4 d-flex gap-2">
          <button type="submit" class="btn btn-sm btn-secondary w-100"><i class="bi bi-filter me-1"></i> Filter Data</button>
          @if(request('start_date') || request('end_date'))
            <a href="{{ route('reports.index') }}" class="btn btn-sm btn-outline-danger w-100"><i class="bi bi-x-circle"></i> Reset</a>
          @endif
        </div>
      </form>
    </div>

    <!-- Ringkasan Statistik Keuangan -->
    <div class="row g-3 mb-4">
      <div class="col-md-4">
        <div class="card card-custom p-3 bg-white">
          <div class="text-muted small fw-semibold">Total Pendapatan (Lunas)</div>
          <div class="fs-3 fw-bold text-success">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card card-custom p-3 bg-white">
          <div class="text-muted small fw-semibold">Total Transaksi Selesai</div>
          <div class="fs-3 fw-bold text-dark">{{ $totalTransactions }} Transaksi</div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card card-custom p-3 bg-white">
          <div class="text-muted small fw-semibold">Rata-rata Pendapatan / Booking</div>
          <div class="fs-3 fw-bold text-primary">Rp {{ number_format($averageRevenue, 0, ',', '.') }}</div>
        </div>
      </div>
    </div>

    <!-- Tabel Detail Transaksi Keuangan -->
    <div class="card card-custom">
      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th class="ps-4">ID Transaksi</th>
              <th>Nama Tamu</th>
              <th>Vila</th>
              <th>Periode Sewa</th>
              <th class="text-end pe-4">Total Pendapatan</th>
            </tr>
          </thead>
          <tbody>
            @forelse($completedBookings as $booking)
              <tr>
                <td class="ps-4 fw-semibold text-secondary">#VG-{{ $booking->id }}</td>
                <td>
                  <strong class="text-dark">{{ $booking->customer_name }}</strong><br>
                  <small class="text-muted">{{ $booking->customer_phone }}</small>
                </td>
                <td>{{ $booking->villa->title ?? 'Vila Dihapus' }}</td>
                <td>
                  <span class="badge text-bg-light border text-dark">{{ $booking->check_in }}</span>
                  <small class="text-muted mx-1">s/d</small>
                  <span class="badge text-bg-light border text-dark">{{ $booking->check_out }}</span>
                </td>
                <td class="text-end pe-4 fw-bold text-success">
                  Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center py-5 text-muted">
                  <i class="bi bi-file-earmark-x fs-2 d-block mb-2"></i>
                  Belum ada data transaksi selesai pada periode ini.
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