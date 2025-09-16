<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Ruangan;


class BookingController extends Controller
{
    // Menampilkan form
    public function create()
    {
        $id_ruangan = Ruangan::all();

        // kirim ke view booking.blade.php
        return view('booking', compact('id_ruangan'));
    }

    // Menyimpan data ke database
    public function store(Request $request)
    {
            dd($request->all());

        $request->validate([
            'id_ruangan' => 'required|integer',
            'divisi' => 'required|string|max:255',
            'waktuMulai' => 'required|date',
            'waktuSelesai' => 'required|date|after_or_equal:waktuMulai',
            'jumlah_orang' => 'required|integer|min:1',
        ]);

        Booking::create([
            'id_ruangan' => $request->id_ruangan,
            'divisi' => $request->divisi,
            'waktuMulai' => $request->waktuMulai,
            'waktuSelesai' => $request->waktuSelesai,
            'jumlah_orang' => $request->jumlah_orang,
        ]);

        return redirect('/booking')->with('success', 'Booking berhasil disimpan!');
    }

    // public function getKalender(Request $request)
    // {
    //     $bulan = $request->query('bulan', date('n'));
    //     $tahun = $request->query('tahun', date('Y'));
    //     $ruangan = $request->query('ruangan', 'Ruang A');

    //     $bookings = Booking::where('ruangan', $ruangan)
    //         ->whereMonth('waktuMulai', $bulan)
    //         ->whereYear('waktuMulai', $tahun)
    //         ->get(['divisi', 'waktuMulai', 'status']);

    //     $data = [];
    //     foreach ($bookings as $b) {
    //         $tanggal = \Carbon\Carbon::parse($b->waktuMulai)->format('Y-m-d');
    //         $data[$tanggal] = $b->divisi . ' (' . $b->status . ')';
    //     }

    //     return response()->json($data);
    // }

    public function index()
    {
        $bookings = \App\Models\Booking::orderBy('waktuMulai', 'asc')->get();
        return view('home', compact('bookings'));
    }

    public function getBookingTable(Request $request)
    {
        $bulan = $request->bulan; // 1–12
        $tahun = $request->tahun;

        $bookings = \App\Models\Booking::whereYear('waktuMulai', $tahun)
            ->whereMonth('waktuMulai', $bulan)
            ->orderBy('waktuMulai', 'asc')
            ->get(['waktuMulai', 'waktuSelesai', 'id_ruangan', 'divisi', 'jumlah_orang']);

        return response()->json($bookings);
    }
}
