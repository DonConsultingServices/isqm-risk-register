<?php ($title = 'Activity Logs'); ?>
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
    <h2>Activity Logs</h2>
  </div>

  <div style="display:flex;gap:12px;margin-bottom:20px;flex-wrap:wrap;">
    <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;padding:12px 16px;">
      <div style="font-size:12px;color:#64748b;margin-bottom:4px;">Total Actions</div>
      <div style="font-size:24px;font-weight:700;color:var(--brand-blue);"><?php echo e($summary['total']); ?></div>
    </div>
    <div style="background:#d1fae5;border:1px solid #86efac;border-radius:8px;padding:12px 16px;">
      <div style="font-size:12px;color:#065f46;margin-bottom:4px;">Created</div>
      <div style="font-size:24px;font-weight:700;color:#065f46;"><?php echo e($summary['created']); ?></div>
    </div>
    <div style="background:#dbeafe;border:1px solid #93c5fd;border-radius:8px;padding:12px 16px;">
      <div style="font-size:12px;color:#1e40af;margin-bottom:4px;">Updated</div>
      <div style="font-size:24px;font-weight:700;color:#1e40af;"><?php echo e($summary['updated']); ?></div>
    </div>
    <div style="background:#fee2e2;border:1px solid #fecaca;border-radius:8px;padding:12px 16px;">
      <div style="font-size:12px;color:#991b1b;margin-bottom:4px;">Deleted</div>
      <div style="font-size:24px;font-weight:700;color:#991b1b;"><?php echo e($summary['deleted']); ?></div>
    </div>
  </div>

  <form method="get" action="<?php echo e(route('activity-logs.index')); ?>" style="display:grid;grid-template-columns:1fr 1fr 1fr 1fr 1fr auto;gap:8px;align-items:end;margin-bottom:16px;padding:12px;background:#f8fafc;border-radius:8px;">
    <div>
      <label style="display:block;margin-bottom:4px;font-size:12px;font-weight:600;color:#475569;">Action</label>
      <select name="action" style="width:100%;padding:8px;border:1px solid #d1d5db;border-radius:6px;">
        <option value="">All Actions</option>
        <option value="created" <?php if(request('action') === 'created'): echo 'selected'; endif; ?>>Created</option>
        <option value="updated" <?php if(request('action') === 'updated'): echo 'selected'; endif; ?>>Updated</option>
        <option value="deleted" <?php if(request('action') === 'deleted'): echo 'selected'; endif; ?>>Deleted</option>
      </select>
    </div>
    <div>
      <label style="display:block;margin-bottom:4px;font-size:12px;font-weight:600;color:#475569;">Model Type</label>
      <select name="model_type" style="width:100%;padding:8px;border:1px solid #d1d5db;border-radius:6px;">
        <option value="">All Types</option>
        <option value="App\Models\IsqmEntry" <?php if(request('model_type') === 'App\Models\IsqmEntry'): echo 'selected'; endif; ?>>ISQM Entry</option>
        <option value="App\Models\Client" <?php if(request('model_type') === 'App\Models\Client'): echo 'selected'; endif; ?>>Client</option>
        <option value="App\Models\MonitoringActivity" <?php if(request('model_type') === 'App\Models\MonitoringActivity'): echo 'selected'; endif; ?>>Monitoring Activity</option>
        <option value="App\Models\DeficiencyType" <?php if(request('model_type') === 'App\Models\DeficiencyType'): echo 'selected'; endif; ?>>Deficiency Type</option>
      </select>
    </div>
    <div>
      <label style="display:block;margin-bottom:4px;font-size:12px;font-weight:600;color:#475569;">Date From</label>
      <input type="date" name="date_from" value="<?php echo e(request('date_from')); ?>" style="width:100%;padding:8px;border:1px solid #d1d5db;border-radius:6px;">
    </div>
    <div>
      <label style="display:block;margin-bottom:4px;font-size:12px;font-weight:600;color:#475569;">Date To</label>
      <input type="date" name="date_to" value="<?php echo e(request('date_to')); ?>" style="width:100%;padding:8px;border:1px solid #d1d5db;border-radius:6px;">
    </div>
    <div></div>
    <div style="display:flex;gap:8px;">
      <button class="btn">Filter</button>
      <a href="<?php echo e(route('activity-logs.index')); ?>" class="btn" style="background:#64748b;">Clear</a>
    </div>
  </form>

  <div style="overflow:auto;background:#fff;border:1px solid #e2e8f0;border-radius:8px;">
    <table style="width:100%;border-collapse:collapse;font-size:14px;">
      <thead>
        <tr>
          <th style="text-align:left;background:#f8fafc;padding:12px;border-bottom:1px solid #e2e8f0;">Date & Time</th>
          <th style="text-align:left;background:#f8fafc;padding:12px;border-bottom:1px solid #e2e8f0;">User</th>
          <th style="text-align:left;background:#f8fafc;padding:12px;border-bottom:1px solid #e2e8f0;">Action</th>
          <th style="text-align:left;background:#f8fafc;padding:12px;border-bottom:1px solid #e2e8f0;">Model</th>
          <th style="text-align:left;background:#f8fafc;padding:12px;border-bottom:1px solid #e2e8f0;">Details</th>
        </tr>
      </thead>
      <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr style="transition:background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
            <td style="padding:12px;border-bottom:1px solid #e2e8f0;">
              <div style="font-weight:500;"><?php echo e($log->created_at->format('M d, Y')); ?></div>
              <div style="font-size:12px;color:#64748b;"><?php echo e($log->created_at->format('H:i:s')); ?></div>
            </td>
            <td style="padding:12px;border-bottom:1px solid #e2e8f0;">
              <?php echo e($log->user?->name ?? 'System'); ?>

            </td>
            <td style="padding:12px;border-bottom:1px solid #e2e8f0;">
              <span style="padding:4px 8px;border-radius:6px;font-size:12px;font-weight:500;
                <?php if($log->action === 'created'): ?> background:#d1fae5;color:#065f46;
                <?php elseif($log->action === 'updated'): ?> background:#dbeafe;color:#1e40af;
                <?php else: ?> background:#fee2e2;color:#991b1b;
                <?php endif; ?>">
                <?php echo e(ucfirst($log->action)); ?>

              </span>
            </td>
            <td style="padding:12px;border-bottom:1px solid #e2e8f0;">
              <span style="color:#64748b;"><?php echo e($log->model_name); ?></span>
              <span style="color:#94a3b8;font-size:12px;">#<?php echo e($log->model_id); ?></span>
            </td>
            <td style="padding:12px;border-bottom:1px solid #e2e8f0;">
              <?php if($log->action === 'updated' && isset($log->changes['before'])): ?>
                <details style="cursor:pointer;">
                  <summary style="color:var(--brand-blue);font-size:12px;">View Changes</summary>
                  <div style="margin-top:8px;padding:8px;background:#f8fafc;border-radius:4px;font-size:12px;">
                    <div style="margin-bottom:4px;"><strong>Changed fields:</strong></div>
                    <?php $__currentLoopData = $log->changes['before']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <?php if(isset($log->changes['after'][$key]) && $log->changes['after'][$key] != $value): ?>
                        <div style="margin-bottom:2px;">
                          <strong><?php echo e($key); ?>:</strong> 
                          <span style="color:#991b1b;"><?php echo e(is_array($value) ? json_encode($value) : (string)$value); ?></span> 
                          → 
                          <span style="color:#065f46;"><?php echo e(is_array($log->changes['after'][$key]) ? json_encode($log->changes['after'][$key]) : (string)$log->changes['after'][$key]); ?></span>
                        </div>
                      <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </div>
                </details>
              <?php elseif($log->changes): ?>
                <span style="color:#64748b;font-size:12px;"><?php echo e(is_array($log->changes) ? json_encode($log->changes, JSON_PRETTY_PRINT) : $log->changes); ?></span>
              <?php else: ?>
                <span style="color:#94a3b8;">—</span>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr>
            <td colspan="5" style="padding:40px;text-align:center;color:#64748b;">
              No activity logs found.
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <?php if($logs->hasPages()): ?>
    <div style="margin-top:16px;display:flex;justify-content:center;">
      <?php echo e($logs->links()); ?>

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

<?php /**PATH C:\xampp\htdocs\DP\isqmapp\resources\views/activity-logs/index.blade.php ENDPATH**/ ?>