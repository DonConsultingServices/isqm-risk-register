<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeficiencyType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function isqmEntries(): HasMany
    {
        return $this->hasMany(IsqmEntry::class);
    }
}


