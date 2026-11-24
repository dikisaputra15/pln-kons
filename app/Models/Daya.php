<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Daya extends Model
{
    protected $fillable = [
        'id_tarif',
        'daya',
        'rp_tarif',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'rp_tarif' => 'decimal:2',
        ];
    }

    /** @return BelongsTo<Tarif, $this> */
    public function tarif(): BelongsTo
    {
        return $this->belongsTo(Tarif::class, 'id_tarif');
    }
}
