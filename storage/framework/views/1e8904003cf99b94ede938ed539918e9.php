<?php ($title = 'Clients'); ?>
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
    <a class="btn" href="<?php echo e(route('clients.create')); ?>">Add Client</a>
  </div>
  <?php if(session('status')): ?><p><?php echo e(session('status')); ?></p><?php endif; ?>
  <table style="width:100%;border-collapse:collapse;font-size:14px;">
    <thead>
      <tr>
        <th style="text-align:left;padding:8px;border-bottom:1px solid #eee;">Name</th>
        <th style="text-align:left;padding:8px;border-bottom:1px solid #eee;">Industry</th>
        <th style="text-align:left;padding:8px;border-bottom:1px solid #eee;">Email</th>
        <th style="text-align:left;padding:8px;border-bottom:1px solid #eee;">Phone</th>
        <th style="padding:8px;border-bottom:1px solid #eee;"></th>
      </tr>
    </thead>
    <tbody>
      <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
          <td style="padding:8px;border-bottom:1px solid #eee;"><?php echo e($c->name); ?></td>
          <td style="padding:8px;border-bottom:1px solid #eee;"><?php echo e($c->industry); ?></td>
          <td style="padding:8px;border-bottom:1px solid #eee;"><?php echo e($c->email); ?></td>
          <td style="padding:8px;border-bottom:1px solid #eee;"><?php echo e($c->phone); ?></td>
          <td style="padding:8px;border-bottom:1px solid #eee;">
            <a class="btn edit-link" 
               href="<?php echo e(route('clients.edit', $c)); ?>"
               onclick="return confirmAction('⚠️ EDIT CLIENT\n\nYou are about to edit client: <?php echo e($c->name); ?>\n\nDo you want to continue?', 'edit')">Edit</a>
            <form style="display:inline" 
                  method="post" 
                  action="<?php echo e(route('clients.destroy', $c)); ?>" 
                  class="delete-form"
                  data-item-name="client '<?php echo e($c->name); ?>'">
              <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
              <button type="submit" 
                      class="btn delete-btn" 
                      style="background:#ef4444"
                      onclick="return confirmDeleteClient(this, '<?php echo e($c->name); ?>')">Delete</button>
            </form>
          </td>
        </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
  </table>
  <div style="margin-top:12px;"><?php echo e($clients->links()); ?></div>
  
  <script>
    function confirmDeleteClient(button, clientName) {
      const message = `⚠️ DELETE CLIENT CONFIRMATION\n\nAre you sure you want to delete client "${clientName}"?\n\n⚠️ This action cannot be undone.\n\nAll client data and associated ISQM entries will be permanently removed.`;
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

<?php /**PATH C:\xampp\htdocs\DP\isqmapp\resources\views/clients/index.blade.php ENDPATH**/ ?>