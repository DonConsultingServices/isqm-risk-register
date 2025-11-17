<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\IsqmEntry;
use App\Models\Module;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RiskController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = IsqmEntry::query()
            ->with(['module', 'monitoringActivity', 'deficiencyType', 'owner', 'client']);

        if ($moduleId = $request->integer('module_id')) {
            $query->where('module_id', $moduleId);
        } elseif ($moduleSlug = $request->string('module_slug')->toString()) {
            $module = Module::where('slug', $moduleSlug)->first();
            if (!$module) {
                return response()->json([
                    'message' => 'Module not found.',
                ], 404);
            }
            $query->where('module_id', $module->id);
        }

        if ($status = $request->string('status')->toString()) {
            $query->where('status', $status);
        }

        if ($search = $request->string('search')->toString()) {
            $query->where(function ($q) use ($search) {
                $q->where('quality_objective', 'like', "%{$search}%")
                    ->orWhere('quality_risk', 'like', "%{$search}%")
                    ->orWhere('assessment_of_risk', 'like', "%{$search}%")
                    ->orWhere('response', 'like', "%{$search}%");
            });
        }

        if ($request->filled('severe')) {
            $query->where('severe', filter_var($request->input('severe'), FILTER_VALIDATE_BOOLEAN));
        }

        if ($request->filled('pervasive')) {
            $query->where('pervasive', filter_var($request->input('pervasive'), FILTER_VALIDATE_BOOLEAN));
        }

        if ($owner = $request->integer('owner_id')) {
            $query->where('owner_id', $owner);
        }

        if ($client = $request->integer('client_id')) {
            $query->where('client_id', $client);
        }

        if ($request->filled('due_before')) {
            $query->whereDate('due_date', '<=', $request->date('due_before'));
        }

        if ($request->filled('due_after')) {
            $query->whereDate('due_date', '>=', $request->date('due_after'));
        }

        $perPage = max(1, min(100, (int) $request->input('per_page', 25)));

        $risks = $query->orderBy('module_id')
            ->orderBy('quality_objective')
            ->paginate($perPage)
            ->appends($request->query());

        $data = collect($risks->items())->map(fn (IsqmEntry $entry) => [
            'id' => $entry->id,
            'module' => [
                'id' => $entry->module?->id,
                'slug' => $entry->module?->slug,
                'name' => $entry->module?->name,
            ],
            'quality_objective' => $entry->quality_objective,
            'quality_risk' => $entry->quality_risk,
            'assessment_of_risk' => $entry->assessment_of_risk,
            'likelihood' => $entry->likelihood,
            'adverse_effect' => $entry->adverse_effect,
            'risk_applicable' => $entry->risk_applicable,
            'risk_applicable_details' => $entry->risk_applicable_details,
            'response' => $entry->response,
            'firm_implementation' => $entry->firm_implementation,
            'toc' => $entry->toc,
            'monitoring_activity' => $entry->monitoringActivity?->name,
            'findings' => $entry->findings,
            'deficiency_type' => $entry->deficiencyType?->name,
            'root_cause' => $entry->root_cause,
            'severe' => $entry->severe,
            'pervasive' => $entry->pervasive,
            'remedial_actions' => $entry->remedial_actions,
            'entity_level' => $entry->entity_level,
            'engagement_level' => $entry->engagement_level,
            'status' => $entry->status,
            'implementation_status' => $entry->implementation_status,
            'owner' => $entry->owner?->only(['id', 'name']),
            'client' => $entry->client?->only(['id', 'name']),
            'due_date' => optional($entry->due_date)->format('Y-m-d'),
            'review_date' => optional($entry->review_date)->format('Y-m-d'),
            'updated_at' => $entry->updated_at?->toIso8601String(),
        ]);

        return response()->json([
            'data' => $data,
            'meta' => [
                'current_page' => $risks->currentPage(),
                'per_page' => $risks->perPage(),
                'total' => $risks->total(),
                'last_page' => $risks->lastPage(),
            ],
        ]);
    }
}


