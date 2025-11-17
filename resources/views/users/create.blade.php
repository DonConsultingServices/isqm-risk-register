@php($title = 'Create User')
<x-layouts.app :title="$title">
  <div style="max-width:600px;margin:0 auto;">
    <div class="topbar" style="margin-bottom:24px;">
      <h2 style="margin:0;">Create User</h2>
      <a href="{{ route('users.index') }}" class="btn" style="background:#64748b;">Cancel</a>
    </div>

    <form method="post" 
          action="{{ route('users.store') }}"
          class="create-form"
          onsubmit="return confirmCreateUser()">
      @csrf
      <div style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:24px;">
        <div style="margin-bottom:20px;">
          <label style="display:block;margin-bottom:8px;font-weight:600;color:#334155;">Full Name *</label>
          <input type="text" name="name" value="{{ old('name') }}" required style="width:100%;padding:12px;border:2px solid #e2e8f0;border-radius:6px;">
        </div>

        <div style="margin-bottom:20px;">
          <label style="display:block;margin-bottom:8px;font-weight:600;color:#334155;">Email Address *</label>
          <input type="email" name="email" value="{{ old('email') }}" required style="width:100%;padding:12px;border:2px solid #e2e8f0;border-radius:6px;">
        </div>

        <div style="margin-bottom:20px;">
          <label style="display:block;margin-bottom:8px;font-weight:600;color:#334155;">Password *</label>
          <input type="password" name="password" required style="width:100%;padding:12px;border:2px solid #e2e8f0;border-radius:6px;">
          <div style="font-size:12px;color:#64748b;margin-top:4px;">Minimum 8 characters</div>
        </div>

        <div style="margin-bottom:20px;">
          <label style="display:block;margin-bottom:8px;font-weight:600;color:#334155;">Confirm Password *</label>
          <input type="password" name="password_confirmation" required style="width:100%;padding:12px;border:2px solid #e2e8f0;border-radius:6px;">
        </div>

        <div style="margin-bottom:20px;">
          <label style="display:block;margin-bottom:8px;font-weight:600;color:#334155;">Role *</label>
          <select name="role" required style="width:100%;padding:12px;border:2px solid #e2e8f0;border-radius:6px;">
            <option value="staff" @selected(old('role') === 'staff')>Staff</option>
            <option value="manager" @selected(old('role') === 'manager')>Manager</option>
            <option value="admin" @selected(old('role') === 'admin')>Admin</option>
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
          <button type="submit" class="btn save-btn">Create User</button>
          <a href="{{ route('users.index') }}" 
             class="btn cancel-link" 
             style="background:#64748b;"
             onclick="return confirmCancelCreate()">Cancel</a>
        </div>
      </div>
    </form>
  </div>
  
  <script>
    function confirmCreateUser() {
      const message = `⚠️ CREATE USER CONFIRMATION\n\nAre you sure you want to create this new user?\n\nPlease verify all information is correct before submitting.\n\n⚠️ Note: User role will determine their access permissions.`;
      return confirm(message);
    }
    
    function confirmCancelCreate() {
      const message = `⚠️ CANCEL CREATION\n\nAre you sure you want to cancel?\n\nAny entered data will be lost.`;
      return confirm(message);
    }
  </script>
</x-layouts.app>

