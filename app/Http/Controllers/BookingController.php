<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    // Menampilkan form
    public function create()
    {
        return view('booking');
    }

    // Menyimpan data ke database
    public function store(Request $request)
    {
        $request->validate([
            'ruangan' => 'required',
            'divisi' => 'required|string|max:255',
            'waktuMulai' => 'required|date',
            'waktuSelesai' => 'required|date|after_or_equal:waktuMulai',
            'status' => 'required|in:reserved,confirm,cancel',
        ]);

        Booking::create([
            'ruangan' => $request->ruangan,
            'divisi' => $request->divisi,
            'waktuMulai' => $request->waktuMulai,
            'waktuSelesai' => $request->waktuSelesai,
            'status' => $request->status,
        ]);

        return redirect('/booking')->with('success', 'Booking berhasil disimpan!');
    }

    public function getKalender(Request $request)
    {
        $bulan = $request->query('bulan', date('n'));
        $tahun = $request->query('tahun', date('Y'));
        $ruangan = $request->query('ruangan', 'Ruang A');

        $bookings = Booking::where('ruangan', $ruangan)
            ->whereMonth('waktuMulai', $bulan)
            ->whereYear('waktuMulai', $tahun)
            ->get(['divisi', 'waktuMulai', 'status']);

        $data = [];
        foreach ($bookings as $b) {
            $tanggal = \Carbon\Carbon::parse($b->waktuMulai)->format('Y-m-d');
            $data[$tanggal] = $b->divisi . ' (' . $b->status . ')';
        }

        return response()->json($data);
    }
}
