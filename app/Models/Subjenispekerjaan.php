<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subjenispekerjaan extends Model
{
    protected $fillable = [
        'id_jenis_pekerjaan',
        'subjenis_pekerjaan',
    ];

    public function jenisPekerjaan(): BelongsTo
    {
        return $this->belongsTo(Jenispekerjaan::class, 'id_jenis_pekerjaan');
    }
}
