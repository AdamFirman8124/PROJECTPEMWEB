<?php

namespace App\Http\Controllers;

use App\Models\Seminar;
use Illuminate\Http\Request;
use App\Http\Controllers\SeminarMaterialsController;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\storage;

class SeminarController extends Controller
{
    public function index()
    {
        $seminars = Seminar::all(); // Mengambil semua data seminar
        return view('seminars.index', compact('seminars')); // Mengirim data ke view
    }

    public function store(Request $request)
    {
        $request->validate([
            'google_map_link' => ['required', 'regex:/^https:\/\/maps\.app\.goo\.gl/'],
            'tanggal_seminar' => 'required|date',
            'lokasi_seminar' => 'required|string|max:255',
            'is_paid' => 'required|boolean',
            'start_registration' => 'required|date',
            'end_registration' => 'required|date',
            'pembicara' => 'required|string|max:255',
            'asal_instansi' => 'required|string|max:255',
            'topik' => 'required|string|max:255',
            'gambar_seminar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'materi' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:2048'
        ]);

        try {
            $seminar = new Seminar();
            $seminar->tanggal_seminar = $request->input('tanggal_seminar');
            $seminar->lokasi_seminar = $request->input('lokasi_seminar');
            $seminar->google_map_link = $request->input('google_map_link');
            $seminar->is_paid = $request->input('is_paid');
            $seminar->start_registration = $request->input('start_registration');
            $seminar->end_registration = $request->input('end_registration');
            $seminar->pembicara = $request->input('pembicara');
            $seminar->asal_instansi = $request->input('asal_instansi');
            $seminar->topik = $request->input('topik');

            if ($request->hasFile('gambar_seminar')) {
                $gambarFile = $request->file('gambar_seminar');
                $gambarName = time() . '_' . $gambarFile->getClientOriginalName();
                $gambarPath = $gambarFile->storeAs('public/seminar_images', $gambarName);
                $seminar->gambar_seminar = $gambarName;
            }

            if ($request->hasFile('materi')) {
                $materiFile = $request->file('materi');
                $materiName = time() . '_' . $materiFile->getClientOriginalName();
                $materiPath = $materiFile->storeAs('public/materi', $materiName);
                $seminar->materi = $materiName;
            }

            $seminar->save();

            return redirect()->route('some.route')->with('success', 'Data berhasil disimpan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data seminar: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
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

    public function create()
    {
        return view('seminars.create');
    }

    public function certificate()
    {
        $seminars = Seminar::all(); // Mengambil semua data seminar
        return view('seminars.certificate', compact('seminars')); // Mengirim data ke view
    }

    public function uploadCertificate(Request $request)
    {
        Log::info('Request data:', $request->all()); // Log semua data request
        Log::info('File:', ['exists' => $request->hasFile('certificate_template')]);

        $request->validate([
            'certificate_template' => 'required|image|mimes:jpeg,png|max:2048',
            'tanggal_seminar' => 'required|date',
            'start_date' => 'required|date', // Validasi input tanggal mulai
        ]);

        if ($request->hasFile('certificate_template')) {
            $file = $request->file('certificate_template');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/certificate_templates', $filename);
        
            Log::info('Path yang disimpan:', ['path' => $path]);
        
            $seminar = new Seminar;
            $seminar->tanggal_seminar = $request->input('tanggal_seminar');
            $seminar->certificate_template = $filename; // Pastikan hanya nama file yang disimpan
            $seminar->start_date = $request->input('start_date'); // Menyimpan tanggal mulai unduh sertifikat

            if ($seminar->save()) {
                return back()->with('success', 'Template sertifikat berhasil diunggah.');
            } else {
                Log::error('Gagal menyimpan data seminar');
                return back()->with('error', 'Gagal menyimpan data');
            }
        } else {
            return back()->with('error', 'File tidak ditemukan.');
        }
    }
}

