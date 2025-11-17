@php($title = 'Edit User')
<x-layouts.app :title="$title">
  <div style="max-width:600px;margin:0 auto;">
    <div class="topbar" style="margin-bottom:24px;">
      <h2 style="margin:0;">Edit User: {{ $user->name }}</h2>
      <a href="{{ route('users.index') }}" class="btn" style="background:#64748b;">Cancel</a>
    </div>

    <form method="post" 
          action="{{ route('users.update', $user) }}"
          class="edit-form"
          onsubmit="return confirmSaveChanges('user', '{{ $user->name }}')">
      @csrf
      @method('put')
      <div style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:24px;">
        <div style="margin-bottom:20px;">
          <label style="display:block;margin-bottom:8px;font-weight:600;color:#334155;">Full Name *</label>
          <input type="text" name="name" value="{{ old('name', $user->name) }}" required style="width:100%;padding:12px;border:2px solid #e2e8f0;border-radius:6px;">
        </div>

        <div style="margin-bottom:20px;">
          <label style="display:block;margin-bottom:8px;font-weight:600;color:#334155;">Email Address *</label>
          <input type="email" name="email" value="{{ old('email', $user->email) }}" required style="width:100%;padding:12px;border:2px solid #e2e8f0;border-radius:6px;">
        </div>

        <div style="margin-bottom:20px;">
          <label style="display:block;margin-bottom:8px;font-weight:600;color:#334155;">New Password</label>
          <input type="password" name="password" style="width:100%;padding:12px;border:2px solid #e2e8f0;border-radius:6px;">
          <div style="font-size:12px;color:#64748b;margin-top:4px;">Leave blank to keep current password. Minimum 8 characters if changing.</div>
        </div>

        <div style="margin-bottom:20px;">
          <label style="display:block;margin-bottom:8px;font-weight:600;color:#334155;">Confirm Password</label>
          <input type="password" name="password_confirmation" style="width:100%;padding:12px;border:2px solid #e2e8f0;border-radius:6px;">
        </div>

        <div style="margin-bottom:20px;">
          <label style="display:block;margin-bottom:8px;font-weight:600;color:#334155;">Role *</label>
          <select name="role" required style="width:100%;padding:12px;border:2px solid #e2e8f0;border-radius:6px;">
            <option value="staff" @selected(old('role', $user->role) === 'staff')>Staff</option>
            <option value="manager" @selected(old('role', $user->role) === 'manager')>Manager</option>
            <option value="admin" @selected(old('role', $user->role) === 'admin')>Admin</option>
          </select>
        </div>

        @if($errors->any())
          <div style="background:#fee2e2;color:#991b1b;padding:12px;border-radius:6px;margin-bottom:20px;">
            <ul style="list-style:none;padding:0;margin:0;">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <div style="display:flex;gap:12px;margin-top:24px;">
          <button type="submit" class="btn save-btn">Update User</button>
          <a href="{{ route('users.index') }}" 
             class="btn cancel-link" 
             style="background:#64748b;"
             onclick="return confirmCancelEdit()">Cancel</a>
        </div>
      </div>
    </form>
  </div>
  
  <script>
    function confirmSaveChanges(type, itemName) {
      const message = `⚠️ SAVE CHANGES CONFIRMATION\n\nAre you sure you want to save changes to ${type} "${itemName}"?\n\nAll modifications will be permanently updated.\n\n⚠️ Note: Changing user role may affect their access permissions.`;
      return confirm(message);
    }
    
    function confirmCancelEdit() {
      const message = `⚠️ CANCEL EDITING\n\nAre you sure you want to cancel?\n\nAny unsaved changes will be lost.`;
      return confirm(message);
    }
    
    // Warn before leaving page if form has been modified
    let formChanged = false;
    document.querySelector('.edit-form').addEventListener('change', function() {
      formChanged = true;
    });
    
    document.querySelector('.edit-form').addEventListener('input', function() {
      formChanged = true;
    });
    
    window.addEventListener('beforeunload', function(e) {
      if (formChanged) {
        e.preventDefault();
        e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
        return e.returnValue;
      }
    });
    
    document.querySelector('.edit-form').addEventListener('submit', function() {
      formChanged = false;
    });
  </script>
</x-layouts.app>

