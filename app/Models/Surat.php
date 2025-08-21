<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    use HasFactory;

    protected $fillable =[
        'surat_dari',
        'no_surat',
        'tanggal_surat',
        'tanggal_diterima',
        'no_agenda',
        'sifat',
        'perihal',
        'ditujukan',
        'respon',
        'catatan',
        'file_surat',
        'status',
    ];

    protected $casts = [
        'ditujukan' => 'array',
        'respon' => 'array',
    ];
    
}
