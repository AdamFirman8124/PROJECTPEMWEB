<?php

namespace App\Http\Controllers;

use App\Models\Seminar;
use Illuminate\Http\Request;

class SeminarController extends Controller
{
    public function index()
    {
        $seminars = Seminar::all(); // Mengambil semua data seminar
        return view('seminars.index', compact('seminars')); // Mengirim data ke view
    }

    public function store(Request $request)
    {
        $seminar = new Seminar();
        $seminar->tanggal_seminar = $request->input('tanggal_seminar');
        $seminar->lokasi_seminar = $request->input('lokasi_seminar');
        $seminar->google_map_link = $request->input('google_map_link');
        $seminar->gambar_seminar = $request->input('gambar_seminar');
        $seminar->is_paid = $request->input('is_paid');
        $seminar->start_registration = $request->input('start_registration');
        $seminar->end_registration = $request->input('end_registration');
        $seminar->pembicara = $request->input('pembicara');
        $seminar->asal_instansi = $request->input('asal_instansi');
        $seminar->topik = $request->input('topik');
        $seminar->save();

        return redirect()->back()->with('success', 'Seminar berhasil ditambahkan');
    }
}
