<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Home</title>
</head>

<body>
    {{-- Navbar/Header --}}
    @include('partials.navbar')

    <div class="container-fluid px-5 py-4 mt-5">

        <!-- Dropdown Pilih Bulan & Tahun -->
        <div class="d-flex justify-content-start mb-4">
            <select id="bulanPicker" class="form-select w-auto me-2">
                <option value="0">Januari</option>
                <option value="1">Februari</option>
                <option value="2">Maret</option>
                <option value="3">April</option>
                <option value="4">Mei</option>
                <option value="5">Juni</option>
                <option value="6">Juli</option>
                <option value="7">Agustus</option>
                <option value="8">September</option>
                <option value="9">Oktober</option>
                <option value="10">November</option>
                <option value="11">Desember</option>
            </select>
            <select id="tahunPicker" class="form-select w-auto"></select>
        </div>

        <!-- Tabel Booking -->
        <div class="table-responsive shadow rounded">
            <table id="bookingTable" class="table table-bordered text-start">
                <thead class="bg-dark text-white">
                    <tr>
                        <th>No</th>
                        <th>Jam Mulai</th>
                        <th>Jam Selesai</th>
                        <th>Ruangan</th>
                        <th>Departemen</th>
                        <th>Jumlah Orang</th>
                    </tr>
                </thead>
                <tbody id="bookingBody">
                    <tr>
                        <td colspan="6" class="text-center">Memuat data...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const bookingBody = document.getElementById("bookingBody");
        const bulanPicker = document.getElementById("bulanPicker");
        const tahunPicker = document.getElementById("tahunPicker");

        // Isi tahun (misal 2020–2030)
        const thisYear = new Date().getFullYear();
        for (let y = thisYear - 2; y <= thisYear + 5; y++) {
            let opt = document.createElement("option");
            opt.value = y;
            opt.textContent = y;
            if (y === thisYear) opt.selected = true;
            tahunPicker.appendChild(opt);
        }

        const thisMonth = new Date().getMonth();
        bulanPicker.value = thisMonth;

        // Render tabel booking
        async function renderBooking() {
            const bulan = parseInt(bulanPicker.value);
            const tahun = parseInt(tahunPicker.value);

            bookingBody.innerHTML = `<tr><td colspan="6" class="text-center">Memuat data...</td></tr>`;

            try {
                const res = await fetch(`/bookingdb/kalender?bulan=${bulan+1}&tahun=${tahun}`);
                console.log('Response status:', res.status); // lihat status HTTP

                const dataBooking = await res.json();
                console.log('Data booking:', dataBooking);


                if (dataBooking.length === 0) {
                    bookingBody.innerHTML = `<tr><td colspan="6" class="text-center">Belum ada booking</td></tr>`;
                    return;
                }

                bookingBody.innerHTML = "";
                dataBooking.forEach((booking, index) => {
                    const row = document.createElement("tr");
                    row.innerHTML = `
                        <td>${index + 1}</td>
                        <td>${booking.waktuMulai}</td>
                        <td>${booking.waktuSelesai}</td>
                        <td>${booking.ruangan}</td>
                        <td>${booking.divisi}</td>
                        <td>${booking.jumlah_orang}</td>
                    `;
                    bookingBody.appendChild(row);
                });
            } catch (error) {
                bookingBody.innerHTML = `<tr><td colspan="6" class="text-center text-danger">Gagal memuat data</td></tr>`;
                console.error(error);
            }
        }

        // Event listener
        bulanPicker.addEventListener('change', renderBooking);
        tahunPicker.addEventListener('change', renderBooking);

        // Render awal
        renderBooking();
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Footer --}}
    @include('partials.footer')
</body>




</html>