@php($title = 'Trashed ISQM Entries')
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
    </div>
    <form method="get" action="{{ route('isqm.trashed') }}" style="display:grid;grid-template-columns:2fr 1fr 1fr 1fr auto;gap:8px;align-items:end;padding:16px;background:#f8fafc;border-radius:10px;border:1px solid #e2e8f0;">
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
      <a href="{{ route('isqm.trashed') }}" class="btn" style="background:#64748b;">Clear</a>
    </div>
    </form>
  </section>

  <div class="topbar">
    <h2>Trashed ISQM Entries</h2>
    <div style="display:flex;gap:8px;">
      <a class="btn" href="{{ route('isqm.index') }}" style="background:#64748b;">Back to Register</a>
    </div>
  </div>

  @if (session('status'))
    <div style="padding:12px;background:#d1fae5;border:1px solid #86efac;border-radius:6px;margin-bottom:16px;color:#065f46;">
      {{ session('status') }}
    </div>
  @endif

  <div style="padding:12px;background:#fef3c7;border:1px solid #fde047;border-radius:6px;margin-bottom:16px;color:#92400e;">
    <strong>⚠️ Warning:</strong> These entries have been deleted. You can restore them or permanently delete them. Only admins can permanently delete entries.
  </div>

  <div style="overflow:auto;background:#fff;border:1px solid #e2e8f0;border-radius:8px;">
    <table style="width:100%;border-collapse:collapse;font-size:14px;">
      <thead>
        <tr>
          <th style="text-align:left;background:#f8fafc;position:sticky;top:0;padding:10px 8px;border-bottom:1px solid #e2e8f0;">ID</th>
          <th style="text-align:left;background:#f8fafc;position:sticky;top:0;padding:10px 8px;border-bottom:1px solid #e2e8f0;">Area</th>
          <th style="text-align:left;background:#f8fafc;position:sticky;top:0;padding:10px 8px;border-bottom:1px solid #e2e8f0;">Quality Objective</th>
          <th style="text-align:left;background:#f8fafc;position:sticky;top:0;padding:10px 8px;border-bottom:1px solid #e2e8f0;">Status</th>
          <th style="text-align:left;background:#f8fafc;position:sticky;top:0;padding:10px 8px;border-bottom:1px solid #e2e8f0;">Deleted At</th>
          <th style="text-align:left;background:#f8fafc;position:sticky;top:0;padding:10px 8px;border-bottom:1px solid #e2e8f0;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($entries as $e)
          <tr style="transition:background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
            <td style="padding:10px 8px;border-bottom:1px solid #e2e8f0;color:#64748b;">#{{ $e->id }}</td>
            <td style="padding:10px 8px;border-bottom:1px solid #e2e8f0;">{{ str_replace('_',' ', $e->area) }}</td>
            <td style="padding:10px 8px;border-bottom:1px solid #e2e8f0;">
              <div style="max-width:300px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ \Illuminate\Support\Str::limit($e->quality_objective, 100) }}">
                {{ \Illuminate\Support\Str::limit($e->quality_objective, 60) }}
              </div>
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
            <td style="padding:10px 8px;border-bottom:1px solid #e2e8f0;color:#64748b;">
              {{ $e->deleted_at->format('M d, Y H:i') }}
            </td>
            <td style="padding:10px 8px;border-bottom:1px solid #e2e8f0;">
              <div style="display:flex;gap:6px;">
                <form style="display:inline" 
                      method="post" 
                      action="{{ route('isqm.restore', $e->id) }}" 
                      onsubmit="return confirm('Are you sure you want to restore entry #{{ $e->id }}?');">
                  @csrf
                  <button type="submit" 
                          class="btn" 
                          style="padding:6px 10px;font-size:12px;background:#10b981;">Restore</button>
                </form>
                @if(auth()->user()->role === 'admin')
                  <form style="display:inline" 
                        method="post" 
                        action="{{ route('isqm.force-delete', $e->id) }}" 
                        onsubmit="return confirm('⚠️ PERMANENT DELETE\n\nAre you sure you want to PERMANENTLY delete entry #{{ $e->id }}?\n\n⚠️ This action CANNOT be undone.\n\nAll data and files will be permanently removed.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="btn" 
                            style="padding:6px 10px;font-size:12px;background:#ef4444;">Permanently Delete</button>
                  </form>
                @endif
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" style="padding:40px;text-align:center;color:#64748b;">
              No trashed entries found.
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
    Showing {{ $entries->firstItem() ?? 0 }} to {{ $entries->lastItem() ?? 0 }} of {{ $entries->total() }} trashed entries
  </div>
</x-layouts.app>

