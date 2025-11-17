<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class IsqmEntry extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'area',
        'category_id',
        'module_id',
        'quality_objective',
        'quality_risk',
        'assessment_of_risk',
        'likelihood',
        'response',
        'firm_implementation',
        'toc',
        'monitoring_activity_id',
        'findings',
        'deficiency_type_id',
        'root_cause',
        'severe',
        'pervasive',
        'adverse_effect',
        'risk_applicable',
        'risk_applicable_details',
        'objective_met',
        'remedial_actions',
        'remedial_owner_id',
        'remedial_target_date',
        'remedial_completed_at',
        'entity_level',
        'engagement_level',
        'status',
        'implementation_status',
        'owner_id',
        'client_id',
        'due_date',
        'review_date',
        'import_source',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'likelihood' => 'boolean',
        'severe' => 'boolean',
        'pervasive' => 'boolean',
        'adverse_effect' => 'boolean',
        'risk_applicable' => 'boolean',
        'objective_met' => 'boolean',
        'entity_level' => 'boolean',
        'engagement_level' => 'boolean',
        'due_date' => 'date',
        'review_date' => 'date',
        'remedial_target_date' => 'date',
        'remedial_completed_at' => 'datetime',
    ];

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    public function category(): BelongsTo
    {
        return $this->module();
    }

    public function monitoringActivity(): BelongsTo
    {
        return $this->belongsTo(MonitoringActivity::class);
    }

    public function deficiencyType(): BelongsTo
    {
        return $this->belongsTo(DeficiencyType::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function remedialOwner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'remedial_owner_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class, 'isqm_entry_id');
    }

    public function monitoringEntries(): HasMany
    {
        return $this->hasMany(MonitoringEntry::class);
    }

    public function scopeCompliance($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('risk_applicable')
              ->orWhere('risk_applicable', true);
        });
    }
}


