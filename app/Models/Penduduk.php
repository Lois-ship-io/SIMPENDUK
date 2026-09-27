<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable([
    'no_kk', 'nik', 'nama', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin',
    'alamat', 'wilayah_id', 'kelurahan', 'kecamatan', 'agama',
    'status_perkawinan', 'pekerjaan', 'kewarganegaraan', 'no_telepon', 'status'
])]
class Penduduk extends Model
{
    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
        ];
    }

    public function wilayah(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class);
    }

    public function kematian(): HasOne
    {
        return $this->hasOne(Kematian::class);
    }
}
