<?php

namespace App\Exports;

use App\Models\Seminar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Materi;

class SeminarExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Materi::select('id', 'judul_materi', 'created_at', 'updated_at')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return ['ID', 'Judul Materi', 'Dibuat Pada', 'Diperbarui Pada'];
    }
}

