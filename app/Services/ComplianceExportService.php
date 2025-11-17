<?php

namespace App\Services;

use App\Models\IsqmEntry;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ComplianceExportService
{
    /**
     * Generate compliance entries according to optional filters.
     */
    public function fetch(array $filters = []): Collection
    {
        $query = IsqmEntry::with(['category', 'monitoringActivity', 'deficiencyType', 'owner'])
            ->compliance();

        if (!empty($filters['module'])) {
            $module = $filters['module'];
            $query->whereHas('category', function ($q) use ($module) {
                $q->where('slug', $module)->orWhere('title', $module);
            });
        }

        if (array_key_exists('severe', $filters) && $filters['severe'] !== null) {
            $query->where('severe', (bool) $filters['severe']);
        }

        if (array_key_exists('pervasive', $filters) && $filters['pervasive'] !== null) {
            $query->where('pervasive', (bool) $filters['pervasive']);
        }

        return $query->orderBy('module_id')->orderBy('title')->get();
    }

    public function toCsv(Collection $entries): array
    {
        $out = fopen('php://temp', 'r+');
        fputcsv($out, [
            'Module',
            'Quality Objective',
            'Quality Risk',
            'Assessment',
            'Response',
            'Implementation',
            'Monitoring',
            'Findings',
            'Root Cause',
            'Severe',
            'Pervasive',
            'Owner',
        ]);

        foreach ($entries as $entry) {
            $moduleName = $entry->category?->title
                ?? ($entry->area ? Str::title(str_replace('_', ' ', $entry->area)) : '');

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

        return [
            'filename' => 'isqm_compliance_'.now()->format('Y-m-d_His').'.csv',
            'content' => $csv,
        ];
    }

    public function summary(Collection $entries): array
    {
        return [
            'total' => $entries->count(),
            'severe' => $entries->where('severe', true)->count(),
            'pervasive' => $entries->where('pervasive', true)->count(),
        ];
    }
}
