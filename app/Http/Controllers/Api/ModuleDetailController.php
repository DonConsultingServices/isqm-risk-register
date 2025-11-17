<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ModuleDetailController extends Controller
{
    public function __invoke(Request $request, Module $module): JsonResponse
    {
        $module->loadCount([
            'risks',
            'risks as open_count' => fn ($q) => $q->where('status', 'open'),
            'risks as monitoring_count' => fn ($q) => $q->where('status', 'monitoring'),
            'risks as closed_count' => fn ($q) => $q->where('status', 'closed'),
            'risks as severe_count' => fn ($q) => $q->where('severe', true),
            'risks as pervasive_count' => fn ($q) => $q->where('pervasive', true),
            'risks as overdue_count' => fn ($q) => $q->whereIn('status', ['open', 'monitoring'])
                ->whereNotNull('due_date')
                ->whereDate('due_date', '<', now()),
        ]);

        $risksQuery = $module->risks()
            ->with(['monitoringActivity', 'deficiencyType', 'owner', 'client'])
            ->orderBy('created_at', 'desc');

        $filters = collect([
            'search' => $request->query('search'),
            'status' => $request->query('status'),
            'objective' => $request->query('f_objective'),
            'risk' => $request->query('f_risk'),
            'assessment' => $request->query('f_assessment'),
            'likelihood' => $request->query('f_likelihood'),
            'adverse' => $request->query('f_adverse'),
            'applicable' => $request->query('f_applicable'),
            'response' => $request->query('f_response'),
            'firm' => $request->query('f_firm'),
            'toc' => $request->query('f_toc'),
            'monitoring' => $request->query('f_monitoring'),
            'findings' => $request->query('f_findings'),
            'deficiency' => $request->query('f_deficiency'),
            'root_cause' => $request->query('f_root_cause'),
            'severe' => $request->query('f_severe'),
            'pervasive' => $request->query('f_pervasive'),
            'remedial' => $request->query('f_remedial'),
            'objective_met' => $request->query('f_objective_met'),
            'entity_level' => $request->query('f_entity_level'),
            'engagement_level' => $request->query('f_engagement_level'),
            'impl_status' => $request->query('f_impl_status'),
            'record_status' => $request->query('f_record_status'),
            'owner' => $request->query('f_owner'),
            'client' => $request->query('f_client'),
            'due_date' => $request->query('f_due_date'),
            'review_date' => $request->query('f_review_date'),
            'due_before' => $request->query('due_before'),
            'due_after' => $request->query('due_after'),
        ]);

        $filters->each(function ($value, $key) use ($risksQuery) {
            if ($value === null || $value === '') {
                return;
            }

            switch ($key) {
                case 'search':
                    $risksQuery->where(function ($query) use ($value) {
                        $query->where('quality_objective', 'like', "%{$value}%")
                            ->orWhere('quality_risk', 'like', "%{$value}%")
                            ->orWhere('assessment_of_risk', 'like', "%{$value}%")
                            ->orWhere('findings', 'like', "%{$value}%");
                    });
                    break;
                case 'status':
                case 'record_status':
                    $risksQuery->where('status', $value);
                    break;
                case 'objective':
                    if ($value) {
                        $risksQuery->where('quality_objective', 'like', "%{$value}%");
                    }
                    break;
                case 'risk':
                    if ($value) {
                        $risksQuery->where('quality_risk', 'like', "%{$value}%");
                    }
                    break;
                case 'assessment':
                    if ($value) {
                        $risksQuery->where('assessment_of_risk', 'like', "%{$value}%");
                    }
                    break;
                case 'likelihood':
                    $risksQuery->where('likelihood', $value === '1' || $value === 'yes' || $value === 'true');
                    break;
                case 'adverse':
                    $risksQuery->where('adverse_effect', $value === '1' || $value === 'yes' || $value === 'true');
                    break;
                case 'applicable':
                    $risksQuery->where('risk_applicable', $value === '1' || $value === 'yes' || $value === 'true');
                    break;
                case 'response':
                    if ($value) {
                        $risksQuery->where('response', 'like', "%{$value}%");
                    }
                    break;
                case 'firm':
                    if ($value) {
                        $risksQuery->where('firm_implementation', 'like', "%{$value}%");
                    }
                    break;
                case 'toc':
                    if ($value) {
                        $risksQuery->where('toc', 'like', "%{$value}%");
                    }
                    break;
                case 'monitoring':
                    $risksQuery->where('monitoring_activity_id', $value);
                    break;
                case 'findings':
                    if ($value) {
                        $risksQuery->where('findings', 'like', "%{$value}%");
                    }
                    break;
                case 'deficiency':
                    $risksQuery->where('deficiency_type_id', $value);
                    break;
                case 'root_cause':
                    if ($value) {
                        $risksQuery->where('root_cause', 'like', "%{$value}%");
                    }
                    break;
                case 'severe':
                    $risksQuery->where('severe', $value === '1' || $value === 'yes' || $value === 'true');
                    break;
                case 'pervasive':
                    $risksQuery->where('pervasive', $value === '1' || $value === 'yes' || $value === 'true');
                    break;
                case 'remedial':
                    if ($value) {
                        $risksQuery->where('remedial_actions', 'like', "%{$value}%");
                    }
                    break;
                case 'objective_met':
                    $risksQuery->where('objective_met', $value === '1' || $value === 'yes' || $value === 'true');
                    break;
                case 'entity_level':
                    $risksQuery->where('entity_level', $value === '1' || $value === 'yes' || $value === 'true');
                    break;
                case 'engagement_level':
                    $risksQuery->where('engagement_level', $value === '1' || $value === 'yes' || $value === 'true');
                    break;
                case 'impl_status':
                    if ($value) {
                        $risksQuery->where('implementation_status', $value);
                    }
                    break;
                case 'owner':
                    $risksQuery->where('owner_id', $value);
                    break;
                case 'client':
                    $risksQuery->where('client_id', $value);
                    break;
                case 'due_date':
                    if ($value) {
                        $risksQuery->whereDate('due_date', $value);
                    }
                    break;
                case 'review_date':
                    if ($value) {
                        $risksQuery->whereDate('review_date', $value);
                    }
                    break;
                case 'due_before':
                    if ($value) {
                        $risksQuery->whereDate('due_date', '<=', $value);
                    }
                    break;
                case 'due_after':
                    if ($value) {
                        $risksQuery->whereDate('due_date', '>=', $value);
                    }
                    break;
            }
        });

        $perPage = max(1, min(100, (int) $request->input('per_page', 20)));
        $risks = $risksQuery->paginate($perPage)->appends($request->query());

        $monitoringSummary = $module->risks()
            ->join('monitoring_activities', 'monitoring_activities.id', '=', 'isqm_entries.monitoring_activity_id')
            ->selectRaw('monitoring_activities.name as name, count(*) as total')
            ->groupBy('monitoring_activities.name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $deficiencySummary = $module->risks()
            ->join('deficiency_types', 'deficiency_types.id', '=', 'isqm_entries.deficiency_type_id')
            ->selectRaw('deficiency_types.name as name, count(*) as total')
            ->groupBy('deficiency_types.name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return response()->json([
            'module' => [
                'id' => $module->id,
                'slug' => $module->slug,
                'name' => $module->name,
                'quality_objective' => $module->quality_objective,
                'stats' => [
                    'total' => $module->risks_count,
                    'open' => $module->open_count,
                    'monitoring' => $module->monitoring_count,
                    'closed' => $module->closed_count,
                    'severe' => $module->severe_count,
                    'pervasive' => $module->pervasive_count,
                    'overdue' => $module->overdue_count,
                ],
                'monitoring_summary' => $monitoringSummary,
                'deficiency_summary' => $deficiencySummary,
            ],
            'risks' => [
                'data' => $risks->map(function ($entry) {
                    return [
                        'id' => $entry->id,
                        'import_source' => $entry->import_source,
                        'title' => $entry->title,
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
                        'objective_met' => $entry->objective_met,
                        'entity_level' => $entry->entity_level,
                        'engagement_level' => $entry->engagement_level,
                        'implementation_status' => $entry->implementation_status,
                        'status' => $entry->status,
                        'owner' => $entry->owner?->only(['id', 'name']),
                        'client' => $entry->client?->only(['id', 'name']),
                        'due_date' => optional($entry->due_date)->format('Y-m-d'),
                        'review_date' => optional($entry->review_date)->format('Y-m-d'),
                        'updated_at' => optional($entry->updated_at)->toIso8601String(),
                    ];
                }),
                'meta' => [
                    'current_page' => $risks->currentPage(),
                    'per_page' => $risks->perPage(),
                    'total' => $risks->total(),
                    'last_page' => $risks->lastPage(),
                ],
            ],
        ]);
    }
}


