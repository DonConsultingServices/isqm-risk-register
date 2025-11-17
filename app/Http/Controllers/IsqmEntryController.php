<?php

namespace App\Http\Controllers;

use App\Models\DeficiencyType;
use App\Models\IsqmEntry;
use App\Models\MonitoringActivity;
use App\Models\Client;
use App\Models\Attachment;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use App\Models\ActivityLog;
use App\Services\XlsxSimpleReader;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;
use App\Models\Module;
use Illuminate\Support\Facades\Schema;
use App\Models\Category;

class IsqmEntryController extends Controller
{
    public function index(Request $request): View
    {
        $query = IsqmEntry::query()->with(['module', 'monitoringActivity', 'deficiencyType', 'client', 'owner']);

        // Filters
        if ($request->filled('area')) {
            $query->where('area', $request->area);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('quality_objective', 'like', "%{$search}%")
                  ->orWhere('quality_risk', 'like', "%{$search}%")
                  ->orWhere('assessment_of_risk', 'like', "%{$search}%")
                  ->orWhere('response', 'like', "%{$search}%")
                  ->orWhere('firm_implementation', 'like', "%{$search}%")
                  ->orWhere('findings', 'like', "%{$search}%")
                  ->orWhere('root_cause', 'like', "%{$search}%")
                  ->orWhere('remedial_actions', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%");
            });
        }
        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }
        if ($request->filled('owner_id')) {
            $query->where('owner_id', $request->owner_id);
        }
        if ($request->filled('due_date_from')) {
            $query->whereDate('due_date', '>=', $request->due_date_from);
        }
        if ($request->filled('due_date_to')) {
            $query->whereDate('due_date', '<=', $request->due_date_to);
        }
        if ($request->filled('created_from')) {
            $query->whereDate('created_at', '>=', $request->created_from);
        }
        if ($request->filled('created_to')) {
            $query->whereDate('created_at', '<=', $request->created_to);
        }
        if ($request->filled('overdue')) {
            $query->whereIn('status', ['open', 'monitoring'])
                  ->whereNotNull('due_date')
                  ->whereDate('due_date', '<', now());
        }

        $entries = $query->latest('updated_at')->paginate(20)->withQueryString();
        $clients = \App\Models\Client::orderBy('name')->get();
        $users = User::orderBy('name')->get();

        return view('isqm.index', compact('entries', 'clients', 'users'));
    }

    public function trashed(Request $request): View
    {
        // Only admins and managers can view trashed entries
        if (!in_array(auth()->user()->role, ['admin', 'manager'])) {
            abort(403, 'You do not have permission to view trashed entries.');
        }

        $query = IsqmEntry::onlyTrashed()->with(['module', 'monitoringActivity', 'deficiencyType', 'client', 'owner']);

        // Filters
        if ($request->filled('area')) {
            $query->where('area', $request->area);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('quality_objective', 'like', "%{$search}%")
                  ->orWhere('quality_risk', 'like', "%{$search}%")
                  ->orWhere('findings', 'like', "%{$search}%");
            });
        }
        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        $entries = $query->latest('deleted_at')->paginate(20)->withQueryString();
        $clients = \App\Models\Client::orderBy('name')->get();

        return view('isqm.trashed', compact('entries', 'clients'));
    }

    public function restore(Request $request, int $id): RedirectResponse
    {
        // Only admins and managers can restore entries
        if (!in_array(auth()->user()->role, ['admin', 'manager'])) {
            abort(403, 'You do not have permission to restore entries.');
        }

        $entry = IsqmEntry::onlyTrashed()->findOrFail($id);
        $entry->restore();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'restored',
            'model_type' => IsqmEntry::class,
            'model_id' => $entry->id,
            'changes' => ['restored_at' => now()],
        ]);

        return redirect()->route('isqm.trashed')->with('status', "Entry #{$entry->id} restored successfully");
    }

    public function forceDelete(Request $request, int $id): RedirectResponse
    {
        // Only admins can permanently delete entries
        if (auth()->user()->role !== 'admin') {
            abort(403, 'You do not have permission to permanently delete entries.');
        }

        $entry = IsqmEntry::onlyTrashed()->with('attachments')->findOrFail($id);
        
        // Delete all attachment files from storage
        foreach ($entry->attachments as $attachment) {
            if (Storage::exists($attachment->path)) {
                Storage::delete($attachment->path);
            }
        }

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'force_deleted',
            'model_type' => IsqmEntry::class,
            'model_id' => $entry->id,
            'changes' => $entry->toArray(),
        ]);

        $entryId = $entry->id;
        $entry->forceDelete();

        return redirect()->route('isqm.trashed')->with('status', "Entry #{$entryId} permanently deleted");
    }

    public function show(IsqmEntry $isqm): View
    {
        $isqm->load(['monitoringActivity', 'deficiencyType', 'client', 'owner', 'attachments']);
        return view('isqm.show', compact('isqm'));
    }

    public function complianceNow(): View
    {
        $entries = IsqmEntry::with(['category', 'monitoringActivity', 'deficiencyType'])
            ->compliance()
            ->orderBy('category_id')
            ->orderBy('title')
            ->get();

        $groupedEntries = $entries->groupBy(function (IsqmEntry $entry) {
            if ($entry->category) {
                return $entry->category->title;
            }

            if ($entry->area) {
                return Str::title(str_replace('_', ' ', $entry->area));
            }

            return 'Other';
        })->sortKeys();

        return view('isqm.compliance', [
            'groupedEntries' => $groupedEntries,
        ]);
    }

    public function create(): View
    {
        return view('isqm.create', [
            'monitoringActivities' => MonitoringActivity::whereNotNull('name')->where('name', '!=', '')->orderBy('name')->get(),
            'deficiencyTypes' => DeficiencyType::whereNotNull('name')->where('name', '!=', '')->orderBy('name')->get(),
            'clients' => Client::orderBy('name')->get(),
            'users' => User::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $validated = $this->validated($request);
            $entry = IsqmEntry::create($validated);
            ActivityLog::create([
                'user_id' => $request->user()?->id,
                'action' => 'created',
                'model_type' => IsqmEntry::class,
                'model_id' => $entry->id,
                'changes' => $entry->toArray(),
            ]);

            if ($request->hasFile('files')) {
                $uploadErrors = [];
                foreach ($request->file('files') as $file) {
                    try {
                        // Sanitize filename
                        $originalName = $file->getClientOriginalName();
                        $sanitizedName = preg_replace('/[<>:"|?*\x00-\x1F]/', '_', $originalName);
                        $sanitizedName = str_replace('..', '', $sanitizedName);
                        
                        $path = $file->store('isqm-attachments');
                        Attachment::create([
                            'isqm_entry_id' => $entry->id,
                            'path' => $path,
                            'filename' => $sanitizedName ?: $originalName,
                            'size' => $file->getSize(),
                        ]);
                    } catch (\Exception $e) {
                        $uploadErrors[] = "Failed to upload {$file->getClientOriginalName()}: " . $e->getMessage();
                    }
                }
                
                if (!empty($uploadErrors)) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['files' => implode(' ', $uploadErrors)])
                        ->with('warning', 'Entry created, but some files failed to upload.');
                }
            }
            
            return $this->redirectAfterAction($request, $entry, 'Entry created successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors($e->errors())
                ->with('error', 'Please correct the errors below and try again.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'An error occurred while creating the entry: ' . $e->getMessage());
        }
    }

    public function edit(IsqmEntry $isqm): View
    {
        return view('isqm.edit', [
            'entry' => $isqm,
            'monitoringActivities' => MonitoringActivity::whereNotNull('name')->where('name', '!=', '')->orderBy('name')->get(),
            'deficiencyTypes' => DeficiencyType::whereNotNull('name')->where('name', '!=', '')->orderBy('name')->get(),
            'clients' => Client::orderBy('name')->get(),
            'users' => User::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, IsqmEntry $isqm): RedirectResponse
    {
        try {
            $validated = $this->validated($request);
            $before = $isqm->getOriginal();
            $isqm->update($validated);
            $after = $isqm->fresh()->toArray();
            ActivityLog::create([
                'user_id' => $request->user()?->id,
                'action' => 'updated',
                'model_type' => IsqmEntry::class,
                'model_id' => $isqm->id,
                'changes' => ['before' => $before, 'after' => $after],
            ]);
            
            if ($request->hasFile('files')) {
                $uploadErrors = [];
                foreach ($request->file('files') as $file) {
                    try {
                        // Sanitize filename
                        $originalName = $file->getClientOriginalName();
                        $sanitizedName = preg_replace('/[<>:"|?*\x00-\x1F]/', '_', $originalName);
                        $sanitizedName = str_replace('..', '', $sanitizedName);
                        
                        $path = $file->store('isqm-attachments');
                        Attachment::create([
                            'isqm_entry_id' => $isqm->id,
                            'path' => $path,
                            'filename' => $sanitizedName ?: $originalName,
                            'size' => $file->getSize(),
                        ]);
                    } catch (\Exception $e) {
                        $uploadErrors[] = "Failed to upload {$file->getClientOriginalName()}: " . $e->getMessage();
                    }
                }
                
                if (!empty($uploadErrors)) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['files' => implode(' ', $uploadErrors)])
                        ->with('warning', 'Entry updated, but some files failed to upload.');
                }
            }
            
            return $this->redirectAfterAction($request, $isqm, 'Entry updated successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors($e->errors())
                ->with('error', 'Please correct the errors below and try again.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'An error occurred while updating the entry: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request, IsqmEntry $isqm): RedirectResponse
    {
        // Load attachments before deletion
        $isqm->load('attachments');
        
        // Delete all attachment files from storage
        foreach ($isqm->attachments as $attachment) {
            if (Storage::exists($attachment->path)) {
                Storage::delete($attachment->path);
            }
        }
        
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'deleted',
            'model_type' => IsqmEntry::class,
            'model_id' => $isqm->id,
            'changes' => $isqm->toArray(),
        ]);
        $isqm->delete();
        return $this->redirectAfterAction($request, $isqm, 'Entry deleted');
    }

    public function bulkUpdate(Request $request): RedirectResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:isqm_entries,id',
            'action' => 'required|in:delete,status_update',
            'status' => 'required_if:action,status_update|in:open,monitoring,closed',
        ]);

        $ids = $request->ids;
        
        if ($request->action === 'delete') {
            $entries = IsqmEntry::whereIn('id', $ids)->with('attachments')->get();
            foreach ($entries as $entry) {
                // Delete all attachment files from storage
                foreach ($entry->attachments as $attachment) {
                    if (Storage::exists($attachment->path)) {
                        Storage::delete($attachment->path);
                    }
                }
                
                ActivityLog::create([
                    'user_id' => auth()->id(),
                    'action' => 'deleted',
                    'model_type' => IsqmEntry::class,
                    'model_id' => $entry->id,
                    'changes' => $entry->toArray(),
                ]);
            }
            IsqmEntry::whereIn('id', $ids)->delete();
            return redirect()->route('isqm.index')->with('status', count($ids).' entries deleted');
        }

        if ($request->action === 'status_update') {
            IsqmEntry::whereIn('id', $ids)->update(['status' => $request->status]);
            foreach ($ids as $id) {
                ActivityLog::create([
                    'user_id' => auth()->id(),
                    'action' => 'updated',
                    'model_type' => IsqmEntry::class,
                    'model_id' => $id,
                    'changes' => ['status' => $request->status],
                ]);
            }
            return redirect()->route('isqm.index')->with('status', count($ids).' entries updated to '.$request->status);
        }

        return back();
    }

    public function importForm(): View
    {
        return view('isqm.import');
    }

    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        $path = $request->file('file')->store('isqm-imports');

        $reader = new XlsxSimpleReader();
        $sheets = $reader->read(storage_path('app/'.$path));

        $categoryMap = [
            'Governance and leadership' => 'governance-and-leadership',
            'Ethical requirements' => 'ethical-requirements',
            'Acceptance and continuance' => 'acceptance-and-continuance',
            'Engagement performance' => 'engagement-performance',
            'Resources' => 'resources',
            'Information and communication' => 'information-and-communication',
        ];

        $created = 0;
        $errors = [];

        foreach ($sheets as $sheetName => $rows) {
            if (!isset($categoryMap[$sheetName])) { continue; }
            if (count($rows) < 3) { continue; }
            
            // Get module for this sheet
            $module = \App\Models\Module::where('slug', $categoryMap[$sheetName])->first();
            if (!$module) {
                $errors[] = "Module not found for sheet: {$sheetName}";
                continue;
            }

            $categoryId = \App\Models\Category::where('slug', $categoryMap[$sheetName])->value('id');
            
            // Row 1 is header (0-indexed)
            $headers = array_map(fn($h) => trim(strtolower((string)$h)), $rows[1] ?? []);

            $col = function(string $needle) use ($headers): ?int {
                foreach ($headers as $i => $h) {
                    if (str_contains($h, $needle)) return $i;
                }
                return null;
            };

            // Find column indices
            $idxObjective = $col('quality objective') ?? $col('objective');
            $idxRisk = $col('quality risk') ?? $col('risk');
            $idxAssessment = $col('assessment') ?? $col('assessment of risk');
            $idxLikelihood = $col('likelihood');
            $idxResponse = $col('response') ?? $col('response to quality risk');
            $idxImplementation = $col('implementation') ?? $col('firm implementation');
            $idxToc = $col('toc') ?? $col('test of control');
            $idxFindings = $col('findings');
            $idxRootCause = $col('root cause');
            $idxRemedial = $col('remedial');
            $idxMonitoring = $col('monitoring activity');
            $idxDeficiency = $col('deficiency type') ?? $col('type of deficiency');
            $idxSevere = $col('severe');
            $idxPervasive = $col('pervasive');
            $idxAdverse = $col('adverse effect');
            $idxRiskApp = $col('risk applicable');
            $idxObjectiveMet = $col('objective met');
            $idxEntityLevel = $col('entity level');
            $idxEngagementLevel = $col('engagement level');
            $idxStatus = $col('status');
            $idxDueDate = $col('due date');

            // Track last objective for "same as above" handling
            $lastObjective = null;

            // Start from row 2 (index 2) - data rows
            for ($r = 2; $r < count($rows); $r++) {
                $row = $rows[$r];
                
                // Get quality objective - if empty, use last objective ("same as above")
                $objective = $idxObjective !== null ? trim((string)($row[$idxObjective] ?? '')) : '';
                if (!empty($objective)) {
                    $lastObjective = $objective; // Update last objective
                } elseif ($lastObjective === null) {
                    // Skip if we don't have an objective yet
                    continue;
                } else {
                    // Use last objective for "same as above"
                    $objective = $lastObjective;
                }
                
                // Must have at least a risk to create entry
                $risk = $idxRisk !== null ? trim((string)($row[$idxRisk] ?? '')) : '';
                if (empty($risk) && empty($objective)) { continue; }

                // Map monitoring activity
                $monitoringId = null;
                if ($idxMonitoring !== null && isset($row[$idxMonitoring])) {
                    $monName = trim((string)$row[$idxMonitoring]);
                    if (!empty($monName) && $monName !== 'NA') {
                        $mon = \App\Models\MonitoringActivity::firstOrCreate(['name' => $monName]);
                        $monitoringId = $mon->id;
                    }
                }

                // Map deficiency type
                $deficiencyId = null;
                if ($idxDeficiency !== null && isset($row[$idxDeficiency])) {
                    $defName = trim((string)$row[$idxDeficiency]);
                    if (!empty($defName) && $defName !== 'NA') {
                        $def = \App\Models\DeficiencyType::firstOrCreate(['name' => $defName]);
                        $deficiencyId = $def->id;
                    }
                }

                // Parse status
                $status = 'open';
                if ($idxStatus !== null && isset($row[$idxStatus])) {
                    $statusVal = strtolower(trim((string)$row[$idxStatus]));
                    if (in_array($statusVal, ['open', 'monitoring', 'closed'])) {
                        $status = $statusVal;
                    }
                }

                // Parse boolean fields
                $parseBool = fn($idx, $row) => $idx !== null && isset($row[$idx]) 
                    ? in_array(strtolower(trim((string)$row[$idx])), ['yes', 'y', '1', 'true'])
                    : null;

                // Parse date
                $parseDate = fn($idx, $row) => $idx !== null && isset($row[$idx]) && !empty(trim((string)$row[$idx]))
                    ? \Carbon\Carbon::parse($row[$idx])->format('Y-m-d')
                    : null;

                try {
                    IsqmEntry::create([
                        'category_id' => $categoryId,
                        'module_id' => $module->id,
                        'title' => substr($objective, 0, 255), // Short title from objective
                        'quality_objective' => $objective,
                        'created_by' => $request->user()?->id,
                        'import_source' => "{$sheetName}:Row" . ($r + 1),
                        'quality_risk' => $idxRisk !== null ? trim((string)($row[$idxRisk] ?? '')) : null,
                        'assessment_of_risk' => $idxAssessment !== null ? trim((string)($row[$idxAssessment] ?? '')) : null,
                        'likelihood' => $parseBool($idxLikelihood, $row),
                        'response' => $idxResponse !== null ? trim((string)($row[$idxResponse] ?? '')) : null,
                        'firm_implementation' => $idxImplementation !== null ? trim((string)($row[$idxImplementation] ?? '')) : null,
                        'toc' => $idxToc !== null ? trim((string)($row[$idxToc] ?? '')) : null,
                        'monitoring_activity_id' => $monitoringId,
                        'findings' => $idxFindings !== null ? trim((string)($row[$idxFindings] ?? '')) : null,
                        'deficiency_type_id' => $deficiencyId,
                        'root_cause' => $idxRootCause !== null ? trim((string)($row[$idxRootCause] ?? '')) : null,
                        'severe' => $parseBool($idxSevere, $row),
                        'pervasive' => $parseBool($idxPervasive, $row),
                        'adverse_effect' => $parseBool($idxAdverse, $row),
                        'risk_applicable' => $parseBool($idxRiskApp, $row),
                        'objective_met' => $parseBool($idxObjectiveMet, $row),
                        'entity_level' => $parseBool($idxEntityLevel, $row),
                        'engagement_level' => $parseBool($idxEngagementLevel, $row),
                        'remedial_actions' => $idxRemedial !== null ? trim((string)($row[$idxRemedial] ?? '')) : null,
                        'status' => $status,
                        'due_date' => $parseDate($idxDueDate, $row),
                    ]);
                    $created++;
                } catch (\Exception $e) {
                    $errors[] = "Row ".($r+1).": ".$e->getMessage();
                }
            }
        }

        $message = "Imported {$created} entries";
        if (!empty($errors)) {
            $message .= ". Errors: ".count($errors);
        }

        return redirect()->route('isqm.index')->with('status', $message);
    }

    private function validated(Request $request): array
    {
        // Preprocess array fields - combine them into strings if they come as arrays
        $arrayFields = ['quality_objective', 'quality_risk', 'assessment_of_risk', 'response', 'firm_implementation', 'toc', 'findings', 'root_cause', 'remedial_actions'];
        foreach ($arrayFields as $field) {
            if ($request->has($field) && is_array($request->input($field))) {
                $values = array_filter(array_map('trim', $request->input($field)), fn($v) => $v !== '');
                if (count($values) > 1) {
                    $request->merge([$field => '• ' . implode("\n\n• ", $values)]);
                } elseif (count($values) === 1) {
                    $request->merge([$field => $values[0]]);
                } else {
                    $request->merge([$field => null]);
                }
            }
        }
        
        $validated = $request->validate([
            'area' => 'required|in:governance_and_leadership,ethical_requirements,acceptance_and_continuance,engagement_performance,resources,information_and_communication',
            'quality_objective' => 'required|string',
            'quality_risk' => 'nullable|string',
            'assessment_of_risk' => 'nullable|string',
            'likelihood' => 'nullable|in:0,1',
            'response' => 'nullable|string',
            'firm_implementation' => 'nullable|string',
            'toc' => 'nullable|string',
            'monitoring_activity_id' => 'nullable|exists:monitoring_activities,id',
            'findings' => 'nullable|string',
            'deficiency_type_id' => 'nullable|exists:deficiency_types,id',
            'root_cause' => 'nullable|string',
            'severe' => 'nullable',
            'pervasive' => 'nullable',
            'adverse_effect' => 'nullable|in:0,1',
            'risk_applicable' => 'nullable|in:0,1',
            'objective_met' => 'nullable',
            'remedial_actions' => 'nullable|string',
            'entity_level' => 'nullable',
            'engagement_level' => 'nullable',
            'status' => 'required|in:open,monitoring,closed',
            'owner_id' => 'nullable|exists:users,id',
            'client_id' => 'nullable|exists:clients,id',
            'due_date' => 'nullable|date',
            'review_date' => 'nullable|date',
            'files.*' => [
                'nullable',
                'file',
                'max:20480', // 20MB in KB
                'mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png',
                function ($attribute, $value, $fail) {
                    if ($value) {
                        // Additional MIME type validation
                        $allowedMimes = [
                            'application/pdf',
                            'application/msword',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'application/vnd.ms-excel',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'image/jpeg',
                            'image/jpg',
                            'image/png',
                        ];
                        
                        $mimeType = $value->getMimeType();
                        if (!in_array($mimeType, $allowedMimes)) {
                            $fail('The file ' . $value->getClientOriginalName() . ' has an invalid file type. Allowed types: PDF, Word, Excel, Images.');
                        }
                        
                        // File size limits by type
                        $sizeInKB = $value->getSize() / 1024;
                        if (str_starts_with($mimeType, 'image/')) {
                            if ($sizeInKB > 5120) { // 5MB for images
                                $fail('The image ' . $value->getClientOriginalName() . ' is too large. Maximum size for images is 5MB.');
                            }
                        } elseif (str_starts_with($mimeType, 'application/vnd.ms-excel') || str_starts_with($mimeType, 'application/vnd.openxmlformats-officedocument.spreadsheetml')) {
                            if ($sizeInKB > 10240) { // 10MB for Excel files
                                $fail('The Excel file ' . $value->getClientOriginalName() . ' is too large. Maximum size for Excel files is 10MB.');
                            }
                        } elseif ($sizeInKB > 20480) { // 20MB for other files
                            $fail('The file ' . $value->getClientOriginalName() . ' is too large. Maximum size is 20MB.');
                        }
                        
                        // Filename sanitization check
                        $filename = $value->getClientOriginalName();
                        if (preg_match('/[<>:"|?*\x00-\x1F]/', $filename)) {
                            $fail('The filename ' . $filename . ' contains invalid characters.');
                        }
                    }
                },
            ],
        ]);

        if (isset($validated['area'])) {
            $slug = str_replace('_', '-', $validated['area']);
            $module = Module::where('slug', $slug)->first();
            if (!$module) {
                abort(422, 'Selected module is invalid.');
            }

            $validated['module_id'] = $module->id;

            if (Schema::hasColumn('isqm_entries', 'area')) {
                // Keep area with underscores for ENUM column (don't convert to hyphens)
                // $validated['area'] already has underscores, so keep it as is
                // The area column expects: governance_and_leadership (with underscores)
            } else {
                unset($validated['area']);
            }

            if (Schema::hasColumn('isqm_entries', 'category_id')) {
                $category = Category::firstOrCreate(
                    ['slug' => $slug],
                    [
                        'title' => $module->name,
                        'description' => $module->quality_objective,
                        'order' => $module->order ?? 0,
                    ]
                );

                $validated['category_id'] = $category->id;
            }
        }

        // Normalize checkbox fields - if not present, set to false; if present, set to true
        $checkboxFields = ['severe', 'pervasive', 'objective_met', 'entity_level', 'engagement_level'];
        foreach ($checkboxFields as $field) {
            $validated[$field] = $request->has($field) && $request->input($field) == '1' ? true : false;
        }

        // Handle select-based boolean fields
        if (isset($validated['likelihood'])) {
            $validated['likelihood'] = $validated['likelihood'] == '1' ? true : ($validated['likelihood'] == '0' ? false : null);
        }
        if (isset($validated['adverse_effect'])) {
            $validated['adverse_effect'] = $validated['adverse_effect'] == '1' ? true : ($validated['adverse_effect'] == '0' ? false : null);
        }
        if (isset($validated['risk_applicable'])) {
            $validated['risk_applicable'] = $validated['risk_applicable'] == '1' ? true : ($validated['risk_applicable'] == '0' ? false : null);
        }

        return $validated;
    }

    private function redirectAfterAction(Request $request, ?IsqmEntry $entry, string $message): RedirectResponse
    {
        $returnTo = $request->input('return_to') ?? $request->query('return_to');

        if (is_string($returnTo) && $returnTo !== '') {
            if (Str::startsWith($returnTo, ['/', url('/')])) {
                return redirect($returnTo)->with('status', $message);
            }
        }

        if ($entry) {
            $entry->loadMissing('module');
            $module = $entry->module;
            if ($module) {
                if ($route = $this->routeForModuleSlug($module->slug)) {
                    return redirect()->route($route)->with('status', $message);
                }
            }
        }

        return redirect()->route('isqm.index')->with('status', $message);
    }

    private function routeForModuleSlug(?string $slug): ?string
    {
        return match ($slug) {
            'governance-and-leadership' => 'areas.governance',
            'ethical-requirements' => 'areas.ethical',
            'acceptance-and-continuance' => 'areas.acceptance',
            'engagement-performance' => 'areas.engagement',
            'resources' => 'areas.resources',
            'information-and-communication' => 'areas.information',
            default => null,
        };
    }

    public function downloadAttachment(Attachment $attachment)
    {
        // Load the entry relationship
        $attachment->load('entry');
        
        // Verify the attachment belongs to an ISQM entry
        $entry = $attachment->entry;
        if (!$entry) {
            abort(404, 'Attachment not found');
        }

        // Check if file exists
        if (!Storage::exists($attachment->path)) {
            abort(404, 'File not found');
        }

        return Storage::download($attachment->path, $attachment->filename);
    }

    public function deleteAttachment(Request $request, Attachment $attachment)
    {
        // Load the entry relationship
        $attachment->load('entry');
        
        // Verify the attachment belongs to an ISQM entry
        $entry = $attachment->entry;
        if (!$entry) {
            abort(404, 'Attachment not found');
        }

        // Log the deletion
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'deleted',
            'model_type' => Attachment::class,
            'model_id' => $attachment->id,
            'changes' => ['filename' => $attachment->filename, 'isqm_entry_id' => $attachment->isqm_entry_id],
        ]);

        // Delete the file from storage
        if (Storage::exists($attachment->path)) {
            Storage::delete($attachment->path);
        }

        // Delete the database record
        $filename = $attachment->filename;
        $attachment->delete();

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Attachment deleted successfully']);
        }

        return redirect()->back()->with('status', "Attachment '{$filename}' deleted successfully");
    }
}


