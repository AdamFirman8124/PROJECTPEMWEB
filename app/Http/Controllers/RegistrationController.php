<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\Seminar;
use Illuminate\Support\Facades\Log;

class RegistrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        $seminars = Seminar::all();
        return view('registrations.create', compact('seminars'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'identitas' => 'required',
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'instansi' => 'required',
                'info' => 'required',
                'seminar' => 'required|exists:seminars,id',
            ]);

            Registration::create([
                'user_id' => auth()->id(),
                'seminar_id' => $request->seminar,
                'identitas' => $request->identitas,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'instansi' => $request->instansi,
                'info' => $request->info
            ]);

            return redirect()->route('home')->with('success', 'Berhasil Daftar');
        } catch (\Exception $e) {
            Log::error('Error saat menyimpan registrasi: ' . $e->getMessage());
            return back()->withErrors('Terjadi kesalahan saat menyimpan data.');
        }
    }       

    public function index()
    {
        $registrations = Registration::with('seminar')->get();
        return view('registrations.index', compact('registrations'));
    }

    public function rekap($seminar_id)
    {
        $registrations = Registration::where('seminar_id', $seminar_id)->get();
        return view('registrations.rekap', compact('registrations'));
    }
}