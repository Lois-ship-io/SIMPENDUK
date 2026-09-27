<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nama', 'ketua_rt'])]
class Wilayah extends Model
{
    public function penduduks(): HasMany
    {
        return $this->hasMany(Penduduk::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
