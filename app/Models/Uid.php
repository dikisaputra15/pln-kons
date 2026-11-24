<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Uid extends Model
{
    protected $fillable = [
        'kode_unit_induk',
        'nama_unit_induk',
        'bpp_kit',
        'bpp_tt',
        'bpp_tr',
        'bpp_tr_plus_margin',
        'susut',
        'oem',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'susut' => 'decimal:2',
            'oem' => 'decimal:2',
        ];
    }

    public function unit(): HasMany
    {
        return $this->hasMany(Unit::class, 'id_unit_induk');
    }
}
