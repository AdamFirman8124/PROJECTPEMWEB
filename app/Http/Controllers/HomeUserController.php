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
            $seminars = Seminar::all();
            return view('LP.daftarseminar', compact('seminar', 'seminars'));
        } catch (\Exception $e) {
            Log::error('Error saat mengambil data seminar: ' . $e->getMessage());
            return back()->withErrors('Terjadi kesalahan saat mengambil data seminar.');
        }
    }
    
}
