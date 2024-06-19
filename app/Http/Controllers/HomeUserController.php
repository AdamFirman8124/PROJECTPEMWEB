<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use App\Models\Seminar; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;// Pastikan menggunakan model Seminar
use App\Models\CertificateTemplate;

class HomeUserController extends Controller
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
        $userRegistrations = Registration::where('user_id', Auth::id())->pluck('seminar_id')->toArray();
        return view('LP.homeuser', compact('seminars', 'userRegistrations')); // Mengirim data ke view home
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
    public function show($id)
    {
        try {
            $seminar = Seminar::findOrFail($id);
            $user_id = Auth::id();
            $isRegistered = Registration::where('user_id', $user_id)->where('seminar_id', $id)->exists();
    
            $certificate = CertificateTemplate::where('seminar_id', $id)->first();
    
            return view('LP.detailseminar', compact('seminar', 'isRegistered', 'certificate'));
        } catch (\Exception $e) {
            Log::error('Gagal menampilkan detail seminar: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menampilkan detail seminar: ' . $e->getMessage());
        }
    }
    public function daftarseminar($seminar_id)
    {
        try {
            $seminar = Seminar::findOrFail($seminar_id);
            $isPaid = $seminar->is_paid;
            $seminars = Seminar::all();
            return view('LP.daftarseminar', compact('seminar', 'seminars', 'isPaid'));
        } catch (\Exception $e) {
            Log::error('Error saat mengambil data seminar: ' . $e->getMessage());
            return back()->withErrors('Terjadi kesalahan saat mengambil data seminar.');
        }
    }
    public function pendaftaranseminar(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'seminar_id' => 'required|exists:seminars,id',
                'identitas' => 'required',
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'instansi' => 'required',
                'info' => 'required',
                'bukti_bayar' => 'sometimes|nullable|mimes:jpeg,png,pdf|max:2048'
            ]);

            // Proses upload bukti pembayaran jika ada
            $buktiBayarPath = null;
            if ($request->hasFile('bukti_bayar')) {
                $buktiBayarName = time() . '_' . $request->file('bukti_bayar')->getClientOriginalName();
                $buktiBayarPath = 'assets/images/bukti-bayar/' . $buktiBayarName;
                $request->file('bukti_bayar')->move(public_path('assets/images/bukti-bayar'), $buktiBayarName);
            }

            // Simpan data registrasi
            Registration::create([
                'user_id' => Auth::id(),
                'seminar_id' => $request->seminar_id,
                'identitas' => $request->identitas,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'instansi' => $request->instansi,
                'info' => $request->info,
                'bukti_bayar' => $buktiBayarPath,
            ]);

            return redirect()->route('homeuser')->with('success', 'Pendaftaran berhasil.');
        } catch (\Exception $e) {
            Log::error('Error saat menyimpan pendaftaran: ' . $e->getMessage());
            return back()->withErrors('Terjadi kesalahan saat menyimpan pendaftaran.')->withInput();
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
    
}
