<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\Seminar;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Exports\RegistrationExport; 
use Maatwebsite\Excel\Facades\Excel; 
use Mpdf\Mpdf;

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
            Log::error('Error fetching seminars: ' . $e->getMessage());
            return back()->withErrors('Terjadi kesalahan saat mengambil data seminar.');
        }
    }

    public function store(Request $request)
    {
        Log::info('Data received: ', $request->all());

        $request->validate([
            'seminar_id' => 'required|exists:seminars,id',
            'user_id' => 'required|exists:users,id',
            'identitas' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
            'instansi' => 'required|string|max:255',
            'info' => 'required|string|max:255',
            'bukti_bayar' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($request->hasFile('bukti_bayar')) {
            $file = $request->file('bukti_bayar');
            $path = $file->store('public/bukti-bayar');
            $filename = basename($path);
        } else {
            $filename = null;
        }

        $registration = new Registration();
        $registration->seminar_id = $request->input('seminar_id');
        $registration->user_id = $request->input('user_id');
        $registration->identitas = $request->input('identitas');
        $registration->name = $request->input('name');
        $registration->email = $request->input('email');
        $registration->phone = $request->input('phone');
        $registration->instansi = $request->input('instansi');
        $registration->info = $request->input('info');
        $registration->bukti_bayar = $filename;

        try {
            $registration->save();
            Log::info('Data saved successfully');
        } catch (\Exception $e) {
            Log::error('Error saving data: ' . $e->getMessage());
            return back()->withErrors('Terjadi kesalahan saat menyimpan data.');
        }

        return redirect()->route('home-user')->with('success', 'Pendaftaran berhasil!');
    }

    public function index()
    {
        try {
            $registrations = Registration::with('seminar')->get();
            return view('registrations.index', compact('registrations'));
        } catch (\Exception $e) {
            Log::error('Error displaying registrations: ' . $e->getMessage());
            return back()->withErrors('Terjadi kesalahan saat menampilkan data.');
        }
    }

    public function rekap($seminar_id)
    {
        try {
            $registrations = Registration::where('seminar_id', $seminar_id)->get();
            return view('registrations.rekap', compact('registrations'));
        } catch (\Exception $e) {
            Log::error('Error displaying recap data: ' . $e->getMessage());
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
            Log::error('Error deleting registration: ' . $e->getMessage());
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
            Log::error('Error checking registration: ' . $e->getMessage());
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
            Log::error('Error showing registrations: ' . $e->getMessage());
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
            Log::error('Error fetching registration data: ' . $e->getMessage());
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
            Log::error('Error updating registration: ' . $e->getMessage());
            return back()->withErrors('Terjadi kesalahan saat menyimpan perubahan data.')->withInput();
        }
    }

    public function export()
    {
        try {
            return Excel::download(new RegistrationExport, 'registrations.xlsx');
        } catch (\Exception $e) {
            Log::error('Error exporting registrations: ' . $e->getMessage());
            return back()->withErrors('Terjadi kesalahan saat mengekspor data.');
        }
    }
    public function exportPdf()
    {
        try {
            $registrations = Registration::with('seminar')->get();

            $html = view('registrations.pdf', compact('registrations'))->render();

            $mpdf = new Mpdf();

            $mpdf->WriteHTML($html);

            return $mpdf->Output('registrations.pdf', 'D');
        } catch (\Exception $e) {
            Log::error('Error exporting registrations to PDF: ' . $e->getMessage());
            return back()->withErrors('Terjadi kesalahan saat mengekspor data ke PDF.');
        }
    }

    public function show($id)
    {
        $seminar = Seminar::with('materi')->find($id);
        $registrations = Registration::where('seminar_id', $id)->get();

        return view('seminar.detail', compact('seminar', 'registrations'));
    }

}
