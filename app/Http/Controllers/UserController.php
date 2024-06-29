<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('seminar.rekap-peserta', compact('users'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus');
    }

    // UserController.php
    public function editRole($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit-role', compact('user'));
    }

    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|string|in:admin,user',
        ]);

        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();

        return redirect()->route('users.index')->with('success', 'Role pengguna berhasil diperbarui');
    }
    
    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function downloadPdf()
    {
        $users = User::all();
        $html = view('users.pdf', compact('users'))->render();

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        $pdfOutput = $mpdf->Output('', 'S');

        return response($pdfOutput, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="users.pdf"');
    }
}
