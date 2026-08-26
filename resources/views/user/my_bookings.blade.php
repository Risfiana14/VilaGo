<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Riwayat Pemesanan | VilaGo</title>
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
  <style>
    body { background-color: #f8fafc; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    .custom-navbar { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-bottom: 1px solid #e2e8f0; }
    .brand-logo { width: 40px; height: 40px; background: linear-gradient(135deg, #0d6efd, #0a58ca); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; box-shadow: 0 4px 10px rgba(13, 110, 253, 0.25); }
    .nav-pill-custom { color: #64748b; font-weight: 600; font-size: 0.9rem; padding: 8px 16px; border-radius: 30px; transition: all 0.2s ease; }
    .nav-pill-custom:hover { color: #0d6efd; background-color: #f1f5f9; }
    .nav-pill-custom.active { color: #0d6efd !important; background-color: #eff6ff !important; }
    .user-profile-badge { background: #ffffff; border: 1px solid #e2e8f0; padding: 4px 12px 4px 6px; border-radius: 30px; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03); transition: all 0.2s ease; }
    .user-profile-badge:hover { background: #f1f5f9; border-color: #cbd5e1; }
    .user-avatar { width: 32px; height: 32px; background: linear-gradient(135deg, #2563eb, #1d4ed8); color: white; font-weight: 700; font-size: 0.85rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
  </style>
</head>
<body class="bg-light">

  <!-- Navbar Sleek & Clean -->
  <nav class="navbar navbar-expand-lg sticky-top custom-navbar py-2 shadow-sm">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center me-4" href="{{ route('user.dashboard') }}">
        <div class="brand-logo me-2">
          <i class="bi bi-house-door-fill fs-5"></i>
        </div>
        <span class="fw-bold fs-4 text-dark tracking-tight">Vila<span class="text-primary">Go</span></span>
      </a>

      <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#userNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="userNavbar">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-1">
          <li class="nav-item">
            <a class="nav-link nav-pill-custom" href="{{ route('user.dashboard') }}">
              <i class="bi bi-grid-fill me-1"></i> Daftar Vila
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-pill-custom active" href="{{ route('user.my_bookings') }}">
              <i class="bi bi-journal-check me-1"></i> Riwayat saya
            </a>
          </li>
        </ul>

        <div class="d-flex align-items-center gap-3 pt-2 pt-lg-0 border-top border-lg-0 border-light mt-2 mt-lg-0">
          <a href="{{ route('settings.index') }}" class="user-profile-badge d-flex align-items-center text-decoration-none" title="Buka Pengaturan Akun">
            <div class="user-avatar me-2">
              {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <span class="fw-semibold text-dark small pe-1">{{ Auth::user()->name }}</span>
          </a>

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
    <h4 class="fw-bold mb-3"><i class="bi bi-receipt me-2 text-primary"></i>Riwayat Reservasi & Pembayaran</h4>

    @if(session('success'))
      <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    @if(session('error'))
      <div class="alert alert-danger border-0 shadow-sm alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
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
                  <td>
                    @if($booking->status == 'cancelled')
                      <span class="badge bg-danger text-white mb-1 d-inline-block"><i class="bi bi-x-circle-fill me-1"></i>Dibatalkan</span>
                      @if($booking->payment_proof)
                        <small class="d-block text-muted">Proses Refund / Batal</small>
                      @endif
                    @elseif(in_array($booking->status, ['confirmed', 'completed']))
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
                    <div class="d-flex justify-content-end gap-1">
                      <button type="button" class="btn btn-sm {{ in_array($booking->status, ['confirmed', 'completed']) ? 'btn-outline-success' : ($booking->payment_proof ? 'btn-outline-primary' : 'btn-primary') }}" data-bs-toggle="modal" data-bs-target="#payModal{{ $booking->id }}">
                        <i class="bi {{ $booking->payment_proof ? 'bi-receipt' : 'bi-wallet2' }} me-1"></i> 
                        {{ in_array($booking->status, ['confirmed', 'completed']) ? 'Detail' : ($booking->payment_proof ? 'Lihat/Ganti' : 'Bayar') }}
                      </button>

                      @php
                        $checkInHours = \Carbon\Carbon::now()->diffInHours(\Carbon\Carbon::parse($booking->check_in), false);
                        $isPending = $booking->status === 'pending';
                        $isConfirmedH1 = ($booking->status === 'confirmed') && ($checkInHours >= 24);
                      @endphp

                      @if($isPending || $isConfirmedH1)
                        <form action="{{ route('user.cancel_booking', $booking->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                          @csrf
                          @method('PATCH')
                          <button type="submit" class="btn btn-sm btn-outline-danger" title="Batalkan Pesanan">
                            <i class="bi bi-x-circle me-1"></i> Batal
                          </button>
                        </form>
                      @endif
                    </div>

                    <!-- Modal Detail & Ulasan -->
                    <div class="modal fade text-start" id="payModal{{ $booking->id }}" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title fw-bold"><i class="bi bi-credit-card-2-front me-2 text-primary"></i>Informasi Pembayaran & Detail</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                          </div>
                          
                          <div class="modal-body">
                            @if($booking->status == 'cancelled')
                              <div class="alert alert-danger text-center mb-3">
                                <i class="bi bi-x-circle-fill fs-2 d-block mb-1"></i>
                                <strong class="d-block fs-6">Reservasi Ini Telah Dibatalkan</strong>
                                <small>Apabila dana sudah terlanjur dikirim, tim VilaGo akan segera memproses pengembalian dana ke rekening Anda.</small>
                              </div>
                            @elseif(in_array($booking->status, ['confirmed', 'completed']))
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

                            @if($booking->payment_proof)
                              <div class="mb-3 p-2 border rounded bg-light text-center">
                                <small class="fw-semibold d-block text-muted mb-2">Bukti Pembayaran Terkirim:</small>
                                <img src="{{ asset('assets/images/payments/' . $booking->payment_proof) }}" class="img-fluid rounded border" style="max-height: 200px;" alt="Bukti Transfer">
                              </div>
                            @endif

                            @if(!in_array($booking->status, ['confirmed', 'completed', 'cancelled']))
                              <form action="{{ route('user.upload_payment', $booking->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
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

                                <button type="submit" class="btn btn-primary btn-sm w-100">
                                  <i class="bi bi-upload me-1"></i> Kirim Bukti Pembayaran
                                </button>
                              </form>
                            @endif

                            <!-- Komponen Form / Hasil Ulasan (Hanya Muncul jika Status 'Completed') -->
                            @if($booking->status == 'completed')
                              <div class="border-top pt-3 mt-3">
                                <h6 class="fw-bold mb-2"><i class="bi bi-star-fill text-warning me-1"></i>Ulasan Pengalaman Menginap</h6>

                                @if($booking->review)
                                  <div class="p-3 bg-light rounded border">
                                    <div class="text-warning mb-1">
                                      @for($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star-fill{{ $i <= $booking->review->rating ? '' : ' text-muted opacity-25' }}"></i>
                                      @endfor
                                      <span class="fw-bold text-dark ms-1">({{ $booking->review->rating }}/5)</span>
                                    </div>
                                    <p class="mb-0 text-secondary small">"{{ $booking->review->comment }}"</p>
                                  </div>
                                @else
                                  <form action="{{ route('user.store_review', $booking->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-2">
                                      <label class="form-label small fw-semibold mb-1">Pilih Rating Bintang</label>
                                      <select name="rating" class="form-select form-select-sm" required>
                                        <option value="">-- Beri Bintang --</option>
                                        <option value="5">⭐⭐⭐⭐⭐ (5/5) Sangat Puas</option>
                                        <option value="4">⭐⭐⭐⭐ (4/5) Bagus</option>
                                        <option value="3">⭐⭐⭐ (3/5) Cukup</option>
                                        <option value="2">⭐⭐ (2/5) Kurang</option>
                                        <option value="1">⭐ (1/5) Buruk</option>
                                      </select>
                                    </div>

                                    <div class="mb-2">
                                      <label class="form-label small fw-semibold mb-1">Tuliskan Ulasan Anda</label>
                                      <textarea name="comment" class="form-control form-control-sm" rows="3" placeholder="Bagikan impresi Anda tentang kebersihan, fasilitas, dan kenyamanan vila..." required></textarea>
                                    </div>

                                    <button type="submit" class="btn btn-sm btn-warning text-dark fw-semibold w-100">
                                      <i class="bi bi-send me-1"></i> Kirim Ulasan
                                    </button>
                                  </form>
                                @endif
                              </div>
                            @endif
                          </div>

                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                          </div>
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