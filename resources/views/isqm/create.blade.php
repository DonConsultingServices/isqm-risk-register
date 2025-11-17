@php($areas = [
  'governance_and_leadership' => 'Governance and leadership',
  'ethical_requirements' => 'Ethical requirements',
  'acceptance_and_continuance' => 'Acceptance and continuance',
  'engagement_performance' => 'Engagement performance',
  'resources' => 'Resources',
  'information_and_communication' => 'Information and communication',
])
@php($title = 'New ISQM Entry')
@php($returnTo = request('return_to') ? urldecode(request('return_to')) : (url()->previous() && url()->previous() !== url()->current() ? url()->previous() : route('isqm.index')))
<x-layouts.app :title="$title">
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
    .dynamic-field-group { margin:16px 0; }
    .dynamic-fields-container { margin-bottom:8px; }
    .dynamic-field-item { margin-bottom:12px; }
    .dynamic-field-item:not(:first-child) { margin-top:12px; padding-top:12px; border-top:1px solid #e2e8f0; }
    .btn-add-field:hover { background:#059669 !important; }
    .btn-remove-field:hover { background:#dc2626 !important; }
  </style>

  <div style="max-width:1400px; margin:0 auto; padding:0 12px;">
    <div class="topbar" style="margin-bottom:24px;">
      <h2 style="margin:0;">New ISQM Entry</h2>
      <a href="{{ $returnTo }}" class="btn" style="background:#64748b;">Cancel</a>
    </div>

    <form method="post" 
          action="{{ route('isqm.store') }}" 
          enctype="multipart/form-data"
          class="create-form"
          onsubmit="return confirmCreateEntry(this)">
      @csrf
      <input type="hidden" name="return_to" value="{{ old('return_to', $returnTo) }}">

      <!-- Area & Quality Objective -->
      <div class="form-section">
        <h3>Basic Information</h3>
        <div class="form-row">
          <div>
            <label>Area *</label>
            <select name="area" required>
              @foreach ($areas as $key => $label)
                <option value="{{ $key }}" @selected(old('area', request('area')) === $key)>{{ $label }}</option>
              @endforeach
            </select>
          </div>
          <div>
            <label>Status *</label>
            <select name="status" required>
              <option value="open" @selected(old('status') === 'open')>Open</option>
              <option value="monitoring" @selected(old('status') === 'monitoring')>Monitoring</option>
              <option value="closed" @selected(old('status') === 'closed')>Closed</option>
            </select>
          </div>
        </div>

        <div class="dynamic-field-group" data-field-name="quality_objective">
          <label>Quality Objective *</label>
          <div class="help-text">The quality objective that the firm aims to achieve</div>
          <div class="dynamic-fields-container">
            <div class="dynamic-field-item">
              <textarea name="quality_objective[]" rows="4" required>{{ old('quality_objective.0') }}</textarea>
              <button type="button" class="btn-remove-field" style="display:none;margin-top:8px;padding:6px 12px;background:#ef4444;color:white;border:none;border-radius:4px;cursor:pointer;font-size:12px;">Remove</button>
            </div>
          </div>
          <button type="button" class="btn-add-field" style="margin-top:8px;padding:8px 16px;background:#10b981;color:white;border:none;border-radius:6px;cursor:pointer;font-size:14px;font-weight:500;">+ Add Another Quality Objective</button>
        </div>
      </div>

      <!-- Risk Assessment Section -->
      <div class="form-section">
        <h3>Risk Assessment and Responses</h3>
        
        <div class="dynamic-field-group" data-field-name="quality_risk">
          <label>Quality Risk</label>
          <div class="help-text">Based on the nature and circumstances of the entity. Must have reasonable possibility of occurring and reasonable possibility of adversely affecting the achievement of QUALITY OBJECTIVE</div>
          <div class="dynamic-fields-container">
            <div class="dynamic-field-item">
              <textarea name="quality_risk[]" rows="4">{{ old('quality_risk.0') }}</textarea>
              <button type="button" class="btn-remove-field" style="display:none;margin-top:8px;padding:6px 12px;background:#ef4444;color:white;border:none;border-radius:4px;cursor:pointer;font-size:12px;">Remove</button>
            </div>
          </div>
          <button type="button" class="btn-add-field" style="margin-top:8px;padding:8px 16px;background:#10b981;color:white;border:none;border-radius:6px;cursor:pointer;font-size:14px;font-weight:500;">+ Add Another Quality Risk</button>
        </div>

        <div class="dynamic-field-group" data-field-name="assessment_of_risk">
          <label>Assessment of Risk</label>
          <div class="help-text">Evaluate the nature and circumstances of the entity to identify the significance of the risk and if it is applicable to the entity. This will influence if the risk is recorded and what the response will be</div>
          <div class="dynamic-fields-container">
            <div class="dynamic-field-item">
              <textarea name="assessment_of_risk[]" rows="4">{{ old('assessment_of_risk.0') }}</textarea>
              <button type="button" class="btn-remove-field" style="display:none;margin-top:8px;padding:6px 12px;background:#ef4444;color:white;border:none;border-radius:4px;cursor:pointer;font-size:12px;">Remove</button>
            </div>
          </div>
          <button type="button" class="btn-add-field" style="margin-top:8px;padding:8px 16px;background:#10b981;color:white;border:none;border-radius:6px;cursor:pointer;font-size:14px;font-weight:500;">+ Add Another Assessment</button>
        </div>

        <div class="form-row-3">
          <div>
            <label>Likelihood</label>
            <select name="likelihood">
              <option value="">—</option>
              <option value="1" @selected(old('likelihood') === '1')>Yes</option>
              <option value="0" @selected(old('likelihood') === '0')>No</option>
            </select>
          </div>
          <div>
            <label>Adverse Effect?</label>
            <select name="adverse_effect">
              <option value="">—</option>
              <option value="1" @selected(old('adverse_effect') === '1')>Yes</option>
              <option value="0" @selected(old('adverse_effect') === '0')>No</option>
            </select>
          </div>
          <div>
            <label>Risk Applicable?</label>
            <select name="risk_applicable">
              <option value="">—</option>
              <option value="1" @selected(old('risk_applicable') === '1')>Yes</option>
              <option value="0" @selected(old('risk_applicable') === '0')>No</option>
            </select>
          </div>
        </div>

        <div class="dynamic-field-group" data-field-name="response">
          <label>Response to Quality Risk</label>
          <div class="help-text">The response designed to address the quality risk</div>
          <div class="dynamic-fields-container">
            <div class="dynamic-field-item">
              <textarea name="response[]" rows="4">{{ old('response.0') }}</textarea>
              <button type="button" class="btn-remove-field" style="display:none;margin-top:8px;padding:6px 12px;background:#ef4444;color:white;border:none;border-radius:4px;cursor:pointer;font-size:12px;">Remove</button>
            </div>
          </div>
          <button type="button" class="btn-add-field" style="margin-top:8px;padding:8px 16px;background:#10b981;color:white;border:none;border-radius:6px;cursor:pointer;font-size:14px;font-weight:500;">+ Add Another Response</button>
        </div>

        <div class="dynamic-field-group" data-field-name="firm_implementation">
          <label>Firm Implementation</label>
          <div class="help-text">How the firm implements the response</div>
          <div class="dynamic-fields-container">
            <div class="dynamic-field-item">
              <textarea name="firm_implementation[]" rows="4">{{ old('firm_implementation.0') }}</textarea>
              <button type="button" class="btn-remove-field" style="display:none;margin-top:8px;padding:6px 12px;background:#ef4444;color:white;border:none;border-radius:4px;cursor:pointer;font-size:12px;">Remove</button>
            </div>
          </div>
          <button type="button" class="btn-add-field" style="margin-top:8px;padding:8px 16px;background:#10b981;color:white;border:none;border-radius:6px;cursor:pointer;font-size:14px;font-weight:500;">+ Add Another Implementation</button>
        </div>

        <div class="dynamic-field-group" data-field-name="toc">
          <label>TOC (Test of Control)</label>
          <div class="help-text">Once a year, follow a test of control approach to evaluate if the response was indeed implemented</div>
          <div class="dynamic-fields-container">
            <div class="dynamic-field-item">
              <textarea name="toc[]" rows="4">{{ old('toc.0') }}</textarea>
              <button type="button" class="btn-remove-field" style="display:none;margin-top:8px;padding:6px 12px;background:#ef4444;color:white;border:none;border-radius:4px;cursor:pointer;font-size:12px;">Remove</button>
            </div>
          </div>
          <button type="button" class="btn-add-field" style="margin-top:8px;padding:8px 16px;background:#10b981;color:white;border:none;border-radius:6px;cursor:pointer;font-size:14px;font-weight:500;">+ Add Another TOC</button>
        </div>
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
              @foreach ($monitoringActivities as $m)
                <option value="{{ $m->id }}" @selected(old('monitoring_activity_id') == $m->id)>{{ $m->name }}</option>
              @endforeach
            </select>
          </div>
          <div>
            <label>Type of Deficiency</label>
            <div class="help-text">Select from the dropdown list</div>
            <select name="deficiency_type_id">
              <option value="">— Select or leave blank if NA —</option>
              @foreach ($deficiencyTypes as $d)
                <option value="{{ $d->id }}" @selected(old('deficiency_type_id') == $d->id)>{{ $d->name }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="dynamic-field-group" data-field-name="findings">
          <label>Findings - Document Finding in Detail</label>
          <div class="help-text">This is like documenting a deficient control. What was identified and what went wrong</div>
          <div class="dynamic-fields-container">
            <div class="dynamic-field-item">
              <textarea name="findings[]" rows="4">{{ old('findings.0') }}</textarea>
              <button type="button" class="btn-remove-field" style="display:none;margin-top:8px;padding:6px 12px;background:#ef4444;color:white;border:none;border-radius:4px;cursor:pointer;font-size:12px;">Remove</button>
            </div>
          </div>
          <button type="button" class="btn-add-field" style="margin-top:8px;padding:8px 16px;background:#10b981;color:white;border:none;border-radius:6px;cursor:pointer;font-size:14px;font-weight:500;">+ Add Another Finding</button>
        </div>

        <div class="dynamic-field-group" data-field-name="root_cause">
          <label>Root Cause</label>
          <div class="help-text">Perform the 5 Why's and ask yourself what is the reason why this happened</div>
          <div class="dynamic-fields-container">
            <div class="dynamic-field-item">
              <textarea name="root_cause[]" rows="4">{{ old('root_cause.0') }}</textarea>
              <button type="button" class="btn-remove-field" style="display:none;margin-top:8px;padding:6px 12px;background:#ef4444;color:white;border:none;border-radius:4px;cursor:pointer;font-size:12px;">Remove</button>
            </div>
          </div>
          <button type="button" class="btn-add-field" style="margin-top:8px;padding:8px 16px;background:#10b981;color:white;border:none;border-radius:6px;cursor:pointer;font-size:14px;font-weight:500;">+ Add Another Root Cause</button>
        </div>

        <div class="checkbox-group">
          <label><input type="checkbox" name="severe" value="1" @checked(old('severe'))> Severe</label>
          <label><input type="checkbox" name="pervasive" value="1" @checked(old('pervasive'))> Pervasive</label>
          <label><input type="checkbox" name="objective_met" value="1" @checked(old('objective_met'))> Objective Met</label>
        </div>

        <div class="dynamic-field-group" data-field-name="remedial_actions">
          <label>Remedial Actions Implemented</label>
          <div class="help-text">What did you do to ensure this does not happen again? Did you change a risk or a response?</div>
          <div class="dynamic-fields-container">
            <div class="dynamic-field-item">
              <textarea name="remedial_actions[]" rows="4">{{ old('remedial_actions.0') }}</textarea>
              <button type="button" class="btn-remove-field" style="display:none;margin-top:8px;padding:6px 12px;background:#ef4444;color:white;border:none;border-radius:4px;cursor:pointer;font-size:12px;">Remove</button>
            </div>
          </div>
          <button type="button" class="btn-add-field" style="margin-top:8px;padding:8px 16px;background:#10b981;color:white;border:none;border-radius:6px;cursor:pointer;font-size:14px;font-weight:500;">+ Add Another Remedial Action</button>
        </div>
      </div>

      <!-- Context & Ownership -->
      <div class="form-section">
        <h3>Context and Ownership</h3>
        
        <div class="form-row">
          <div>
            <label>Client</label>
            <select name="client_id">
              <option value="">— No Client —</option>
              @foreach ($clients as $c)
                <option value="{{ $c->id }}" @selected(old('client_id') == $c->id)>{{ $c->name }}</option>
              @endforeach
            </select>
          </div>
          <div>
            <label>Owner</label>
            <select name="owner_id">
              <option value="">— No Owner —</option>
              @foreach ($users as $u)
                <option value="{{ $u->id }}" @selected(old('owner_id') == $u->id)>{{ $u->name }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="form-row">
          <div>
            <label>Due Date</label>
            <input type="date" name="due_date" value="{{ old('due_date') }}">
          </div>
          <div>
            <label>Review Date</label>
            <input type="date" name="review_date" value="{{ old('review_date') }}">
          </div>
        </div>

        <div class="checkbox-group">
          <label><input type="checkbox" name="entity_level" value="1" @checked(old('entity_level'))> Entity Level</label>
          <label><input type="checkbox" name="engagement_level" value="1" @checked(old('engagement_level'))> Engagement Level</label>
        </div>
      </div>

      <!-- Attachments -->
      <div class="form-section">
        <h3>Attachments</h3>
        <label>Upload Files (Multiple files allowed)</label>
        <input type="file" name="files[]" id="file-input" multiple accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png" style="margin-bottom:8px;">
        <div id="file-list" style="margin-top:8px;padding:8px;background:#f8fafc;border-radius:6px;display:none;">
          <strong style="display:block;margin-bottom:4px;font-size:13px;">Selected files:</strong>
          <ul id="file-names" style="list-style:none;padding:0;margin:0;font-size:13px;color:#475569;"></ul>
        </div>
        <div class="help-text">You can select multiple files at once (hold Ctrl/Cmd to select multiple, or drag and drop). Supported formats: PDF, Word, Excel, Images. Maximum 20MB per file.</div>
      </div>

      <div class="form-actions">
        <button type="submit" class="btn save-btn">Save Entry</button>
        <a href="{{ $returnTo }}" 
           class="btn cancel-link" 
           style="background:#64748b;"
           onclick="return confirmCancelCreate()">Cancel</a>
      </div>
    </form>
  </div>
  
  <script>
    // Dynamic field management
    document.addEventListener('DOMContentLoaded', function() {
      // Handle "Add Another" buttons
      document.querySelectorAll('.btn-add-field').forEach(button => {
        button.addEventListener('click', function() {
          const group = this.closest('.dynamic-field-group');
          const container = group.querySelector('.dynamic-fields-container');
          const fieldName = group.getAttribute('data-field-name');
          const firstItem = container.querySelector('.dynamic-field-item');
          const firstTextarea = firstItem.querySelector('textarea');
          
          // Create new field item
          const newItem = document.createElement('div');
          newItem.className = 'dynamic-field-item';
          newItem.style.marginTop = '12px';
          newItem.style.paddingTop = '12px';
          newItem.style.borderTop = '1px solid #e2e8f0';
          
          const newTextarea = document.createElement('textarea');
          newTextarea.name = fieldName + '[]';
          newTextarea.rows = 4;
          newTextarea.style.width = '100%';
          newTextarea.style.padding = '10px';
          newTextarea.style.border = '1px solid #d1d5db';
          newTextarea.style.borderRadius = '6px';
          newTextarea.style.fontSize = '14px';
          newTextarea.style.fontFamily = 'inherit';
          newTextarea.style.minHeight = '80px';
          newTextarea.style.resize = 'vertical';
          if (firstTextarea.hasAttribute('required')) {
            newTextarea.removeAttribute('required'); // Only first field is required
          }
          
          const removeBtn = document.createElement('button');
          removeBtn.type = 'button';
          removeBtn.className = 'btn-remove-field';
          removeBtn.textContent = 'Remove';
          removeBtn.style.marginTop = '8px';
          removeBtn.style.padding = '6px 12px';
          removeBtn.style.background = '#ef4444';
          removeBtn.style.color = 'white';
          removeBtn.style.border = 'none';
          removeBtn.style.borderRadius = '4px';
          removeBtn.style.cursor = 'pointer';
          removeBtn.style.fontSize = '12px';
          
          removeBtn.addEventListener('click', function() {
            newItem.remove();
            updateRemoveButtons(group);
          });
          
          newItem.appendChild(newTextarea);
          newItem.appendChild(removeBtn);
          container.appendChild(newItem);
          
          // Show remove buttons on all items (except if only one remains)
          updateRemoveButtons(group);
          
          // Focus on new textarea
          newTextarea.focus();
        });
      });
      
      // Show remove buttons if there are multiple fields
      document.querySelectorAll('.dynamic-field-group').forEach(group => {
        updateRemoveButtons(group);
      });
      
      function updateRemoveButtons(group) {
        const container = group.querySelector('.dynamic-fields-container');
        const items = container.querySelectorAll('.dynamic-field-item');
        const removeButtons = container.querySelectorAll('.btn-remove-field');
        
        // Show remove buttons only if there's more than one field
        if (items.length > 1) {
          removeButtons.forEach(btn => btn.style.display = 'block');
        } else {
          removeButtons.forEach(btn => btn.style.display = 'none');
        }
      }
      
      // Handle form submission - combine array fields into single strings
      document.querySelector('.create-form').addEventListener('submit', function(e) {
        document.querySelectorAll('.dynamic-field-group').forEach(group => {
          const fieldName = group.getAttribute('data-field-name');
          const textareas = group.querySelectorAll('textarea[name="' + fieldName + '[]"]');
          const values = Array.from(textareas)
            .map(ta => ta.value.trim())
            .filter(val => val !== '');
          
          // Create hidden input with combined value
          let combinedValue = values.join('\n\n• ');
          if (values.length > 1) {
            combinedValue = '• ' + values.join('\n\n• ');
          } else if (values.length === 1) {
            combinedValue = values[0];
          } else {
            combinedValue = '';
          }
          
          // Remove old hidden inputs
          group.querySelectorAll('input[type="hidden"][name="' + fieldName + '"]').forEach(input => input.remove());
          
          // Add new hidden input with combined value
          const hiddenInput = document.createElement('input');
          hiddenInput.type = 'hidden';
          hiddenInput.name = fieldName;
          hiddenInput.value = combinedValue;
          group.appendChild(hiddenInput);
          
          // Remove array inputs from submission (they're just for UI)
          textareas.forEach(ta => {
            ta.removeAttribute('name');
          });
        });
      });
    });
    
    function confirmCreateEntry(form) {
      const message = `⚠️ CREATE ENTRY CONFIRMATION\n\nAre you sure you want to create this new ISQM entry?\n\nPlease verify all information is correct before submitting.`;
      return confirm(message);
    }
    
    function confirmCancelCreate() {
      const message = `⚠️ CANCEL CREATION\n\nAre you sure you want to cancel?\n\nAny entered data will be lost.`;
      return confirm(message);
    }
    
    // Show selected files
    const fileInput = document.getElementById('file-input');
    const fileList = document.getElementById('file-list');
    const fileNames = document.getElementById('file-names');
    
    if (fileInput) {
      fileInput.addEventListener('change', function(e) {
        const files = Array.from(e.target.files);
        if (files.length > 0) {
          fileNames.innerHTML = '';
          files.forEach((file, index) => {
            const li = document.createElement('li');
            li.style.padding = '4px 0';
            li.innerHTML = `<span style="color:#059669;">✓</span> ${file.name} <span style="color:#64748b;">(${(file.size / 1024).toFixed(2)} KB)</span>`;
            fileNames.appendChild(li);
          });
          fileList.style.display = 'block';
        } else {
          fileList.style.display = 'none';
        }
      });
    }
    
    // Warn before leaving page if form has been modified
    let formChanged = false;
    document.querySelector('.create-form').addEventListener('change', function() {
      formChanged = true;
    });
    
    document.querySelector('.create-form').addEventListener('input', function() {
      formChanged = true;
    });
    
    window.addEventListener('beforeunload', function(e) {
      if (formChanged) {
        e.preventDefault();
        e.returnValue = 'You have unsaved data. Are you sure you want to leave?';
        return e.returnValue;
      }
    });
    
    document.querySelector('.create-form').addEventListener('submit', function() {
      formChanged = false;
    });
  </script>
</x-layouts.app>
