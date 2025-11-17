@php($title = 'Notifications')
<x-layouts.app :title="$title">
  <div class="topbar">
    <h2>{{ $title }}</h2>
    <div style="display:flex;gap:8px;">
      @if(auth()->user()->unreadNotifications()->count() > 0)
        <form method="post" action="{{ route('notifications.mark-all-read') }}" style="display:inline;">
          @csrf
          <button type="submit" class="btn" style="background:#64748b;padding:8px 16px;font-size:13px;">Mark All Read</button>
        </form>
      @endif
    </div>
  </div>

  <div style="display:flex;gap:12px;margin-bottom:20px;">
    <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;padding:12px 16px;">
      <div style="font-size:12px;color:#64748b;margin-bottom:4px;">Total</div>
      <div style="font-size:24px;font-weight:700;color:var(--brand-blue);">{{ auth()->user()->notifications()->count() }}</div>
    </div>
    <div style="background:#fee2e2;border:1px solid #fecaca;border-radius:8px;padding:12px 16px;">
      <div style="font-size:12px;color:#991b1b;margin-bottom:4px;">Unread</div>
      <div style="font-size:24px;font-weight:700;color:#991b1b;">{{ auth()->user()->unreadNotifications()->count() }}</div>
    </div>
    <div style="background:#d1fae5;border:1px solid #86efac;border-radius:8px;padding:12px 16px;">
      <div style="font-size:12px;color:#065f46;margin-bottom:4px;">Read</div>
      <div style="font-size:24px;font-weight:700;color:#065f46;">{{ auth()->user()->readNotifications()->count() }}</div>
    </div>
  </div>

  @if($notifications->count() > 0)
    <div style="overflow:auto;background:#fff;border:1px solid #e2e8f0;border-radius:8px;">
      <div style="padding:0;">
        @foreach ($notifications as $n)
          <div style="padding:16px;border-bottom:1px solid #e2e8f0;display:flex;justify-content:space-between;align-items:start;transition:background 0.2s;{{ $n->read_at ? '' : 'background:#fef3c7;' }}" onmouseover="this.style.background='{{ $n->read_at ? '#f8fafc' : '#fef3c7' }}'" onmouseout="this.style.background='{{ $n->read_at ? '' : '#fef3c7' }}'">
            <div style="flex:1;">
              @if(!$n->read_at)
                <span style="display:inline-block;width:8px;height:8px;background:#ef4444;border-radius:50%;margin-right:8px;"></span>
              @endif
              <div style="font-weight:600;margin-bottom:4px;color:#1e293b;">
                {{ data_get($n->data, 'title', data_get($n->data, 'quality_objective', 'Notification')) }}
              </div>
              <div style="font-size:13px;color:#64748b;margin-bottom:8px;line-height:1.5;">
                @if(data_get($n->data, 'entry_id'))
                  <a href="{{ route('isqm.show', data_get($n->data, 'entry_id')) }}" style="color:var(--brand-blue);text-decoration:none;">
                    Entry #{{ data_get($n->data, 'entry_id') }}
                  </a>
                  @if(data_get($n->data, 'area'))
                    • {{ str_replace('_', ' ', data_get($n->data, 'area')) }}
                  @endif
                @endif
              </div>
              <div style="font-size:12px;color:#94a3b8;">
                {{ $n->created_at->diffForHumans() }} • {{ $n->created_at->format('M d, Y H:i') }}
              </div>
            </div>
            <div style="margin-left:16px;">
              @if(is_null($n->read_at))
                <form method="post" action="{{ route('notifications.read', $n->id) }}">
                  @csrf
                  <button type="submit" class="btn" style="padding:6px 12px;font-size:12px;">Mark Read</button>
                </form>
              @else
                <span style="font-size:12px;color:#16a34a;padding:4px 8px;background:#d1fae5;border-radius:6px;">Read</span>
              @endif
            </div>
          </div>
        @endforeach
      </div>
    </div>
    <div style="margin-top:16px;display:flex;justify-content:center;">
      {{ $notifications->links() }}
    </div>
  @else
    <div style="text-align:center;padding:60px 20px;background:#fff;border:1px solid #e2e8f0;border-radius:8px;">
      <div style="font-size:48px;margin-bottom:16px;">📭</div>
      <h3 style="margin:0 0 8px;color:#1e293b;">No notifications</h3>
      <p style="color:#64748b;margin:0;">You're all caught up!</p>
    </div>
  @endif
</x-layouts.app>
