<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journey extends Model
{
    protected $table = 'journeys';
    protected $fillable = [
        'biodata_id',
        'status',
        'action_by',
        'notes',
    ];

    public function biodata()
    {
        return $this->belongsTo(Biodata::class, 'biodata_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'action_by', 'id');
    }
}