<?php

namespace App\Http\Controllers;

use App\Exports\CertificateExport;
use App\Models\CertificateTemplate;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Models\Seminar; 
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;// Pastikan menggunakan model Seminar
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Pembicara;
use App\Exports\PembicaraExport;
use App\Models\Materi;
use App\Exports\SeminarExport;
use App\Exports\MateriExport;


class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        Log::info('AdminController instantiated.');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        Log::info('Loading all seminars for the admin dashboard.');
        $seminars = Seminar::all();

        return view('admin.index', compact('seminars'));
    }

    public function filter($filter)
    {
        Log::info('Applying filter: ' . $filter);
        if ($filter == 'gratis') {
            $seminars = Seminar::with('pembicara')->where('is_paid', false)->get();
        } elseif ($filter == 'berbayar') {
            $seminars = Seminar::with('pembicara')->where('is_paid', true)->get();
        } else {
            Log::error('Invalid filter provided: ' . $filter);
            return redirect()->route('admin_dashboard');
        }

        return view('admin.index', compact('seminars'));
    }
    public function rekap()
    {
        Log::info('Memulai pengambilan semua data seminar untuk rekap');
        try {
            $seminars = Seminar::with('pembicara')->get(); // Atau logika lain untuk mendapatkan data seminar yang relevan
            Log::info('Berhasil mengambil semua data seminar untuk rekap');
            return view('admin.rekap', compact('seminars'));
        } catch (\Exception $e) {
            Log::error('Gagal mengambil data seminar untuk rekap: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengambil data seminar untuk rekap: ' . $e->getMessage());
        }
    }
    public function create()
    {
        Log::info('Loading all speakers for creating a new seminar.');
        $pembicaras = Pembicara::all();
        return view('admin.tambahseminar', compact('pembicaras'));
    }
    public function store(Request $request)
    {
        Log::info('Storing new seminar data.');
        $request->validate([
            'nama_seminar' => 'required|string|max:255',
            'tanggal_seminar' => 'required|date',
            'lokasi_seminar' => 'required|string|max:255',
            'google_map_link' => ['required', 'url', 'regex:/^https:\/\/maps\.app\.goo\.gl/'],
            'gambar_seminar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'start_registration' => 'required|date',
            'end_registration' => 'required|date|after_or_equal:start_registration',
            'pembicara_id' => 'required|exists:pembicaras,id', // Pastikan ini validasi ada
        ]);
    
        try {
            $seminar = new Seminar();
            $seminar->nama_seminar = $request->input('nama_seminar');
            $seminar->tanggal_seminar = $request->input('tanggal_seminar');
            $seminar->lokasi_seminar = $request->input('lokasi_seminar');
            $seminar->google_map_link = $request->input('google_map_link');
            $seminar->start_registration = $request->input('start_registration');
            $seminar->end_registration = $request->input('end_registration');
            $seminar->is_paid = $request->has('is_paid');
            $seminar->pembicara_id = $request->input('pembicara_id'); // Tambahkan ini
    
            // Upload gambar seminar
            if ($request->hasFile('gambar_seminar')) {
                $imageName = time() . '.' . $request->file('gambar_seminar')->extension();
                $request->file('gambar_seminar')->move(public_path('assets/images/gambar-seminar'), $imageName);
                $seminar->gambar_seminar = 'assets/images/gambar-seminar/' . $imageName;
            }
    
            $seminar->save();
    
            Log::info('Berhasil menyimpan data seminar');
    
            return redirect()->route('admin_dashboard')->with('success', 'Seminar berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data seminar: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        Log::info('Editing seminar with ID: ' . $id);
        try {
            $seminar = Seminar::with('pembicara')->findOrFail($id);
            $seminar->tanggal_seminar = \Carbon\Carbon::parse($seminar->tanggal_seminar);
            $pembicaras = Pembicara::all();
            return view('admin.editseminar', compact('seminar', 'pembicaras'));
        } catch (\Exception $e) {
            Log::error('Gagal mengedit seminar: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengedit seminar: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        Log::info('Updating seminar with ID: ' . $id);
        $request->validate([
            'nama_seminar' => 'required|string|max:255|unique:seminars,nama_seminar,' . $id,
            'tanggal_seminar' => 'required|date',
            'lokasi_seminar' => 'required|string|max:255',
            'is_paid' => 'required|boolean',
            'pembicara_id' => 'required|exists:pembicaras,id',
        ]);

        try {
            $seminar = Seminar::with('pembicara')->findOrFail($id);
            $seminar->nama_seminar = $request->input('nama_seminar');
            $seminar->tanggal_seminar = $request->input('tanggal_seminar');
            $seminar->lokasi_seminar = $request->input('lokasi_seminar');
            $seminar->is_paid = $request->input('is_paid');
            $seminar->pembicara_id = $request->input('pembicara_id');
            $seminar->save();

            return redirect()->route('admin.rekap')->with('success', 'Seminar berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui seminar: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui seminar: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        Log::info('Showing details for seminar with ID: ' . $id);
        try {
            $seminar = Seminar::with('pembicara')->findOrFail($id);
    
            return view('admin.detailseminar', compact('seminar'));
        } catch (\Exception $e) {
            Log::error('Gagal menampilkan detail seminar: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menampilkan detail seminar: ' . $e->getMessage());
        }
    }
    public function hapusseminar($id)
    {
        Log::info('Memulai proses penghapusan seminar dengan ID: ' . $id);
        try {
            $seminar = Seminar::with('pembicara')->findOrFail($id);
            $seminar->delete();
            Log::info('Seminar berhasil dihapus');
            return redirect()->route('seminars.rekap')->with('success', 'Seminar berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus seminar: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus seminar: ' . $e->getMessage());
        }
    }
    public function detailseminar($id)
    {
        Log::info('Fetching details for seminar with ID: ' . $id);
        try {
            $seminar = Seminar::with('pembicara')->findOrFail($id);
            $user_id = auth()->id();
            $isRegistered = Registration::where('user_id', $user_id)->where('seminar_id', $id)->exists();
        
            return view('LP.detailseminar', compact('seminar', 'isRegistered'));
        } catch (\Exception $e) {
            Log::error('Gagal menampilkan detail seminar: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menampilkan detail seminar: ' . $e->getMessage());
        }
    }
    public function daftarseminar($seminar_id)
    {
        Log::info('Registering for seminar with ID: ' . $seminar_id);
        try {
            $seminar = Seminar::with('pembicara')->findOrFail($seminar_id);
            $seminars = Seminar::with('pembicara')->all();
            return view('LP.daftarseminar', compact('seminar', 'seminars'));
        } catch (\Exception $e) {
            Log::error('Error saat mengambil data seminar: ' . $e->getMessage());
            return back()->withErrors('Terjadi kesalahan saat mengambil data seminar.');
        }
    }
    public function datapeserta()
    {
        Log::info('Fetching all participant data.');
        try {
            $registrations = Registration::with('seminar.pembicara')->get();
            return view('admin.datapeserta', compact('registrations'));
        } catch (\Exception $e) {
            Log::error('Error saat menampilkan registrasi: ' . $e->getMessage());
            return back()->withErrors('Terjadi kesalahan saat menampilkan data.');
        }
    }    public function editpeserta($id)
    {
        Log::info('Editing participant data for ID: ' . $id);
        try {
            $registration = Registration::findOrFail($id);
            $seminars = Seminar::with('pembicara')->all();
            return view('admin.editdatapeserta', compact('registration', 'seminars'));
        } catch (\Exception $e) {
            Log::error('Error saat mengambil data registrasi untuk edit: ' . $e->getMessage());
            return back()->withErrors('Terjadi kesalahan saat mengambil data registrasi.');
        }
    }
    public function updatepeserta(Request $request, $id)
    {
        Log::info('Updating participant data for ID: ' . $id);
        try {
            $registration = Registration::findOrFail($id);
    
            $request->validate([
                'identitas' => 'required',
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'instansi' => 'required',
                'info' => 'required',
                'seminar' => 'required|exists:seminars,id',
                'bukti_bayar' => 'sometimes|nullable|mimes:jpeg,png,pdf|max:2048',
                'status' => 'required|in:Belum diverifikasi,Sudah diverifikasi',
            ]);
    
            if ($request->hasFile('bukti_bayar')) {
                // Delete old file if exists
                if ($registration->bukti_bayar) {
                    Storage::delete(public_path($registration->bukti_bayar));
                }
    
                // Store new file
                $buktiBayarName = time() . '_' . $request->file('bukti_bayar')->getClientOriginalName();
                $request->file('bukti_bayar')->move(public_path('assets/images/bukti-bayar'), $buktiBayarName);
                $registration->bukti_bayar = 'assets/images/bukti-bayar/' . $buktiBayarName;
            }
    
            // Update registration details
            $registration->seminar_id = $request->seminar;
            $registration->identitas = $request->identitas;
            $registration->name = $request->name;
            $registration->email = $request->email;
            $registration->phone = $request->phone;
            $registration->instansi = $request->instansi;
            $registration->info = $request->info;
            $registration->status = $request->status;
    
            $registration->save();
    
            return redirect()->route('rekap_peserta')->with('success', 'Data registrasi berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error saat menyimpan perubahan registrasi: ' . $e->getMessage());
            return back()->withErrors('Terjadi kesalahan saat menyimpan perubahan data.')->withInput();
        }
    }
    
    public function rekapPeserta()
    {
        Log::info('Rekapitulating participant data.');
        try {
            $users = User::all();
            return view('admin.datapengguna', compact('users'));
        } catch (\Exception $e) {
            Log::error('Gagal mengambil rekap peserta: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengambil rekap peserta: ' . $e->getMessage());
        }
    }
    public function hapuspeserta($id)
    {
        Log::info('Deleting participant data for ID: ' . $id);
        try {
            $registration = Registration::findOrFail($id);
            $registration->delete();
            return redirect()->back()->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error deleting registration: ' . $e->getMessage());
            return back()->withErrors('Terjadi kesalahan saat menghapus data.');
        }
    }
    public function certificate()
    {
        Log::info('Memulai pengambilan semua data seminar untuk sertifikat');
        try {
            $seminars = Seminar::with('pembicara')->get(); // Mengambil semua data seminar
            Log::info('Berhasil mengambil semua data seminar untuk sertifikat');
            return view('admin.uploadsertif', compact('seminars'));
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
            if ($request->hasFile('certificate_template')) {
                $certificateName = time() . '_' . $request->file('certificate_template')->getClientOriginalName();
                $request->file('certificate_template')->move(public_path('assets/images/sertif-seminar'), $certificateName);
                $path = 'assets/images/sertif-seminar/' . $certificateName;
    
                Log::info('File berhasil diupload, menyimpan data template baru');
                $template = new CertificateTemplate();
                $template->name = $certificateName;
                $template->file_path = $path;
                $template->seminar_id = $seminarId;
                $template->access_time = $request->input('access_time');
                $template->save();
    
                Log::info('Template sertifikat baru berhasil disimpan');
                return back()->with('success', 'Template sertifikat berhasil diupload.');
            } else {
                Log::warning('Tidak ada file yang diupload');
                return back()->with('error', 'Tidak ada file yang diupload.');
            }
        } catch (\Exception $e) {
            Log::error('Gagal mengupload template sertifikat: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengupload template sertifikat: ' . $e->getMessage());
        }
    }
    public function updateCertificate(Request $request, $templateId)
    {
        Log::info('Updating certificate access time for template ID: ' . $templateId);
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


    public function export() 
    {
        return Excel::download(new PembicaraExport, 'pembicara.xlsx');
    }

    public function tambahPembicara()
    {
        $seminars = Seminar::all();
        return view('admin.tambahpembicara', compact('seminars'));
    }

    public function simpanPembicara(Request $request)
    {
        $request->validate([
            'nama_pembicara' => 'required|string|max:255',
            'topik' => 'required|string|max:255',
            'asal_instansi' => 'required|string|max:255',
        ]);

        $pembicara = new Pembicara([
            'nama_pembicara' => $request->nama_pembicara,
            'topik' => $request->topik,
            'asal_instansi' => $request->asal_instansi,
        ]);

        $pembicara->save();

        return redirect()->route('admin_dashboard')->with('success', 'Pembicara berhasil ditambahkan');
    }

    public function tambahMateri()
    {
        $seminars = Seminar::all();
        return view('admin.tambahMateri', compact('seminars'));
    }

    public function simpanMateri(Request $request)
    {
        $request->validate([
            'seminar_id' => 'required|exists:seminars,id',
            'judul_materi' => 'required|string|max:255',
            'file_materi.*' => 'required|file' // Validasi untuk multiple files
        ]);

        foreach ($request->file('file_materi') as $file) {
            $path = $file->store('public/materi');

            Materi::create([
                'seminar_id' => $request->seminar_id,
                'judul_materi' => $request->judul_materi,
                'file_path' => $path
            ]);
        }

        return redirect()->route('admin_dashboard')->with('success', 'Materi berhasil ditambahkan');
    }

    public function exportMateri()
    {
        return Excel::download(new MateriExport, 'seminar.xlsx');
    }

    public function exportSeminar()
    {
        return Excel::download(new SeminarExport, 'seminar.xlsx');
    }
}