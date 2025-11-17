@php($title = 'ISQM Register')
@php($areas = [
  'governance_and_leadership' => 'Governance and leadership',
  'ethical_requirements' => 'Ethical requirements',
  'acceptance_and_continuance' => 'Acceptance and continuance',
  'engagement_performance' => 'Engagement performance',
  'resources' => 'Resources',
  'information_and_communication' => 'Information and communication',
])
<x-layouts.app :title="$title">
  <section style="margin-bottom:20px;">
    <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;margin-bottom:12px;">
      <h2 style="margin:0;color:#0f172a;font-size:22px;">Filters</h2>
      <a href="{{ route('isqm.compliance') }}" class="btn" style="background:#1e3a8a;">Compliance Now</a>
    </div>
    <form method="get" action="{{ route('isqm.index') }}" style="display:grid;grid-template-columns:2fr 1fr 1fr 1fr auto;gap:8px;align-items:end;padding:16px;background:#f8fafc;border-radius:10px;border:1px solid #e2e8f0;">
    <div>
      <label style="display:block;margin-bottom:4px;font-size:12px;font-weight:600;color:#475569;">Search</label>
      <input type="text" name="search" value="{{ request('search') }}" placeholder="Search objectives, risks, findings..." style="width:100%;padding:8px;border:1px solid #d1d5db;border-radius:6px;">
    </div>
    <div>
      <label style="display:block;margin-bottom:4px;font-size:12px;font-weight:600;color:#475569;">Area</label>
      <select name="area" style="width:100%;padding:8px;border:1px solid #d1d5db;border-radius:6px;">
        <option value="">All Areas</option>
        @foreach ($areas as $key => $label)
          <option value="{{ $key }}" @selected(request('area') === $key)>{{ $label }}</option>
        @endforeach
      </select>
    </div>
    <div>
      <label style="display:block;margin-bottom:4px;font-size:12px;font-weight:600;color:#475569;">Status</label>
      <select name="status" style="width:100%;padding:8px;border:1px solid #d1d5db;border-radius:6px;">
        <option value="">All Status</option>
        <option value="open" @selected(request('status') === 'open')>Open</option>
        <option value="monitoring" @selected(request('status') === 'monitoring')>Monitoring</option>
        <option value="closed" @selected(request('status') === 'closed')>Closed</option>
      </select>
    </div>
    <div>
      <label style="display:block;margin-bottom:4px;font-size:12px;font-weight:600;color:#475569;">Client</label>
      <select name="client_id" style="width:100%;padding:8px;border:1px solid #d1d5db;border-radius:6px;">
        <option value="">All Clients</option>
        @foreach ($clients as $c)
          <option value="{{ $c->id }}" @selected(request('client_id') == $c->id)>{{ $c->name }}</option>
        @endforeach
      </select>
    </div>
    <div style="display:flex;gap:8px;">
      <button class="btn">Filter</button>
      <a href="{{ route('isqm.index') }}" class="btn" style="background:#64748b;">Clear</a>
    </div>
    </form>
  </section>

  <div class="topbar">
    <h2>ISQM Register</h2>
    <div style="display:flex;gap:8px;">
      <a class="btn" href="{{ route('isqm.import.form') }}" style="background:#64748b;">Import Excel</a>
      <a class="btn" href="{{ route('isqm.create', ['return_to' => request()->fullUrl()]) }}">Add Entry</a>
    </div>
  </div>

  <div id="bulk-actions" style="display:none;padding:12px;background:#fef3c7;border:1px solid #fde047;border-radius:6px;margin-bottom:16px;">
    <form id="bulk-form" method="post" action="{{ route('isqm.bulk.update') }}" class="bulk-action-form">
      @csrf
      <input type="hidden" name="ids" id="bulk-ids">
      <div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
        <span id="bulk-count" style="font-weight:600;"></span>
        <select name="action" id="bulk-action" required style="padding:6px 10px;border:1px solid #d1d5db;border-radius:6px;">
          <option value="">Select action...</option>
          <option value="status_update">Change Status</option>
          <option value="delete">Delete Selected</option>
        </select>
        <select name="status" id="bulk-status" style="display:none;padding:6px 10px;border:1px solid #d1d5db;border-radius:6px;">
          <option value="open">Open</option>
          <option value="monitoring">Monitoring</option>
          <option value="closed">Closed</option>
        </select>
        <button type="submit" class="btn bulk-submit-btn" style="padding:6px 12px;font-size:13px;">Apply</button>
        <button type="button" onclick="clearSelection()" style="padding:6px 12px;background:#64748b;color:#fff;border:0;border-radius:6px;cursor:pointer;font-size:13px;">Cancel</button>
      </div>
    </form>
  </div>

  @if (session('status'))
    <div style="padding:12px;background:#d1fae5;border:1px solid #86efac;border-radius:6px;margin-bottom:16px;color:#065f46;">
      {{ session('status') }}
    </div>
  @endif

  @if(request('overdue'))
    <div style="padding:12px;background:#fee2e2;border:1px solid #fecaca;border-radius:6px;margin-bottom:16px;">
      <strong>Showing overdue items only</strong> | <a href="{{ route('isqm.index') }}" style="color:#991b1b;">Show all</a>
    </div>
  @endif

  <div style="overflow:auto;background:#fff;border:1px solid #e2e8f0;border-radius:8px;">
    <table style="width:100%;border-collapse:collapse;font-size:14px;">
      <thead>
        <tr>
          <th style="text-align:left;background:#f8fafc;position:sticky;top:0;padding:10px 8px;border-bottom:1px solid #e2e8f0;">
            <input type="checkbox" id="select-all" onchange="toggleAll(this)">
          </th>
          <th style="text-align:left;background:#f8fafc;position:sticky;top:0;padding:10px 8px;border-bottom:1px solid #e2e8f0;">ID</th>
          <th style="text-align:left;background:#f8fafc;position:sticky;top:0;padding:10px 8px;border-bottom:1px solid #e2e8f0;">Area</th>
          <th style="text-align:left;background:#f8fafc;position:sticky;top:0;padding:10px 8px;border-bottom:1px solid #e2e8f0;">Quality Objective</th>
          <th style="text-align:left;background:#f8fafc;position:sticky;top:0;padding:10px 8px;border-bottom:1px solid #e2e8f0;">Status</th>
          <th style="text-align:left;background:#f8fafc;position:sticky;top:0;padding:10px 8px;border-bottom:1px solid #e2e8f0;">Due Date</th>
          <th style="text-align:left;background:#f8fafc;position:sticky;top:0;padding:10px 8px;border-bottom:1px solid #e2e8f0;">Client</th>
          <th style="text-align:left;background:#f8fafc;position:sticky;top:0;padding:10px 8px;border-bottom:1px solid #e2e8f0;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($entries as $e)
          <tr style="transition:background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
            <td style="padding:10px 8px;border-bottom:1px solid #e2e8f0;">
              <input type="checkbox" class="entry-checkbox" value="{{ $e->id }}" onchange="updateBulkActions()">
            </td>
            <td style="padding:10px 8px;border-bottom:1px solid #e2e8f0;color:#64748b;">#{{ $e->id }}</td>
            <td style="padding:10px 8px;border-bottom:1px solid #e2e8f0;">{{ str_replace('_',' ', $e->area) }}</td>
            <td style="padding:10px 8px;border-bottom:1px solid #e2e8f0;">
              <a href="{{ route('isqm.show', ['isqm' => $e, 'return_to' => request()->fullUrl()]) }}" class="btn" style="padding:6px 10px;font-size:12px;background:#64748b;">View</a>
            </td>
            <td style="padding:10px 8px;border-bottom:1px solid #e2e8f0;">
              <span style="font-size:12px;padding:4px 8px;border-radius:12px;display:inline-block;font-weight:500;
                @if($e->status === 'open') background:#fef3c7;color:#92400e;
                @elseif($e->status === 'monitoring') background:#dbeafe;color:#1e40af;
                @else background:#d1fae5;color:#065f46;
                @endif">
                {{ ucfirst($e->status) }}
              </span>
            </td>
            <td style="padding:10px 8px;border-bottom:1px solid #e2e8f0;">
              @if($e->due_date)
                @if($e->due_date->isPast() && $e->status !== 'closed')
                  <span style="color:#ef4444;font-weight:600;">Overdue: {{ $e->due_date->format('M d, Y') }}</span>
                @else
                  {{ $e->due_date->format('M d, Y') }}
                @endif
              @else
                <span style="color:#94a3b8;">—</span>
              @endif
            </td>
            <td style="padding:10px 8px;border-bottom:1px solid #e2e8f0;">
              {{ $e->client?->name ?? '—' }}
            </td>
            <td style="padding:10px 8px;border-bottom:1px solid #e2e8f0;">
              <div style="display:flex;gap:6px;">
                <a href="{{ route('isqm.show', ['isqm' => $e, 'return_to' => request()->fullUrl()]) }}" class="btn" style="padding:6px 10px;font-size:12px;background:#64748b;">View</a>
                <a href="{{ route('isqm.edit', ['isqm' => $e, 'return_to' => request()->fullUrl()]) }}" 
                   class="btn edit-link" 
                   style="padding:6px 10px;font-size:12px;"
                   onclick="return confirmAction('⚠️ EDIT ENTRY\n\nYou are about to edit entry #{{ $e->id }}.\n\nDo you want to continue?', 'edit')">Edit</a>
                <form style="display:inline" 
                      method="post" 
                      action="{{ route('isqm.destroy', $e) }}" 
                      class="delete-form"
                      data-item-id="{{ $e->id }}"
                      data-item-name="entry #{{ $e->id }}">
                  @csrf @method('delete')
                  <input type="hidden" name="return_to" value="{{ request()->fullUrl() }}">
                  <button type="submit" 
                          class="btn delete-btn" 
                          style="padding:6px 10px;font-size:12px;background:#ef4444;"
                          onclick="return confirmDelete(this)">Delete</button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" style="padding:40px;text-align:center;color:#64748b;">
              No entries found. <a href="{{ route('isqm.create') }}" style="color:var(--brand-blue);">Create your first entry</a>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if($entries->hasPages())
    <div style="margin-top:16px;display:flex;justify-content:center;">
      {{ $entries->links() }}
    </div>
  @endif

  <div style="margin-top:16px;padding:12px;background:#f8fafc;border-radius:6px;font-size:13px;color:#64748b;">
    Showing {{ $entries->firstItem() ?? 0 }} to {{ $entries->lastItem() ?? 0 }} of {{ $entries->total() }} entries
  </div>

  <script>
    function toggleAll(checkbox) {
      document.querySelectorAll('.entry-checkbox').forEach(cb => cb.checked = checkbox.checked);
      updateBulkActions();
    }
    function updateBulkActions() {
      const checked = Array.from(document.querySelectorAll('.entry-checkbox:checked')).map(cb => cb.value);
      const bulkDiv = document.getElementById('bulk-actions');
      const bulkIds = document.getElementById('bulk-ids');
      const bulkCount = document.getElementById('bulk-count');
      const bulkStatus = document.getElementById('bulk-status');
      
      if (checked.length > 0) {
        bulkDiv.style.display = 'block';
        bulkIds.value = JSON.stringify(checked);
        bulkCount.textContent = checked.length + ' selected';
      } else {
        bulkDiv.style.display = 'none';
      }
    }
    function clearSelection() {
      document.querySelectorAll('.entry-checkbox').forEach(cb => cb.checked = false);
      document.getElementById('select-all').checked = false;
      updateBulkActions();
    }
    document.getElementById('bulk-action').addEventListener('change', function() {
      document.getElementById('bulk-status').style.display = this.value === 'status_update' ? 'inline-block' : 'none';
    });
    
    // Confirmation functions
    function confirmDelete(button) {
      const form = button.closest('form');
      const itemName = form.getAttribute('data-item-name') || 'this item';
      const itemId = form.getAttribute('data-item-id') || '';
      const message = `⚠️ DELETE CONFIRMATION\n\nAre you sure you want to delete ${itemName}?\n\n⚠️ This action cannot be undone.\n\nAll associated data will be permanently removed.`;
      return confirm(message);
    }
    
    // Bulk action confirmation
    document.getElementById('bulk-form').addEventListener('submit', function(e) {
      const action = document.getElementById('bulk-action').value;
      const ids = JSON.parse(document.getElementById('bulk-ids').value || '[]');
      const count = ids.length;
      
      if (action === 'delete') {
        const message = `⚠️ BULK DELETE CONFIRMATION\n\nAre you sure you want to delete ${count} selected entr${count === 1 ? 'y' : 'ies'}?\n\n⚠️ This action cannot be undone.\n\nAll selected entries and their associated data will be permanently removed.`;
        if (!confirm(message)) {
          e.preventDefault();
          return false;
        }
      } else if (action === 'status_update') {
        const status = document.getElementById('bulk-status').value;
        const message = `⚠️ BULK UPDATE CONFIRMATION\n\nAre you sure you want to change the status of ${count} selected entr${count === 1 ? 'y' : 'ies'} to "${status}"?\n\nThis will update the status of all selected entries.`;
        if (!confirm(message)) {
          e.preventDefault();
          return false;
        }
      }
    });
  </script>
</x-layouts.app>
