<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Tambahkan ini untuk memperbaiki error
use Illuminate\Support\Facades\Log; // Tambahkan ini untuk memperbaiki error undefined type 'Log'

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function logout(Request $request)
    {
        Log::info("Attempting to logout user: " . $request->user()->name);
        Auth::logout();
        return redirect('/');
    }
    protected function authenticated(Request $request, $user)
    {
        // Session::put('name', $user->name);
        if ($user->role === 'user') {
            return redirect('/home-user');
        } else {
            return redirect()->route('admin_dashboard');
        }
    }
    protected function redirectTo()
    {
        if (Auth::user()->role === 'admin') {
            return '/admin/dashboard';
        }

        return '/home';
    }
}
