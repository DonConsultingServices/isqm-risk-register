@php($title = 'Users')
<x-layouts.app :title="$title">
  <div class="topbar">
    <h2>Users</h2>
    <a class="btn" href="{{ route('users.create') }}">Add User</a>
  </div>

  @if (session('status'))
    <div style="padding:12px;background:#d1fae5;border:1px solid #86efac;border-radius:6px;margin-bottom:16px;color:#065f46;">
      {{ session('status') }}
    </div>
  @endif

  <div style="overflow:auto;background:#fff;border:1px solid #e2e8f0;border-radius:8px;">
    <table style="width:100%;border-collapse:collapse;font-size:14px;">
      <thead>
        <tr>
          <th style="text-align:left;background:#f8fafc;padding:12px;border-bottom:1px solid #e2e8f0;">Name</th>
          <th style="text-align:left;background:#f8fafc;padding:12px;border-bottom:1px solid #e2e8f0;">Email</th>
          <th style="text-align:left;background:#f8fafc;padding:12px;border-bottom:1px solid #e2e8f0;">Role</th>
          <th style="text-align:left;background:#f8fafc;padding:12px;border-bottom:1px solid #e2e8f0;">Created</th>
          <th style="text-align:left;background:#f8fafc;padding:12px;border-bottom:1px solid #e2e8f0;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($users as $user)
          <tr style="transition:background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
            <td style="padding:12px;border-bottom:1px solid #e2e8f0;">
              <strong>{{ $user->name }}</strong>
              @if($user->id === auth()->id())
                <span style="font-size:11px;color:#64748b;margin-left:8px;">(You)</span>
              @endif
            </td>
            <td style="padding:12px;border-bottom:1px solid #e2e8f0;">{{ $user->email }}</td>
            <td style="padding:12px;border-bottom:1px solid #e2e8f0;">
              <span style="padding:4px 8px;border-radius:6px;font-size:12px;font-weight:500;
                @if($user->role === 'admin') background:#fee2e2;color:#991b1b;
                @elseif($user->role === 'manager') background:#dbeafe;color:#1e40af;
                @else background:#e2e8f0;color:#475569;
                @endif">
                {{ ucfirst($user->role) }}
              </span>
            </td>
            <td style="padding:12px;border-bottom:1px solid #e2e8f0;color:#64748b;">
              {{ $user->created_at->format('M d, Y') }}
            </td>
            <td style="padding:12px;border-bottom:1px solid #e2e8f0;">
              <div style="display:flex;gap:6px;">
                <a href="{{ route('users.edit', $user) }}" 
                   class="btn edit-link" 
                   style="padding:6px 10px;font-size:12px;"
                   onclick="return confirmAction('⚠️ EDIT USER\n\nYou are about to edit user: {{ $user->name }}\n\nDo you want to continue?', 'edit')">Edit</a>
                @if($user->id !== auth()->id())
                  <form style="display:inline;" 
                        method="post" 
                        action="{{ route('users.destroy', $user) }}" 
                        class="delete-form"
                        data-item-name="user '{{ $user->name }}'">
                    @csrf @method('delete')
                    <button type="submit" 
                            class="btn delete-btn" 
                            style="padding:6px 10px;font-size:12px;background:#ef4444;"
                            onclick="return confirmDeleteUser(this, '{{ $user->name }}')">Delete</button>
                  </form>
                @endif
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" style="padding:40px;text-align:center;color:#64748b;">
              No users found. <a href="{{ route('users.create') }}" style="color:var(--brand-blue);">Create the first user</a>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if($users->hasPages())
    <div style="margin-top:16px;display:flex;justify-content:center;">
      {{ $users->links() }}
    </div>
  @endif
  
  <script>
    function confirmDeleteUser(button, userName) {
      const message = `⚠️ DELETE USER CONFIRMATION\n\nAre you sure you want to delete user "${userName}"?\n\n⚠️ This action cannot be undone.\n\nAll user data and associated records will be permanently removed.\n\nThe user will no longer be able to access the system.`;
      return confirm(message);
    }
  </script>
</x-layouts.app>

