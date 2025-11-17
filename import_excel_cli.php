<?php

use App\Models\Category;
use App\Models\DeficiencyType;
use App\Models\IsqmEntry;
use App\Models\MonitoringActivity;
use App\Models\Module;
use App\Services\XlsxSimpleReader;
use Carbon\Carbon;

require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$path = $argv[1] ?? null;
if (!$path) {
    fwrite(STDERR, "Usage: php import_excel_cli.php /path/to/file.xlsx\n");
    exit(1);
}

if (!file_exists($path)) {
    fwrite(STDERR, "File not found: {$path}\n");
    exit(1);
}

$reader = new XlsxSimpleReader();
$sheets = $reader->read($path);

$categoryMap = [
    'Governance and leadership' => 'governance-and-leadership',
    'Ethical requirements' => 'ethical-requirements',
    'Acceptance and continuance' => 'acceptance-and-continuance',
    'Engagement performance' => 'engagement-performance',
    'Resources' => 'resources',
    'Information and communication' => 'information-and-communication',
];

$colIndex = function(array $headers, string $needle): ?int {
    foreach ($headers as $i => $h) {
        if (str_contains(strtolower($h), $needle)) {
            return $i;
        }
    }
    return null;
};

$parseBool = static fn($value) => $value !== null && in_array(strtolower(trim((string)$value)), ['yes', 'y', '1', 'true']);

$parseDate = static function ($value) {
    if (empty($value)) {
        return null;
    }
    try {
        return Carbon::parse($value)->format('Y-m-d');
    } catch (\Throwable $e) {
        return null;
    }
};

$created = 0;
foreach ($sheets as $sheetName => $rows) {
    if (!isset($categoryMap[$sheetName])) {
        continue;
    }
    if (count($rows) < 3) {
        continue;
    }

    $category = Category::where('slug', $categoryMap[$sheetName])->first();
    if (!$category) {
        fwrite(STDERR, "Category not found for sheet: {$sheetName}\n");
        continue;
    }

    $module = \App\Models\Module::firstOrCreate(
        ['slug' => $categoryMap[$sheetName]],
        [
            'name' => $category->title,
            'quality_objective' => $category->description,
            'order' => $category->order ?? 0,
        ]
    );

    $headers = array_map(static fn($h) => trim((string) $h), $rows[1] ?? []);

    $idxObjective = $colIndex($headers, 'quality objective') ?? $colIndex($headers, 'objective');
    $idxRisk = $colIndex($headers, 'quality risk') ?? $colIndex($headers, 'risk');
    $idxAssessment = $colIndex($headers, 'assessment of risk');
    $idxLikelihood = $colIndex($headers, 'likelihood');
    $idxAdverse = $colIndex($headers, 'adverse effect');
    $idxApplicable = $colIndex($headers, 'risk applicable');
    $idxResponse = $colIndex($headers, 'response');
    $idxImplementation = $colIndex($headers, 'implementation');
    $idxToc = $colIndex($headers, 'toc');
    $idxMonitoring = $colIndex($headers, 'monitoring');
    $idxFindings = $colIndex($headers, 'findings');
    $idxDeficiency = $colIndex($headers, 'deficiency');
    $idxRootCause = $colIndex($headers, 'root cause');
    $idxSevere = $colIndex($headers, 'severe');
    $idxPervasive = $colIndex($headers, 'pervasive');
    $idxRemedial = $colIndex($headers, 'remedial');

    $lastObjective = null;

    for ($r = 2; $r < count($rows); $r++) {
        $row = $rows[$r];

        $objective = $idxObjective !== null ? trim((string)($row[$idxObjective] ?? '')) : '';
        if ($objective !== '') {
            $lastObjective = $objective;
        } elseif ($lastObjective) {
            $objective = $lastObjective;
        } else {
            continue;
        }

        $risk = $idxRisk !== null ? trim((string)($row[$idxRisk] ?? '')) : '';
        if ($risk === '' && $objective === '') {
            continue;
        }

        $monitoringId = null;
        if ($idxMonitoring !== null) {
            $name = trim((string)($row[$idxMonitoring] ?? ''));
            if ($name !== '' && strcasecmp($name, 'NA') !== 0) {
                $monitoringId = MonitoringActivity::firstOrCreate(['name' => $name])->id;
            }
        }

        $deficiencyId = null;
        if ($idxDeficiency !== null) {
            $name = trim((string)($row[$idxDeficiency] ?? ''));
            if ($name !== '' && strcasecmp($name, 'NA') !== 0) {
                $deficiencyId = DeficiencyType::firstOrCreate(['name' => $name])->id;
            }
        }

        IsqmEntry::create([
            'category_id' => $category->id,
            'module_id' => $module->id,
            'title' => substr($objective, 0, 255),
            'quality_objective' => $objective,
            'quality_risk' => $risk,
            'assessment_of_risk' => $idxAssessment !== null ? (string)($row[$idxAssessment] ?? '') : null,
            'likelihood' => $idxLikelihood !== null ? $parseBool($row[$idxLikelihood] ?? null) : null,
            'adverse_effect' => $idxAdverse !== null ? $parseBool($row[$idxAdverse] ?? null) : null,
            'risk_applicable' => $idxApplicable !== null ? $parseBool($row[$idxApplicable] ?? null) : null,
            'response' => $idxResponse !== null ? (string)($row[$idxResponse] ?? '') : null,
            'firm_implementation' => $idxImplementation !== null ? (string)($row[$idxImplementation] ?? '') : null,
            'toc' => $idxToc !== null ? (string)($row[$idxToc] ?? '') : null,
            'monitoring_activity_id' => $monitoringId,
            'findings' => $idxFindings !== null ? (string)($row[$idxFindings] ?? '') : null,
            'deficiency_type_id' => $deficiencyId,
            'root_cause' => $idxRootCause !== null ? (string)($row[$idxRootCause] ?? '') : null,
            'severe' => $idxSevere !== null ? $parseBool($row[$idxSevere] ?? null) : null,
            'pervasive' => $idxPervasive !== null ? $parseBool($row[$idxPervasive] ?? null) : null,
            'remedial_actions' => $idxRemedial !== null ? (string)($row[$idxRemedial] ?? '') : null,
            'status' => 'open',
        ]);

        $created++;
    }
}

echo "Imported {$created} entries\n";

