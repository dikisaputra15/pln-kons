<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model
{
    protected $fillable = [
        'id_unit_induk',
        'kode_unit',
        'nama_unit',
    ];

    public function unitInduk(): BelongsTo
    {
        return $this->belongsTo(Uid::class, 'id_unit_induk');
    }

    public function gi(): HasMany
    {
        return $this->hasMany(Gi::class, 'id_unit');
    }
}
