@php($title = 'Dashboard')
<x-layouts.app :title="$title" :showDashboardTopbar="true" :heading="$title">
  <style>
    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px; }
    .stat-card { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 16px; }
    .stat-card h4 { margin: 0 0 8px; font-size: 14px; color: #64748b; font-weight: 500; }
    .stat-card .number { font-size: 32px; font-weight: 700; color: var(--brand-blue); }
    .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
    .card { background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 16px; }
    .card h3 { margin: 0 0 12px; font-size: 16px; font-weight: 600; }
    table { width: 100%; border-collapse: collapse; font-size: 14px; }
    th, td { text-align: left; padding: 8px; border-bottom: 1px solid #e2e8f0; }
    th { font-weight: 600; color: #475569; background: #f8fafc; }
    .badge { display: inline-block; padding: 2px 8px; border-radius: 12px; font-size: 12px; font-weight: 500; }
    .badge-open { background: #fef3c7; color: #92400e; }
    .badge-monitoring { background: #dbeafe; color: #1e40af; }
    .badge-overdue { background: #fee2e2; color: #991b1b; }
  </style>

  <div data-dashboard data-endpoint="{{ route('api.dashboard') }}">
  <div class="stats-grid">
    <div class="stat-card">
      <h4>Total Entries</h4>
      <div class="number" data-dashboard-stat="total_entries">{{ $stats['total_entries'] }}</div>
    </div>
    <div class="stat-card">
      <h4>Open Items</h4>
      <div class="number" data-dashboard-stat="open_entries">{{ $stats['open_entries'] }}</div>
    </div>
    <div class="stat-card">
      <h4>Monitoring</h4>
      <div class="number" data-dashboard-stat="monitoring_entries">{{ $stats['monitoring_entries'] }}</div>
    </div>
    <div class="stat-card">
      <h4>Overdue</h4>
      <div class="number" style="color:#ef4444;" data-dashboard-stat="overdue">{{ $stats['overdue'] }}</div>
    </div>
    <div class="stat-card">
      <h4>Due Soon</h4>
      <div class="number" style="color:#f59e0b;" data-dashboard-stat="due_soon">{{ $stats['due_soon'] }}</div>
    </div>
    <div class="stat-card">
      <h4>Total Clients</h4>
      <div class="number" data-dashboard-stat="total_clients">{{ $stats['total_clients'] }}</div>
    </div>
  </div>

  <div class="card" style="margin-top:24px;">
    <h3>Entries by Area</h3>
    <table>
      <thead>
        <tr>
          <th>Area</th>
          <th>Total</th>
          <th>Open</th>
          <th>Monitoring</th>
          <th>Closed</th>
        </tr>
      </thead>
      <tbody data-dashboard-modules-table>
        @foreach($byArea as $area)
          <tr>
            <td><strong>{{ $area->module_name }}</strong></td>
            <td><strong>{{ $area->count }}</strong></td>
            <td><span style="color:#92400e;">{{ $area->open_count }}</span></td>
            <td><span style="color:#1e40af;">{{ $area->monitoring_count }}</span></td>
            <td><span style="color:#065f46;">{{ $area->count - $area->open_count - $area->monitoring_count }}</span></td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  @if($byArea->count() > 0)
  <div class="card" style="margin-top:24px;">
    <h3>Visual Summary</h3>
    <div data-dashboard-modules-summary style="display:grid;grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));gap:16px;margin-top:16px;">
      @foreach($byArea as $area)
        <div style="padding:16px;background:#f8fafc;border-radius:8px;border-left:4px solid var(--brand-blue);">
          <div style="font-size:12px;color:#64748b;margin-bottom:8px;">{{ $area->module_name }}</div>
          <div style="font-size:28px;font-weight:700;color:var(--brand-blue);margin-bottom:8px;">{{ $area->count }}</div>
          <div style="display:flex;gap:12px;font-size:12px;">
            <span style="color:#92400e;">{{ $area->open_count }} open</span>
            <span style="color:#1e40af;">{{ $area->monitoring_count }} monitoring</span>
          </div>
          @if($area->count > 0)
            <div style="margin-top:8px;height:4px;background:#e2e8f0;border-radius:2px;overflow:hidden;">
              <div style="height:100%;background:var(--brand-blue);width:{{ ($area->open_count / $area->count) * 100 }}%;"></div>
            </div>
          @endif
        </div>
      @endforeach
    </div>
  </div>
  @endif

  <div class="card" style="margin-top:24px;">
    <h3>Recent Open Items &amp; Notifications</h3>
    <div style="display:grid;grid-template-columns:1fr 320px;gap:20px;align-items:start;">
      <div>
        @if($recentOpen->count() > 0)
          <table data-dashboard-recent-table>
            <thead>
              <tr>
                <th>Area</th>
                <th>Objective</th>
                <th>Status</th>
                <th>Due</th>
              </tr>
            </thead>
            <tbody>
              @foreach($recentOpen as $entry)
                <tr>
                  <td>{{ $entry->module?->name ?? '—' }}</td>
                  <td><a href="{{ route('isqm.edit', $entry) }}" style="color:var(--brand-blue);text-decoration:none;">{{ Str::limit($entry->quality_objective, 50) }}</a></td>
                  <td>
                    <span class="badge badge-{{ $entry->status }}">
                      {{ ucfirst($entry->status) }}
                    </span>
                  </td>
                  <td>
                    @if($entry->due_date)
                      @if($entry->due_date->isPast() && $entry->status !== 'closed')
                        <span class="badge badge-overdue">Overdue</span>
                      @else
                        {{ $entry->due_date->format('M d, Y') }}
                      @endif
                    @else
                      —
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
          <div style="margin-top:12px;">
            <a href="{{ route('isqm.index') }}" class="btn">View All</a>
          </div>
        @else
          <p>No open items. <a href="{{ route('isqm.create') }}">Create your first entry</a></p>
        @endif
      </div>

      <div style="border-left:1px solid #e2e8f0;padding-left:16px;">
        <h4 style="margin:0 0 12px;font-size:14px;color:#475569;">Recent Notifications</h4>
        <div data-dashboard-notifications>
          @if($notifications->count() > 0)
            <ul style="list-style:none;padding:0;margin:0;">
              @foreach($notifications as $notif)
                <li style="padding:10px 0;border-bottom:1px solid #e2e8f0;">
                  <div style="font-weight:500;">{{ data_get($notif->data, 'quality_objective', 'Notification') }}</div>
                  <div style="font-size:12px;color:#64748b;">{{ $notif->created_at->diffForHumans() }}</div>
                </li>
              @endforeach
            </ul>
            <div style="margin-top:12px;">
              <a href="{{ route('notifications.index') }}" class="btn">View All</a>
            </div>
          @else
            <p style="color:#64748b;">No recent notifications.</p>
          @endif
        </div>
      </div>
    </div>
  </div>
  </div>
</x-layouts.app>
