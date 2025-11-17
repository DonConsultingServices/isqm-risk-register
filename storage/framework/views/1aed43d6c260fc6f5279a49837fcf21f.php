<?php ($areas = [
  'governance_and_leadership' => 'Governance and leadership',
  'ethical_requirements' => 'Ethical requirements',
  'acceptance_and_continuance' => 'Acceptance and continuance',
  'engagement_performance' => 'Engagement performance',
  'resources' => 'Resources',
  'information_and_communication' => 'Information and communication',
]); ?>
<?php ($title = 'Edit ISQM Entry #'.$entry->id); ?>
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
  <style>
    .form-section { background:#fff; border:1px solid #e2e8f0; border-radius:8px; padding:20px; margin-bottom:20px; }
    .form-section h3 { margin:0 0 16px; font-size:16px; font-weight:600; color:#1e293b; border-bottom:2px solid var(--brand-blue); padding-bottom:8px; }
    label { display:block; margin:12px 0 4px; font-weight:600; font-size:14px; color:#334155; }
    .help-text { font-size:12px; color:#64748b; margin-top:2px; font-style:italic; }
    input[type="text"], input[type="date"], select, textarea { width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px; font-size:14px; font-family:inherit; }
    textarea { min-height:80px; resize:vertical; }
    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    .form-row-3 { display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px; }
    .checkbox-group { display:flex; flex-wrap:wrap; gap:20px; margin:12px 0; }
    .checkbox-group label { margin:0; font-weight:normal; display:flex; align-items:center; gap:6px; }
    .checkbox-group input[type="checkbox"] { width:auto; margin:0; }
    .form-actions { display:flex; gap:12px; margin-top:24px; padding-top:20px; border-top:1px solid #e2e8f0; }
    .attachment-list { margin:12px 0; padding:12px; background:#f8fafc; border-radius:6px; }
    .attachment-list a { color:var(--brand-blue); text-decoration:none; }
  </style>

  <div style="max-width:1400px; margin:0 auto; padding:0 12px;">
    <div class="topbar" style="margin-bottom:24px;">
      <h2 style="margin:0;">Edit ISQM Entry #<?php echo e($entry->id); ?></h2>
      <div style="display:flex;gap:8px;">
        <a href="<?php echo e(route('isqm.show', ['isqm' => $entry, 'return_to' => $returnTo])); ?>" class="btn" style="background:#64748b;">View</a>
        <a href="<?php echo e($returnTo); ?>" class="btn" style="background:#64748b;">Cancel</a>
      </div>
    </div>

    <form method="post" action="<?php echo e(route('isqm.update', $entry)); ?>" enctype="multipart/form-data">
      <?php echo csrf_field(); ?>
      <?php echo method_field('put'); ?>
      <input type="hidden" name="return_to" value="<?php echo e(old('return_to', $returnTo)); ?>">

      <!-- Area & Quality Objective -->
      <div class="form-section">
        <h3>Basic Information</h3>
        <div class="form-row">
          <div>
            <label>Area *</label>
            <select name="area" required>
              <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($key); ?>" <?php if(old('area', $entry->area) === $key): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>
          <div>
            <label>Status *</label>
            <select name="status" required>
              <option value="open" <?php if(old('status', $entry->status) === 'open'): echo 'selected'; endif; ?>>Open</option>
              <option value="monitoring" <?php if(old('status', $entry->status) === 'monitoring'): echo 'selected'; endif; ?>>Monitoring</option>
              <option value="closed" <?php if(old('status', $entry->status) === 'closed'): echo 'selected'; endif; ?>>Closed</option>
            </select>
          </div>
        </div>

        <label>Quality Objective *</label>
        <div class="help-text">The quality objective that the firm aims to achieve</div>
        <textarea name="quality_objective" rows="4" required><?php echo e(old('quality_objective', $entry->quality_objective)); ?></textarea>
      </div>

      <!-- Risk Assessment Section -->
      <div class="form-section">
        <h3>Risk Assessment and Responses</h3>
        
        <label>Quality Risk</label>
        <div class="help-text">Based on the nature and circumstances of the entity. Must have reasonable possibility of occurring and reasonable possibility of adversely affecting the achievement of QUALITY OBJECTIVE</div>
        <textarea name="quality_risk" rows="4"><?php echo e(old('quality_risk', $entry->quality_risk)); ?></textarea>

        <label>Assessment of Risk</label>
        <div class="help-text">Evaluate the nature and circumstances of the entity to identify the significance of the risk and if it is applicable to the entity. This will influence if the risk is recorded and what the response will be</div>
        <textarea name="assessment_of_risk" rows="4"><?php echo e(old('assessment_of_risk', $entry->assessment_of_risk)); ?></textarea>

        <div class="form-row-3">
          <div>
            <label>Likelihood</label>
            <select name="likelihood">
              <option value="">—</option>
              <option value="1" <?php if(old('likelihood', $entry->likelihood) === true || old('likelihood') === '1'): echo 'selected'; endif; ?>>Yes</option>
              <option value="0" <?php if(old('likelihood') !== null && old('likelihood') !== '1' && $entry->likelihood === false): echo 'selected'; endif; ?>>No</option>
            </select>
          </div>
          <div>
            <label>Adverse Effect?</label>
            <select name="adverse_effect">
              <option value="">—</option>
              <option value="1" <?php if(old('adverse_effect', $entry->adverse_effect) === true || old('adverse_effect') === '1'): echo 'selected'; endif; ?>>Yes</option>
              <option value="0" <?php if(old('adverse_effect') !== null && old('adverse_effect') !== '1' && $entry->adverse_effect === false): echo 'selected'; endif; ?>>No</option>
            </select>
          </div>
          <div>
            <label>Risk Applicable?</label>
            <select name="risk_applicable">
              <option value="">—</option>
              <option value="1" <?php if(old('risk_applicable', $entry->risk_applicable) === true || old('risk_applicable') === '1'): echo 'selected'; endif; ?>>Yes</option>
              <option value="0" <?php if(old('risk_applicable') !== null && old('risk_applicable') !== '1' && $entry->risk_applicable === false): echo 'selected'; endif; ?>>No</option>
            </select>
          </div>
        </div>

        <label>Response to Quality Risk</label>
        <div class="help-text">The response designed to address the quality risk</div>
        <textarea name="response" rows="4"><?php echo e(old('response', $entry->response)); ?></textarea>

        <label>Firm Implementation</label>
        <div class="help-text">How the firm implements the response</div>
        <textarea name="firm_implementation" rows="4"><?php echo e(old('firm_implementation', $entry->firm_implementation)); ?></textarea>

        <label>TOC (Test of Control)</label>
        <div class="help-text">Once a year, follow a test of control approach to evaluate if the response was indeed implemented</div>
        <textarea name="toc" rows="4"><?php echo e(old('toc', $entry->toc)); ?></textarea>
      </div>

      <!-- Monitoring Section -->
      <div class="form-section">
        <h3>Monitoring and Remedial Action</h3>
        
        <div class="form-row">
          <div>
            <label>Monitoring Activity</label>
            <div class="help-text">Monitoring activity is selected from a dropdown list. If the monitoring activity does not appear here, please add it to the list on the "Lists" section. If no finding was identified for this specific risk and response, then select NA</div>
            <select name="monitoring_activity_id">
              <option value="">— Select or leave blank if NA —</option>
              <?php $__currentLoopData = $monitoringActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($m->id); ?>" <?php if(old('monitoring_activity_id', $entry->monitoring_activity_id) == $m->id): echo 'selected'; endif; ?>><?php echo e($m->name); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>
          <div>
            <label>Type of Deficiency</label>
            <div class="help-text">Select from the dropdown list</div>
            <select name="deficiency_type_id">
              <option value="">— Select or leave blank if NA —</option>
              <?php $__currentLoopData = $deficiencyTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($d->id); ?>" <?php if(old('deficiency_type_id', $entry->deficiency_type_id) == $d->id): echo 'selected'; endif; ?>><?php echo e($d->name); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>
        </div>

        <label>Findings - Document Finding in Detail</label>
        <div class="help-text">This is like documenting a deficient control. What was identified and what went wrong</div>
        <textarea name="findings" rows="4"><?php echo e(old('findings', $entry->findings)); ?></textarea>

        <label>Root Cause</label>
        <div class="help-text">Perform the 5 Why's and ask yourself what is the reason why this happened</div>
        <textarea name="root_cause" rows="4"><?php echo e(old('root_cause', $entry->root_cause)); ?></textarea>

        <div class="checkbox-group">
          <label><input type="checkbox" name="severe" value="1" <?php if(old('severe', $entry->severe)): echo 'checked'; endif; ?>> Severe</label>
          <label><input type="checkbox" name="pervasive" value="1" <?php if(old('pervasive', $entry->pervasive)): echo 'checked'; endif; ?>> Pervasive</label>
          <label><input type="checkbox" name="objective_met" value="1" <?php if(old('objective_met', $entry->objective_met)): echo 'checked'; endif; ?>> Objective Met</label>
        </div>

        <label>Remedial Actions Implemented</label>
        <div class="help-text">What did you do to ensure this does not happen again? Did you change a risk or a response?</div>
        <textarea name="remedial_actions" rows="4"><?php echo e(old('remedial_actions', $entry->remedial_actions)); ?></textarea>
      </div>

      <!-- Context & Ownership -->
      <div class="form-section">
        <h3>Context and Ownership</h3>
        
        <div class="form-row">
          <div>
            <label>Client</label>
            <select name="client_id">
              <option value="">— No Client —</option>
              <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($c->id); ?>" <?php if(old('client_id', $entry->client_id) == $c->id): echo 'selected'; endif; ?>><?php echo e($c->name); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>
          <div>
            <label>Owner</label>
            <select name="owner_id">
              <option value="">— No Owner —</option>
              <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($u->id); ?>" <?php if(old('owner_id', $entry->owner_id) == $u->id): echo 'selected'; endif; ?>><?php echo e($u->name); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>
        </div>

        <div class="form-row">
          <div>
            <label>Due Date</label>
            <input type="date" name="due_date" value="<?php echo e(old('due_date', optional($entry->due_date)->format('Y-m-d'))); ?>">
          </div>
          <div>
            <label>Review Date</label>
            <input type="date" name="review_date" value="<?php echo e(old('review_date', optional($entry->review_date)->format('Y-m-d'))); ?>">
          </div>
        </div>

        <div class="checkbox-group">
          <label><input type="checkbox" name="entity_level" value="1" <?php if(old('entity_level', $entry->entity_level)): echo 'checked'; endif; ?>> Entity Level</label>
          <label><input type="checkbox" name="engagement_level" value="1" <?php if(old('engagement_level', $entry->engagement_level)): echo 'checked'; endif; ?>> Engagement Level</label>
        </div>
      </div>

      <!-- Attachments -->
      <div class="form-section">
        <h3>Attachments</h3>
        <?php if($entry->attachments->count() > 0): ?>
          <div class="attachment-list">
            <strong style="display:block;margin-bottom:8px;">Existing Attachments:</strong>
            <ul style="list-style:none;padding:0;margin:0;">
              <?php $__currentLoopData = $entry->attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li style="padding:4px 0;">
                  <a href="<?php echo e(Storage::url($a->path)); ?>" target="_blank"><?php echo e($a->filename); ?></a>
                  <span style="color:#64748b;font-size:12px;margin-left:8px;">(<?php echo e(number_format($a->size / 1024, 2)); ?> KB)</span>
                </li>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
          </div>
        <?php endif; ?>
        <label>Upload Additional Files</label>
        <input type="file" name="files[]" multiple accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
        <div class="help-text">You can select multiple files. Supported formats: PDF, Word, Excel, Images</div>
      </div>

      <div class="form-actions">
        <button type="submit" class="btn">Update Entry</button>
        <a href="<?php echo e(route('isqm.show', ['isqm' => $entry, 'return_to' => $returnTo])); ?>" class="btn" style="background:#64748b;">View</a>
        <a href="<?php echo e($returnTo); ?>" class="btn" style="background:#64748b;">Cancel</a>
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
<?php /**PATH C:\xampp\htdocs\DP\isqmapp\resources\views/isqm/edit.blade.php ENDPATH**/ ?>