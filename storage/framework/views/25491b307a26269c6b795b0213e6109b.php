<?php ($title = 'Add Deficiency Type'); ?>
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
  <div style="max-width:720px;margin:20px auto;">
    <h2><?php echo e($title); ?></h2>
    <form method="post" 
          action="<?php echo e(route('lists.deficiency.store')); ?>"
          class="create-form"
          onsubmit="return confirmCreateItem('deficiency type')">
      <?php echo csrf_field(); ?>
      <label style="display:block;margin:10px 0 6px;font-weight:600;">Name</label>
      <input type="text" name="name" required style="width:100%;padding:8px;border:1px solid #d1d5db;border-radius:6px;">
      <label style="display:block;margin:10px 0 6px;font-weight:600;">Description</label>
      <textarea name="description" rows="3" style="width:100%;padding:8px;border:1px solid #d1d5db;border-radius:6px;"></textarea>
      <div style="margin-top:12px;display:flex;gap:8px;">
        <a href="<?php echo e(route('lists.deficiency.index')); ?>" 
           class="cancel-link"
           onclick="return confirmCancelCreate()">Cancel</a>
        <button type="submit" class="btn save-btn">Save</button>
      </div>
    </form>
  </div>
  
  <script>
    function confirmCreateItem(type) {
      const message = `⚠️ CREATE ${type.toUpperCase()} CONFIRMATION\n\nAre you sure you want to create this new ${type}?\n\nPlease verify all information is correct before submitting.`;
      return confirm(message);
    }
    
    function confirmCancelCreate() {
      const message = `⚠️ CANCEL CREATION\n\nAre you sure you want to cancel?\n\nAny entered data will be lost.`;
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

<?php /**PATH C:\xampp\htdocs\DP\isqmapp\resources\views/lists/deficiency/create.blade.php ENDPATH**/ ?>