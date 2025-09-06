<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Biodata extends Model
{
    protected $table = 'biodatas';
    protected $fillable = [
        'no_kk',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jk',
        'agama_id',
        'alamat',
        'status_nikah_id',
        'kategori_id',
        'kondisi_id',
        'pengampu_id',
        'created_by',
    ];
}
