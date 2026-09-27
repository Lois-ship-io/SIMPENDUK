<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['penduduk_id', 'tanggal_kematian', 'penyebab_kematian', 'tempat_kematian', 'keterangan'])]
class Kematian extends Model
{
    protected function casts(): array
    {
        return [
            'tanggal_kematian' => 'date',
        ];
    }

    public function penduduk(): BelongsTo
    {
        return $this->belongsTo(Penduduk::class);
    }
}
