<?php ($title = 'Notifications'); ?>
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
      <?php if(auth()->user()->unreadNotifications()->count() > 0): ?>
        <form method="post" action="<?php echo e(route('notifications.mark-all-read')); ?>" style="display:inline;">
          <?php echo csrf_field(); ?>
          <button type="submit" class="btn" style="background:#64748b;padding:8px 16px;font-size:13px;">Mark All Read</button>
        </form>
      <?php endif; ?>
    </div>
  </div>

  <div style="display:flex;gap:12px;margin-bottom:20px;">
    <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;padding:12px 16px;">
      <div style="font-size:12px;color:#64748b;margin-bottom:4px;">Total</div>
      <div style="font-size:24px;font-weight:700;color:var(--brand-blue);"><?php echo e(auth()->user()->notifications()->count()); ?></div>
    </div>
    <div style="background:#fee2e2;border:1px solid #fecaca;border-radius:8px;padding:12px 16px;">
      <div style="font-size:12px;color:#991b1b;margin-bottom:4px;">Unread</div>
      <div style="font-size:24px;font-weight:700;color:#991b1b;"><?php echo e(auth()->user()->unreadNotifications()->count()); ?></div>
    </div>
    <div style="background:#d1fae5;border:1px solid #86efac;border-radius:8px;padding:12px 16px;">
      <div style="font-size:12px;color:#065f46;margin-bottom:4px;">Read</div>
      <div style="font-size:24px;font-weight:700;color:#065f46;"><?php echo e(auth()->user()->readNotifications()->count()); ?></div>
    </div>
  </div>

  <?php if($notifications->count() > 0): ?>
    <div style="overflow:auto;background:#fff;border:1px solid #e2e8f0;border-radius:8px;">
      <div style="padding:0;">
        <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div style="padding:16px;border-bottom:1px solid #e2e8f0;display:flex;justify-content:space-between;align-items:start;transition:background 0.2s;<?php echo e($n->read_at ? '' : 'background:#fef3c7;'); ?>" onmouseover="this.style.background='<?php echo e($n->read_at ? '#f8fafc' : '#fef3c7'); ?>'" onmouseout="this.style.background='<?php echo e($n->read_at ? '' : '#fef3c7'); ?>'">
            <div style="flex:1;">
              <?php if(!$n->read_at): ?>
                <span style="display:inline-block;width:8px;height:8px;background:#ef4444;border-radius:50%;margin-right:8px;"></span>
              <?php endif; ?>
              <div style="font-weight:600;margin-bottom:4px;color:#1e293b;">
                <?php echo e(data_get($n->data, 'title', data_get($n->data, 'quality_objective', 'Notification'))); ?>

              </div>
              <div style="font-size:13px;color:#64748b;margin-bottom:8px;line-height:1.5;">
                <?php if(data_get($n->data, 'entry_id')): ?>
                  <a href="<?php echo e(route('isqm.show', data_get($n->data, 'entry_id'))); ?>" style="color:var(--brand-blue);text-decoration:none;">
                    Entry #<?php echo e(data_get($n->data, 'entry_id')); ?>

                  </a>
                  <?php if(data_get($n->data, 'area')): ?>
                    • <?php echo e(str_replace('_', ' ', data_get($n->data, 'area'))); ?>

                  <?php endif; ?>
                <?php endif; ?>
              </div>
              <div style="font-size:12px;color:#94a3b8;">
                <?php echo e($n->created_at->diffForHumans()); ?> • <?php echo e($n->created_at->format('M d, Y H:i')); ?>

              </div>
            </div>
            <div style="margin-left:16px;">
              <?php if(is_null($n->read_at)): ?>
                <form method="post" action="<?php echo e(route('notifications.read', $n->id)); ?>">
                  <?php echo csrf_field(); ?>
                  <button type="submit" class="btn" style="padding:6px 12px;font-size:12px;">Mark Read</button>
                </form>
              <?php else: ?>
                <span style="font-size:12px;color:#16a34a;padding:4px 8px;background:#d1fae5;border-radius:6px;">Read</span>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    </div>
    <div style="margin-top:16px;display:flex;justify-content:center;">
      <?php echo e($notifications->links()); ?>

    </div>
  <?php else: ?>
    <div style="text-align:center;padding:60px 20px;background:#fff;border:1px solid #e2e8f0;border-radius:8px;">
      <div style="font-size:48px;margin-bottom:16px;">📭</div>
      <h3 style="margin:0 0 8px;color:#1e293b;">No notifications</h3>
      <p style="color:#64748b;margin:0;">You're all caught up!</p>
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
<?php /**PATH C:\xampp\htdocs\DP\isqmapp\resources\views/notifications/index.blade.php ENDPATH**/ ?>