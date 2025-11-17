<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\DeficiencyType;
use App\Models\IsqmEntry;
use App\Models\MonitoringActivity;
use App\Models\Module;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class IsqmEntryJsonSeeder extends Seeder
{
    private const IMPORT_SOURCE = 'isqm_full_data_json_v1';

    public function run(): void
    {
        $path = base_path('isqm_full_data.json');

        if (!File::exists($path)) {
            $this->command?->warn("JSON seed skipped: {$path} not found.");
            return;
        }

        try {
            $modules = json_decode(File::get($path), true, 512, JSON_THROW_ON_ERROR);
        } catch (\Throwable $e) {
            $this->command?->error('Unable to decode isqm_full_data.json: '.$e->getMessage());
            return;
        }

        if (!is_array($modules) || empty($modules)) {
            $this->command?->warn('JSON seed skipped: decoded data is empty.');
            return;
        }

        $hasCategoryColumn = Schema::hasColumn('isqm_entries', 'category_id');
        $hasModuleColumn = Schema::hasColumn('isqm_entries', 'module_id');
        $hasAreaColumn = Schema::hasColumn('isqm_entries', 'area');

        // Remove previously imported records to avoid duplicates.
        IsqmEntry::where('import_source', self::IMPORT_SOURCE)->delete();

        $created = 0;

        foreach ($modules as $module) {
            $moduleName = $this->sanitizeText(Arr::get($module, 'module'));
            $qualityObjective = $this->sanitizeText(Arr::get($module, 'quality_objective'));

            if ($moduleName === null) {
                continue;
            }

            $moduleSlug = Str::slug($moduleName);

            $moduleRecord = Module::firstOrCreate(
                ['slug' => $moduleSlug],
                [
                    'name' => $moduleName,
                    'quality_objective' => $qualityObjective,
                    'order' => $this->categoryOrderFromSlug($moduleSlug),
                ]
            );

            if ($moduleRecord->wasRecentlyCreated === false && $qualityObjective && $moduleRecord->quality_objective !== $qualityObjective) {
                $moduleRecord->update(['quality_objective' => $qualityObjective]);
            }

            $moduleId = $moduleRecord->id;

            $categoryId = null;
            if ($hasCategoryColumn) {
                $category = Category::firstOrCreate(
                    ['slug' => $moduleSlug],
                    [
                        'title' => $moduleName,
                        'description' => $qualityObjective,
                        'order' => $this->categoryOrderFromSlug($moduleSlug),
                    ]
                );
                $categoryId = $category->id;
            }

            $areaValue = $hasAreaColumn ? $this->areaFromSlug($moduleSlug) : null;

            foreach (Arr::get($module, 'risks', []) as $risk) {
                $riskDescription = $this->sanitizeText(Arr::get($risk, 'description'));

                if ($riskDescription === null) {
                    continue;
                }

                $riskApplicableRaw = Arr::get($risk, 'risk_applicable');
                $riskApplicableBool = $this->normalizeBoolean($riskApplicableRaw);
                $riskApplicableDetails = $riskApplicableBool === null
                    ? $this->sanitizeText($riskApplicableRaw)
                    : null;

                $data = [
                    'title' => $this->buildTitle($riskDescription),
                    'quality_objective' => $qualityObjective,
                    'quality_risk' => $riskDescription,
                    'assessment_of_risk' => $this->sanitizeText(Arr::get($risk, 'assessment')),
                    'likelihood' => $this->normalizeBoolean(Arr::get($risk, 'likelihood')),
                    'adverse_effect' => $this->normalizeBoolean(Arr::get($risk, 'adverse_effect')),
                    'risk_applicable' => $riskApplicableBool,
                    'risk_applicable_details' => $riskApplicableDetails,
                    'response' => $this->sanitizeText(Arr::get($risk, 'response')),
                    'firm_implementation' => $this->sanitizeText(Arr::get($risk, 'firm_implementation')),
                    'toc' => $this->sanitizeText(Arr::get($risk, 'toc')),
                    'monitoring_activity_id' => $this->resolveMonitoringActivity(Arr::get($risk, 'monitoring_activity')),
                    'findings' => $this->sanitizeText(Arr::get($risk, 'findings')),
                    'deficiency_type_id' => $this->resolveDeficiencyType(Arr::get($risk, 'deficiency_type')),
                    'root_cause' => $this->sanitizeText(Arr::get($risk, 'root_cause')),
                    'severe' => $this->normalizeBoolean(Arr::get($risk, 'severe')),
                    'pervasive' => $this->normalizeBoolean(Arr::get($risk, 'pervasive')),
                    'remedial_actions' => $this->sanitizeText(Arr::get($risk, 'remedial_action')),
                    'status' => 'open',
                    'implementation_status' => 'not_started',
                    'import_source' => self::IMPORT_SOURCE,
                ];

                if ($hasCategoryColumn && $categoryId !== null) {
                    $data['category_id'] = $categoryId;
                }

                if ($hasModuleColumn) {
                    $data['module_id'] = $moduleId;
                }

                if ($areaValue !== null) {
                    $data['area'] = $areaValue;
                }

                IsqmEntry::create($data);
                $created++;
            }
        }

        $this->command?->info("Seeded {$created} ISQM entries from JSON.");
    }

    private function sanitizeText(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $text = trim((string) $value);

        if ($text === '' || in_array(strtolower($text), ['nan', 'na', 'n/a'], true)) {
            return null;
        }

        return $text;
    }

    private function normalizeBoolean(mixed $value): ?bool
    {
        if ($value === null) {
            return null;
        }

        if (is_bool($value)) {
            return $value;
        }

        $normalized = strtolower(trim((string) $value));

        return match ($normalized) {
            'yes', 'y', 'true', '1' => true,
            'no', 'n', 'false', '0' => false,
            default => null,
        };
    }

    private function resolveMonitoringActivity(mixed $value): ?int
    {
        $name = $this->sanitizeText($value);

        if ($name === null) {
            return null;
        }

        return MonitoringActivity::firstOrCreate(['name' => $name])->id;
    }

    private function resolveDeficiencyType(mixed $value): ?int
    {
        $name = $this->sanitizeText($value);

        if ($name === null) {
            return null;
        }

        return DeficiencyType::firstOrCreate(['name' => $name])->id;
    }

    private function buildTitle(string $description): string
    {
        return Str::limit(preg_replace('/\s+/', ' ', $description) ?? $description, 200, '');
    }

    private function areaFromSlug(string $slug): ?string
    {
        return str_replace('-', '_', $slug);
    }

    private function categoryOrderFromSlug(string $slug): int
    {
        return match ($slug) {
            'governance-and-leadership' => 1,
            'ethical-requirements' => 2,
            'acceptance-and-continuance' => 3,
            'engagement-performance' => 4,
            'resources' => 5,
            'information-and-communication' => 6,
            default => 99,
        };
    }
}


