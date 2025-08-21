<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    use HasFactory;

    protected $fillable=[
        'tanggal_surat',
        'tujuan',
        'pengolah_surat',
        'no_surat',
        'perihal',
        'lain_lain',
        'agenda',
        'file_surat'
    ];
}
