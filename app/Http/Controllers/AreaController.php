<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\DeficiencyType;
use App\Models\IsqmEntry;
use App\Models\MonitoringActivity;
use App\Models\User;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AreaController extends Controller
{
    public function governance(): View
    {
        return $this->showArea('governance-and-leadership', 'Governance and Leadership');
    }

    public function ethical(): View
    {
        return $this->showArea('ethical-requirements', 'Ethical Requirements');
    }

    public function acceptance(): View
    {
        return $this->showArea('acceptance-and-continuance', 'Acceptance and Continuance');
    }

    public function engagement(): View
    {
        return $this->showArea('engagement-performance', 'Engagement Performance');
    }

    public function resources(): View
    {
        return $this->showArea('resources', 'Resources');
    }

    public function information(): View
    {
        return $this->showArea('information-and-communication', 'Information and Communication');
    }

    private function showArea(string $areaSlug, string $title): View
    {
        $module = Module::where('slug', $areaSlug)->first();
        if (!$module) {
            abort(404, 'Module not found');
        }

        $request = request();

        $query = IsqmEntry::where('module_id', $module->id)
            ->with(['module', 'monitoringActivity', 'deficiencyType', 'client', 'owner']);

        $query->orderByRaw('CASE WHEN import_source IS NULL THEN 1 ELSE 0 END');

        $driver = $query->getModel()->getConnection()->getDriverName();
        if ($driver === 'mysql') {
            $query->orderByRaw("CAST(SUBSTRING_INDEX(import_source, 'Row', -1) AS UNSIGNED)");
        } else {
            $query->orderBy('import_source');
        }

        $query->orderBy('quality_objective')
            ->orderBy('id');

        // Global search
        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where(function($q) use ($search) {
                $q->where('quality_objective', 'like', "%{$search}%")
                  ->orWhere('quality_risk', 'like', "%{$search}%")
                  ->orWhere('findings', 'like', "%{$search}%");
            });
        }

        // Column-specific filters
        $filters = collect([
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
        ]);

        $filters->each(function ($value, $key) use ($query) {
            if ($value === null || $value === '') {
                return;
            }

            switch ($key) {
                case 'status':
                case 'record_status':
                    $query->where('status', $value);
                    break;
                case 'objective':
                    if ($value) {
                        $query->where('quality_objective', 'like', "%{$value}%");
                    }
                    break;
                case 'risk':
                    if ($value) {
                        $query->where('quality_risk', 'like', "%{$value}%");
                    }
                    break;
                case 'assessment':
                    if ($value) {
                        $query->where('assessment_of_risk', 'like', "%{$value}%");
                    }
                    break;
                case 'likelihood':
                    $query->where('likelihood', $value === '1' || $value === 'yes' || $value === 'true');
                    break;
                case 'adverse':
                    $query->where('adverse_effect', $value === '1' || $value === 'yes' || $value === 'true');
                    break;
                case 'applicable':
                    $query->where('risk_applicable', $value === '1' || $value === 'yes' || $value === 'true');
                    break;
                case 'response':
                    if ($value) {
                        $query->where('response', 'like', "%{$value}%");
                    }
                    break;
                case 'firm':
                    if ($value) {
                        $query->where('firm_implementation', 'like', "%{$value}%");
                    }
                    break;
                case 'toc':
                    if ($value) {
                        $query->where('toc', 'like', "%{$value}%");
                    }
                    break;
                case 'monitoring':
                    $query->where('monitoring_activity_id', $value);
                    break;
                case 'findings':
                    if ($value) {
                        $query->where('findings', 'like', "%{$value}%");
                    }
                    break;
                case 'deficiency':
                    $query->where('deficiency_type_id', $value);
                    break;
                case 'root_cause':
                    if ($value) {
                        $query->where('root_cause', 'like', "%{$value}%");
                    }
                    break;
                case 'severe':
                    $query->where('severe', $value === '1' || $value === 'yes' || $value === 'true');
                    break;
                case 'pervasive':
                    $query->where('pervasive', $value === '1' || $value === 'yes' || $value === 'true');
                    break;
                case 'remedial':
                    if ($value) {
                        $query->where('remedial_actions', 'like', "%{$value}%");
                    }
                    break;
                case 'objective_met':
                    $query->where('objective_met', $value === '1' || $value === 'yes' || $value === 'true');
                    break;
                case 'entity_level':
                    $query->where('entity_level', $value === '1' || $value === 'yes' || $value === 'true');
                    break;
                case 'engagement_level':
                    $query->where('engagement_level', $value === '1' || $value === 'yes' || $value === 'true');
                    break;
                case 'impl_status':
                    if ($value) {
                        $query->where('implementation_status', $value);
                    }
                    break;
                case 'owner':
                    $query->where('owner_id', $value);
                    break;
                case 'client':
                    $query->where('client_id', $value);
                    break;
                case 'due_date':
                    if ($value) {
                        $query->whereDate('due_date', $value);
                    }
                    break;
                case 'review_date':
                    if ($value) {
                        $query->whereDate('review_date', $value);
                    }
                    break;
            }
        });

        $entries = $query->paginate(20)->withQueryString();

        $stats = [
            'total' => IsqmEntry::where('module_id', $module->id)->count(),
            'open' => IsqmEntry::where('module_id', $module->id)->where('status', 'open')->count(),
            'monitoring' => IsqmEntry::where('module_id', $module->id)->where('status', 'monitoring')->count(),
            'closed' => IsqmEntry::where('module_id', $module->id)->where('status', 'closed')->count(),
            'overdue' => IsqmEntry::where('module_id', $module->id)
                ->whereIn('status', ['open', 'monitoring'])
                ->whereNotNull('due_date')
                ->whereDate('due_date', '<', now())
                ->count(),
            'severe' => IsqmEntry::where('module_id', $module->id)->where('severe', true)->count(),
            'pervasive' => IsqmEntry::where('module_id', $module->id)->where('pervasive', true)->count(),
        ];

        $base = IsqmEntry::where('module_id', $module->id);

        $filterOptions = [
            'objectives' => (clone $base)->select('quality_objective')->whereNotNull('quality_objective')->distinct()->orderBy('quality_objective')->pluck('quality_objective'),
            'risks' => (clone $base)->select('quality_risk')->whereNotNull('quality_risk')->distinct()->orderBy('quality_risk')->pluck('quality_risk'),
            'assessments' => (clone $base)->select('assessment_of_risk')->whereNotNull('assessment_of_risk')->distinct()->orderBy('assessment_of_risk')->pluck('assessment_of_risk'),
            'responses' => (clone $base)->select('response')->whereNotNull('response')->distinct()->orderBy('response')->pluck('response'),
            'firmImplementations' => (clone $base)->select('firm_implementation')->whereNotNull('firm_implementation')->distinct()->orderBy('firm_implementation')->pluck('firm_implementation'),
            'tocs' => (clone $base)->select('toc')->whereNotNull('toc')->distinct()->orderBy('toc')->pluck('toc'),
            'monitoringActivities' => MonitoringActivity::orderBy('name')->pluck('name', 'id'),
            'findings' => (clone $base)->select('findings')->whereNotNull('findings')->distinct()->orderBy('findings')->pluck('findings'),
            'deficiencyTypes' => DeficiencyType::orderBy('name')->pluck('name', 'id'),
            'rootCauses' => (clone $base)->select('root_cause')->whereNotNull('root_cause')->distinct()->orderBy('root_cause')->pluck('root_cause'),
            'remedialActions' => (clone $base)->select('remedial_actions')->whereNotNull('remedial_actions')->distinct()->orderBy('remedial_actions')->pluck('remedial_actions'),
            'implementationStatuses' => collect([
                '' => 'All',
                'not_started' => 'Not Started',
                'in_progress' => 'In Progress',
                'implemented' => 'Implemented',
                'verified' => 'Verified',
            ]),
            'statusOptions' => collect([
                '' => 'All',
                'open' => 'Open',
                'monitoring' => 'Monitoring',
                'closed' => 'Closed',
            ]),
            'owners' => User::orderBy('name')->pluck('name', 'id'),
            'clients' => Client::orderBy('name')->pluck('name', 'id'),
            'boolean' => collect([
                '' => 'All',
                '1' => 'Yes',
                '0' => 'No',
            ]),
        ];

        $monitoringBreakdown = (clone $base)
            ->join('monitoring_activities', 'monitoring_activities.id', '=', 'isqm_entries.monitoring_activity_id')
            ->selectRaw('monitoring_activities.name as name, count(*) as total')
            ->groupBy('monitoring_activities.name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $deficiencyBreakdown = (clone $base)
            ->join('deficiency_types', 'deficiency_types.id', '=', 'isqm_entries.deficiency_type_id')
            ->selectRaw('deficiency_types.name as name, count(*) as total')
            ->groupBy('deficiency_types.name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return view('areas.show', compact(
            'entries',
            'stats',
            'module',
            'title',
            'filters',
            'filterOptions',
            'monitoringBreakdown',
            'deficiencyBreakdown'
        ));
    }
}

