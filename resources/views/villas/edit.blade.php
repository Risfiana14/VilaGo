<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Data Vila | VilaGo</title>
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
</head>
<body class="bg-light">
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card shadow-sm border-0">
          <div class="card-header bg-warning text-dark py-3">
            <h5 class="mb-0 font-weight-bold"><i class="bi bi-pencil-square me-2"></i>Edit Data Vila</h5>
          </div>
          <div class="card-body p-4">

            <!-- Alert Notifikasi Error Validasi -->
            @if ($errors->any())
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><i class="bi bi-exclamation-triangle-fill me-2"></i> Gagal Memperbarui:</strong>
                <ul class="mb-0 mt-2">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif

            <form action="{{ route('villas.update', $villa->id) }}" method="POST">
              @csrf
              @method('PUT')

              <div class="mb-3">
                <label class="form-label fw-semibold">Nama Vila</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $villa->title) }}" required>
              </div>

              <div class="mb-3">
                <label class="form-label fw-semibold">Lokasi</label>
                <input type="text" name="location" class="form-control" value="{{ old('location', $villa->location) }}" required>
              </div>

              <div class="mb-3">
                <label class="form-label fw-semibold">Alamat Lengkap</label>
                <textarea name="address" class="form-control" rows="2" placeholder="Contoh: Jl. Raya Oro-Oro Ombo No. 12" required>{{ old('address') }}</textarea>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label fw-semibold">Harga per Malam (Rp)</label>
                  <input type="number" name="price_per_night" class="form-control" value="{{ old('price_per_night', $villa->price_per_night) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label fw-semibold">Kapasitas (Orang)</label>
                  <input type="number" name="capacity" class="form-control" value="{{ old('capacity', $villa->capacity) }}" required>
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label fw-semibold">Status Vila</label>
                <select name="status" class="form-select" required>
                  <option value="available" {{ old('status', $villa->status) == 'available' ? 'selected' : '' }}>Tersedia (Available)</option>
                  <option value="booked" {{ old('status', $villa->status) == 'booked' ? 'selected' : '' }}>Tersewa / Dibooking (Booked)</option>
                  <option value="maintenance" {{ old('status', $villa->status) == 'maintenance' ? 'selected' : '' }}>Dalam Perbaikan (Maintenance)</option>
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label fw-semibold">Deskripsi Vila</label>
                <textarea name="description" class="form-control" rows="4" required>{{ old('description', $villa->description) }}</textarea>
              </div>

              <div class="d-flex justify-content-between pt-2">
                <a href="{{ route('home') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Batal</a>
                <button type="submit" class="btn btn-warning text-dark fw-semibold"><i class="bi bi-check-circle me-1"></i> Perbarui Data</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>