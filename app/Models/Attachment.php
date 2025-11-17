<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attachment extends Model
{
    protected $fillable = ['isqm_entry_id','path','filename','size'];

    public function entry(): BelongsTo
    {
        return $this->belongsTo(IsqmEntry::class, 'isqm_entry_id');
    }
}


