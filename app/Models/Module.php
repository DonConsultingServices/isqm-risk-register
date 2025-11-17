<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'quality_objective',
        'description',
        'order',
    ];

    public function risks(): HasMany
    {
        return $this->hasMany(IsqmEntry::class);
    }
}


