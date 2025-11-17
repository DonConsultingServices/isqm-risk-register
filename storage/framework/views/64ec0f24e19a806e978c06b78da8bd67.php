<?php ($title = 'Risks'); ?>
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
  <div class="topbar">
    <h2>Quality Risks</h2>
  </div>

  <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));gap:16px;margin-bottom:24px;">
    <?php $__currentLoopData = $byArea; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;padding:16px;">
        <div style="font-weight:600;margin-bottom:8px;"><?php echo e($area->module_title); ?></div>
        <div style="font-size:24px;font-weight:700;color:var(--brand-blue);"><?php echo e($area->total); ?></div>
        <div style="font-size:12px;color:#64748b;margin-top:8px;">
          <?php if($area->severe_count > 0): ?>
            <span style="color:#991b1b;"><?php echo e($area->severe_count); ?> severe</span>
          <?php endif; ?>
          <?php if($area->pervasive_count > 0): ?>
            <span style="color:#92400e;margin-left:8px;"><?php echo e($area->pervasive_count); ?> pervasive</span>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>

  <form method="get" action="<?php echo e(route('risks.index')); ?>" style="display:grid;grid-template-columns:1fr 1fr 1fr auto;gap:8px;align-items:end;margin-bottom:16px;padding:12px;background:#f8fafc;border-radius:8px;">
    <div>
      <label style="display:block;margin-bottom:4px;font-size:12px;font-weight:600;color:#475569;">Area</label>
      <select name="area" style="width:100%;padding:8px;border:1px solid #d1d5db;border-radius:6px;">
        <option value="">All Areas</option>
        <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($module->slug); ?>" <?php if(request('area') === $module->slug): echo 'selected'; endif; ?>><?php echo e($module->name); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </select>
    </div>
    <div>
      <label style="display:block;margin-bottom:4px;font-size:12px;font-weight:600;color:#475569;">Filter</label>
      <select name="filter" style="width:100%;padding:8px;border:1px solid #d1d5db;border-radius:6px;">
        <option value="">All Risks</option>
        <option value="severe" <?php if(request('filter') === 'severe'): echo 'selected'; endif; ?>>Severe</option>
        <option value="pervasive" <?php if(request('filter') === 'pervasive'): echo 'selected'; endif; ?>>Pervasive</option>
        <option value="adverse" <?php if(request('filter') === 'adverse'): echo 'selected'; endif; ?>>Adverse Effect</option>
      </select>
    </div>
    <div></div>
    <div style="display:flex;gap:8px;">
      <button class="btn">Filter</button>
      <a href="<?php echo e(route('risks.index')); ?>" class="btn" style="background:#64748b;">Clear</a>
    </div>
  </form>

  <div style="overflow:auto;background:#fff;border:1px solid #e2e8f0;border-radius:8px;">
    <table style="width:100%;border-collapse:collapse;font-size:14px;">
      <thead>
        <tr>
          <th style="text-align:left;background:#f8fafc;position:sticky;top:0;padding:10px 8px;border-bottom:1px solid #e2e8f0;">Area</th>
          <th style="text-align:left;background:#f8fafc;position:sticky;top:0;padding:10px 8px;border-bottom:1px solid #e2e8f0;">Quality Risk</th>
          <th style="text-align:left;background:#f8fafc;position:sticky;top:0;padding:10px 8px;border-bottom:1px solid #e2e8f0;">Assessment</th>
          <th style="text-align:left;background:#f8fafc;position:sticky;top:0;padding:10px 8px;border-bottom:1px solid #e2e8f0;">Severity</th>
          <th style="text-align:left;background:#f8fafc;position:sticky;top:0;padding:10px 8px;border-bottom:1px solid #e2e8f0;">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $risks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $risk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr style="transition:background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
            <td style="padding:10px 8px;border-bottom:1px solid #e2e8f0;"><?php echo e($risk->module?->name ?? '—'); ?></td>
            <td style="padding:10px 8px;border-bottom:1px solid #e2e8f0;">
              <a href="<?php echo e(route('isqm.show', $risk)); ?>" style="color:var(--brand-blue);text-decoration:none;"><?php echo e(Str::limit($risk->quality_risk, 80)); ?></a>
            </td>
            <td style="padding:10px 8px;border-bottom:1px solid #e2e8f0;"><?php echo e(Str::limit($risk->assessment_of_risk, 60)); ?></td>
            <td style="padding:10px 8px;border-bottom:1px solid #e2e8f0;">
              <div style="display:flex;gap:4px;flex-wrap:wrap;">
                <?php if($risk->severe): ?>
                  <span style="padding:2px 6px;background:#fee2e2;color:#991b1b;border-radius:6px;font-size:11px;font-weight:500;">Severe</span>
                <?php endif; ?>
                <?php if($risk->pervasive): ?>
                  <span style="padding:2px 6px;background:#fef3c7;color:#92400e;border-radius:6px;font-size:11px;font-weight:500;">Pervasive</span>
                <?php endif; ?>
                <?php if($risk->adverse_effect): ?>
                  <span style="padding:2px 6px;background:#fee2e2;color:#991b1b;border-radius:6px;font-size:11px;font-weight:500;">Adverse</span>
                <?php endif; ?>
              </div>
            </td>
            <td style="padding:10px 8px;border-bottom:1px solid #e2e8f0;">
              <a href="<?php echo e(route('isqm.show', $risk)); ?>" class="btn" style="padding:6px 10px;font-size:12px;background:#64748b;">View</a>
            </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr>
            <td colspan="5" style="padding:40px;text-align:center;color:#64748b;">
              No risks found with the selected filters.
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <?php if($risks->hasPages()): ?>
    <div style="margin-top:16px;display:flex;justify-content:center;">
      <?php echo e($risks->links()); ?>

    </div>
  <?php endif; ?>
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

<?php /**PATH C:\xampp\htdocs\DP\isqmapp\resources\views/risks/index.blade.php ENDPATH**/ ?>