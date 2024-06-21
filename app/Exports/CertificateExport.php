<?php

namespace App\Exports;

use App\Models\CertificateTemplate;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CertificateExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return CertificateTemplate::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return ['ID', 'Nama', 'File Path', 'Seminar ID', 'Dibuat Pada', 'Diperbarui Pada', 'Waktu Akses'];
    }
}
