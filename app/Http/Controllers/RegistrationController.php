<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\Seminar;
use Illuminate\Support\Facades\Log;
use App\Models\PaymentRecord;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage; // Pastikan untuk menambahkan ini jika belum ada

class RegistrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        try {
            $seminars = Seminar::all();
            return view('registrations.create', compact('seminars'));
        } catch (\Exception $e) {
            Log::error('Error saat mengambil data seminar: ' . $e->getMessage());
            return back()->withErrors('Terjadi kesalahan saat mengambil data seminar.');
        }
    }
    public function store(Request $request)
    {
        try {
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
                        Log::info('Seminar ID: ' . $value . ' is_paid status: ' . $seminar->is_paid);
                        if (!$seminar) {
                            $fail('Seminar yang dipilih tidak valid.');
                        } elseif ($seminar->is_paid === 1 && !$request->hasFile('payment_proof')) {
                            $fail('Bukti pembayaran diperlukan untuk seminar yang dipilih.');
                        }
                    },
                ],
                'payment_proof' => 'required_if:seminar.is_paid,1|mimes:jpeg,png,pdf',
            ]);
            
            if ($validator->fails()) {
                Log::error('Validasi data gagal dengan error: ' . json_encode($validator->errors()));
                return back()->withErrors($validator)->withInput();
            }
    
            $paymentProofPath = null;
    
            if ($request->hasFile('payment_proof')) {
                $paymentProofPath = $request->file('payment_proof')->store('public/payment_proofs');
            }
    
            $registration = Registration::create([
                'user_id' => auth()->id(),
                'seminar_id' => $request->seminar,
                'identitas' => $request->identitas,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'instansi' => $request->instansi,
                'info' => $request->info,
                'bukti_bayar' => $paymentProofPath,
                'status' => 'Menunggu Konfirmasi'
            ]);
    
            if ($paymentProofPath) {
                PaymentRecord::create([
                    'registration_id' => $registration->id,
                    'payment_proof_path' => $paymentProofPath
                ]);
            }
    
            return redirect()->route('home')->with('success', 'Berhasil Daftar');
        } catch (\Exception $e) {
            Log::error('Error saat menyimpan registrasi: ' . $e->getMessage());
            return back()->withErrors('Terjadi kesalahan saat menyimpan data.')->withInput();
        }
    }    

    public function index()
    {
        try {
            $registrations = Registration::with('seminar')->get();
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

            if ($request->hasFile('bukti_bayar')) {
                if ($registration->bukti_bayar) {
                    Storage::delete($registration->bukti_bayar);
                }

                $registration->bukti_bayar = $request->file('bukti_bayar')->store('public/payment_proofs');
            }

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
