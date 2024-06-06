<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificate;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::all();
        return view('certificates', compact('certificates'));
    }

    public function create()
    {
        return view('certificates.create');
    }

    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            // tambahkan validasi sesuai kebutuhan
        ]);

        // Simpan sertifikat
        Certificate::create($request->all());

        return redirect()->route('certificates.index')
            ->with('success', 'Sertifikat berhasil dibuat.');
    }

    public function show($id)
    {
        $certificate = Certificate::findOrFail($id);
        return view('certificates.show', compact('certificate'));
    }

    public function edit($id)
    {
        $certificate = Certificate::findOrFail($id);
        return view('certificates.edit', compact('certificate'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data
        $request->validate([
            // tambahkan validasi sesuai kebutuhan
        ]);

        // Update sertifikat
        Certificate::findOrFail($id)->update($request->all());

        return redirect()->route('certificates.index')
            ->with('success', 'Sertifikat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Hapus sertifikat
        Certificate::findOrFail($id)->delete();

        return redirect()->route('certificates.index')
            ->with('success', 'Sertifikat berhasil dihapus.');
    }
}
