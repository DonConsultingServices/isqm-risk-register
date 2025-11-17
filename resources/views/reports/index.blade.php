@php($title = 'Reports')
<x-layouts.app :title="$title">
  <div class="topbar">
    <h2>{{ $title }}</h2>
    <div style="display:flex;gap:8px;">
      <a class="btn" href="{{ route('reports.export') }}?{{ request()->getQueryString() }}" style="background:#64748b;">Export CSV</a>
      <a class="btn" href="{{ route('reports.export.excel') }}?{{ request()->getQueryString() }}">Export Excel</a>
    </div>
  </div>
  <form method="get" style="display:grid;grid-template-columns:repeat(5,1fr);gap:8px;align-items:end;margin-bottom:12px;">
    <div>
      <label>Area</label>
      <select name="area" style="width:100%;padding:8px;border:1px solid #d1d5db;border-radius:6px;">
        <option value="">All</option>
        @foreach (['governance_and_leadership','ethical_requirements','acceptance_and_continuance','engagement_performance','resources','information_and_communication'] as $a)
          <option value="{{ $a }}" @selected(request('area') === $a)>{{ str_replace('_',' ',$a) }}</option>
        @endforeach
      </select>
    </div>
    <div>
      <label>Status</label>
      <select name="status" style="width:100%;padding:8px;border:1px solid #d1d5db;border-radius:6px;">
        <option value="">All</option>
        @foreach (['open','monitoring','closed'] as $s)
          <option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst($s) }}</option>
        @endforeach
      </select>
    </div>
    <div>
      <label>Due from</label>
      <input type="date" name="due_from" value="{{ request('due_from') }}" style="width:100%;padding:8px;border:1px solid #d1d5db;border-radius:6px;">
    </div>
    <div>
      <label>Due to</label>
      <input type="date" name="due_to" value="{{ request('due_to') }}" style="width:100%;padding:8px;border:1px solid #d1d5db;border-radius:6px;">
    </div>
    <div>
      <button class="btn">Filter</button>
    </div>
  </form>
  <div style="display:flex;gap:12px;margin-bottom:20px;flex-wrap:wrap;">
    <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;padding:12px 16px;min-width:120px;">
      <div style="font-size:12px;color:#64748b;margin-bottom:4px;">Total</div>
      <div style="font-size:24px;font-weight:700;color:var(--brand-blue);">{{ $summary['total'] }}</div>
    </div>
    <div style="background:#fef3c7;border:1px solid #fde047;border-radius:8px;padding:12px 16px;min-width:120px;">
      <div style="font-size:12px;color:#92400e;margin-bottom:4px;">Open</div>
      <div style="font-size:24px;font-weight:700;color:#92400e;">{{ $summary['open'] }}</div>
    </div>
    <div style="background:#dbeafe;border:1px solid #93c5fd;border-radius:8px;padding:12px 16px;min-width:120px;">
      <div style="font-size:12px;color:#1e40af;margin-bottom:4px;">Monitoring</div>
      <div style="font-size:24px;font-weight:700;color:#1e40af;">{{ $summary['monitoring'] }}</div>
    </div>
    <div style="background:#d1fae5;border:1px solid #86efac;border-radius:8px;padding:12px 16px;min-width:120px;">
      <div style="font-size:12px;color:#065f46;margin-bottom:4px;">Closed</div>
      <div style="font-size:24px;font-weight:700;color:#065f46;">{{ $summary['closed'] }}</div>
    </div>
    @if($summary['total'] > 0)
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:12px 16px;flex:1;min-width:200px;">
      <div style="font-size:12px;color:#64748b;margin-bottom:8px;">Status Distribution</div>
      <div style="display:flex;gap:4px;height:24px;border-radius:4px;overflow:hidden;">
        <div style="background:#fef3c7;flex:{{ $summary['open'] / $summary['total'] * 100 }}%;" title="Open: {{ $summary['open'] }}"></div>
        <div style="background:#dbeafe;flex:{{ $summary['monitoring'] / $summary['total'] * 100 }}%;" title="Monitoring: {{ $summary['monitoring'] }}"></div>
        <div style="background:#d1fae5;flex:{{ $summary['closed'] / $summary['total'] * 100 }}%;" title="Closed: {{ $summary['closed'] }}"></div>
      </div>
    </div>
    @endif
  </div>
  <div style="overflow:auto;background:#fff;border:1px solid #e2e8f0;border-radius:8px;">
    <table style="width:100%;border-collapse:collapse;font-size:14px;">
      <thead>
        <tr>
          <th style="text-align:left;background:#f8fafc;padding:12px;border-bottom:1px solid #e2e8f0;">ID</th>
          <th style="text-align:left;background:#f8fafc;padding:12px;border-bottom:1px solid #e2e8f0;">Area</th>
          <th style="text-align:left;background:#f8fafc;padding:12px;border-bottom:1px solid #e2e8f0;">Status</th>
          <th style="text-align:left;background:#f8fafc;padding:12px;border-bottom:1px solid #e2e8f0;">Due</th>
          <th style="text-align:left;background:#f8fafc;padding:12px;border-bottom:1px solid #e2e8f0;">Quality Objective</th>
          <th style="text-align:left;background:#f8fafc;padding:12px;border-bottom:1px solid #e2e8f0;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($entries as $e)
          <tr style="transition:background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
            <td style="padding:12px;border-bottom:1px solid #e2e8f0;color:#64748b;">#{{ $e->id }}</td>
            <td style="padding:12px;border-bottom:1px solid #e2e8f0;">{{ str_replace('_',' ',$e->area) }}</td>
            <td style="padding:12px;border-bottom:1px solid #e2e8f0;">
              <span style="padding:4px 8px;border-radius:6px;font-size:12px;font-weight:500;
                @if($e->status === 'open') background:#fef3c7;color:#92400e;
                @elseif($e->status === 'monitoring') background:#dbeafe;color:#1e40af;
                @else background:#d1fae5;color:#065f46;
                @endif">
                {{ ucfirst($e->status) }}
              </span>
            </td>
            <td style="padding:12px;border-bottom:1px solid #e2e8f0;">
              @if($e->due_date)
                @if($e->due_date->isPast() && $e->status !== 'closed')
                  <span style="color:#ef4444;font-weight:600;">Overdue</span>
                @else
                  {{ $e->due_date->format('M d, Y') }}
                @endif
              @else
                <span style="color:#94a3b8;">—</span>
              @endif
            </td>
            <td style="padding:12px;border-bottom:1px solid #e2e8f0;">
              <a href="{{ route('isqm.show', $e) }}" style="color:var(--brand-blue);text-decoration:none;">{{ Str::limit($e->quality_objective, 100) }}</a>
            </td>
            <td style="padding:12px;border-bottom:1px solid #e2e8f0;">
              <a href="{{ route('isqm.show', $e) }}" class="btn" style="padding:6px 10px;font-size:12px;background:#64748b;">View</a>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" style="padding:40px;text-align:center;color:#64748b;">
              No entries found with the selected filters.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div style="margin-top:12px;">{{ $entries->links() }}</div>
</x-layouts.app>

