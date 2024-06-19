<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use App\Models\Seminar; 
use Illuminate\Support\Facades\Log;// Pastikan menggunakan model Seminar

class LPController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function landingpage()
    {
        $seminars = Seminar::all(); // Mengambil semua data seminar
        return view('index', compact('seminars')); // Mengirim data ke view home
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
        
            return view('detailseminar', compact('seminar', 'isRegistered'));
        } catch (\Exception $e) {
            Log::error('Gagal menampilkan detail seminar: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menampilkan detail seminar: ' . $e->getMessage());
        }
    }
    
}
