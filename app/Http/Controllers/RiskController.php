<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\IsqmEntry;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RiskController extends Controller
{
    public function index(Request $request): View
    {
        $modules = Module::orderBy('order')->orderBy('name')->get();
        $moduleBySlug = $modules->pluck('id', 'slug');

        $query = IsqmEntry::query()->with(['module', 'monitoringActivity', 'deficiencyType', 'client']);

        if ($request->filled('area')) {
            $slug = $request->query('area');
            if ($moduleBySlug->has($slug)) {
                $query->where('module_id', $moduleBySlug->get($slug));
            }
        }

        // Filter by severity
        if ($request->filled('filter')) {
            $filter = $request->filter;
            if ($filter === 'severe') {
                $query->where('severe', true);
            } elseif ($filter === 'pervasive') {
                $query->where('pervasive', true);
            } elseif ($filter === 'adverse') {
                $query->where('adverse_effect', true);
            }
        }

        // Only show entries with risks
        $query->whereNotNull('quality_risk')
              ->where('quality_risk', '!=', '');

        $risks = $query->latest('updated_at')->paginate(20)->withQueryString();

        // Group by area for summary
        $byArea = IsqmEntry::whereNotNull('quality_risk')
            ->where('quality_risk', '!=', '')
            ->join('modules', 'modules.id', '=', 'isqm_entries.module_id')
            ->selectRaw('modules.name as module_title, modules.slug as module_slug, count(*) as total,
                sum(case when severe = 1 then 1 else 0 end) as severe_count,
                sum(case when pervasive = 1 then 1 else 0 end) as pervasive_count,
                sum(case when adverse_effect = 1 then 1 else 0 end) as adverse_count')
            ->groupBy('modules.id', 'modules.name', 'modules.slug')
            ->orderBy('modules.order')
            ->orderBy('modules.name')
            ->get();

        return view('risks.index', [
            'risks' => $risks,
            'byArea' => $byArea,
            'modules' => $modules,
        ]);
    }
}

