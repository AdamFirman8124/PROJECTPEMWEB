<?php

namespace App\Exports;

use App\Models\Seminar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SeminarExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Seminar::all();
    }

    public function headings(): array
    {
        return ['ID', 'Nama Seminar', 'Tanggal Seminar', 'Lokasi Seminar', 'Link Google Map', 'Gambar Seminar', 'Apakah Berbayar', 'Mulai Pendaftaran', 'Akhir Pendaftaran', 'ID Pembicara'];
    }
}