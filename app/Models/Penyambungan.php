<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penyambungan extends Model
{
    protected $fillable = [
        'daya_awal',
        'daya_akhir',
        'perva',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return ['perva' => 'decimal:2'];
    }
}
