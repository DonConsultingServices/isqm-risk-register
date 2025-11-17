@php($title = 'Edit Profile')
<x-layouts.app :title="$title" :showDashboardTopbar="true" :heading="$title">
  <style>
    .profile-edit-container { max-width: 800px; margin: 0 auto; padding: 24px; }
    .profile-edit-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px; padding-bottom: 24px; border-bottom: 2px solid #e2e8f0; }
    .profile-edit-header h1 { margin: 0; font-size: 28px; color: #0f172a; }
    
    .profile-edit-form { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 32px; }
    .profile-edit-form h2 { margin: 0 0 24px; font-size: 20px; color: #1e293b; border-bottom: 2px solid #e2e8f0; padding-bottom: 12px; }
    
    .form-group { margin-bottom: 24px; }
    .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #334155; font-size: 14px; }
    .form-group input { width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 6px; font-size: 14px; font-family: inherit; }
    .form-group input:focus { outline: none; border-color: var(--brand-blue, #2563eb); box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); }
    .form-group .help-text { font-size: 12px; color: #64748b; margin-top: 4px; }
    .form-group .error { color: #ef4444; font-size: 12px; margin-top: 4px; }
    
    .form-actions { display: flex; gap: 12px; margin-top: 32px; padding-top: 24px; border-top: 1px solid #e2e8f0; }
    
    .info-box { background: #dbeafe; border-left: 4px solid #3b82f6; padding: 16px; margin: 16px 0; border-radius: 4px; }
    .info-box h4 { margin: 0 0 8px; color: #1e40af; font-size: 16px; }
    .info-box p { margin: 4px 0; color: #1e3a8a; font-size: 14px; }
  </style>

  <div class="profile-edit-container">
    <div class="profile-edit-header">
      <h1>Edit Profile</h1>
      <a href="{{ route('profile.show') }}" class="btn" style="background: #64748b;">Cancel</a>
    </div>

    @if (session('status'))
      <div style="padding: 12px; background: #d1fae5; border: 1px solid #86efac; border-radius: 6px; margin-bottom: 24px; color: #065f46;">
        {{ session('status') }}
      </div>
    @endif

    <form method="post" 
          action="{{ route('profile.update') }}"
          class="profile-edit-form"
          onsubmit="return confirmSaveProfile()">
      @csrf
      @method('put')

      <h2>Personal Information</h2>

      <div class="form-group">
        <label for="name">Full Name *</label>
        <input type="text" 
               id="name" 
               name="name" 
               value="{{ old('name', $user->name) }}" 
               required 
               autofocus>
        @error('name')
          <div class="error">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group">
        <label for="email">Email Address *</label>
        <input type="email" 
               id="email" 
               name="email" 
               value="{{ old('email', $user->email) }}" 
               required>
        @error('email')
          <div class="error">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group">
        <label for="role">Role</label>
        <input type="text" 
               id="role" 
               value="{{ ucfirst($user->role) }}" 
               disabled 
               style="background: #f8fafc; cursor: not-allowed;">
        <div class="help-text">Your role cannot be changed. Contact an administrator if you need a role change.</div>
      </div>

      <h2 style="margin-top: 32px;">Change Password</h2>

      <div class="info-box">
        <h4>💡 Password Change</h4>
        <p>Leave the password fields blank if you don't want to change your password. If you want to change your password, enter a new password and confirm it.</p>
      </div>

      <div class="form-group">
        <label for="password">New Password</label>
        <input type="password" 
               id="password" 
               name="password" 
               autocomplete="new-password">
        <div class="help-text">Leave blank to keep current password. Minimum 8 characters if changing.</div>
        @error('password')
          <div class="error">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group">
        <label for="password_confirmation">Confirm New Password</label>
        <input type="password" 
               id="password_confirmation" 
               name="password_confirmation" 
               autocomplete="new-password">
        @error('password_confirmation')
          <div class="error">{{ $message }}</div>
        @enderror
      </div>

      @if($errors->any())
        <div style="background: #fee2e2; color: #991b1b; padding: 12px; border-radius: 6px; margin-bottom: 24px;">
          <ul style="list-style: none; padding: 0; margin: 0;">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <div class="form-actions">
        <button type="submit" class="btn save-btn">Update Profile</button>
        <a href="{{ route('profile.show') }}" 
           class="btn cancel-link" 
           style="background: #64748b;"
           onclick="return confirmCancelEdit()">Cancel</a>
      </div>
    </form>
  </div>
  
  <script>
    function confirmSaveProfile() {
      const message = `⚠️ UPDATE PROFILE CONFIRMATION\n\nAre you sure you want to update your profile?\n\nAll modifications will be permanently updated.`;
      return confirm(message);
    }
    
    function confirmCancelEdit() {
      const message = `⚠️ CANCEL EDITING\n\nAre you sure you want to cancel?\n\nAny unsaved changes will be lost.`;
      return confirm(message);
    }
    
    // Warn before leaving page if form has been modified
    let formChanged = false;
    document.querySelector('.profile-edit-form').addEventListener('change', function() {
      formChanged = true;
    });
    
    document.querySelector('.profile-edit-form').addEventListener('input', function() {
      formChanged = true;
    });
    
    window.addEventListener('beforeunload', function(e) {
      if (formChanged) {
        e.preventDefault();
        e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
        return e.returnValue;
      }
    });
    
    document.querySelector('.profile-edit-form').addEventListener('submit', function() {
      formChanged = false;
    });
  </script>
</x-layouts.app>

