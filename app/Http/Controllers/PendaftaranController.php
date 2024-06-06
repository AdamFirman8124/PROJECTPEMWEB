<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seminar; // Assuming you have a Seminar model

class PendaftaranController extends Controller
{
    public function create()
    {
        $seminars = Seminar::all(); // Mengambil semua data seminar
        return view('daftar.create', compact('seminars'));
    }

    public function store(Request $request)
    {
        // Proses penyimpanan data pendaftaran
        return redirect()->route('home')->with('success', 'Pendaftaran berhasil!');
    }
}