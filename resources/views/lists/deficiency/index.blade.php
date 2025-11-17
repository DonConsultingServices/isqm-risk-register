@php($title = 'Deficiency Types')
<x-layouts.app :title="$title">
  <div class="topbar">
    <h2>{{ $title }}</h2>
    <a class="btn" href="{{ route('lists.deficiency.create') }}">Add</a>
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
               href="{{ route('lists.deficiency.edit', $i) }}"
               onclick="return confirmAction('⚠️ EDIT DEFICIENCY TYPE\n\nYou are about to edit: {{ $i->name }}\n\nDo you want to continue?', 'edit')">Edit</a>
            <form style="display:inline" 
                  method="post" 
                  action="{{ route('lists.deficiency.destroy', $i) }}" 
                  class="delete-form"
                  data-item-name="deficiency type '{{ $i->name }}'">
              @csrf @method('delete')
              <button type="submit" 
                      class="btn delete-btn" 
                      style="background:#ef4444"
                      onclick="return confirmDeleteDeficiency(this, '{{ $i->name }}')">Delete</button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
  <div style="margin-top:12px;">{{ $items->links() }}</div>
  
  <script>
    function confirmDeleteDeficiency(button, itemName) {
      const message = `⚠️ DELETE DEFICIENCY TYPE CONFIRMATION\n\nAre you sure you want to delete "${itemName}"?\n\n⚠️ This action cannot be undone.\n\nThis deficiency type will be removed from all associated ISQM entries.`;
      return confirm(message);
    }
  </script>
</x-layouts.app>

