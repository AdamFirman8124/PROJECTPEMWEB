<?php

namespace App\Http\Controllers;

use App\Models\Seminar;
use Illuminate\Http\Request;
use App\Http\Controllers\SeminarMaterialsController;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\CertificateTemplate;
use App\Models\Registration;
use Dompdf\Dompdf;


class SeminarController extends Controller
{
    public function index()
    {
        Log::info('Memulai pengambilan semua data seminar');
        try {
            $seminars = Seminar::all(); // Mengambil semua data seminar
            Log::info('Berhasil mengambil semua data seminar');
            return view('seminar.rekap', compact('seminars')); // Mengirim data ke view
        } catch (\Exception $e) {
            Log::error('Gagal mengambil data seminar: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengambil data seminar: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        Log::info('Memulai proses validasi data seminar');
        $request->validate([
            'google_map_link' => ['required', 'regex:/^https:\/\/maps\.app\.goo\.gl/'],
            'tanggal_seminar' => 'required|date',
            'lokasi_seminar' => 'required|string|max:255',
            'is_paid' => 'nullable|boolean',
            'start_registration' => 'required|date',
            'end_registration' => 'required|date',
            'pembicara' => 'required|string|max:255',
            'asal_instansi' => 'required|string|max:255',
            'topik' => 'required|string|max:255',
            'gambar_seminar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'materi' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:2048'
        ]);
        Log::info('Validasi data seminar berhasil');

        try {
            Log::info('Memulai proses penyimpanan data seminar');
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
                Log::info('Memulai proses penyimpanan gambar seminar');
                $gambarFile = $request->file('gambar_seminar');
                $gambarName = time() . '_' . $gambarFile->getClientOriginalName();
                $gambarPath = $gambarFile->storeAs('public/seminar_images', $gambarName);
                $seminar->gambar_seminar = $gambarName;
                Log::info('Gambar seminar berhasil disimpan');
            }

            if ($request->hasFile('materi')) {
                Log::info('Memulai proses penyimpanan materi seminar');
                $materiFile = $request->file('materi');
                $materiName = time() . '_' . $materiFile->getClientOriginalName();
                $materiPath = $materiFile->storeAs('public/materi', $materiName);
                $seminar->materi = $materiName;
                Log::info('Materi seminar berhasil disimpan');
            }

            $seminar->save();
            Log::info('Berhasil menyimpan data seminar');
            return redirect()->route('seminar.rekap')->with('success', 'Seminar berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data seminar: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $seminar = Seminar::findOrFail($id);
            $user_id = auth()->id();
            $isRegistered = Registration::where('user_id', $user_id)->where('seminar_id', $id)->exists();
        
            return view('seminar.detail', compact('seminar', 'isRegistered'));
        } catch (\Exception $e) {
            Log::error('Gagal menampilkan detail seminar: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menampilkan detail seminar: ' . $e->getMessage());
        }
    }
    
    public function register(Request $request)
    {
        Log::info('Memulai proses pendaftaran seminar dengan ID: ' . $request->seminar_id);
        try {
            $seminar = Seminar::findOrFail($request->seminar_id);
            // Logika untuk menyimpan pendaftaran, misalnya menambahkan data ke tabel pendaftaran
            Log::info('Berhasil mendaftarkan seminar dengan ID: ' . $request->seminar_id);
            return redirect()->back()->with('success', 'Pendaftaran seminar berhasil');
        } catch (\Exception $e) {
            Log::error('Gagal mendaftarkan seminar: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mendaftarkan seminar: ' . $e->getMessage());
        }
    }

    public function rekapPeserta()
    {
        try {
            $users = User::all();
            return view('seminar.rekap-peserta', compact('users'));
        } catch (\Exception $e) {
            Log::error('Gagal mengambil rekap peserta: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengambil rekap peserta: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $seminar = Seminar::findOrFail($id);
            $seminar->tanggal_seminar = \Carbon\Carbon::parse($seminar->tanggal_seminar);
            return view('seminar.edit', compact('seminar'));
        } catch (\Exception $e) {
            Log::error('Gagal mengedit seminar: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengedit seminar: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'topik' => 'required|string|max:255',
            'tanggal_seminar' => 'required|date',
            'lokasi_seminar' => 'required|string|max:255',
            'pembicara' => 'required|string|max:255',
            'asal_instansi' => 'required|string|max:255'
        ]);

        try {
            $seminar = Seminar::findOrFail($id);
            $seminar->update($request->all());

            return redirect()->route('seminar.rekap')->with('success', 'Seminar berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui seminar: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui seminar: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        Log::info('Memulai proses penghapusan seminar dengan ID: ' . $id);
        try {
            $seminar = Seminar::findOrFail($id);
            $seminar->delete();
            Log::info('Seminar berhasil dihapus');
            return redirect()->route('seminars.rekap')->with('success', 'Seminar berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus seminar: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus seminar: ' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('seminar.create');
    }

    public function certificate()
    {
        Log::info('Memulai pengambilan semua data seminar untuk sertifikat');
        try {
            $seminars = Seminar::all(); // Mengambil semua data seminar
            Log::info('Berhasil mengambil semua data seminar untuk sertifikat');
            return view('seminar.certificate', compact('seminars'));
        } catch (\Exception $e) {
            Log::error('Gagal mengambil data seminar untuk sertifikat: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengambil data seminar untuk sertifikat: ' . $e->getMessage());
        }
    }

    public function uploadCertificate(Request $request, $seminarId)
    {
        Log::info('Memulai validasi data untuk upload template sertifikat');
        $request->validate([
            'certificate_template' => 'required|file|mimes:jpeg,png,pdf|max:2048',
            'access_time' => 'required|date' // Validasi input tanggal
        ]);

        Log::info('Validasi selesai, mencari template sertifikat yang ada');
        try {
            // Cek apakah sudah ada template sertifikat untuk seminar ini
            $existingTemplate = CertificateTemplate::where('seminar_id', $seminarId)->first();
            if ($existingTemplate) {
                Log::warning('Template sertifikat sudah ada untuk seminar ini');
                return back()->with('error', 'Template sertifikat sudah diupload untuk seminar ini.');
            }

            Log::info('Tidak ada template yang ada, memproses file upload');
            $file = $request->file('certificate_template');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/certificate_templates', $filename);

            Log::info('File berhasil diupload, menyimpan data template baru');
            $template = new CertificateTemplate();
            $template->name = $filename;
            $template->file_path = $path;
            $template->seminar_id = $seminarId;
            $template->access_time = $request->input('access_time');
            $template->save();

            Log::info('Template sertifikat baru berhasil disimpan');
            return back()->with('success', 'Template sertifikat berhasil diupload.');
        } catch (\Exception $e) {
            Log::error('Gagal mengupload template sertifikat: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengupload template sertifikat: ' . $e->getMessage());
        }
    }

    public function rekap()
    {
        Log::info('Memulai pengambilan semua data seminar untuk rekap');
        try {
            $seminars = Seminar::all();
            Log::info('Berhasil mengambil semua data seminar untuk rekap');
            return view('seminar.rekap', compact('seminars'));
        } catch (\Exception $e) {
            Log::error('Gagal mengambil data seminar untuk rekap: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengambil data seminar untuk rekap: ' . $e->getMessage());
        }
    }

    public function updateCertificate(Request $request, $templateId)
    {
        $request->validate([
            'access_time' => 'required|date'
        ]);

        try {
            $template = CertificateTemplate::find($templateId);
            if (!$template) {
                $template = new CertificateTemplate();
                $template->seminar_id = $request->seminar_id; // Pastikan Anda mengirim seminar_id dari form
            }
            $template->access_time = $request->input('access_time');
            $template->save();

            return back()->with('success', 'Tanggal akses sertifikat berhasil diupdate.');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui tanggal akses sertifikat: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui tanggal akses sertifikat: ' . $e->getMessage());
        }
    }

    public function showCertificateDetail($id)
    {
        try {
            $seminar = Seminar::with('certificateTemplate')->findOrFail($id);
            return view('seminar.certificate-detail', compact('seminar'));
        } catch (\Exception $e) {
            Log::error('Gagal menampilkan detail sertifikat: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menampilkan detail sertifikat: ' . $e->getMessage());
        }
    }

    public function downloadCertificate($id)
    {
        try {
            $seminar = Seminar::with('certificateTemplate')->findOrFail($id);
            $imgPath = public_path('storage/' . $seminar->certificateTemplate->file_path);

            $dompdf = new Dompdf();
            $dompdf->loadHtml('<img src="' . $imgPath . '" style="width: 100%;">');
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();

            return $dompdf->stream('certificate.pdf');
        } catch (\Exception $e) {
            Log::error('Gagal mendownload sertifikat: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mendownload sertifikat: ' . $e->getMessage());
        }
    }
}
