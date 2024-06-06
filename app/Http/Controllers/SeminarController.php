<?php

namespace App\Http\Controllers;

use App\Models\Seminar;
use Illuminate\Http\Request;
use App\Http\Controllers\SeminarMaterialsController;
use App\Models\User;
use Illuminate\Support\Facades\Log; // Menambahkan use statement untuk Log

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

    public function show($id)
    {
        $seminar = Seminar::findOrFail($id);
        return view('seminar_materials.show', compact('seminar'));
    }
    
    public function register(Request $request)
    {
        $seminar = Seminar::findOrFail($request->seminar_id);
        // Logika untuk menyimpan pendaftaran, misalnya menambahkan data ke tabel pendaftaran
        return redirect()->back()->with('success', 'Pendaftaran seminar berhasil');
    }


    public function rekapPeserta()
    {
        $users = User::all(); // Mengambil semua data seminar
        return view('seminars.rekap-peserta', compact('users')); // Mengirim data ke view
    }

    public function edit($id)
    {
        $seminar = Seminar::findOrFail($id);
        return view('seminar.edit', compact('seminar'));
    }

    public function update(Request $request, $id)
    {
        $seminar = Seminar::findOrFail($id);
        $updateResult = $seminar->update($request->all());
        Log::info('Update Result:', ['result' => $updateResult]);
        return redirect()->route('home')->with('success', 'Seminar berhasil diperbarui');
    }

    public function destroy($id)
    {
        $seminar = Seminar::findOrFail($id);
        $seminar->delete();
        return redirect()->route('home')->with('success', 'Seminar berhasil dihapus');
    }
}