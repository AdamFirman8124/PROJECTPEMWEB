<?php

namespace App\Http\Controllers;
use App\Models\CertificateTemplate;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Models\Seminar; 
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;// Pastikan menggunakan model Seminar

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
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $seminars = Seminar::all();

        return view('admin.index', compact('seminars'));
    }

    public function filter($filter)
    {
        if ($filter == 'gratis') {
            $seminars = Seminar::where('is_paid', false)->get();
        } elseif ($filter == 'berbayar') {
            $seminars = Seminar::where('is_paid', true)->get();
        } else {
            // Handle invalid filter case, for example redirect to default view
            return redirect()->route('admin_dashboard');
        }

        return view('admin.index', compact('seminars'));
    }
    public function rekap()
    {
        Log::info('Memulai pengambilan semua data seminar untuk rekap');
        try {
            $seminars = Seminar::all(); // Atau logika lain untuk mendapatkan data seminar yang relevan
            Log::info('Berhasil mengambil semua data seminar untuk rekap');
            return view('admin.rekap', compact('seminars'));
        } catch (\Exception $e) {
            Log::error('Gagal mengambil data seminar untuk rekap: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengambil data seminar untuk rekap: ' . $e->getMessage());
        }
    }
    public function create()
    {
        return view('admin.tambahseminar');
    }
    public function store(Request $request)
    {
        $request->validate([
            'pembicara' => 'required|string|max:255',
            'asal_instansi' => 'required|string|max:255',
            'topik' => 'required|string|max:255',
            'tanggal_seminar' => 'required|date',
            'lokasi_seminar' => 'required|string|max:255',
            'google_map_link' => ['required', 'url', 'regex:/^https:\/\/maps\.app\.goo\.gl/'],
            'gambar_seminar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'start_registration' => 'required|date',
            'end_registration' => 'required|date|after_or_equal:start_registration',
            'materi' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:2048'
        ]);
    
        try {
            $seminar = new Seminar();
            $seminar->pembicara = $request->input('pembicara');
            $seminar->asal_instansi = $request->input('asal_instansi');
            $seminar->topik = $request->input('topik');
            $seminar->tanggal_seminar = $request->input('tanggal_seminar');
            $seminar->lokasi_seminar = $request->input('lokasi_seminar');
            $seminar->google_map_link = $request->input('google_map_link');
            $seminar->start_registration = $request->input('start_registration');
            $seminar->end_registration = $request->input('end_registration');
            
            // Handle checkbox value
            $seminar->is_paid = $request->has('is_paid');
    
            // Upload gambar seminar
            if ($request->hasFile('gambar_seminar')) {
                $imageName = time() . '.' . $request->file('gambar_seminar')->extension();
                $request->file('gambar_seminar')->move(public_path('assets/images/gambar-seminar'), $imageName);
                $seminar->gambar_seminar = 'assets/images/gambar-seminar/' . $imageName;
            }
    
            if ($request->hasFile('materi')) {
                $materiName = time() . '_' . $request->file('materi')->getClientOriginalName();
                $request->file('materi')->move(public_path('assets/images/materi-seminar'), $materiName);
                $seminar->materi = 'assets/images/materi-seminar/' . $materiName;
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
        try {
            $seminar = Seminar::findOrFail($id);
            $seminar->tanggal_seminar = \Carbon\Carbon::parse($seminar->tanggal_seminar);
            return view('admin.editseminar', compact('seminar'));
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

            return redirect()->route('admin.rekap')->with('success', 'Seminar berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui seminar: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui seminar: ' . $e->getMessage());
        }
    }

    
    public function show($id)
    {
        try {
            $seminar = Seminar::findOrFail($id);
    
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
            $seminar = Seminar::findOrFail($id);
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
        try {
            $seminar = Seminar::findOrFail($id);
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
        try {
            $seminar = Seminar::findOrFail($seminar_id);
            $seminars = Seminar::all();
            return view('LP.daftarseminar', compact('seminar', 'seminars'));
        } catch (\Exception $e) {
            Log::error('Error saat mengambil data seminar: ' . $e->getMessage());
            return back()->withErrors('Terjadi kesalahan saat mengambil data seminar.');
        }
    }
    public function datapeserta()
    {
        try {
            $registrations = Registration::with('seminar')->get();
            return view('admin.datapeserta', compact('registrations'));
        } catch (\Exception $e) {
            Log::error('Error saat menampilkan registrasi: ' . $e->getMessage());
            return back()->withErrors('Terjadi kesalahan saat menampilkan data.');
        }
    }    public function editpeserta($id)
    {
        try {
            $registration = Registration::findOrFail($id);
            $seminars = Seminar::all();
            return view('admin.editdatapeserta', compact('registration', 'seminars'));
        } catch (\Exception $e) {
            Log::error('Error saat mengambil data registrasi untuk edit: ' . $e->getMessage());
            return back()->withErrors('Terjadi kesalahan saat mengambil data registrasi.');
        }
    }
    public function updatepeserta(Request $request, $id)
    {
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
            $seminars = Seminar::all(); // Mengambil semua data seminar
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

    
}
