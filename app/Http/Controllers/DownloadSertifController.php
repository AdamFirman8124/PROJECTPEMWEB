<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use App\Models\Seminar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\CertificateTemplate;
use setasign\Fpdi\Tcpdf\Fpdi;
use Illuminate\Support\Facades\File;

class DownloadSertifController extends Controller
{
    public function downloadCertificate($seminarId)
    {
        try {
            // Find the seminar based on $seminarId
            $seminar = Seminar::findOrFail($seminarId);

            // Get the latest certificate template for the seminar
            $certificate = CertificateTemplate::where('seminar_id', $seminarId)
                ->latest()
                ->first();

            if (!$certificate) {
                return back()->with('error', 'Sertifikat tidak tersedia untuk seminar ini.');
            }

            $filePath = public_path($certificate->file_path);

            if (!file_exists($filePath)) {
                return back()->with('error', 'File sertifikat tidak ditemukan.');
            }

            // Get file extension to determine the type
            $fileExtension = File::extension($filePath);

            // Ensure the directory exists
            $userCertPath = public_path('assets/images/sertif-user');
            if (!file_exists($userCertPath)) {
                mkdir($userCertPath, 0777, true);
            }

            // Generate a unique file name for the output
            $userName = Auth::user()->name;
            $timestamp = time();
            $outputFileName = 'Certificate_' . $userName . '_' . $timestamp;
            $downloadFileName = 'Certificate_' . str_replace(' ', '_', $userName) . '.' . $fileExtension;
            $outputFilePath = $userCertPath . '/' . $outputFileName . '.' . $fileExtension;

            if ($fileExtension == 'pdf') {
                // Handle PDF certificate
                $pdf = new Fpdi();
                $pageCount = $pdf->setSourceFile($filePath);
                $tplId = $pdf->importPage(1);
                // Add a page in landscape orientation
                $pdf->AddPage('L');
                $pdf->useTemplate($tplId);

                // Set font and add the user's name
                $pdf->SetFont('Helvetica', '', 24);
                $pdf->SetXY(30, 90); // Adjust these coordinates based on where you want the name to appear
                $pdf->Cell(0, 10, Auth::user()->name, 0, 1, 'C');

                // Output the PDF to the specified directory
                $pdf->Output($outputFilePath, 'F');
            } elseif ($fileExtension == 'png') {
                // Handle PNG certificate
                $img = imagecreatefrompng($filePath);
                $black = imagecolorallocate($img, 0, 0, 0);
                $fontPath = public_path('fonts/arial.ttf'); // Ensure you have the correct path to a TTF font file
                $fontSize = 24;
                $x = 30; // X-coordinate of the text
                $y = 90; // Y-coordinate of the text
                imagettftext($img, $fontSize, 0, $x, $y, $black, $fontPath, Auth::user()->name);

                // Save the image
                imagepng($img, $outputFilePath);
                imagedestroy($img);
            } else {
                return back()->with('error', 'Format file sertifikat tidak didukung.');
            }

            // Update the database with the new file path
            $certificate->file_path_user = 'assets/images/sertif-user/' . $outputFileName . '.' . $fileExtension;
            $certificate->save();

            // Return a response for the download with the user's name in the file name
            return response()->download($outputFilePath, $downloadFileName);

        } catch (\Exception $e) {
            Log::error('Gagal mengunduh sertifikat: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengunduh sertifikat: ' . $e->getMessage());
        }
    }
}