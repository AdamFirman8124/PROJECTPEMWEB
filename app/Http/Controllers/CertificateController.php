<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Seminar;
use App\Models\Certificate;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::with('user', 'seminar')->get();
        $users = User::all();
        $seminars = Seminar::all(); // Fetch all seminars

        return view('certificates.index', compact('certificates', 'users', 'seminars'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('certificates.create');
    }

   /**
 * Store a newly created resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
public function store(Request $request)
{   
    
    $request->validate([
        'seminar_id' => 'required',
        'download_start_date' => 'required|date',
        'user_id' => 'required',
        'user_name' => 'required|string',
    ]);

    $certificate = new Certificate;
    $certificate->seminar_id = $request->seminar_id;
    $certificate->download_start_date = $request->download_start_date;
    $certificate->user_id = $request->user_id;
    $certificate->user_name = $request->user_name;
    $certificate->save();

    return redirect()->route('certificates.index')
        ->with('success', 'Sertifikat berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $certificate = Certificate::findOrFail($id);
        return view('certificates.show', compact('certificate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $certificate = Certificate::findOrFail($id);
        return view('certificates.edit', compact('certificate'));
    }

    /**
 * Update the specified resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
public function update(Request $request, $id)
{
    $request->validate([
        'seminar_id' => 'required',
        'download_start_date' => 'required|date',
        'user_id' => 'required',
        'user_name' => 'required|string',
    ]);

    $certificate = Certificate::findOrFail($id);
    $certificate->seminar_id = $request->seminar_id;
    $certificate->download_start_date = $request->download_start_date;
    $certificate->user_id = $request->user_id;
    $certificate->user_name = $request->user_name;
    $certificate->save();

    return redirect()->route('certificates.index')
        ->with('success', 'Sertifikat berhasil diperbarui.');
}
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $certificate = Certificate::findOrFail($id);
        $certificate->delete();

        return redirect()->route('certificates.index')
            ->with('success', 'Sertifikat berhasil dihapus.');
    }
}