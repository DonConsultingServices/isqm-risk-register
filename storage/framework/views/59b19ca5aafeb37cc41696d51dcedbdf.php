<?php ($title = 'Reports'); ?>
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
    <h2><?php echo e($title); ?></h2>
    <div style="display:flex;gap:8px;">
      <a class="btn" href="<?php echo e(route('reports.export')); ?>?<?php echo e(request()->getQueryString()); ?>" style="background:#64748b;">Export CSV</a>
      <a class="btn" href="<?php echo e(route('reports.export.excel')); ?>?<?php echo e(request()->getQueryString()); ?>">Export Excel</a>
    </div>
  </div>
  <form method="get" style="display:grid;grid-template-columns:repeat(5,1fr);gap:8px;align-items:end;margin-bottom:12px;">
    <div>
      <label>Area</label>
      <select name="area" style="width:100%;padding:8px;border:1px solid #d1d5db;border-radius:6px;">
        <option value="">All</option>
        <?php $__currentLoopData = ['governance_and_leadership','ethical_requirements','acceptance_and_continuance','engagement_performance','resources','information_and_communication']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($a); ?>" <?php if(request('area') === $a): echo 'selected'; endif; ?>><?php echo e(str_replace('_',' ',$a)); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </select>
    </div>
    <div>
      <label>Status</label>
      <select name="status" style="width:100%;padding:8px;border:1px solid #d1d5db;border-radius:6px;">
        <option value="">All</option>
        <?php $__currentLoopData = ['open','monitoring','closed']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($s); ?>" <?php if(request('status') === $s): echo 'selected'; endif; ?>><?php echo e(ucfirst($s)); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </select>
    </div>
    <div>
      <label>Due from</label>
      <input type="date" name="due_from" value="<?php echo e(request('due_from')); ?>" style="width:100%;padding:8px;border:1px solid #d1d5db;border-radius:6px;">
    </div>
    <div>
      <label>Due to</label>
      <input type="date" name="due_to" value="<?php echo e(request('due_to')); ?>" style="width:100%;padding:8px;border:1px solid #d1d5db;border-radius:6px;">
    </div>
    <div>
      <button class="btn">Filter</button>
    </div>
  </form>
  <div style="display:flex;gap:12px;margin-bottom:20px;flex-wrap:wrap;">
    <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;padding:12px 16px;min-width:120px;">
      <div style="font-size:12px;color:#64748b;margin-bottom:4px;">Total</div>
      <div style="font-size:24px;font-weight:700;color:var(--brand-blue);"><?php echo e($summary['total']); ?></div>
    </div>
    <div style="background:#fef3c7;border:1px solid #fde047;border-radius:8px;padding:12px 16px;min-width:120px;">
      <div style="font-size:12px;color:#92400e;margin-bottom:4px;">Open</div>
      <div style="font-size:24px;font-weight:700;color:#92400e;"><?php echo e($summary['open']); ?></div>
    </div>
    <div style="background:#dbeafe;border:1px solid #93c5fd;border-radius:8px;padding:12px 16px;min-width:120px;">
      <div style="font-size:12px;color:#1e40af;margin-bottom:4px;">Monitoring</div>
      <div style="font-size:24px;font-weight:700;color:#1e40af;"><?php echo e($summary['monitoring']); ?></div>
    </div>
    <div style="background:#d1fae5;border:1px solid #86efac;border-radius:8px;padding:12px 16px;min-width:120px;">
      <div style="font-size:12px;color:#065f46;margin-bottom:4px;">Closed</div>
      <div style="font-size:24px;font-weight:700;color:#065f46;"><?php echo e($summary['closed']); ?></div>
    </div>
    <?php if($summary['total'] > 0): ?>
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:12px 16px;flex:1;min-width:200px;">
      <div style="font-size:12px;color:#64748b;margin-bottom:8px;">Status Distribution</div>
      <div style="display:flex;gap:4px;height:24px;border-radius:4px;overflow:hidden;">
        <div style="background:#fef3c7;flex:<?php echo e($summary['open'] / $summary['total'] * 100); ?>%;" title="Open: <?php echo e($summary['open']); ?>"></div>
        <div style="background:#dbeafe;flex:<?php echo e($summary['monitoring'] / $summary['total'] * 100); ?>%;" title="Monitoring: <?php echo e($summary['monitoring']); ?>"></div>
        <div style="background:#d1fae5;flex:<?php echo e($summary['closed'] / $summary['total'] * 100); ?>%;" title="Closed: <?php echo e($summary['closed']); ?>"></div>
      </div>
    </div>
    <?php endif; ?>
  </div>
  <div style="overflow:auto;background:#fff;border:1px solid #e2e8f0;border-radius:8px;">
    <table style="width:100%;border-collapse:collapse;font-size:14px;">
      <thead>
        <tr>
          <th style="text-align:left;background:#f8fafc;padding:12px;border-bottom:1px solid #e2e8f0;">ID</th>
          <th style="text-align:left;background:#f8fafc;padding:12px;border-bottom:1px solid #e2e8f0;">Area</th>
          <th style="text-align:left;background:#f8fafc;padding:12px;border-bottom:1px solid #e2e8f0;">Status</th>
          <th style="text-align:left;background:#f8fafc;padding:12px;border-bottom:1px solid #e2e8f0;">Due</th>
          <th style="text-align:left;background:#f8fafc;padding:12px;border-bottom:1px solid #e2e8f0;">Quality Objective</th>
          <th style="text-align:left;background:#f8fafc;padding:12px;border-bottom:1px solid #e2e8f0;">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $entries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr style="transition:background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
            <td style="padding:12px;border-bottom:1px solid #e2e8f0;color:#64748b;">#<?php echo e($e->id); ?></td>
            <td style="padding:12px;border-bottom:1px solid #e2e8f0;"><?php echo e(str_replace('_',' ',$e->area)); ?></td>
            <td style="padding:12px;border-bottom:1px solid #e2e8f0;">
              <span style="padding:4px 8px;border-radius:6px;font-size:12px;font-weight:500;
                <?php if($e->status === 'open'): ?> background:#fef3c7;color:#92400e;
                <?php elseif($e->status === 'monitoring'): ?> background:#dbeafe;color:#1e40af;
                <?php else: ?> background:#d1fae5;color:#065f46;
                <?php endif; ?>">
                <?php echo e(ucfirst($e->status)); ?>

              </span>
            </td>
            <td style="padding:12px;border-bottom:1px solid #e2e8f0;">
              <?php if($e->due_date): ?>
                <?php if($e->due_date->isPast() && $e->status !== 'closed'): ?>
                  <span style="color:#ef4444;font-weight:600;">Overdue</span>
                <?php else: ?>
                  <?php echo e($e->due_date->format('M d, Y')); ?>

                <?php endif; ?>
              <?php else: ?>
                <span style="color:#94a3b8;">—</span>
              <?php endif; ?>
            </td>
            <td style="padding:12px;border-bottom:1px solid #e2e8f0;">
              <a href="<?php echo e(route('isqm.show', $e)); ?>" style="color:var(--brand-blue);text-decoration:none;"><?php echo e(Str::limit($e->quality_objective, 100)); ?></a>
            </td>
            <td style="padding:12px;border-bottom:1px solid #e2e8f0;">
              <a href="<?php echo e(route('isqm.show', $e)); ?>" class="btn" style="padding:6px 10px;font-size:12px;background:#64748b;">View</a>
            </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr>
            <td colspan="6" style="padding:40px;text-align:center;color:#64748b;">
              No entries found with the selected filters.
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
  <div style="margin-top:12px;"><?php echo e($entries->links()); ?></div>
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

<?php /**PATH C:\xampp\htdocs\DP\isqmapp\resources\views/reports/index.blade.php ENDPATH**/ ?>