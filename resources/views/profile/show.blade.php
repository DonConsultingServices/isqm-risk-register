@php($title = 'My Profile')
<x-layouts.app :title="$title" :showDashboardTopbar="true" :heading="$title">
  <style>
    .profile-container { max-width: 1200px; margin: 0 auto; padding: 24px; }
    .profile-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px; padding-bottom: 24px; border-bottom: 2px solid #e2e8f0; }
    .profile-header h1 { margin: 0; font-size: 28px; color: #0f172a; }
    
    .profile-grid { display: grid; grid-template-columns: 1fr 2fr; gap: 24px; margin-bottom: 32px; }
    
    .profile-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px; }
    .profile-card h2 { margin: 0 0 20px; font-size: 20px; color: #1e293b; border-bottom: 2px solid #e2e8f0; padding-bottom: 12px; }
    .profile-card h3 { margin: 0 0 16px; font-size: 18px; color: #334155; }
    
    .profile-info { display: grid; gap: 16px; }
    .info-row { display: grid; grid-template-columns: 140px 1fr; gap: 12px; padding: 12px 0; border-bottom: 1px solid #f1f5f9; }
    .info-row:last-child { border-bottom: none; }
    .info-label { color: #64748b; font-weight: 500; font-size: 14px; }
    .info-value { color: #1e293b; font-size: 14px; }
    
    .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
    .stat-card { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; text-align: center; }
    .stat-number { font-size: 32px; font-weight: 700; color: var(--brand-blue, #2563eb); margin: 0 0 8px; }
    .stat-label { font-size: 14px; color: #64748b; margin: 0; }
    
    .entries-table { width: 100%; border-collapse: collapse; font-size: 14px; }
    .entries-table th { text-align: left; padding: 12px; background: #f8fafc; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: 600; }
    .entries-table td { padding: 12px; border-bottom: 1px solid #f1f5f9; color: #334155; }
    .entries-table tr:hover { background: #f8fafc; }
    
    .activity-list { display: grid; gap: 12px; }
    .activity-item { padding: 12px; background: #f8fafc; border-left: 3px solid var(--brand-blue, #2563eb); border-radius: 4px; }
    .activity-item .activity-action { font-weight: 600; color: #1e293b; margin-bottom: 4px; }
    .activity-item .activity-time { font-size: 12px; color: #64748b; }
    
    .role-badge { display: inline-block; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600; }
    .role-badge.admin { background: #fee2e2; color: #991b1b; }
    .role-badge.manager { background: #dbeafe; color: #1e40af; }
    .role-badge.staff { background: #e2e8f0; color: #475569; }
    
    .status-badge { display: inline-block; padding: 4px 8px; border-radius: 6px; font-size: 12px; font-weight: 500; }
    .status-badge.open { background: #fef3c7; color: #92400e; }
    .status-badge.monitoring { background: #dbeafe; color: #1e40af; }
    .status-badge.closed { background: #d1fae5; color: #065f46; }
    
    .empty-state { text-align: center; padding: 40px; color: #64748b; }
    .empty-state p { margin: 8px 0; }
  </style>

  <div class="profile-container">
    <div class="profile-header">
      <h1>My Profile</h1>
      <div style="display: flex; gap: 12px;">
        <a href="{{ route('profile.edit') }}" class="btn">Edit Profile</a>
        <a href="{{ route('dashboard') }}" class="btn" style="background: #64748b;">Back to Dashboard</a>
      </div>
    </div>

    <div class="profile-grid">
      <div>
        <div class="profile-card">
          <h2>Profile Information</h2>
          <div class="profile-info">
            <div class="info-row">
              <span class="info-label">Name:</span>
              <span class="info-value">{{ $user->name }}</span>
            </div>
            <div class="info-row">
              <span class="info-label">Email:</span>
              <span class="info-value">{{ $user->email }}</span>
            </div>
            <div class="info-row">
              <span class="info-label">Role:</span>
              <span class="info-value">
                <span class="role-badge {{ $user->role }}">{{ ucfirst($user->role) }}</span>
              </span>
            </div>
            <div class="info-row">
              <span class="info-label">Member Since:</span>
              <span class="info-value">{{ $user->created_at->format('M d, Y') }}</span>
            </div>
            <div class="info-row">
              <span class="info-label">Last Updated:</span>
              <span class="info-value">{{ $user->updated_at->format('M d, Y H:i') }}</span>
            </div>
          </div>
        </div>
      </div>

      <div>
        <div class="profile-card">
          <h2>My Statistics</h2>
          <div class="stats-grid">
            <div class="stat-card">
              <div class="stat-number">{{ $totalEntries }}</div>
              <div class="stat-label">Total Entries</div>
            </div>
            <div class="stat-card">
              <div class="stat-number">{{ $openEntries }}</div>
              <div class="stat-label">Open Entries</div>
            </div>
            <div class="stat-card">
              <div class="stat-number">{{ $monitoringEntries }}</div>
              <div class="stat-label">Monitoring</div>
            </div>
            <div class="stat-card">
              <div class="stat-number">{{ $closedEntries }}</div>
              <div class="stat-label">Closed</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="profile-grid">
      <div>
        <div class="profile-card">
          <h2>Recent Entries</h2>
          @if($recentEntries->count() > 0)
            <table class="entries-table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Area</th>
                  <th>Status</th>
                  <th>Created</th>
                </tr>
              </thead>
              <tbody>
                @foreach($recentEntries as $entry)
                  <tr>
                    <td><a href="{{ route('isqm.show', $entry) }}" style="color: var(--brand-blue, #2563eb); text-decoration: none;">#{{ $entry->id }}</a></td>
                    <td>{{ $entry->area ? str_replace('_', ' ', $entry->area) : ($entry->module?->title ?? '—') }}</td>
                    <td><span class="status-badge {{ $entry->status }}">{{ ucfirst($entry->status) }}</span></td>
                    <td>{{ $entry->created_at->format('M d, Y') }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
            <div style="margin-top: 16px; text-align: center;">
              <a href="{{ route('isqm.index') }}" style="color: var(--brand-blue, #2563eb); text-decoration: none; font-size: 14px;">View All Entries →</a>
            </div>
          @else
            <div class="empty-state">
              <p>No entries yet.</p>
              <a href="{{ route('isqm.create') }}" class="btn" style="margin-top: 16px;">Create Your First Entry</a>
            </div>
          @endif
        </div>
      </div>

      <div>
        <div class="profile-card">
          <h2>Recent Activity</h2>
          @if($recentActivity->count() > 0)
            <div class="activity-list">
              @foreach($recentActivity as $activity)
                <div class="activity-item">
                  <div class="activity-action">
                    {{ ucfirst($activity->action) }} - 
                    @if($activity->model_type)
                      {{ str_replace('App\\Models\\', '', $activity->model_type) }} #{{ $activity->model_id }}
                    @else
                      System Activity
                    @endif
                  </div>
                  <div class="activity-time">{{ $activity->created_at->format('M d, Y H:i') }}</div>
                </div>
              @endforeach
            </div>
            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'manager')
              <div style="margin-top: 16px; text-align: center;">
                <a href="{{ route('activity-logs.index') }}" style="color: var(--brand-blue, #2563eb); text-decoration: none; font-size: 14px;">View All Activity →</a>
              </div>
            @endif
          @else
            <div class="empty-state">
              <p>No activity yet.</p>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</x-layouts.app>

