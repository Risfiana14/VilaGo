<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Reservasi | VilaGo</title>
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
</head>
<body class="bg-light">
  <div class="container py-5">
    
    <!-- Header & Tombol Navigasi Kembali -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h3 class="mb-1 fw-bold">Daftar Reservasi VilaGo</h3>
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

    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <div class="card border-0 shadow-sm">
      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th>ID</th>
              <th>Nama Tamu</th>
              <th>Vila</th>
              <th>Check-in / Check-out</th>
              <th>Total Biaya</th>
              <th>Status</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($bookings as $booking)
              <tr>
                <td>#VG-{{ $booking->id }}</td>
                <td>
                  <strong>{{ $booking->customer_name }}</strong><br>
                  <small class="text-muted">{{ $booking->customer_phone }}</small>
                </td>
                <td>{{ $booking->villa->title ?? 'Vila Dihapus' }}</td>
                <td>
                  <span class="badge text-bg-light text-dark">{{ $booking->check_in }}</span> s/d 
                  <span class="badge text-bg-light text-dark">{{ $booking->check_out }}</span>
                </td>
                <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                <td>
                  @if($booking->status == 'pending')
                    <span class="badge bg-warning text-dark">Menunggu</span>
                  @elseif($booking->status == 'confirmed')
                    <span class="badge bg-primary">Dikonfirmasi</span>
                  @elseif($booking->status == 'completed')
                    <span class="badge bg-success">Selesai</span>
                  @else
                    <span class="badge bg-danger">Dibatalkan</span>
                  @endif
                </td>
                <td>
                  <div class="d-flex justify-content-center align-items-center gap-2">
                    <!-- Form Ubah Status Cepat -->
                    <form action="{{ route('bookings.updateStatus', $booking->id) }}" method="POST" class="d-inline">
                      @csrf
                      @method('PATCH')
                      <select name="status" onchange="this.form.submit()" class="form-select form-select-sm">
                        <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirm</option>
                        <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Complete</option>
                        <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancel</option>
                      </select>
                    </form>

                    <!-- Tombol Edit Data Booking -->
                    <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-sm btn-outline-warning text-dark" title="Edit Booking">
                      <i class="bi bi-pencil"></i> Edit
                    </a>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center py-4 text-muted">Belum ada transaksi reservasi yang tercatat.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>