<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class Setting extends Model
{
    protected $fillable = ['key','value'];

    public static function get(string $key, $default = null): mixed
    {
        try {
            $row = static::query()->where('key', $key)->first();
            return $row?->value ?? $default;
        } catch (QueryException $e) {
            // Table doesn't exist yet, return default value
            return $default;
        }
    }
}


