<?php ($title = 'Settings'); ?>
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
  <div style="max-width:640px;margin:20px auto;">
    <h2><?php echo e($title); ?></h2>
    <?php if(session('status')): ?><p><?php echo e(session('status')); ?></p><?php endif; ?>
    <form method="post" action="<?php echo e(route('settings.update')); ?>">
      <?php echo csrf_field(); ?>
      <label style="display:block;margin:10px 0 6px;font-weight:600;">Organisation name</label>
      <input type="text" name="org_name" value="<?php echo e(old('org_name', $org_name)); ?>" required style="width:100%;padding:8px;border:1px solid #d1d5db;border-radius:6px;">
      <label style="display:block;margin:10px 0 6px;font-weight:600;">Brand color</label>
      <input type="color" name="brand_color" value="<?php echo e(old('brand_color', $brand_color)); ?>" required>
      <div style="margin-top:12px;display:flex;gap:8px;">
        <button class="btn">Save</button>
      </div>
    </form>
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

<?php /**PATH C:\xampp\htdocs\DP\isqmapp\resources\views/settings/edit.blade.php ENDPATH**/ ?>