<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    protected $table = 'desas';
    protected $fillable = ['kode_kec', 'kode_desa', 'kode_wilayah', 'nama'];
}
