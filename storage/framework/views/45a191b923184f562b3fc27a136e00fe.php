<?php $title = $module->name ?? 'Module'; ?>
<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => $title]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($title)]); ?>
  <div
    style="max-width:1400px; margin:0 auto; padding:0 12px;"
    data-module-root
    data-module-slug="<?php echo e($module->slug); ?>"
    data-module-endpoint="<?php echo e(route('api.modules.show', $module)); ?>"
    data-lists-endpoint="<?php echo e(route('api.lists')); ?>"
    data-view-url="<?php echo e(url('isqm')); ?>/:id"
    data-edit-url="<?php echo e(url('isqm')); ?>/:id/edit"
  >
    <nav style="font-size:13px;color:#64748b;margin-bottom:12px;display:flex;gap:6px;align-items:center;">
      <a href="<?php echo e(route('dashboard')); ?>" style="color:var(--brand-blue);text-decoration:none;">Dashboard</a>
      <span>/</span>
      <span><?php echo e($title); ?></span>
    </nav>

    <div class="topbar">
      <h2><?php echo e($title); ?></h2>
      <a class="btn" href="<?php echo e(route('isqm.create', ['area' => str_replace('-', '_', $module->slug), 'return_to' => request()->fullUrl()])); ?>">Add Entry</a>
    </div>

    <?php if($module->quality_objective): ?>
      <div style="background:#0f172a;color:#e2e8f0;border-radius:12px;padding:24px;margin-bottom:20px;">
        <div style="font-size:12px;text-transform:uppercase;letter-spacing:0.08em;color:#94a3b8;margin-bottom:8px;">Quality Objective</div>
        <p style="margin:0;font-size:16px;line-height:1.6;color:#f8fafc;white-space:pre-wrap;"><?php echo e($module->quality_objective); ?></p>
      </div>
    <?php endif; ?>

    <section class="filter-section">
      <div class="filter-header">
        <h2 class="filter-title">Filters</h2>
      </div>
      <form method="get" action="<?php echo e(request()->url()); ?>" id="areaFilters" data-module-form class="filter-form">
        <div class="filter-search-row">
          <div class="filter-field">
            <label class="filter-label" for="search-input">Search</label>
            <input type="text" id="search-input" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search objectives, risks..." class="filter-input filter-search">
          </div>
          <div class="filter-field">
            <label class="filter-label" for="status-select">Status</label>
            <select id="status-select" name="status" class="filter-input">
              <option value="">All Status</option>
              <option value="open" <?php if(request('status') === 'open'): echo 'selected'; endif; ?>>Open</option>
              <option value="monitoring" <?php if(request('status') === 'monitoring'): echo 'selected'; endif; ?>>Monitoring</option>
              <option value="closed" <?php if(request('status') === 'closed'): echo 'selected'; endif; ?>>Closed</option>
            </select>
          </div>
          <div class="filter-actions">
            <button class="btn" type="submit">Filter</button>
            <a href="<?php echo e(request()->url()); ?>" class="btn btn-secondary" data-module-clear>Clear</a>
          </div>
        </div>

        <div class="filter-grid">
          <?php
            $filterFields = [
              ['name' => 'f_objective', 'label' => 'Quality Objective', 'key' => 'objective', 'options' => $filterOptions['objectives'], 'type' => 'select', 'includeAll' => true],
              ['name' => 'f_risk', 'label' => 'Quality Risk', 'key' => 'risk', 'options' => $filterOptions['risks'], 'type' => 'select', 'includeAll' => true],
              ['name' => 'f_assessment', 'label' => 'Assessment of Risk', 'key' => 'assessment', 'options' => $filterOptions['assessments'], 'type' => 'select', 'includeAll' => true],
              ['name' => 'f_likelihood', 'label' => 'Likelihood', 'key' => 'likelihood', 'options' => $filterOptions['boolean'], 'type' => 'select', 'includeAll' => false],
              ['name' => 'f_adverse', 'label' => 'Adverse Effect?', 'key' => 'adverse', 'options' => $filterOptions['boolean'], 'type' => 'select', 'includeAll' => false],
              ['name' => 'f_applicable', 'label' => 'Risk Applicable?', 'key' => 'applicable', 'options' => $filterOptions['boolean'], 'type' => 'select', 'includeAll' => false],
              ['name' => 'f_response', 'label' => 'Response to Quality Risk', 'key' => 'response', 'options' => $filterOptions['responses'], 'type' => 'select', 'includeAll' => true],
              ['name' => 'f_firm', 'label' => 'Firm Implementation', 'key' => 'firm', 'options' => $filterOptions['firmImplementations'], 'type' => 'select', 'includeAll' => true],
              ['name' => 'f_toc', 'label' => 'TOC', 'key' => 'toc', 'options' => $filterOptions['tocs'], 'type' => 'select', 'includeAll' => true],
              ['name' => 'f_monitoring', 'label' => 'Monitoring Activity', 'key' => 'monitoring', 'options' => $filterOptions['monitoringActivities'], 'type' => 'select', 'includeAll' => true, 'isAssoc' => true],
              ['name' => 'f_findings', 'label' => 'Findings', 'key' => 'findings', 'options' => $filterOptions['findings'], 'type' => 'select', 'includeAll' => true],
              ['name' => 'f_deficiency', 'label' => 'Deficiency Type', 'key' => 'deficiency', 'options' => $filterOptions['deficiencyTypes'], 'type' => 'select', 'includeAll' => true, 'isAssoc' => true],
              ['name' => 'f_root_cause', 'label' => 'Root Cause', 'key' => 'root_cause', 'options' => $filterOptions['rootCauses'], 'type' => 'select', 'includeAll' => true],
              ['name' => 'f_severe', 'label' => 'Severe', 'key' => 'severe', 'options' => $filterOptions['boolean'], 'type' => 'select', 'includeAll' => false],
              ['name' => 'f_pervasive', 'label' => 'Pervasive', 'key' => 'pervasive', 'options' => $filterOptions['boolean'], 'type' => 'select', 'includeAll' => false],
              ['name' => 'f_remedial', 'label' => 'Remedial Actions', 'key' => 'remedial', 'options' => $filterOptions['remedialActions'], 'type' => 'select', 'includeAll' => true],
              ['name' => 'f_objective_met', 'label' => 'Objective Met', 'key' => 'objective_met', 'options' => $filterOptions['boolean'], 'type' => 'select', 'includeAll' => false],
              ['name' => 'f_entity_level', 'label' => 'Entity Level', 'key' => 'entity_level', 'options' => $filterOptions['boolean'], 'type' => 'select', 'includeAll' => false],
              ['name' => 'f_engagement_level', 'label' => 'Engagement Level', 'key' => 'engagement_level', 'options' => $filterOptions['boolean'], 'type' => 'select', 'includeAll' => false],
              ['name' => 'f_impl_status', 'label' => 'Implementation Status', 'key' => 'impl_status', 'options' => $filterOptions['implementationStatuses'], 'type' => 'select', 'includeAll' => false],
              ['name' => 'f_record_status', 'label' => 'Record Status', 'key' => 'record_status', 'options' => $filterOptions['statusOptions'], 'type' => 'select', 'includeAll' => false],
              ['name' => 'f_owner', 'label' => 'Owner', 'key' => 'owner', 'options' => $filterOptions['owners'], 'type' => 'select', 'includeAll' => true, 'isAssoc' => true],
              ['name' => 'f_client', 'label' => 'Client', 'key' => 'client', 'options' => $filterOptions['clients'], 'type' => 'select', 'includeAll' => true, 'isAssoc' => true],
              ['name' => 'f_due_date', 'label' => 'Due Date', 'key' => 'due_date', 'type' => 'date', 'value' => $filters['due_date'] ?? ''],
              ['name' => 'f_review_date', 'label' => 'Review Date', 'key' => 'review_date', 'type' => 'date', 'value' => $filters['review_date'] ?? ''],
            ];
          ?>
          <?php $__currentLoopData = $filterFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="filter-field">
              <label class="filter-label"><?php echo e($field['label']); ?></label>
              <?php if($field['type'] === 'select'): ?>
                <select name="<?php echo e($field['name']); ?>" class="filter-input">
                  <?php if($field['includeAll'] ?? false): ?>
                    <option value="">All</option>
                  <?php endif; ?>
                  <?php if($field['isAssoc'] ?? false): ?>
                    <?php $__currentLoopData = $field['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($id); ?>" <?php if(($filters[$field['key']] ?? '') == $id): echo 'selected'; endif; ?>><?php echo e($name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php else: ?>
                    <?php $__currentLoopData = $field['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($value); ?>" <?php if(($filters[$field['key']] ?? '') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php endif; ?>
                </select>
              <?php elseif($field['type'] === 'date'): ?>
                <input type="date" name="<?php echo e($field['name']); ?>" value="<?php echo e($field['value']); ?>" class="filter-input">
              <?php endif; ?>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="filter-form-actions">
          <button class="btn" type="submit">Apply Filters</button>
          <button type="button" class="btn btn-secondary" data-module-clear>Clear</button>
        </div>
      </form>
    </section>

  <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:12px;margin-bottom:24px;">
    <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:16px;">
      <div style="font-size:12px;color:#64748b;text-transform:uppercase;letter-spacing:0.08em;">Total</div>
      <div style="font-size:28px;font-weight:700;color:var(--brand-blue);margin-top:4px;" data-module-stat="total"><?php echo e($stats['total']); ?></div>
    </div>
    <div style="background:#fef3c7;border:1px solid #fde047;border-radius:10px;padding:16px;">
      <div style="font-size:12px;color:#92400e;text-transform:uppercase;letter-spacing:0.08em;">Open</div>
      <div style="font-size:28px;font-weight:700;color:#92400e;margin-top:4px;" data-module-stat="open"><?php echo e($stats['open']); ?></div>
    </div>
    <div style="background:#dbeafe;border:1px solid #93c5fd;border-radius:10px;padding:16px;">
      <div style="font-size:12px;color:#1e40af;text-transform:uppercase;letter-spacing:0.08em;">Monitoring</div>
      <div style="font-size:28px;font-weight:700;color:#1e40af;margin-top:4px;" data-module-stat="monitoring"><?php echo e($stats['monitoring']); ?></div>
    </div>
    <div style="background:#d1fae5;border:1px solid #86efac;border-radius:10px;padding:16px;">
      <div style="font-size:12px;color:#065f46;text-transform:uppercase;letter-spacing:0.08em;">Closed</div>
      <div style="font-size:28px;font-weight:700;color:#065f46;margin-top:4px;" data-module-stat="closed"><?php echo e($stats['closed']); ?></div>
    </div>
    <div style="background:#fee2e2;border:1px solid #fecaca;border-radius:10px;padding:16px;">
      <div style="font-size:12px;color:#b91c1c;text-transform:uppercase;letter-spacing:0.08em;">Severe</div>
      <div style="font-size:28px;font-weight:700;color:#b91c1c;margin-top:4px;" data-module-stat="severe"><?php echo e($stats['severe']); ?></div>
    </div>
    <div style="background:#ede9fe;border:1px solid #c4b5fd;border-radius:10px;padding:16px;">
      <div style="font-size:12px;color:#5b21b6;text-transform:uppercase;letter-spacing:0.08em;">Pervasive</div>
      <div style="font-size:28px;font-weight:700;color:#5b21b6;margin-top:4px;" data-module-stat="pervasive"><?php echo e($stats['pervasive']); ?></div>
    </div>
    <div style="background:#fee2e2;border:1px solid #fecaca;border-radius:10px;padding:16px;">
      <div style="font-size:12px;color:#991b1b;text-transform:uppercase;letter-spacing:0.08em;">Overdue</div>
      <div style="font-size:28px;font-weight:700;color:#991b1b;margin-top:4px;" data-module-stat="overdue"><?php echo e($stats['overdue']); ?></div>
    </div>
  </div>

  <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:16px;margin-bottom:28px;">
      <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;padding:20px;">
        <h3 style="margin:0 0 12px;font-size:16px;color:#0f172a;">Top Monitoring Activities</h3>
        <ul style="margin:0;padding-left:18px;font-size:13px;color:#475569;" data-module-monitoring>
          <?php $__empty_1 = true; $__currentLoopData = $monitoringBreakdown; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <li style="margin-bottom:6px;"><?php echo e($item->name); ?> <span style="color:#1e40af;font-weight:600;">×<?php echo e($item->total); ?></span></li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <li style="color:#64748b;">No monitoring activity data.</li>
          <?php endif; ?>
        </ul>
      </div>

      <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;padding:20px;">
        <h3 style="margin:0 0 12px;font-size:16px;color:#0f172a;">Deficiency Snapshot</h3>
        <ul style="margin:0;padding-left:18px;font-size:13px;color:#475569;" data-module-deficiency>
          <?php $__empty_1 = true; $__currentLoopData = $deficiencyBreakdown; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <li style="margin-bottom:6px;"><?php echo e($item->name); ?> <span style="color:#b45309;font-weight:600;">×<?php echo e($item->total); ?></span></li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <li style="color:#64748b;">No deficiency data.</li>
          <?php endif; ?>
        </ul>
      </div>
  </div>

  <style>
    .isqm-table-wrap.has-horizontal { overflow-x: auto !important; }
    .inline-select {
      appearance: none;
      -webkit-appearance: none;
      -moz-appearance: none;
      background: #fff url('data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 20 20" fill="none" stroke="%2394a3b8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"%3E%3Cpolyline points="6 8 10 12 14 8"/%3E%3C/svg%3E') no-repeat right 8px center;
      border: 1px solid #cbd5e1;
      border-radius: 4px;
      padding: 4px 24px 4px 8px;
      font-size: 12px;
      color: #1f2937;
      min-width: 70px;
      background-color: #fff;
    }
    .inline-select:disabled {
      background-color: #f8fafc;
      color: #1f2937;
      opacity: 1;
    }
    .status-pill {
      display:inline-flex;
      align-items:center;
      justify-content:center;
      min-width:46px;
      padding:2px 10px;
      border-radius:999px;
      font-size:12px;
      font-weight:600;
      letter-spacing:.02em;
      text-transform:uppercase;
    }
    .status-pill.pill-yes { background:#ecfdf5; color:#047857; }
    .status-pill.pill-no { background:#fee2e2; color:#b91c1c; }
    .status-pill.pill-na { background:#e2e8f0; color:#475569; }
    @keyframes spin {
      to { transform: rotate(360deg); }
    }
    .filter-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
      gap: 12px;
    }
    .filter-field {
      display: flex;
      flex-direction: column;
    }
    .filter-label {
      display: block;
      margin-bottom: 4px;
      font-size: 12px;
      font-weight: 600;
      color: #475569;
    }
    .filter-input {
      width: 100%;
      padding: 8px;
      border: 1px solid #cbd5e1;
      border-radius: 4px;
      font-size: 13px;
      color: #1f2937;
      background-color: #fff;
    }
    .filter-input:focus {
      outline: none;
      border-color: var(--brand-blue, #3b82f6);
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    .filter-section {
      margin-bottom: 20px;
    }
    .filter-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 12px;
      margin-bottom: 12px;
    }
    .filter-title {
      margin: 0;
      color: #0f172a;
      font-size: 22px;
    }
    .filter-form {
      display: grid;
      gap: 16px;
      padding: 16px;
      background: #f8fafc;
      border-radius: 10px;
      border: 1px solid #e2e8f0;
    }
    .filter-search-row {
      display: grid;
      grid-template-columns: 2fr 1fr auto;
      gap: 8px;
      align-items: end;
    }
    .filter-actions {
      display: flex;
      gap: 8px;
    }
    .filter-form-actions {
      display: flex;
      gap: 8px;
      justify-content: flex-end;
    }
    .btn-secondary {
      background: #64748b;
    }
    .btn-secondary:hover {
      background: #475569;
    }
  </style>

    <?php
      $boolLabel = static fn ($value) => $value === null ? '—' : ($value ? 'Yes' : 'No');
    ?>

    <div style="display:flex;justify-content:flex-end;gap:8px;margin-bottom:8px;">
      <button type="button" class="btn" style="background:#e2e8f0;color:#1f2937;" data-scroll="left" aria-label="Scroll table left">⬅ Scroll Left</button>
      <button type="button" class="btn" style="background:#e2e8f0;color:#1f2937;" data-scroll="right" aria-label="Scroll table right">Scroll Right ➡</button>
    </div>
    <div class="isqm-table-wrap" style="max-height:calc(100vh - 320px);overflow-y:auto;overflow-x:auto;background:#fff;border:1px solid #e2e8f0;border-radius:8px;" role="region" aria-label="ISQM entries table" tabindex="0">
      <table style="width:100%;border-collapse:collapse;font-size:13px;min-width:2200px;" role="table" aria-label="ISQM entries with filters">
        <thead>
          <tr>
            <th scope="col" style="text-align:left;background:#f1f5f9;position:sticky;top:0;padding:10px 8px;border-bottom:1px solid #e2e8f0;z-index:3;">Ref</th>
            <th scope="col" style="text-align:left;background:#d9ead3;position:sticky;top:0;padding:10px 8px;border-bottom:1px solid #cbd5e1;min-width:240px;z-index:3;">Quality Objective</th>
            <th scope="col" style="text-align:left;background:#fce8d5;position:sticky;top:0;padding:10px 8px;border-bottom:1px solid #cbd5e1;min-width:220px;z-index:3;">Quality Risk</th>
            <th scope="colgroup" colspan="6" style="text-align:center;background:#fef3c7;position:sticky;top:0;padding:10px 8px;border-bottom:1px solid #cbd5e1;z-index:3;">Risk Assessment &amp; Responses</th>
            <th scope="col" style="text-align:left;background:#d1fae5;position:sticky;top:0;padding:10px 8px;border-bottom:1px solid #cbd5e1;min-width:200px;z-index:3;">TOC (Test of Control)</th>
            <th scope="colgroup" colspan="7" style="text-align:center;background:#e2e8f0;position:sticky;top:0;padding:10px 8px;border-bottom:1px solid #cbd5e1;z-index:3;">Monitoring &amp; Remedial Actions</th>
            <th scope="colgroup" colspan="9" style="text-align:center;background:#c7d2fe;position:sticky;top:0;padding:10px 8px;border-bottom:1px solid #cbd5e1;z-index:3;">Context &amp; Tracking</th>
          </tr>
          <tr>
            <th scope="col" style="text-align:left;background:#f1f5f9;position:sticky;top:42px;padding:8px;border-bottom:1px solid #cbd5e1;z-index:2;"></th>
            <th scope="col" style="text-align:left;background:#d9ead3;position:sticky;top:42px;padding:8px;border-bottom:1px solid #cbd5e1;z-index:2;"></th>
            <th scope="col" style="text-align:left;background:#fce8d5;position:sticky;top:42px;padding:8px;border-bottom:1px solid #cbd5e1;z-index:2;"></th>
            <th scope="col" style="text-align:left;background:#fef3c7;position:sticky;top:42px;padding:8px;border-bottom:1px solid #cbd5e1;min-width:220px;z-index:2;">Assessment of Risk</th>
            <th scope="col" style="text-align:left;background:#fef3c7;position:sticky;top:42px;padding:8px;border-bottom:1px solid #cbd5e1;min-width:110px;z-index:2;">Likelihood</th>
            <th scope="col" style="text-align:left;background:#fef3c7;position:sticky;top:42px;padding:8px;border-bottom:1px solid #cbd5e1;min-width:130px;z-index:2;">Adverse Effect?</th>
            <th scope="col" style="text-align:left;background:#fef3c7;position:sticky;top:42px;padding:8px;border-bottom:1px solid #cbd5e1;min-width:140px;z-index:2;">Risk Applicable?</th>
            <th scope="col" style="text-align:left;background:#fef3c7;position:sticky;top:42px;padding:8px;border-bottom:1px solid #cbd5e1;min-width:240px;z-index:2;">Response to Quality Risk</th>
            <th scope="col" style="text-align:left;background:#fef3c7;position:sticky;top:42px;padding:8px;border-bottom:1px solid #cbd5e1;min-width:220px;z-index:2;">Firm Implementation</th>
            <th scope="col" style="text-align:left;background:#e2e8f0;position:sticky;top:42px;padding:8px;border-bottom:1px solid #cbd5e1;min-width:200px;z-index:2;">Monitoring Activity</th>
            <th scope="col" style="text-align:left;background:#e2e8f0;position:sticky;top:42px;padding:8px;border-bottom:1px solid #cbd5e1;min-width:200px;z-index:2;">Findings</th>
            <th scope="col" style="text-align:left;background:#e2e8f0;position:sticky;top:42px;padding:8px;border-bottom:1px solid #cbd5e1;min-width:180px;z-index:2;">Type of Deficiency</th>
            <th scope="col" style="text-align:left;background:#e2e8f0;position:sticky;top:42px;padding:8px;border-bottom:1px solid #cbd5e1;min-width:200px;z-index:2;">Root Cause</th>
            <th scope="col" style="text-align:left;background:#e2e8f0;position:sticky;top:42px;padding:8px;border-bottom:1px solid #cbd5e1;min-width:110px;z-index:2;">Severe?</th>
            <th scope="col" style="text-align:left;background:#e2e8f0;position:sticky;top:42px;padding:8px;border-bottom:1px solid #cbd5e1;min-width:120px;z-index:2;">Pervasive?</th>
            <th scope="col" style="text-align:left;background:#e2e8f0;position:sticky;top:42px;padding:8px;border-bottom:1px solid #cbd5e1;min-width:220px;z-index:2;">Remedial Actions</th>
            <th scope="col" style="text-align:left;background:#c7d2fe;position:sticky;top:42px;padding:8px;border-bottom:1px solid #cbd5e1;min-width:120px;z-index:2;">Objective Met?</th>
            <th scope="col" style="text-align:left;background:#c7d2fe;position:sticky;top:42px;padding:8px;border-bottom:1px solid #cbd5e1;min-width:120px;z-index:2;">Entity Level?</th>
            <th scope="col" style="text-align:left;background:#c7d2fe;position:sticky;top:42px;padding:8px;border-bottom:1px solid #cbd5e1;min-width:140px;z-index:2;">Engagement Level?</th>
            <th scope="col" style="text-align:left;background:#c7d2fe;position:sticky;top:42px;padding:8px;border-bottom:1px solid #cbd5e1;min-width:160px;z-index:2;">Implementation Status</th>
            <th scope="col" style="text-align:left;background:#c7d2fe;position:sticky;top:42px;padding:8px;border-bottom:1px solid #cbd5e1;min-width:120px;z-index:2;">Status</th>
            <th scope="col" style="text-align:left;background:#c7d2fe;position:sticky;top:42px;padding:8px;border-bottom:1px solid #cbd5e1;min-width:180px;z-index:2;">Owner</th>
            <th scope="col" style="text-align:left;background:#c7d2fe;position:sticky;top:42px;padding:8px;border-bottom:1px solid #cbd5e1;min-width:180px;z-index:2;">Client</th>
            <th scope="col" style="text-align:left;background:#c7d2fe;position:sticky;top:42px;padding:8px;border-bottom:1px solid #cbd5e1;min-width:150px;z-index:2;">Due Date</th>
            <th scope="col" style="text-align:left;background:#c7d2fe;position:sticky;top:42px;padding:8px;border-bottom:1px solid #cbd5e1;min-width:150px;z-index:2;">Review Date</th>
          </tr>           
        </thead>
        <tbody data-module-table role="rowgroup">
          
          <tr role="row">
            <td colspan="25" style="padding:40px;text-align:center;color:#64748b;" role="gridcell" aria-colspan="25">
              <div style="display:inline-flex;align-items:center;gap:8px;">
                <div style="width:16px;height:16px;border:2px solid #cbd5e1;border-top-color:#3b82f6;border-radius:50%;animation:spin 0.6s linear infinite;"></div>
                Loading entries...
              </div>
            </td>
          </tr>
          <?php $__empty_1 = true; $__currentLoopData = $entries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr style="border-bottom:1px solid #e2e8f0;display:none;" data-server-rendered>
              <td style="padding:12px 8px;vertical-align:top;color:#475569;"><?php echo e($e->import_source ?? ('#' . $e->id)); ?></td>
              <td style="padding:12px 8px;vertical-align:top;white-space:pre-wrap;line-height:1.5;">
                <div style="font-weight:600;color:var(--brand-blue);margin-bottom:4px;"><?php echo e($e->quality_objective); ?></div>
                <div style="display:flex;gap:8px;margin-top:12px;">
                  <a href="<?php echo e(route('isqm.show', ['isqm' => $e, 'return_to' => request()->fullUrl()])); ?>" class="btn" style="padding:6px 10px;font-size:12px;background:#64748b;">View</a>
                  <a href="<?php echo e(route('isqm.edit', ['isqm' => $e, 'return_to' => request()->fullUrl()])); ?>" class="btn" style="padding:6px 10px;font-size:12px;">Edit</a>
                </div>
              </td>
              <td style="padding:12px 8px;vertical-align:top;white-space:pre-wrap;line-height:1.5;"><?php echo e($e->quality_risk ?? '—'); ?></td>
              <td style="padding:12px 8px;vertical-align:top;white-space:pre-wrap;line-height:1.5;"><?php echo e($e->assessment_of_risk ?? '—'); ?></td>
              <td style="padding:12px 8px;vertical-align:top;">
                <span class="status-pill <?php echo e($e->likelihood === true ? 'pill-yes' : ($e->likelihood === false ? 'pill-no' : 'pill-na')); ?>">
                  <?php echo e($e->likelihood === true ? 'Yes' : ($e->likelihood === false ? 'No' : '—')); ?>

                </span>
              </td>
              <td style="padding:12px 8px;vertical-align:top;">
                <span class="status-pill <?php echo e($e->adverse_effect === true ? 'pill-yes' : ($e->adverse_effect === false ? 'pill-no' : 'pill-na')); ?>">
                  <?php echo e($e->adverse_effect === true ? 'Yes' : ($e->adverse_effect === false ? 'No' : '—')); ?>

                </span>
              </td>
              <td style="padding:12px 8px;vertical-align:top;">
                <?php
                  $riskApplicableLabel = $e->risk_applicable === true ? 'Yes' : ($e->risk_applicable === false ? 'No' : '—');
                  $riskApplicableClass = $e->risk_applicable === true ? 'pill-yes' : ($e->risk_applicable === false ? 'pill-no' : 'pill-na');
                  $riskApplicableDetails = $e->risk_applicable_details;
                ?>
                <div>
                  <span class="status-pill <?php echo e($riskApplicableClass); ?>"><?php echo e($riskApplicableLabel); ?></span>
                  <?php if(!empty($riskApplicableDetails)): ?>
                    <div style="margin-top:8px;font-size:12px;color:#475569;white-space:pre-wrap;line-height:1.5;"><?php echo e($riskApplicableDetails); ?></div>
                  <?php endif; ?>
                </div>
              </td>
              <td style="padding:12px 8px;vertical-align:top;white-space:pre-wrap;line-height:1.5;"><?php echo e($e->response ?? '—'); ?></td>
              <td style="padding:12px 8px;vertical-align:top;white-space:pre-wrap;line-height:1.5;"><?php echo e($e->firm_implementation ?? '—'); ?></td>
              <td style="padding:12px 8px;vertical-align:top;white-space:pre-wrap;line-height:1.5;"><?php echo e($e->toc ?? '—'); ?></td>
              <td style="padding:12px 8px;vertical-align:top;"><?php echo e($e->monitoringActivity?->name ?? '—'); ?></td>
              <td style="padding:12px 8px;vertical-align:top;white-space:pre-wrap;line-height:1.5;"><?php echo e($e->findings ?? '—'); ?></td>
              <td style="padding:12px 8px;vertical-align:top;"><?php echo e($e->deficiencyType?->name ?? '—'); ?></td>
              <td style="padding:12px 8px;vertical-align:top;white-space:pre-wrap;line-height:1.5;"><?php echo e($e->root_cause ?? '—'); ?></td>
              <td style="padding:12px 8px;vertical-align:top;">
                <span class="status-pill <?php echo e($e->severe === true ? 'pill-yes' : ($e->severe === false ? 'pill-no' : 'pill-na')); ?>">
                  <?php echo e($e->severe === true ? 'Yes' : ($e->severe === false ? 'No' : '—')); ?>

                </span>
              </td>
              <td style="padding:12px 8px;vertical-align:top;">
                <span class="status-pill <?php echo e($e->pervasive === true ? 'pill-yes' : ($e->pervasive === false ? 'pill-no' : 'pill-na')); ?>">
                  <?php echo e($e->pervasive === true ? 'Yes' : ($e->pervasive === false ? 'No' : '—')); ?>

                </span>
              </td>
              <td style="padding:12px 8px;vertical-align:top;white-space:pre-wrap;line-height:1.5;"><?php echo e($e->remedial_actions ?? '—'); ?></td>
              <td style="padding:12px 8px;vertical-align:top;">
                <span class="status-pill <?php echo e($e->objective_met === true ? 'pill-yes' : ($e->objective_met === false ? 'pill-no' : 'pill-na')); ?>">
                  <?php echo e($e->objective_met === true ? 'Yes' : ($e->objective_met === false ? 'No' : '—')); ?>

                </span>
              </td>
              <td style="padding:12px 8px;vertical-align:top;">
                <span class="status-pill <?php echo e($e->entity_level === true ? 'pill-yes' : ($e->entity_level === false ? 'pill-no' : 'pill-na')); ?>">
                  <?php echo e($e->entity_level === true ? 'Yes' : ($e->entity_level === false ? 'No' : '—')); ?>

                </span>
              </td>
              <td style="padding:12px 8px;vertical-align:top;">
                <span class="status-pill <?php echo e($e->engagement_level === true ? 'pill-yes' : ($e->engagement_level === false ? 'pill-no' : 'pill-na')); ?>">
                  <?php echo e($e->engagement_level === true ? 'Yes' : ($e->engagement_level === false ? 'No' : '—')); ?>

                </span>
              </td>
              <td style="padding:12px 8px;vertical-align:top;">
                <?php echo e($e->implementation_status ? str_replace('_', ' ', ucfirst($e->implementation_status)) : '—'); ?>

              </td>
              <td style="padding:12px 8px;vertical-align:top;">
                <?php
                  $statusStyle = match ($e->status) {
                    'open' => 'background:#fef3c7;color:#92400e;',
                    'monitoring' => 'background:#dbeafe;color:#1e40af;',
                    default => 'background:#d1fae5;color:#065f46;',
                  };
                ?>
                <span style="font-size:12px;padding:4px 8px;border-radius:12px;display:inline-block;font-weight:500;<?php echo e($statusStyle); ?>">
                  <?php echo e(ucfirst($e->status)); ?>

                </span>
              </td>
              <td style="padding:12px 8px;vertical-align:top;"><?php echo e($e->owner?->name ?? '—'); ?></td>
              <td style="padding:12px 8px;vertical-align:top;"><?php echo e($e->client?->name ?? '—'); ?></td>
              <?php
                $dueDateLabel = $e->due_date ? $e->due_date->format('M d, Y') : null;
                if ($e->due_date && $e->due_date->isPast() && $e->status !== 'closed') {
                    $dueDateLabel = '<span style="color:#ef4444;font-weight:600;">Overdue: ' . $e->due_date->format('M d, Y') . '</span>';
                } elseif ($e->due_date) {
                    $dueDateLabel = e($dueDateLabel);
                }

                $reviewDateLabel = $e->review_date ? $e->review_date->format('M d, Y') : null;
              ?>
              <td style="padding:12px 8px;vertical-align:top;">
                <?php echo $dueDateLabel ?? '<span style="color:#94a3b8;">—</span>'; ?>

              </td>
              <td style="padding:12px 8px;vertical-align:top;">
                <?php echo $reviewDateLabel ? e($reviewDateLabel) : '<span style="color:#94a3b8;">—</span>'; ?>

              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr role="row">
              <td colspan="25" style="padding:40px;text-align:center;color:#64748b;" role="gridcell" aria-colspan="25">
                No entries found in <?php echo e($title); ?>. <a href="<?php echo e(route('isqm.create', ['area' => str_replace('-', '_', $module->slug)])); ?>" style="color:var(--brand-blue);" aria-label="Create your first entry in <?php echo e($title); ?>">Create your first entry</a>
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <div data-module-pagination-info style="margin-top:16px;padding:12px;background:#f8fafc;border-radius:6px;font-size:13px;color:#64748b;">
      
    </div>
    <div data-module-pagination style="margin-top:16px;display:flex;gap:8px;"></div>

    <script>
    (function() {
      const wrapper = document.querySelector('.isqm-table-wrap');
      if (!wrapper) return;
      const table = wrapper.querySelector('table');
      if (!table) return;

      const scrollButtons = document.querySelectorAll('button[data-scroll]');
      const toggleButtons = () => {
        const needsScroll = table.scrollWidth > wrapper.clientWidth + 1;
        scrollButtons.forEach(btn => {
          btn.style.display = needsScroll ? 'inline-flex' : 'none';
        });
      };

      scrollButtons.forEach(btn => {
        btn.addEventListener('click', () => {
          const direction = btn.dataset.scroll === 'left' ? -1 : 1;
          const amount = wrapper.clientWidth * 0.8;
          wrapper.scrollBy({ left: direction * amount, behavior: 'smooth' });
        });
      });

      const updateHorizontalState = () => {
        const needsHorizontal = table.scrollWidth > wrapper.clientWidth + 1;
        wrapper.classList.toggle('has-horizontal', needsHorizontal);
        toggleButtons();
      };

      updateHorizontalState();
      window.addEventListener('resize', updateHorizontalState);

      if (typeof ResizeObserver !== 'undefined') {
        const observer = new ResizeObserver(updateHorizontalState);
        observer.observe(table);
      }
    })();
  </script>

  
  <script src="<?php echo e(asset('js/module.js')); ?>"></script>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $attributes = $__attributesOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__attributesOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $component = $__componentOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__componentOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>

<?php /**PATH C:\xampp\htdocs\DP\isqmapp\resources\views/areas/show.blade.php ENDPATH**/ ?>