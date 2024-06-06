<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\Seminar;

class RegistrationController extends Controller
{
    public function create()
    {
        $seminars = Seminar::all();
        return view('registrations.create', compact('seminars'));
    }

    public function store(Request $request)
    {
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