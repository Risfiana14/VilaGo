<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kelola Fasilitas | VilaGo</title>
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
        <h3 class="mb-1 fw-bold text-dark">Kelola Fasilitas Vila</h3>
        <p class="text-muted mb-0">Daftar master fasilitas yang dapat disediakan di unit vila.</p>
      </div>
      <div>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
          <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
        </a>
      </div>
    </div>

    <!-- Alert Notifikasi -->
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <div class="row g-4">
      <!-- Form Tambah Fasilitas -->
      <div class="col-md-4">
        <div class="card card-custom p-4">
          <h5 class="fw-bold mb-3"><i class="bi bi-plus-circle me-2 text-primary"></i>Tambah Fasilitas</h5>
          <form action="{{ route('facilities.store') }}" method="POST">
            @csrf
            <div class="mb-3">
              <label class="form-label fw-semibold small">Nama Fasilitas</label>
              <input type="text" name="name" class="form-control" placeholder="Contoh: Kolam Renang" required>
            </div>
            <div class="mb-3">
              <label class="form-label fw-semibold small">Class Icon Bootstrap</label>
              <input type="text" name="icon" class="form-control" placeholder="Contoh: bi-water / bi-wifi" value="bi-check-circle" required>
              <small class="text-muted d-block mt-1">Gunakan class dari <a href="https://icons.getbootstrap.com/" target="_blank">Bootstrap Icons</a></small>
            </div>
            <button type="submit" class="btn btn-primary w-100 fw-semibold"><i class="bi bi-save me-1"></i> Simpan Fasilitas</button>
          </form>
        </div>
      </div>

      <!-- Tabel Daftar Fasilitas -->
      <div class="col-md-8">
        <div class="card card-custom">
          <div class="table-responsive">
            <table class="table align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th class="ps-4">No</th>
                  <th>Icon</th>
                  <th>Nama Fasilitas</th>
                  <th class="text-end pe-4">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($facilities as $facility)
                  <tr>
                    <td class="ps-4">{{ $loop->iteration }}</td>
                    <td>
                      <span class="fs-4 text-primary"><i class="bi {{ $facility->icon }}"></i></span>
                    </td>
                    <td class="fw-semibold text-dark">{{ $facility->name }}</td>
                    <td class="text-end pe-4">
                      <form action="{{ route('facilities.destroy', $facility->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus fasilitas ini?')" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Fasilitas">
                          <i class="bi bi-trash"></i> Hapus
                        </button>
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="4" class="text-center py-5 text-muted">
                      <i class="bi bi-grid-3x3-gap fs-2 d-block mb-2"></i>
                      Belum ada master fasilitas terdaftar.
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>
</body>
</html>