<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use App\Models\Seminar; 
use Illuminate\Support\Facades\Log;// Pastikan menggunakan model Seminar

class HomeController extends Controller
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
        $seminars = Seminar::all(); // Mengambil semua data seminar
        if (auth()->user()->role === 'admin') {
            return redirect('/admin/dashboard');
        } else if (auth()->user()->role === 'user') {
            return redirect('/home-user');
        }
        return view('/', compact('seminars')); // Mengirim data ke view home
    }
    public function show($id)
    {
        try {
            $seminar = Seminar::findOrFail($id);
            $user_id = auth()->id();
            $isRegistered = Registration::where('user_id', $user_id)->where('seminar_id', $id)->exists();
        
            return view('LP.detail', compact('seminar', 'isRegistered'));
        } catch (\Exception $e) {
            Log::error('Gagal menampilkan detail seminar: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menampilkan detail seminar: ' . $e->getMessage());
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
}
