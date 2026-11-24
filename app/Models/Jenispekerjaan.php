<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jenispekerjaan extends Model
{
    protected $fillable = [
        'id_kategori',
        'jenis_pekerjaan',
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function subJenispekerjaan(): HasMany
    {
        return $this->hasMany(Subjenispekerjaan::class, 'id_jenis_pekerjaan');
    }
}
