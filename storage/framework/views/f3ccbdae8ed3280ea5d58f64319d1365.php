<?php ($title = 'Users'); ?>
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
    <h2>Users</h2>
    <a class="btn" href="<?php echo e(route('users.create')); ?>">Add User</a>
  </div>

  <?php if(session('status')): ?>
    <div style="padding:12px;background:#d1fae5;border:1px solid #86efac;border-radius:6px;margin-bottom:16px;color:#065f46;">
      <?php echo e(session('status')); ?>

    </div>
  <?php endif; ?>

  <div style="overflow:auto;background:#fff;border:1px solid #e2e8f0;border-radius:8px;">
    <table style="width:100%;border-collapse:collapse;font-size:14px;">
      <thead>
        <tr>
          <th style="text-align:left;background:#f8fafc;padding:12px;border-bottom:1px solid #e2e8f0;">Name</th>
          <th style="text-align:left;background:#f8fafc;padding:12px;border-bottom:1px solid #e2e8f0;">Email</th>
          <th style="text-align:left;background:#f8fafc;padding:12px;border-bottom:1px solid #e2e8f0;">Role</th>
          <th style="text-align:left;background:#f8fafc;padding:12px;border-bottom:1px solid #e2e8f0;">Created</th>
          <th style="text-align:left;background:#f8fafc;padding:12px;border-bottom:1px solid #e2e8f0;">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr style="transition:background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
            <td style="padding:12px;border-bottom:1px solid #e2e8f0;">
              <strong><?php echo e($user->name); ?></strong>
              <?php if($user->id === auth()->id()): ?>
                <span style="font-size:11px;color:#64748b;margin-left:8px;">(You)</span>
              <?php endif; ?>
            </td>
            <td style="padding:12px;border-bottom:1px solid #e2e8f0;"><?php echo e($user->email); ?></td>
            <td style="padding:12px;border-bottom:1px solid #e2e8f0;">
              <span style="padding:4px 8px;border-radius:6px;font-size:12px;font-weight:500;
                <?php if($user->role === 'admin'): ?> background:#fee2e2;color:#991b1b;
                <?php elseif($user->role === 'manager'): ?> background:#dbeafe;color:#1e40af;
                <?php else: ?> background:#e2e8f0;color:#475569;
                <?php endif; ?>">
                <?php echo e(ucfirst($user->role)); ?>

              </span>
            </td>
            <td style="padding:12px;border-bottom:1px solid #e2e8f0;color:#64748b;">
              <?php echo e($user->created_at->format('M d, Y')); ?>

            </td>
            <td style="padding:12px;border-bottom:1px solid #e2e8f0;">
              <div style="display:flex;gap:6px;">
                <a href="<?php echo e(route('users.edit', $user)); ?>" 
                   class="btn edit-link" 
                   style="padding:6px 10px;font-size:12px;"
                   onclick="return confirmAction('⚠️ EDIT USER\n\nYou are about to edit user: <?php echo e($user->name); ?>\n\nDo you want to continue?', 'edit')">Edit</a>
                <?php if($user->id !== auth()->id()): ?>
                  <form style="display:inline;" 
                        method="post" 
                        action="<?php echo e(route('users.destroy', $user)); ?>" 
                        class="delete-form"
                        data-item-name="user '<?php echo e($user->name); ?>'">
                    <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                    <button type="submit" 
                            class="btn delete-btn" 
                            style="padding:6px 10px;font-size:12px;background:#ef4444;"
                            onclick="return confirmDeleteUser(this, '<?php echo e($user->name); ?>')">Delete</button>
                  </form>
                <?php endif; ?>
              </div>
            </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr>
            <td colspan="5" style="padding:40px;text-align:center;color:#64748b;">
              No users found. <a href="<?php echo e(route('users.create')); ?>" style="color:var(--brand-blue);">Create the first user</a>
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <?php if($users->hasPages()): ?>
    <div style="margin-top:16px;display:flex;justify-content:center;">
      <?php echo e($users->links()); ?>

    </div>
  <?php endif; ?>
  
  <script>
    function confirmDeleteUser(button, userName) {
      const message = `⚠️ DELETE USER CONFIRMATION\n\nAre you sure you want to delete user "${userName}"?\n\n⚠️ This action cannot be undone.\n\nAll user data and associated records will be permanently removed.\n\nThe user will no longer be able to access the system.`;
      return confirm(message);
    }
  </script>
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

<?php /**PATH C:\xampp\htdocs\DP\isqmapp\resources\views/users/index.blade.php ENDPATH**/ ?>