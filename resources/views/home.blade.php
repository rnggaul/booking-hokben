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
        <!-- Pilih Ruangan -->
        <div class="d-flex justify-content-start mb-4">
            <select id="ruanganPicker" class="form-select w-auto me-2">
                <option value="ruangan A">Ruangan A</option>
                <option value="ruangan B">Ruangan B</option>
                <option value="ruangan C">Ruangan C</option>
            </select>
        </div>

        <!-- Dropdown Pilih Bulan -->
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
            <select id="tahunPicker" class="form-select w-auto">
                <!-- JS akan isi range tahun -->
            </select>
        </div>

        <!-- Kalender -->
        <div class="table-responsive shadow rounded">
            <table id="kalender" class="table table-bordered text-start" style="table-layout: fixed;">
                <thead class="bg-white text-dark">
                    <tr>
                        <th class="text-center fw-semibold">Senin</th>
                        <th class="text-center fw-semibold">Selasa</th>
                        <th class="text-center fw-semibold">Rabu</th>
                        <th class="text-center fw-semibold">Kamis</th>
                        <th class="text-center fw-semibold">Jumat</th>
                        <th class="text-center fw-semibold bg-light">Sabtu</th>
                        <th class="text-center fw-semibold bg-light">Minggu</th>
                    </tr>
                </thead>
                <tbody id="kalenderBody"></tbody>
            </table>
        </div>
    </div>

    <script>
        
        const kalenderBody = document.getElementById("kalenderBody");
        const bulanPicker = document.getElementById("bulanPicker");
        const tahunPicker = document.getElementById("tahunPicker");

        // Isi tahun (misalnya 2020–2030)
        const thisYear = new Date().getFullYear();
        for (let y = thisYear - 2; y <= thisYear + 5; y++) {
            let opt = document.createElement("option");
            opt.value = y;
            opt.textContent = y;
            if (y === thisYear) opt.selected = true;
            tahunPicker.appendChild(opt);
        }

        // Fungsi render kalender
        async function renderKalender() {
            const bulan = parseInt(document.getElementById('bulanPicker').value);
            const tahun = parseInt(document.getElementById('tahunPicker').value);
            const ruangan = document.getElementById('ruanganPicker').value;
            const kalenderBody = document.getElementById('kalenderBody');

            kalenderBody.innerHTML = "";

            // Fetch data dari Laravel
            const res = await fetch(`/bookingdb/kalender?bulan=${bulan+1}&tahun=${tahun}&ruangan=${ruangan}`);
            const dataBooking = await res.json();

            const firstDay = new Date(tahun, bulan, 1);
            const lastDay = new Date(tahun, bulan + 1, 0);
            const startDay = (firstDay.getDay() + 6) % 7; // Senin=0
            let date = 1;

            for (let i = 0; i < 6; i++) {
                let row = document.createElement("tr");
                for (let j = 0; j < 7; j++) {
                    let cell = document.createElement("td");
                    cell.style.height = "100px";
                    cell.style.verticalAlign = "top";
                    cell.style.textAlign = "left";
                    cell.style.padding = "5px";

                    if (i === 0 && j < startDay) {
                        cell.innerHTML = "";
                    } else if (date > lastDay.getDate()) {
                        cell.innerHTML = "";
                    } else {
                        let tanggal = `${tahun}-${String(bulan + 1).padStart(2,'0')}-${String(date).padStart(2,'0')}`;
                        let isi = `<strong>${date}</strong>`;
                        if (dataBooking[tanggal]) {
                            isi += `<br><span class="badge bg-primary">${dataBooking[tanggal]}</span>`;
                        }
                        cell.innerHTML = isi;
                        date++;
                    }
                    row.appendChild(cell);
                }
                kalenderBody.appendChild(row);
            }
        }

        // Event listener
        document.getElementById('bulanPicker').addEventListener('change', renderKalender);
        document.getElementById('tahunPicker').addEventListener('change', renderKalender);
        document.getElementById('ruanganPicker').addEventListener('change', renderKalender);

        // Render awal
        renderKalender();
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Footer --}}
    @include('partials.footer')
</body>

</html>