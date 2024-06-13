<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\Seminar;
use Illuminate\Support\Facades\Log;
use App\Models\PaymentRecord;
use Illuminate\Support\Facades\Validator;

class RegistrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        Log::info('Middleware auth telah diatur pada RegistrationController');
    }

    public function create()
    {
        try {
            $seminars = Seminar::all();
            Log::info('Mengambil semua seminar untuk form registrasi');
            return view('registrations.create', compact('seminars'));
        } catch (\Exception $e) {
            Log::error('Error saat mengambil data seminar: ' . $e->getMessage());
            return back()->withErrors('Terjadi kesalahan saat mengambil data seminar.');
        }
    }
    public function store(Request $request)
    {
        Log::info('Memulai proses penyimpanan registrasi');
        
        try {
            Log::info('Memulai validasi data registrasi');
            
            $validator = Validator::make($request->all(), [
                'identitas' => 'required',
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'instansi' => 'required',
                'info' => 'required',
                'seminar' => [
                    'required',
                    function ($attribute, $value, $fail) use ($request) {
                        $seminar = Seminar::find($value);
                        if (!$seminar || ($seminar->is_paid && !$request->hasFile('payment_proof'))) {
                            $fail('The selected seminar is either invalid or requires a payment proof.');
                        }
                    },
                ],
                'bukti_bayar' => 'required_if:seminar.is_paid,1|mimes:jpeg,png,pdf',
            ]);
            
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            
            Log::info('Validasi data berhasil');
    
            // Inisialisasi variabel bukti pembayaran
            $paymentProofPath = null;
    
            // Upload file bukti pembayaran jika ada
            if ($request->hasFile('payment_proof')) {
                $paymentProofPath = $request->file('payment_proof')->store('public/payment_proofs');
                Log::info('File bukti pembayaran berhasil diupload');
            }
    
            Log::info('Memulai proses pembuatan registrasi baru');
    
            // Buat instance Registration
            $registration = Registration::create([
                'user_id' => auth()->id(),
                'seminar_id' => $request->seminar,
                'identitas' => $request->identitas,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'instansi' => $request->instansi,
                'info' => $request->info,
                'bukti_bayar' => $paymentProofPath, // Simpan path bukti pembayaran di sini
                'status' => 'Menunggu Konfirmasi' // Contoh status, sesuaikan dengan kebutuhan
            ]);
    
            Log::info('Registrasi baru telah dibuat');
    
            // Jika ada bukti pembayaran, simpan juga ke payment_records
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
            return back()->withErrors('Terjadi kesalahan saat menyimpan data.')->withInput();
        } finally {
            Log::info('Proses penyimpanan registrasi selesai');
        }
    }    

    public function index()
    {
        try {
            $registrations = Registration::with('seminar')->get();
            Log::info('Menampilkan semua registrasi');
            return view('registrations.index', compact('registrations'));
        } catch (\Exception $e) {
            Log::error('Error saat menampilkan registrasi: ' . $e->getMessage());
            return back()->withErrors('Terjadi kesalahan saat menampilkan data.');
        }
    }

    public function rekap($seminar_id)
    {
        try {
            $registrations = Registration::where('seminar_id', $seminar_id)->get();
            Log::info('Menampilkan rekap registrasi untuk seminar dengan ID: ' . $seminar_id);
            return view('registrations.rekap', compact('registrations'));
        } catch (\Exception $e) {
            Log::error('Error saat menampilkan rekap registrasi: ' . $e->getMessage());
            return back()->withErrors('Terjadi kesalahan saat menampilkan rekap data.');
        }
    }

    public function destroy($id)
    {
        try {
            $registration = Registration::findOrFail($id);
            $registration->delete();
            Log::info('Registrasi dengan ID: ' . $id . ' telah dihapus');
            return redirect()->back()->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error saat menghapus registrasi: ' . $e->getMessage());
            return back()->withErrors('Terjadi kesalahan saat menghapus data.');
        }
    }

    public function checkRegistration()
    {
        try {
            $user = auth()->user();
            $isRegistered = Registration::where('user_id', $user->id)->exists();
            Log::info('Memeriksa status registrasi untuk user dengan ID: ' . $user->id);
            return response()->json(['registered' => $isRegistered]);
        } catch (\Exception $e) {
            Log::error('Error saat memeriksa registrasi: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan saat memeriksa registrasi.'], 500);
        }
    }

    public function showRegistrations()
    {
        try {
            $user_id = auth()->id();
            $registrations = Registration::where('user_id', $user_id)->with('seminar')->get();
            Log::info('Menampilkan registrasi untuk user dengan ID: ' . $user_id);
            return view('home', compact('registrations'));
        } catch (\Exception $e) {
            Log::error('Error saat menampilkan registrasi: ' . $e->getMessage());
            return back()->withErrors('Terjadi kesalahan saat menampilkan data.');
        }
    }

    public function edit($id)
    {
        try {
            $registration = Registration::findOrFail($id);
            $seminars = Seminar::all();
            return view('registrations.edit', compact('registration', 'seminars'));
        } catch (\Exception $e) {
            Log::error('Error saat mengambil data registrasi untuk edit: ' . $e->getMessage());
            return back()->withErrors('Terjadi kesalahan saat mengambil data registrasi.');
        }
    }


    public function update(Request $request, $id)
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
                'bukti_bayar' => 'sometimes|mimes:jpeg,png,pdf',
                'status' => 'required|in:Belum diverifikasi,Sudah diverifikasi',
            ]);

            // Handle file upload if new file is provided
            if ($request->hasFile('bukti_bayar')) {
                // Delete old file if exists
                if ($registration->bukti_bayar) {
                    Storage::delete($registration->bukti_bayar);
                }

                // Store new file
                $registration->bukti_bayar = $request->file('bukti_bayar')->store('public/payment_proofs');
            }

            // Update other fields
            $registration->seminar_id = $request->seminar;
            $registration->identitas = $request->identitas;
            $registration->name = $request->name;
            $registration->email = $request->email;
            $registration->phone = $request->phone;
            $registration->instansi = $request->instansi;
            $registration->info = $request->info;
            $registration->status = $request->status;

            $registration->save();

            return redirect()->route('registrations.index')->with('success', 'Data registrasi berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error saat menyimpan perubahan registrasi: ' . $e->getMessage());
            return back()->withErrors('Terjadi kesalahan saat menyimpan perubahan data.')->withInput();
        }
    }

}
