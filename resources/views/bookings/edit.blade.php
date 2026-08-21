<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Reservasi | VilaGo</title>
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
      overflow: hidden;
    }
    .card-header-custom {
      background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
      color: #212529;
      padding: 1.25rem 1.75rem;
    }
    .form-control, .form-select {
      border-radius: 8px;
      padding: 0.6rem 0.9rem;
      border: 1px solid #ced4da;
    }
    .btn-action {
      border-radius: 8px;
      padding: 0.6rem 1.4rem;
      font-weight: 600;
    }
  </style>
</head>
<body>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-lg-8 col-md-10">
        <div class="card card-custom">
          
          <div class="card-header-custom d-flex align-items-center justify-content-between">
            <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i>Edit Data Reservasi #VG-{{ $booking->id }}</h5>
            <span class="badge bg-dark text-white rounded-pill px-3 py-2">VilaGo System</span>
          </div>

          <div class="card-body p-4 p-md-5">

            @if ($errors->any())
              <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <strong class="fs-6"><i class="bi bi-exclamation-triangle-fill me-2"></i>Gagal Memperbarui Data:</strong>
                <ul class="mb-0 mt-2 ps-3 small">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif

            <form action="{{ route('bookings.update', $booking->id) }}" method="POST">
              @csrf
              @method('PUT')

              <div class="row g-3 mb-3">
                <div class="col-md-8">
                  <label class="form-label fw-semibold">Pilih Vila <span class="text-danger">*</span></label>
                  <select name="villa_id" id="villa_id" class="form-select" required>
                    @foreach($villas as $villa)
                      <option value="{{ $villa->id }}" data-price="{{ $villa->price_per_night }}" {{ old('villa_id', $booking->villa_id) == $villa->id ? 'selected' : '' }}>
                        {{ $villa->title }} - Rp {{ number_format($villa->price_per_night, 0, ',', '.') }} / malam
                      </option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-4">
                  <label class="form-label fw-semibold">Status Reservasi <span class="text-danger">*</span></label>
                  <select name="status" class="form-select" required>
                    <option value="pending" {{ old('status', $booking->status) == 'pending' ? 'selected' : '' }}>Pending (Menunggu)</option>
                    <option value="confirmed" {{ old('status', $booking->status) == 'confirmed' ? 'selected' : '' }}>Confirmed (Dikonfirmasi)</option>
                    <option value="completed" {{ old('status', $booking->status) == 'completed' ? 'selected' : '' }}>Completed (Selesai)</option>
                    <option value="cancelled" {{ old('status', $booking->status) == 'cancelled' ? 'selected' : '' }}>Cancelled (Dibatalkan)</option>
                  </select>
                </div>
              </div>

              <div class="row g-3 mb-3">
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Nama Tamu <span class="text-danger">*</span></label>
                  <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name', $booking->customer_name) }}" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Nomor Telepon/WA <span class="text-danger">*</span></label>
                  <input type="text" name="customer_phone" class="form-control" value="{{ old('customer_phone', $booking->customer_phone) }}" required>
                </div>
              </div>

              <div class="row g-3 mb-3">
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Tanggal Check-in <span class="text-danger">*</span></label>
                  <input type="date" name="check_in" id="check_in" class="form-control" value="{{ old('check_in', $booking->check_in) }}" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Tanggal Check-out <span class="text-danger">*</span></label>
                  <input type="date" name="check_out" id="check_out" class="form-control" value="{{ old('check_out', $booking->check_out) }}" required>
                </div>
              </div>

              <div class="mb-4">
                <label class="form-label fw-semibold">Total Biaya (Rp) <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text bg-light fw-semibold">Rp</span>
                  <input type="number" name="total_price" id="total_price" class="form-control bg-white" value="{{ old('total_price', $booking->total_price) }}" readonly required>
                </div>
                <small id="duration_info" class="text-muted fw-semibold mt-1 d-block"></small>
              </div>

              <hr class="my-4 text-muted opacity-25">

              <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary btn-action">
                  <i class="bi bi-arrow-left me-1"></i> Batal
                </a>
                <button type="submit" class="btn btn-warning btn-action fw-bold shadow-sm">
                  <i class="bi bi-check-circle me-1"></i> Perbarui Reservasi
                </button>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const villaSelect = document.getElementById('villa_id');
      const checkInInput = document.getElementById('check_in');
      const checkOutInput = document.getElementById('check_out');
      const totalPriceInput = document.getElementById('total_price');
      const durationInfo = document.getElementById('duration_info');

      function calculateTotal() {
        const selectedOption = villaSelect.options[villaSelect.selectedIndex];
        const pricePerNight = parseFloat(selectedOption.getAttribute('data-price')) || 0;
        
        const checkInDate = new Date(checkInInput.value);
        const checkOutDate = new Date(checkOutInput.value);

        if (pricePerNight > 0 && checkInInput.value && checkOutInput.value && checkOutDate > checkInDate) {
          const timeDiff = checkOutDate.getTime() - checkInDate.getTime();
          const nights = Math.ceil(timeDiff / (1000 * 3600 * 24));
          const total = nights * pricePerNight;

          totalPriceInput.value = total;
          durationInfo.innerText = `* Total untuk ${nights} malam menginap`;
          durationInfo.className = 'text-success fw-semibold mt-1 d-block';
        } else if (checkOutInput.value && checkInInput.value && checkOutDate <= checkInDate) {
          totalPriceInput.value = '';
          durationInfo.innerText = '* Tanggal check-out harus setelah check-in';
          durationInfo.className = 'text-danger fw-semibold mt-1 d-block';
        }
      }

      calculateTotal();
      villaSelect.addEventListener('change', calculateTotal);
      checkInInput.addEventListener('change', calculateTotal);
      checkOutInput.addEventListener('change', calculateTotal);
    });
  </script>
</body>
</html>