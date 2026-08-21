<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Reservasi | VilaGo</title>
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
    .table > :not(caption) > * > * {
      padding: 1rem 0.75rem;
    }
    .btn-action {
      border-radius: 6px;
    }
  </style>
</head>
<body>
  <div class="container py-5">
    
    <!-- Header & Tombol Navigasi -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h3 class="mb-1 fw-bold text-dark">Daftar Reservasi VilaGo</h3>
        <p class="text-muted mb-0">Kelola riwayat pemesanan dan status konfirmasi tamu.</p>
      </div>
      <div class="d-flex gap-2">
        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
          <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
        </a>
        <a href="{{ route('bookings.create') }}" class="btn btn-primary">
          <i class="bi bi-plus-lg me-1"></i> Tambah Booking
        </a>
      </div>
    </div>

    <!-- Alert Notifikasi Sukses -->
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <!-- Tabel Data Reservasi -->
    <div class="card card-custom">
      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th class="ps-4">ID</th>
              <th>Nama Tamu</th>
              <th>Vila</th>
              <th>Check-in / Check-out</th>
              <th>Total Biaya</th>
              <th>Status</th>
              <th class="text-center pe-4">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($bookings as $booking)
              <tr>
                <td class="ps-4 fw-semibold text-secondary">#VG-{{ $booking->id }}</td>
                <td>
                  <strong class="text-dark">{{ $booking->customer_name }}</strong><br>
                  <small class="text-muted"><i class="bi bi-telephone me-1"></i>{{ $booking->customer_phone }}</small>
                </td>
                <td class="fw-medium">{{ $booking->villa->title ?? 'Vila Dihapus' }}</td>
                <td>
                  <span class="badge text-bg-light border text-dark">{{ $booking->check_in }}</span>
                  <small class="text-muted mx-1">s/d</small>
                  <span class="badge text-bg-light border text-dark">{{ $booking->check_out }}</span>
                </td>
                <td class="fw-bold text-primary">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                <td>
                  @if($booking->status == 'pending')
                    <span class="badge bg-warning text-dark px-2 py-1">Menunggu</span>
                  @elseif($booking->status == 'confirmed')
                    <span class="badge bg-primary px-2 py-1">Dikonfirmasi</span>
                  @elseif($booking->status == 'completed')
                    <span class="badge bg-success px-2 py-1">Selesai</span>
                  @else
                    <span class="badge bg-danger px-2 py-1">Dibatalkan</span>
                  @endif
                </td>
                <td class="pe-4">
                  <div class="d-flex justify-content-center align-items-center gap-2">
                    
                    <!-- Form Update Status Cepat -->
                    <form action="{{ route('bookings.updateStatus', $booking->id) }}" method="POST" class="d-inline">
                      @csrf
                      @method('PATCH')
                      <select name="status" onchange="this.form.submit()" class="form-select form-select-sm" style="min-width: 110px;">
                        <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirm</option>
                        <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Complete</option>
                        <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancel</option>
                      </select>
                    </form>

                    <!-- Tombol Edit -->
                    <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-sm btn-outline-warning text-dark btn-action" title="Edit Booking">
                      <i class="bi bi-pencil"></i>
                    </a>

                    <!-- Tombol Hapus -->
                    <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-outline-danger btn-action" title="Hapus Booking">
                        <i class="bi bi-trash"></i>
                      </button>
                    </form>

                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center py-5 text-muted">
                  <i class="bi bi-journal-x fs-2 d-block mb-2"></i>
                  Belum ada transaksi reservasi yang tercatat.
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