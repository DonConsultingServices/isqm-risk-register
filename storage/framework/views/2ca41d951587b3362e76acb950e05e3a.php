<?php ($title = 'ISQM Entry #'.$isqm->id); ?>
<?php ($returnTo = request('return_to') ? urldecode(request('return_to')) : (url()->previous() && url()->previous() !== url()->current() ? url()->previous() : route('isqm.index'))); ?>
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
  <div style="max-width:1200px;margin:0 auto;">
    <div class="topbar">
      <h2>ISQM Entry #<?php echo e($isqm->id); ?></h2>
      <div style="display:flex;gap:8px;">
        <a class="btn" href="<?php echo e(route('isqm.edit', ['isqm' => $isqm, 'return_to' => $returnTo])); ?>">Edit</a>
        <a class="btn" href="<?php echo e($returnTo); ?>" style="background:#64748b;">Back</a>
      </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-top:20px;">
      <div class="card" style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:16px;">
        <h3 style="margin:0 0 12px;font-size:16px;font-weight:600;">Basic Information</h3>
        <table style="width:100%;font-size:14px;">
          <tr><td style="padding:6px 0;color:#64748b;width:140px;">Area:</td><td style="padding:6px 0;"><strong><?php echo e(str_replace('_', ' ', $isqm->area)); ?></strong></td></tr>
          <tr><td style="padding:6px 0;color:#64748b;">Status:</td><td style="padding:6px 0;"><span style="padding:4px 8px;background:#e2e8f0;border-radius:6px;"><?php echo e(ucfirst($isqm->status)); ?></span></td></tr>
          <tr><td style="padding:6px 0;color:#64748b;">Client:</td><td style="padding:6px 0;"><?php echo e($isqm->client?->name ?? '—'); ?></td></tr>
          <tr><td style="padding:6px 0;color:#64748b;">Owner:</td><td style="padding:6px 0;"><?php echo e($isqm->owner?->name ?? '—'); ?></td></tr>
          <tr><td style="padding:6px 0;color:#64748b;">Due Date:</td><td style="padding:6px 0;"><?php echo e($isqm->due_date?->format('M d, Y') ?? '—'); ?></td></tr>
          <tr><td style="padding:6px 0;color:#64748b;">Review Date:</td><td style="padding:6px 0;"><?php echo e($isqm->review_date?->format('M d, Y') ?? '—'); ?></td></tr>
        </table>
      </div>

      <div class="card" style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:16px;">
        <h3 style="margin:0 0 12px;font-size:16px;font-weight:600;">Risk Flags</h3>
        <div style="display:flex;flex-wrap:wrap;gap:8px;">
          <?php if($isqm->likelihood !== null): ?>
            <span style="padding:4px 8px;background:<?php echo e($isqm->likelihood ? '#fef3c7' : '#d1fae5'); ?>;color:<?php echo e($isqm->likelihood ? '#92400e' : '#065f46'); ?>;border-radius:6px;font-size:12px;">
              Likelihood: <?php echo e($isqm->likelihood ? 'Yes' : 'No'); ?>

            </span>
          <?php endif; ?>
          <?php if($isqm->severe): ?><span style="padding:4px 8px;background:#fee2e2;color:#991b1b;border-radius:6px;font-size:12px;">Severe</span><?php endif; ?>
          <?php if($isqm->pervasive): ?><span style="padding:4px 8px;background:#fef3c7;color:#92400e;border-radius:6px;font-size:12px;">Pervasive</span><?php endif; ?>
          <?php if($isqm->adverse_effect): ?><span style="padding:4px 8px;background:#fee2e2;color:#991b1b;border-radius:6px;font-size:12px;">Adverse Effect</span><?php endif; ?>
          <?php if($isqm->risk_applicable !== null): ?>
            <span style="padding:4px 8px;background:<?php echo e($isqm->risk_applicable ? '#fee2e2' : '#d1fae5'); ?>;color:<?php echo e($isqm->risk_applicable ? '#991b1b' : '#065f46'); ?>;border-radius:6px;font-size:12px;">
              Risk Applicable: <?php echo e($isqm->risk_applicable ? 'Yes' : 'No'); ?>

            </span>
          <?php endif; ?>
          <?php if($isqm->entity_level): ?><span style="padding:4px 8px;background:#dbeafe;color:#1e40af;border-radius:6px;font-size:12px;">Entity Level</span><?php endif; ?>
          <?php if($isqm->engagement_level): ?><span style="padding:4px 8px;background:#dbeafe;color:#1e40af;border-radius:6px;font-size:12px;">Engagement Level</span><?php endif; ?>
          <?php if($isqm->objective_met): ?><span style="padding:4px 8px;background:#d1fae5;color:#065f46;border-radius:6px;font-size:12px;">Objective Met</span><?php endif; ?>
        </div>
      </div>
    </div>

    <div class="card" style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:16px;margin-top:20px;">
      <h3 style="margin:0 0 12px;font-size:16px;font-weight:600;">Quality Objective</h3>
      <p style="margin:0;line-height:1.6;"><?php echo e($isqm->quality_objective); ?></p>
    </div>

    <?php if($isqm->quality_risk): ?>
    <div class="card" style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:16px;margin-top:16px;">
      <h3 style="margin:0 0 12px;font-size:16px;font-weight:600;">Quality Risk</h3>
      <p style="margin:0;line-height:1.6;"><?php echo e($isqm->quality_risk); ?></p>
    </div>
    <?php endif; ?>

    <?php if($isqm->assessment_of_risk): ?>
    <div class="card" style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:16px;margin-top:16px;">
      <h3 style="margin:0 0 12px;font-size:16px;font-weight:600;">Assessment of Risk</h3>
      <p style="margin:0;line-height:1.6;"><?php echo e($isqm->assessment_of_risk); ?></p>
    </div>
    <?php endif; ?>

    <?php if($isqm->response): ?>
    <div class="card" style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:16px;margin-top:16px;">
      <h3 style="margin:0 0 12px;font-size:16px;font-weight:600;">Response</h3>
      <p style="margin:0;line-height:1.6;"><?php echo e($isqm->response); ?></p>
    </div>
    <?php endif; ?>

    <?php if($isqm->firm_implementation): ?>
    <div class="card" style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:16px;margin-top:16px;">
      <h3 style="margin:0 0 12px;font-size:16px;font-weight:600;">Firm Implementation</h3>
      <p style="margin:0;line-height:1.6;"><?php echo e($isqm->firm_implementation); ?></p>
    </div>
    <?php endif; ?>

    <?php if($isqm->toc): ?>
    <div class="card" style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:16px;margin-top:16px;">
      <h3 style="margin:0 0 12px;font-size:16px;font-weight:600;">TOC (Test of Control)</h3>
      <p style="margin:0;line-height:1.6;"><?php echo e($isqm->toc); ?></p>
    </div>
    <?php endif; ?>

    <?php if($isqm->findings || $isqm->root_cause || $isqm->monitoringActivity || $isqm->deficiencyType): ?>
    <div class="card" style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:16px;margin-top:16px;">
      <h3 style="margin:0 0 12px;font-size:16px;font-weight:600;">Monitoring & Findings</h3>
      <table style="width:100%;font-size:14px;">
        <?php if($isqm->monitoringActivity): ?>
        <tr><td style="padding:6px 0;color:#64748b;width:180px;">Monitoring Activity:</td><td style="padding:6px 0;"><?php echo e($isqm->monitoringActivity->name); ?></td></tr>
        <?php endif; ?>
        <?php if($isqm->findings): ?>
        <tr><td style="padding:6px 0;color:#64748b;vertical-align:top;">Findings:</td><td style="padding:6px 0;"><?php echo e($isqm->findings); ?></td></tr>
        <?php endif; ?>
        <?php if($isqm->deficiencyType): ?>
        <tr><td style="padding:6px 0;color:#64748b;">Deficiency Type:</td><td style="padding:6px 0;"><?php echo e($isqm->deficiencyType->name); ?></td></tr>
        <?php endif; ?>
        <?php if($isqm->root_cause): ?>
        <tr><td style="padding:6px 0;color:#64748b;vertical-align:top;">Root Cause:</td><td style="padding:6px 0;"><?php echo e($isqm->root_cause); ?></td></tr>
        <?php endif; ?>
      </table>
    </div>
    <?php endif; ?>

    <?php if($isqm->remedial_actions): ?>
    <div class="card" style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:16px;margin-top:16px;">
      <h3 style="margin:0 0 12px;font-size:16px;font-weight:600;">Remedial Actions</h3>
      <p style="margin:0;line-height:1.6;"><?php echo e($isqm->remedial_actions); ?></p>
    </div>
    <?php endif; ?>

    <?php if($isqm->attachments->count() > 0): ?>
    <div class="card" style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:16px;margin-top:16px;">
      <h3 style="margin:0 0 12px;font-size:16px;font-weight:600;">Attachments</h3>
      <ul style="list-style:none;padding:0;margin:0;">
        <?php $__currentLoopData = $isqm->attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $att): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li style="padding:8px 0;border-bottom:1px solid #e2e8f0;">
            <a href="<?php echo e(Storage::url($att->path)); ?>" target="_blank" style="color:var(--brand-blue);text-decoration:none;"><?php echo e($att->filename); ?></a>
            <span style="color:#64748b;font-size:12px;margin-left:8px;">(<?php echo e(number_format($att->size / 1024, 2)); ?> KB)</span>
          </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
    </div>
    <?php endif; ?>

    <div style="margin-top:20px;padding-top:16px;border-top:1px solid #e2e8f0;color:#64748b;font-size:12px;">
      Created: <?php echo e($isqm->created_at->format('M d, Y H:i')); ?> | 
      Updated: <?php echo e($isqm->updated_at->format('M d, Y H:i')); ?>

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

<?php /**PATH C:\xampp\htdocs\DP\isqmapp\resources\views/isqm/show.blade.php ENDPATH**/ ?>