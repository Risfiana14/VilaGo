<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Riwayat Pemesanan | VilaGo</title>
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
</head>
<body class="bg-light">

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg bg-white shadow-sm py-3 sticky-top">
    <div class="container">
      <a class="navbar-brand fw-bold text-primary fs-4" href="{{ route('user.dashboard') }}"><i class="bi bi-house-door-fill me-2"></i>VilaGo</a>
      <div class="d-flex align-items-center gap-3">
        <a href="{{ route('user.dashboard') }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-grid me-1"></i> Katalog Vila</a>
        <a href="{{ route('user.my_bookings') }}" class="btn btn-sm btn-primary"><i class="bi bi-journal-check me-1"></i> Riwayat Saya</a>
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-box-arrow-right me-1"></i> Logout</button>
        </form>
      </div>
    </div>
  </nav>

  <div class="container py-4">
    <h4 class="fw-bold mb-3"><i class="bi bi-receipt me-2 text-primary"></i>Riwayat Reservasi & Pembayaran</h4>

    <!-- Alert Sukses -->
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <div class="card border-0 shadow-sm rounded-3">
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th>Vila</th>
                <th>Tanggal Stay</th>
                <th>Total Bayar</th>
                <th>Status Pemesanan</th>
                <th>Status Pembayaran</th>
                <th class="text-end">Aksi / Instruksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($bookings as $booking)
                <tr>
                  <td>
                    <strong>{{ $booking->villa->title ?? 'Vila' }}</strong><br>
                    <small class="text-muted"><i class="bi bi-geo-alt"></i> {{ $booking->villa->location ?? '-' }}</small>
                  </td>
                  <td>
                    <small class="d-block">In: {{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y') }}</small>
                    <small class="d-block text-muted">Out: {{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }}</small>
                  </td>
                  <td class="fw-bold text-primary">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                  
                  <!-- Status Pemesanan -->
                  <td>
                    @if($booking->status == 'pending')
                      <span class="badge text-bg-warning">Menunggu Konfirmasi</span>
                    @elseif($booking->status == 'confirmed')
                      <span class="badge text-bg-primary">Dikonfirmasi</span>
                    @elseif($booking->status == 'completed')
                      <span class="badge text-bg-success">Selesai</span>
                    @else
                      <span class="badge text-bg-danger">Batal</span>
                    @endif
                  </td>

                  <!-- Status Pembayaran (Disinkronkan dengan Konfirmasi Admin) -->
                  <td>
                    @if(in_array($booking->status, ['confirmed', 'completed']))
                      <span class="badge bg-success text-white mb-1 d-inline-block"><i class="bi bi-patch-check-fill me-1"></i>Lunas</span>
                      @if($booking->payment_method)
                        <small class="d-block text-muted">via {{ $booking->payment_method }}</small>
                      @endif
                    @elseif($booking->payment_proof)
                      <span class="badge bg-info text-dark mb-1 d-inline-block"><i class="bi bi-clock-history me-1"></i>Menunggu Verifikasi</span>
                      <small class="d-block text-muted">via {{ $booking->payment_method ?? 'Transfer' }}</small>
                    @else
                      <span class="badge bg-secondary">Belum Lunas</span>
                    @endif
                  </td>

                  <td class="text-end">
                    <!-- Tombol Modal Upload / Detail -->
                    <button type="button" class="btn btn-sm {{ in_array($booking->status, ['confirmed', 'completed']) ? 'btn-outline-success' : ($booking->payment_proof ? 'btn-outline-primary' : 'btn-primary') }}" data-bs-toggle="modal" data-bs-target="#payModal{{ $booking->id }}">
                      <i class="bi {{ $booking->payment_proof ? 'bi-receipt' : 'bi-wallet2' }} me-1"></i> 
                      {{ in_array($booking->status, ['confirmed', 'completed']) ? 'Detail Pembayaran' : ($booking->payment_proof ? 'Lihat / Ganti Bukti' : 'Instruksi & Upload Bayar') }}
                    </button>

                    <!-- Modal Upload & Detail Pembayaran -->
                    <div class="modal fade text-start" id="payModal{{ $booking->id }}" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title fw-bold"><i class="bi bi-credit-card-2-front me-2 text-primary"></i>Informasi Pembayaran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          
                          <form action="{{ route('user.upload_payment', $booking->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                              
                              @if(in_array($booking->status, ['confirmed', 'completed']))
                                <div class="alert alert-success text-center mb-3">
                                  <i class="bi bi-check-circle-fill fs-2 d-block mb-1"></i>
                                  <strong class="d-block fs-6">Pembayaran Telah Diverifikasi & Lunas!</strong>
                                  <small>Terima kasih, reservasi Anda telah terkonfirmasi oleh Admin VilaGo.</small>
                                </div>
                              @else
                                <div class="alert alert-info small mb-3">
                                  Silakan transfer sebesar <strong class="text-primary fs-6">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</strong> ke rekening berikut:
                                  <ul class="mb-0 mt-2 ps-3 fw-semibold">
                                    <li>BCA: 8830-1234-56 (a.n. VilaGo Utama)</li>
                                    <li>Mandiri: 142-00-9876-543 (a.n. VilaGo Utama)</li>
                                  </ul>
                                </div>
                              @endif

                              <!-- Preview Bukti Pembayaran -->
                              @if($booking->payment_proof)
                                <div class="mb-3 p-2 border rounded bg-light text-center">
                                  <small class="fw-semibold d-block text-muted mb-2">Bukti Pembayaran Terkirim:</small>
                                  <img src="{{ asset('assets/images/payments/' . $booking->payment_proof) }}" class="img-fluid rounded border" style="max-height: 200px;" alt="Bukti Transfer">
                                </div>
                              @endif

                              @if(!in_array($booking->status, ['confirmed', 'completed']))
                                <div class="mb-3">
                                  <label class="form-label fw-semibold">Pilih Bank Transfer</label>
                                  <select name="payment_method" class="form-select" required>
                                    <option value="Bank BCA" {{ $booking->payment_method == 'Bank BCA' ? 'selected' : '' }}>Bank BCA</option>
                                    <option value="Bank Mandiri" {{ $booking->payment_method == 'Bank Mandiri' ? 'selected' : '' }}>Bank Mandiri</option>
                                    <option value="QRIS" {{ $booking->payment_method == 'QRIS' ? 'selected' : '' }}>QRIS</option>
                                  </select>
                                </div>

                                <div class="mb-3">
                                  <label class="form-label fw-semibold">
                                    {{ $booking->payment_proof ? 'Ganti File Bukti Transfer' : 'Unggah Bukti Transfer (Image)' }}
                                  </label>
                                  <input type="file" name="payment_proof" class="form-control" accept="image/*" required>
                                </div>
                              @endif

                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                              @if(!in_array($booking->status, ['confirmed', 'completed']))
                                <button type="submit" class="btn btn-primary btn-sm">
                                  <i class="bi bi-upload me-1"></i> Kirim Bukti Pembayaran
                                </button>
                              @endif
                            </div>
                          </form>

                        </div>
                      </div>
                    </div>

                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="text-center py-4 text-muted">Belum ada riwayat pemesanan.</td>
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