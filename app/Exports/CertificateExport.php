<?php

namespace App\Exports;

use App\Models\CertificateTemplate;
use Maatwebsite\Excel\Concerns\FromCollection;

class CertificateExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return CertificateTemplate::all();
    }
}
