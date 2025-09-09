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
        'kecamatan_id',
        'desa_id',
        'status'
    ];

    public function agama()
    {
        return $this->hasOne('App\Models\Agama', 'id', 'agama_id');
    }

    public function statusNikah()
    {
        return $this->hasOne('App\Models\StatusNikah', 'id', 'status_nikah_id');
    }

    public function kategori()
    {
        return $this->hasOne('App\Models\Kategori', 'id', 'kategori_id');
    }

    public function kondisi()
    {
        return $this->hasOne('App\Models\Kondisi', 'id', 'kondisi_id');
    }

    public function pengampu()
    {
        return $this->hasOne('App\Models\Pengampu', 'id', 'pengampu_id');
    }

    public function kecamatan()
    {
        return $this->hasOne('App\Models\Kecamatan', 'id', 'kecamatan_id');
    }

    public function desa()
    {
        return $this->hasOne('App\Models\Desa', 'id', 'desa_id');
    }

    public function createdBy()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    }

    public function approvals()
    {
        return $this->hasMany(Journey::class, 'biodata_id', 'id')->where('status', 1);
    }

    public function journeyApprovals()
    {
        return $this->hasMany(Journey::class, 'biodata_id', 'id')->orderBy('id', 'desc');
    }
}