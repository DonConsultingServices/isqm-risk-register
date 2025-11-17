<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MonitoringEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'isqm_entry_id',
        'performed_by',
        'performed_at',
        'outcome',
        'status',
        'attachment_id',
        'next_due_at',
    ];

    protected $casts = [
        'performed_at' => 'datetime',
        'next_due_at' => 'date',
    ];

    public function isqmEntry(): BelongsTo
    {
        return $this->belongsTo(IsqmEntry::class);
    }

    public function performedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'performed_by');
    }

    public function attachment(): BelongsTo
    {
        return $this->belongsTo(Attachment::class);
    }
}
