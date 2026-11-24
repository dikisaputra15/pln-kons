<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    protected $fillable = [
        'nama_tarif',
    ];

    public function daya()
    {
        return $this->hasMany(Daya::class);
    }
}
