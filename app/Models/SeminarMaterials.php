<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeminarMaterials extends Model
{
    use HasFactory;

    protected $table = 'seminar_materials';

    protected $primaryKey = 'material_id';

    public $timestamps = true;

    protected $fillable = [
        'file_path',
        'description',
    ];

    /**
     * Get the seminar that owns the material.
     */
    //public function seminar()
   // {
       // return $this->belongsTo(Seminar::class, 'seminar_id');
   // }
}

$seminarMaterials = SeminarMaterials::all();

foreach ($seminarMaterials as $material) {
    echo $material->file_path;
}