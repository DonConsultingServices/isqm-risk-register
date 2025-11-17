<?php

namespace App\Http\Controllers;

use App\Models\IsqmEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View;
use Illuminate\Support\Facades\Schema;

class ReportsController extends Controller
{
    public function index(Request $request): View
    {
        $q = IsqmEntry::query();
        if ($area = $request->string('area')->toString()) {
            $slug = str_replace('_', '-', $area);
            $moduleId = \App\Models\Module::where('slug', $slug)->value('id');
            if ($moduleId) {
                $q->where('module_id', $moduleId);
            }
            if (Schema::hasColumn('isqm_entries', 'area')) {
                $q->where('area', $slug);
            }
        }
        if ($status = $request->string('status')->toString()) { $q->where('status', $status); }
        if ($from = $request->date('due_from')) { $q->whereDate('due_date', '>=', $from); }
        if ($to = $request->date('due_to')) { $q->whereDate('due_date', '<=', $to); }

        $entries = $q->latest('id')->paginate(25)->withQueryString();

        $summary = [
            'total' => IsqmEntry::whereIn('id', $entries->pluck('id'))->count(),
            'open' => IsqmEntry::whereIn('id', $entries->pluck('id'))->where('status','open')->count(),
            'monitoring' => IsqmEntry::whereIn('id', $entries->pluck('id'))->where('status','monitoring')->count(),
            'closed' => IsqmEntry::whereIn('id', $entries->pluck('id'))->where('status','closed')->count(),
        ];

        return view('reports.index', compact('entries','summary'));
    }

    public function exportCsv(Request $request)
    {
        $q = IsqmEntry::query();
        if ($area = $request->string('area')->toString()) { $q->where('area', $area); }
        if ($status = $request->string('status')->toString()) { $q->where('status', $status); }
        if ($from = $request->date('due_from')) { $q->whereDate('due_date', '>=', $from); }
        if ($to = $request->date('due_to')) { $q->whereDate('due_date', '<=', $to); }

        $rows = $q->get(['id','area','status','due_date','quality_objective','quality_risk']);
        $out = fopen('php://temp', 'r+');
        fputcsv($out, ['ID','Area','Status','Due','Quality objective','Quality risk']);
        foreach ($rows as $r) {
            fputcsv($out, [$r->id, $r->area, $r->status, optional($r->due_date)->toDateString(), $r->quality_objective, $r->quality_risk]);
        }
        rewind($out);
        $csv = stream_get_contents($out);
        fclose($out);

        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="isqm_report.csv"',
        ]);
    }

    public function exportExcel(Request $request)
    {
        $q = IsqmEntry::query()->with(['monitoringActivity', 'deficiencyType', 'client', 'owner']);
        if ($area = $request->string('area')->toString()) { $q->where('area', $area); }
        if ($status = $request->string('status')->toString()) { $q->where('status', $status); }
        if ($from = $request->date('due_from')) { $q->whereDate('due_date', '>=', $from); }
        if ($to = $request->date('due_to')) { $q->whereDate('due_date', '<=', $to); }

        $entries = $q->get();
        
        // Create CSV with all Excel columns
        $out = fopen('php://temp', 'r+');
        fputcsv($out, [
            'ID', 'Area', 'Quality Objective', 'Quality Risk', 'Assessment of Risk', 'Likelihood',
            'Adverse Effect', 'Risk Applicable', 'Response to Quality Risk', 'Firm Implementation',
            'TOC (Test of Control)', 'Monitoring Activity', 'Findings', 'Type of Deficiency', 'Root Cause',
            'Severe', 'Pervasive', 'Objective Met', 'Remedial Actions', 'Entity Level',
            'Engagement Level', 'Status', 'Client', 'Owner', 'Due Date', 'Review Date',
            'Created At', 'Updated At'
        ]);

        foreach ($entries as $e) {
            fputcsv($out, [
                $e->id,
                str_replace('_', ' ', $e->area),
                $e->quality_objective,
                $e->quality_risk ?? '',
                $e->assessment_of_risk ?? '',
                $e->likelihood ? 'Yes' : ($e->likelihood === false ? 'No' : ''),
                $e->adverse_effect ? 'Yes' : ($e->adverse_effect === false ? 'No' : ''),
                $e->risk_applicable ? 'Yes' : ($e->risk_applicable === false ? 'No' : ''),
                $e->response ?? '',
                $e->firm_implementation ?? '',
                $e->toc ?? '',
                $e->monitoringActivity?->name ?? '',
                $e->findings ?? '',
                $e->deficiencyType?->name ?? '',
                $e->root_cause ?? '',
                $e->severe ? 'Yes' : 'No',
                $e->pervasive ? 'Yes' : 'No',
                $e->objective_met ? 'Yes' : 'No',
                $e->remedial_actions ?? '',
                $e->entity_level ? 'Yes' : 'No',
                $e->engagement_level ? 'Yes' : 'No',
                ucfirst($e->status),
                $e->client?->name ?? '',
                $e->owner?->name ?? '',
                $e->due_date?->format('Y-m-d') ?? '',
                $e->review_date?->format('Y-m-d') ?? '',
                $e->created_at->format('Y-m-d H:i:s'),
                $e->updated_at->format('Y-m-d H:i:s'),
            ]);
        }
        
        rewind($out);
        $csv = stream_get_contents($out);
        fclose($out);

        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="isqm_register_export_'.date('Y-m-d').'.csv"',
        ]);
    }

    public function exportCompliance(Request $request)
    {
        $query = IsqmEntry::with(['category', 'monitoringActivity', 'deficiencyType', 'owner'])
            ->compliance();

        if ($module = $request->string('module')->toString()) {
            $query->whereHas('category', function ($q) use ($module) {
                $q->where('slug', $module)->orWhere('title', $module);
            });
        }

        if ($request->has('severe')) {
            $value = filter_var($request->input('severe'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            if ($value !== null) {
                $query->where('severe', $value);
            }
        }

        if ($request->has('pervasive')) {
            $value = filter_var($request->input('pervasive'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            if ($value !== null) {
                $query->where('pervasive', $value);
            }
        }

        $entries = $query->orderBy('module_id')->orderBy('title')->get();

        $out = fopen('php://temp', 'r+');
        fputcsv($out, [
            'Module',
            'Quality Objective',
            'Quality Risk',
            'Assessment',
            'Response',
            'Implementation',
            'Monitoring Activity',
            'Findings',
            'Root Cause',
            'Severe',
            'Pervasive',
            'Owner'
        ]);

        foreach ($entries as $entry) {
            $moduleName = $entry->category?->title ?? ($entry->area ? str_replace('_', ' ', $entry->area) : '');
            fputcsv($out, [
                $moduleName,
                $entry->quality_objective,
                $entry->quality_risk,
                $entry->assessment_of_risk,
                $entry->response,
                $entry->firm_implementation,
                $entry->monitoringActivity?->name,
                $entry->findings,
                $entry->root_cause,
                $entry->severe ? 'Yes' : 'No',
                $entry->pervasive ? 'Yes' : 'No',
                $entry->owner?->name,
            ]);
        }

        rewind($out);
        $csv = stream_get_contents($out);
        fclose($out);

        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="isqm_compliance_'.date('Y-m-d').'.csv"',
        ]);
    }
}


