@php($title = 'Add Monitoring Activity')
<x-layouts.app :title="$title">
  <div style="max-width:720px;margin:20px auto;">
    <h2>{{ $title }}</h2>
    <form method="post" 
          action="{{ route('lists.monitoring.store') }}"
          class="create-form"
          onsubmit="return confirmCreateItem('monitoring activity')">
      @csrf
      <label style="display:block;margin:10px 0 6px;font-weight:600;">Name</label>
      <input type="text" name="name" required style="width:100%;padding:8px;border:1px solid #d1d5db;border-radius:6px;">
      <label style="display:block;margin:10px 0 6px;font-weight:600;">Description</label>
      <textarea name="description" rows="3" style="width:100%;padding:8px;border:1px solid #d1d5db;border-radius:6px;"></textarea>
      <div style="margin-top:12px;display:flex;gap:8px;">
        <a href="{{ route('lists.monitoring.index') }}" 
           class="cancel-link"
           onclick="return confirmCancelCreate()">Cancel</a>
        <button type="submit" class="btn save-btn">Save</button>
      </div>
    </form>
  </div>
  
  <script>
    function confirmCreateItem(type) {
      const message = `⚠️ CREATE ${type.toUpperCase()} CONFIRMATION\n\nAre you sure you want to create this new ${type}?\n\nPlease verify all information is correct before submitting.`;
      return confirm(message);
    }
    
    function confirmCancelCreate() {
      const message = `⚠️ CANCEL CREATION\n\nAre you sure you want to cancel?\n\nAny entered data will be lost.`;
      return confirm(message);
    }
  </script>
</x-layouts.app>

