<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Reservasi | VilaGo</title>
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
</head>
<body class="bg-light">
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card shadow-sm border-0">
          <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-0 font-weight-bold"><i class="bi bi-journal-plus me-2"></i>Tambah Reservasi Baru</h5>
          </div>
          <div class="card-body p-4">

            @if ($errors->any())
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><i class="bi bi-exclamation-triangle-fill me-2"></i> Gagal Menyimpan:</strong>
                <ul class="mb-0 mt-2">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif

            <form action="{{ route('bookings.store') }}" method="POST">
              @csrf

              <div class="mb-3">
                <label class="form-label fw-semibold">Pilih Vila</label>
                <!-- Menambahkan data-price pada elemen option -->
                <select name="villa_id" id="villa_id" class="form-select" required>
                  <option value="" data-price="0">-- Pilih Vila yang Tersedia --</option>
                  @foreach($villas as $villa)
                    <option value="{{ $villa->id }}" data-price="{{ $villa->price_per_night }}" {{ old('villa_id') == $villa->id ? 'selected' : '' }}>
                      {{ $villa->title }} - Rp {{ number_format($villa->price_per_night, 0, ',', '.') }} / malam
                    </option>
                  @endforeach
                </select>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label fw-semibold">Nama Tamu</label>
                  <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name') }}" placeholder="Contoh: Budi Santoso" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label fw-semibold">Nomor Telepon/WA</label>
                  <input type="text" name="customer_phone" class="form-control" value="{{ old('customer_phone') }}" placeholder="Contoh: 08123456789" required>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label fw-semibold">Tanggal Check-in</label>
                  <input type="date" name="check_in" id="check_in" class="form-control" value="{{ old('check_in') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label fw-semibold">Tanggal Check-out</label>
                  <input type="date" name="check_out" id="check_out" class="form-control" value="{{ old('check_out') }}" required>
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label fw-semibold">Total Biaya (Rp)</label>
                <!-- Input dijadikan readonly agar dihitung otomatis oleh sistem -->
                <input type="number" name="total_price" id="total_price" class="form-control bg-white" value="{{ old('total_price') }}" placeholder="0" readonly required>
                <small id="duration_info" class="text-muted fw-semibold"></small>
              </div>

              <div class="d-flex justify-content-between pt-2">
                <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Batal</a>
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle me-1"></i> Simpan Reservasi</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Skrip Perhitungan Otomatis -->
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
          durationInfo.innerText = `* Menginap selama ${nights} malam (Rp ${pricePerNight.toLocaleString('id-ID')} / malam)`;
          durationInfo.classList.remove('text-danger');
          durationInfo.classList.add('text-success');
        } else if (checkOutInput.value && checkInInput.value && checkOutDate <= checkInDate) {
          totalPriceInput.value = '';
          durationInfo.innerText = '* Tanggal check-out harus setelah tanggal check-in';
          durationInfo.classList.remove('text-success');
          durationInfo.classList.add('text-danger');
        } else {
          totalPriceInput.value = '';
          durationInfo.innerText = '';
        }
      }

      villaSelect.addEventListener('change', calculateTotal);
      checkInInput.addEventListener('change', calculateTotal);
      checkOutInput.addEventListener('change', calculateTotal);
    });
  </script>
</body>
</html>