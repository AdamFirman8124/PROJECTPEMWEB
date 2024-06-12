<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\Seminar;
use Illuminate\Support\Facades\Log;
use App\Models\PaymentRecord;

class RegistrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        Log::info('Middleware auth telah diatur pada RegistrationController');
    }

    public function create()
    {
        $seminars = Seminar::all();
        Log::info('Mengambil semua seminar untuk form registrasi');
        return view('registrations.create', compact('seminars'));
    }

    public function store(Request $request)
    {
        Log::info('Memulai proses penyimpanan registrasi');
        try {
            Log::info('Memulai validasi data registrasi');
            $request->validate([
                'identitas' => 'required',
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'instansi' => 'required',
                'info' => 'required',
                'seminar' => 'required|exists:seminars,id',
                'payment_proof' => 'required_if:seminar.is_paid,1',
            ]);
            Log::info('Validasi data berhasil');

            $paymentProofPath = null;
            if ($request->hasFile('payment_proof')) {
                $paymentProofPath = $request->file('payment_proof')->store('public/payment_proofs');
            }

            Log::info('Memulai proses pembuatan registrasi baru');
            $registration = Registration::create([
                'user_id' => auth()->id(),
                'seminar_id' => $request->seminar,
                'identitas' => $request->identitas,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'instansi' => $request->instansi,
                'info' => $request->info,
                'payment_proof' => $paymentProofPath
            ]);
            Log::info('Registrasi baru telah dibuat');

            if ($paymentProofPath) {
                Log::info('Memulai proses penyimpanan data pembayaran');
                PaymentRecord::create([
                    'registration_id' => $registration->id,
                    'payment_proof_path' => $paymentProofPath
                ]);
                Log::info('Data pembayaran telah disimpan di tabel payment_records');
            }

            Log::info('Proses penyimpanan registrasi berhasil');
            return redirect()->route('home')->with('success', 'Berhasil Daftar');
        } catch (\Exception $e) {
            Log::error('Error saat menyimpan registrasi: ' . $e->getMessage());
            return back()->withErrors('Terjadi kesalahan saat menyimpan data.');
        } finally {
            Log::info('Proses penyimpanan registrasi selesai');
        }
    }       

    public function index()
    {
        $registrations = Registration::with('seminar')->get();
        Log::info('Menampilkan semua registrasi');
        return view('registrations.index', compact('registrations'));
    }    

    public function rekap($seminar_id)
    {
        $registrations = Registration::where('seminar_id', $seminar_id)->get();
        Log::info('Menampilkan rekap registrasi untuk seminar dengan ID: ' . $seminar_id);
        return view('registrations.rekap', compact('registrations'));
    }
    public function destroy($id)
    {
        $registration = Registration::findOrFail($id);
        $registration->delete();
        Log::info('Registrasi dengan ID: ' . $id . ' telah dihapus');
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
    public function checkRegistration()
    {
        try {
            $user = auth()->user();
            $isRegistered = Registration::where('user_id', $user->id)->exists(); // Memeriksa apakah pengguna sudah terdaftar
            Log::info('Memeriksa status registrasi untuk user dengan ID: ' . $user->id);
            return response()->json(['registered' => $isRegistered]);
        } catch (\Exception $e) {
            Log::error('Error saat memeriksa registrasi: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function showRegistrations()
    {
        $user_id = auth()->id();
        $registrations = Registration::where('user_id', $user_id)->with('seminar')->get();
        Log::info('Menampilkan registrasi untuk user dengan ID: ' . $user_id);
        return view('home', compact('registrations'));
    }

}

