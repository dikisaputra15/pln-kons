<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gi extends Model
{
    protected $fillable = [
        'id_unit',
        'nama_gi',
    ];

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'id_unit');
    }
}
