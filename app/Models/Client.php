<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','industry','email','phone',
    ];

    public function isqmEntries(): HasMany
    {
        return $this->hasMany(IsqmEntry::class);
    }
}


