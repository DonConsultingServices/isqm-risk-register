@php($title = 'Edit Monitoring Activity')
<x-layouts.app :title="$title">
  <div style="max-width:720px;margin:20px auto;">
    <h2>{{ $title }}</h2>
    <form method="post" 
          action="{{ route('lists.monitoring.update', $item) }}"
          class="edit-form"
          onsubmit="return confirmSaveChanges('monitoring activity', '{{ $item->name }}')">
      @csrf @method('put')
      <label style="display:block;margin:10px 0 6px;font-weight:600;">Name</label>
      <input type="text" name="name" value="{{ old('name', $item->name) }}" required style="width:100%;padding:8px;border:1px solid #d1d5db;border-radius:6px;">
      <label style="display:block;margin:10px 0 6px;font-weight:600;">Description</label>
      <textarea name="description" rows="3" style="width:100%;padding:8px;border:1px solid #d1d5db;border-radius:6px;">{{ old('description', $item->description) }}</textarea>
      <div style="margin-top:12px;display:flex;gap:8px;">
        <a href="{{ route('lists.monitoring.index') }}" 
           class="cancel-link"
           onclick="return confirmCancelEdit()">Cancel</a>
        <button type="submit" class="btn save-btn">Save</button>
      </div>
    </form>
  </div>
  
  <script>
    function confirmSaveChanges(type, itemName) {
      const message = `⚠️ SAVE CHANGES CONFIRMATION\n\nAre you sure you want to save changes to ${type} "${itemName}"?\n\nAll modifications will be permanently updated.`;
      return confirm(message);
    }
    
    function confirmCancelEdit() {
      const message = `⚠️ CANCEL EDITING\n\nAre you sure you want to cancel?\n\nAny unsaved changes will be lost.`;
      return confirm(message);
    }
  </script>
</x-layouts.app>

