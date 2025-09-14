<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Booking</title>
    <style>
        html,
        body {
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1 0 auto;
            /* ambil sisa tinggi */
            display: flex;
            justify-content: center;
            /* center horizontal */
            align-items: center;
            /* center vertical */
            padding: 20px;
            background-color: #f8f9fa;
        }

        form {
            width: 100%;
            max-width: 800px;
            /* agar tidak terlalu lebar */
        }

        footer {
            flex-shrink: 0;
            /* selalu di bawah */
        }
    </style>
</head>

<body>

    {{-- Navbar/Header --}}
    @include('partials.navbar')
    <main>
        <form class="row g-3 shadow p-4 rounded bg-light" action="{{ url('/booking') }}" method="POST">
            @csrf
            <!-- Ruangan -->
            <div class="col-md-6">
                <label for="ruangan" class="form-label">Ruangan</label>
                <select class="form-select" id="ruangan" name="ruangan" required>
                    <option selected disabled value="">Pilih Ruangan...</option>
                    <option value="Ruangan A">Ruangan A</option>
                    <option value="Ruangan B">Ruangan B</option>
                    <option value="Ruangan C">Ruangan C</option>
                </select>
            </div>

            <!-- Divisi -->
            <div class="col-md-6">
                <label for="divisi" class="form-label">Divisi</label>
                <input type="text" class="form-control" id="divisi" name="divisi" placeholder="Masukkan divisi" required>
            </div>

            <!-- Waktu Mulai -->
            <div class="col-md-6">
                <label for="waktuMulai" class="form-label">Waktu Mulai</label>
                <input type="datetime-local" class="form-control" id="waktuMulai" name="waktuMulai" required>
            </div>

            <!-- Waktu Selesai -->
            <div class="col-md-6">
                <label for="waktuSelesai" class="form-label">Waktu Selesai</label>
                <input type="datetime-local" class="form-control" id="waktuSelesai" name="waktuSelesai" required>
            </div>

            <!-- Status -->
            <div class="col-md-6">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option selected disabled value="">Pilih Status...</option>
                    <option value="reserved">Reserved</option>
                    <option value="confirm">Confirm</option>
                    <option value="cancel">Cancel</option>
                </select>
            </div>

            <!-- Submit -->
            <div class="col-12 text-end">
                <button class="btn btn-primary px-4" type="submit">Simpan Booking</button>
            </div>
        </form>
    </main>

    {{-- Footer --}}
    @include('partials.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>