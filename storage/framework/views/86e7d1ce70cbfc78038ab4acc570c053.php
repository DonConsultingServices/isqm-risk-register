<?php ($title = 'User Guide'); ?>
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
    .guide-container { max-width: 1200px; margin: 0 auto; padding: 24px; }
    .guide-header { margin-bottom: 32px; }
    .guide-header h1 { margin: 0 0 8px; font-size: 32px; color: #0f172a; }
    .guide-header p { margin: 0; color: #64748b; font-size: 16px; }
    
    .topics-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; margin-top: 32px; }
    .topic-card { background: #fff; border: 2px solid #e2e8f0; border-radius: 12px; padding: 24px; transition: all 0.3s; cursor: pointer; }
    .topic-card:hover { border-color: var(--brand-blue, #2563eb); box-shadow: 0 4px 12px rgba(37, 99, 235, 0.1); transform: translateY(-2px); }
    .topic-icon { font-size: 32px; margin-bottom: 12px; }
    .topic-title { margin: 0 0 8px; font-size: 18px; font-weight: 600; color: #1e293b; }
    .topic-description { margin: 0; color: #64748b; font-size: 14px; line-height: 1.6; }
    
    .quick-links { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px; margin-top: 32px; }
    .quick-links h2 { margin: 0 0 16px; font-size: 20px; color: #1e293b; }
    .quick-links-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 12px; }
    .quick-link { display: block; padding: 12px 16px; background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; text-decoration: none; color: #334155; font-size: 14px; transition: all 0.2s; }
    .quick-link:hover { border-color: var(--brand-blue, #2563eb); color: var(--brand-blue, #2563eb); background: #f0f4ff; }
  </style>

  <div class="guide-container">
    <div class="guide-header">
      <h1>📚 User Guide</h1>
      <p>Learn how to use the ISQM Quality Management System effectively</p>
    </div>

    <div class="topics-grid">
      <a href="<?php echo e(route('user-guide.show', 'getting-started')); ?>" class="topic-card">
        <div class="topic-icon">🚀</div>
        <h3 class="topic-title">Getting Started</h3>
        <p class="topic-description">Introduction to the system, login, and basic navigation</p>
      </a>

      <a href="<?php echo e(route('user-guide.show', 'dashboard')); ?>" class="topic-card">
        <div class="topic-icon">📊</div>
        <h3 class="topic-title">Dashboard Overview</h3>
        <p class="topic-description">Understand your dashboard and key metrics</p>
      </a>

      <a href="<?php echo e(route('user-guide.show', 'creating-entries')); ?>" class="topic-card">
        <div class="topic-icon">➕</div>
        <h3 class="topic-title">Creating ISQM Entries</h3>
        <p class="topic-description">Step-by-step guide to creating new ISQM entries</p>
      </a>

      <a href="<?php echo e(route('user-guide.show', 'editing-entries')); ?>" class="topic-card">
        <div class="topic-icon">✏️</div>
        <h3 class="topic-title">Editing Entries</h3>
        <p class="topic-description">How to edit and update existing ISQM entries</p>
      </a>

      <a href="<?php echo e(route('user-guide.show', 'using-filters')); ?>" class="topic-card">
        <div class="topic-icon">🔍</div>
        <h3 class="topic-title">Using Filters</h3>
        <p class="topic-description">Filter and search entries effectively</p>
      </a>

      <a href="<?php echo e(route('user-guide.show', 'compliance-now')); ?>" class="topic-card">
        <div class="topic-icon">✅</div>
        <h3 class="topic-title">Compliance Now</h3>
        <p class="topic-description">Understanding the Compliance Now feature</p>
      </a>

      <a href="<?php echo e(route('user-guide.show', 'isqm-areas')); ?>" class="topic-card">
        <div class="topic-icon">📋</div>
        <h3 class="topic-title">ISQM Areas</h3>
        <p class="topic-description">Working with different ISQM areas</p>
      </a>

      <a href="<?php echo e(route('user-guide.show', 'managing-clients')); ?>" class="topic-card">
        <div class="topic-icon">👥</div>
        <h3 class="topic-title">Managing Clients</h3>
        <p class="topic-description">Add, edit, and manage clients</p>
      </a>

      <a href="<?php echo e(route('user-guide.show', 'monitoring-activities')); ?>" class="topic-card">
        <div class="topic-icon">🔍</div>
        <h3 class="topic-title">Monitoring Activities</h3>
        <p class="topic-description">Set up and manage monitoring activities</p>
      </a>

      <a href="<?php echo e(route('user-guide.show', 'bulk-actions')); ?>" class="topic-card">
        <div class="topic-icon">📦</div>
        <h3 class="topic-title">Bulk Actions</h3>
        <p class="topic-description">Perform actions on multiple entries at once</p>
      </a>

      <a href="<?php echo e(route('user-guide.show', 'importing-data')); ?>" class="topic-card">
        <div class="topic-icon">📥</div>
        <h3 class="topic-title">Importing Data</h3>
        <p class="topic-description">Import ISQM entries from Excel files</p>
      </a>

      <a href="<?php echo e(route('user-guide.show', 'reports-exports')); ?>" class="topic-card">
        <div class="topic-icon">📊</div>
        <h3 class="topic-title">Reports & Exports</h3>
        <p class="topic-description">Generate reports and export data</p>
      </a>

      <a href="<?php echo e(route('user-guide.show', 'user-management')); ?>" class="topic-card">
        <div class="topic-icon">👤</div>
        <h3 class="topic-title">User Management</h3>
        <p class="topic-description">Manage users and permissions (Admin only)</p>
      </a>

      <a href="<?php echo e(route('user-guide.show', 'notifications')); ?>" class="topic-card">
        <div class="topic-icon">🔔</div>
        <h3 class="topic-title">Notifications</h3>
        <p class="topic-description">Understanding the notification system</p>
      </a>

      <a href="<?php echo e(route('user-guide.show', 'settings')); ?>" class="topic-card">
        <div class="topic-icon">⚙️</div>
        <h3 class="topic-title">Settings</h3>
        <p class="topic-description">Configure system settings (Admin only)</p>
      </a>
    </div>

    <div class="quick-links">
      <h2>Quick Links</h2>
      <div class="quick-links-grid">
        <a href="<?php echo e(route('dashboard')); ?>" class="quick-link">Dashboard</a>
        <a href="<?php echo e(route('isqm.index')); ?>" class="quick-link">ISQM Register</a>
        <a href="<?php echo e(route('isqm.compliance')); ?>" class="quick-link">Compliance Now</a>
        <a href="<?php echo e(route('reports.index')); ?>" class="quick-link">Reports</a>
        <a href="<?php echo e(route('clients.index')); ?>" class="quick-link">Clients</a>
        <a href="<?php echo e(route('notifications.index')); ?>" class="quick-link">Notifications</a>
      </div>
    </div>
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

<?php /**PATH C:\xampp\htdocs\DP\isqmapp\resources\views/user-guide/index.blade.php ENDPATH**/ ?>