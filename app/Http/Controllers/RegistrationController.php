<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\Seminar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    public function create($seminar_id)
    {
        $seminar = Seminar::findOrFail($seminar_id);
        return view('registrations.create', compact('seminar'));
    }

    public function store(Request $request, $seminar_id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|max:15',
        ]);

        $registration = new Registration();
        $registration->user_id = Auth::id();
        $registration->seminar_id = $seminar_id;
        $registration->name = $request->name;
        $registration->email = $request->email;
        $registration->phone = $request->phone;
        $registration->save();

        return redirect()->route('home')->with('success', 'Pendaftaran berhasil');
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
