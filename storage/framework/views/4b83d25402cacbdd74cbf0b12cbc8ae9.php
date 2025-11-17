<?php ($title = 'Compliance Now'); ?>
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
  <style>
    .compliance-page { max-width: 1400px; margin: 0 auto; padding: 16px; }
    .compliance-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
    .compliance-header h1 { margin: 0; font-size: 28px; color: #0f172a; }
    .module-card { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px; margin-bottom: 28px; box-shadow: 0 4px 14px rgba(15, 23, 42, 0.05); }
    .module-header { display: flex; flex-direction: column; gap: 8px; margin-bottom: 20px; }
    .module-title { font-size: 22px; font-weight: 700; color: var(--brand-blue, #2563eb); }
    .module-objective { font-size: 14px; color: #475569; line-height: 1.6; background: #f8fafc; padding: 12px 16px; border-radius: 10px; border-left: 3px solid var(--brand-blue, #2563eb); }
    .risk-grid { display: grid; gap: 18px; }
    .risk-card { border: 1px solid #cbd5f5; border-radius: 10px; padding: 18px; background: #f8fbff; }
    .risk-title-row { display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; margin-bottom: 10px; }
    .risk-title { font-size: 16px; font-weight: 600; color: #1e293b; margin: 0; }
    .chip-set { display: flex; gap: 8px; flex-wrap: wrap; }
    .chip { font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: .04em; padding: 4px 10px; border-radius: 999px; }
    .chip--critical { background: #fee2e2; color: #b91c1c; }
    .chip--pervasive { background: #ede9fe; color: #5b21b6; }
    .chip--monitor { background: #dcfce7; color: #15803d; }
    .risk-sections { display: grid; gap: 14px; }
    .risk-section { display: grid; gap: 6px; }
    .risk-section strong { color: #0f172a; font-size: 13px; letter-spacing: .02em; }
    .risk-section p { margin: 0; color: #334155; font-size: 14px; line-height: 1.6; white-space: pre-wrap; }
    .empty-state { text-align: center; padding: 80px 20px; border: 2px dashed #cbd5f5; border-radius: 12px; background: #f8fafc; color: #475569; }
  </style>

  <div class="compliance-page">
    <div class="compliance-header">
      <h1>Immediate Compliance Actions</h1>
      <div style="display:flex;gap:8px;">
        <a href="<?php echo e(route('reports.export.compliance')); ?>" class="btn" style="background:#0f766e;">Download CSV</a>
        <a href="<?php echo e(route('isqm.index')); ?>" class="btn" style="background:#1e3a8a;">Back to Register</a>
      </div>
    </div>

    <?php if($groupedEntries->isEmpty()): ?>
      <div class="empty-state">
        <h2 style="margin:0 0 12px;">All clear for now</h2>
        <p>No outstanding ISQM responses or monitoring activities requiring action were found.</p>
      </div>
    <?php else: ?>
      <?php $__currentLoopData = $groupedEntries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module => $entryGroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <section class="module-card">
          <div class="module-header">
            <span class="module-title"><?php echo e($module); ?></span>
            <?php if(optional($entryGroup->first())->quality_objective): ?>
              <div class="module-objective">
                <strong>Quality Objective:</strong>
                <div><?php echo e(optional($entryGroup->first())->quality_objective); ?></div>
              </div>
            <?php endif; ?>
          </div>

          <div class="risk-grid">
            <?php $__currentLoopData = $entryGroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <article class="risk-card">
                <div class="risk-title-row">
                  <h3 class="risk-title"><?php echo e($entry->quality_risk ?? $entry->title); ?></h3>
                  <div class="chip-set">
                    <?php if($entry->severe): ?>
                      <span class="chip chip--critical">Severe</span>
                    <?php endif; ?>
                    <?php if($entry->pervasive): ?>
                      <span class="chip chip--pervasive">Pervasive</span>
                    <?php endif; ?>
                    <?php if(optional($entry->monitoringActivity)->name): ?>
                      <span class="chip chip--monitor"><?php echo e($entry->monitoringActivity->name); ?></span>
                    <?php endif; ?>
                  </div>
                </div>

                <div class="risk-sections">
                  <?php if($entry->assessment_of_risk): ?>
                    <div class="risk-section">
                      <strong>Why this matters</strong>
                      <p><?php echo e($entry->assessment_of_risk); ?></p>
                    </div>
                  <?php endif; ?>

                  <?php if($entry->response): ?>
                    <div class="risk-section">
                      <strong>Required Response</strong>
                      <p><?php echo e($entry->response); ?></p>
                    </div>
                  <?php endif; ?>

                  <?php if($entry->firm_implementation): ?>
                    <div class="risk-section">
                      <strong>Firm Implementation</strong>
                      <p><?php echo e($entry->firm_implementation); ?></p>
                    </div>
                  <?php endif; ?>

                  <?php if($entry->toc): ?>
                    <div class="risk-section">
                      <strong>Test of Controls</strong>
                      <p><?php echo e($entry->toc); ?></p>
                    </div>
                  <?php endif; ?>

                  <?php if($entry->remedial_actions): ?>
                    <div class="risk-section">
                      <strong>Remedial Actions</strong>
                      <p><?php echo e($entry->remedial_actions); ?></p>
                    </div>
                  <?php endif; ?>

                  <?php if($entry->deficiencyType || $entry->findings || $entry->root_cause): ?>
                    <div class="risk-section">
                      <strong>Monitoring Notes</strong>
                      <p>
                        <?php if($entry->deficiencyType): ?>
                          <span style="display:block;"><em>Deficiency:</em> <?php echo e($entry->deficiencyType->name); ?></span>
                        <?php endif; ?>
                        <?php if($entry->findings): ?>
                          <span style="display:block;"><em>Finding:</em> <?php echo e($entry->findings); ?></span>
                        <?php endif; ?>
                        <?php if($entry->root_cause): ?>
                          <span style="display:block;"><em>Root Cause:</em> <?php echo e($entry->root_cause); ?></span>
                        <?php endif; ?>
                      </p>
                    </div>
                  <?php endif; ?>
                </div>
              </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
        </section>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
  </div>
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

<?php /**PATH C:\xampp\htdocs\DP\isqmapp\resources\views/isqm/compliance.blade.php ENDPATH**/ ?>