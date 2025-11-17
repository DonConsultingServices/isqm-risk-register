@php($title = 'Monitoring Activities')
<x-layouts.app :title="$title">
  <div class="topbar">
    <h2>{{ $title }}</h2>
    <a class="btn" href="{{ route('lists.monitoring.create') }}">Add</a>
  </div>
  @if (session('status'))<p>{{ session('status') }}</p>@endif
  <table style="width:100%;border-collapse:collapse;font-size:14px;">
    <thead>
      <tr>
        <th style="text-align:left;padding:8px;border-bottom:1px solid #eee;">Name</th>
        <th style="text-align:left;padding:8px;border-bottom:1px solid #eee;">Description</th>
        <th style="padding:8px;border-bottom:1px solid #eee;"></th>
      </tr>
    </thead>
    <tbody>
      @foreach ($items as $i)
        <tr>
          <td style="padding:8px;border-bottom:1px solid #eee;">{{ $i->name }}</td>
          <td style="padding:8px;border-bottom:1px solid #eee;">{{ $i->description }}</td>
          <td style="padding:8px;border-bottom:1px solid #eee;">
            <a class="btn edit-link" 
               href="{{ route('lists.monitoring.edit', $i) }}"
               onclick="return confirmAction('⚠️ EDIT MONITORING ACTIVITY\n\nYou are about to edit: {{ $i->name }}\n\nDo you want to continue?', 'edit')">Edit</a>
            <form style="display:inline" 
                  method="post" 
                  action="{{ route('lists.monitoring.destroy', $i) }}" 
                  class="delete-form"
                  data-item-name="monitoring activity '{{ $i->name }}'">
              @csrf @method('delete')
              <button type="submit" 
                      class="btn delete-btn" 
                      style="background:#ef4444"
                      onclick="return confirmDeleteMonitoring(this, '{{ $i->name }}')">Delete</button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
  <div style="margin-top:12px;">{{ $items->links() }}</div>
  
  <script>
    function confirmDeleteMonitoring(button, itemName) {
      const message = `⚠️ DELETE MONITORING ACTIVITY CONFIRMATION\n\nAre you sure you want to delete "${itemName}"?\n\n⚠️ This action cannot be undone.\n\nThis monitoring activity will be removed from all associated ISQM entries.`;
      return confirm(message);
    }
  </script>
</x-layouts.app>

