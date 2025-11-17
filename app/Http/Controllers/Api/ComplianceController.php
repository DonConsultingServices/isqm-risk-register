<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\IsqmEntry;
use Illuminate\Http\JsonResponse;

class ComplianceController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $entries = IsqmEntry::with(['module', 'monitoringActivity', 'deficiencyType'])
            ->where(function ($query) {
                $query->whereNull('risk_applicable')
                    ->orWhere('risk_applicable', true);
            })
            ->orderBy('module_id')
            ->orderBy('title')
            ->get()
            ->groupBy(fn (IsqmEntry $entry) => $entry->module?->name ?? 'Other')
            ->map(fn ($group) => $group->map(fn (IsqmEntry $entry) => [
                'id' => $entry->id,
                'quality_objective' => $entry->quality_objective,
                'quality_risk' => $entry->quality_risk ?? $entry->title,
                'assessment_of_risk' => $entry->assessment_of_risk,
                'response' => $entry->response,
                'firm_implementation' => $entry->firm_implementation,
                'toc' => $entry->toc,
                'monitoring_activity' => $entry->monitoringActivity?->name,
                'findings' => $entry->findings,
                'deficiency_type' => $entry->deficiencyType?->name,
                'root_cause' => $entry->root_cause,
                'remedial_actions' => $entry->remedial_actions,
                'severe' => $entry->severe,
                'pervasive' => $entry->pervasive,
            ]));

        return response()->json([
            'data' => $entries,
        ]);
    }
}


