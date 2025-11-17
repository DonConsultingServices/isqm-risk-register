@php($title = 'Clients')
<x-layouts.app :title="$title">
  <div class="topbar">
    <h2>{{ $title }}</h2>
    <a class="btn" href="{{ route('clients.create') }}">Add Client</a>
  </div>
  @if (session('status'))<p>{{ session('status') }}</p>@endif
  <table style="width:100%;border-collapse:collapse;font-size:14px;">
    <thead>
      <tr>
        <th style="text-align:left;padding:8px;border-bottom:1px solid #eee;">Name</th>
        <th style="text-align:left;padding:8px;border-bottom:1px solid #eee;">Industry</th>
        <th style="text-align:left;padding:8px;border-bottom:1px solid #eee;">Email</th>
        <th style="text-align:left;padding:8px;border-bottom:1px solid #eee;">Phone</th>
        <th style="padding:8px;border-bottom:1px solid #eee;"></th>
      </tr>
    </thead>
    <tbody>
      @foreach ($clients as $c)
        <tr>
          <td style="padding:8px;border-bottom:1px solid #eee;">{{ $c->name }}</td>
          <td style="padding:8px;border-bottom:1px solid #eee;">{{ $c->industry }}</td>
          <td style="padding:8px;border-bottom:1px solid #eee;">{{ $c->email }}</td>
          <td style="padding:8px;border-bottom:1px solid #eee;">{{ $c->phone }}</td>
          <td style="padding:8px;border-bottom:1px solid #eee;">
            <a class="btn edit-link" 
               href="{{ route('clients.edit', $c) }}"
               onclick="return confirmAction('⚠️ EDIT CLIENT\n\nYou are about to edit client: {{ $c->name }}\n\nDo you want to continue?', 'edit')">Edit</a>
            <form style="display:inline" 
                  method="post" 
                  action="{{ route('clients.destroy', $c) }}" 
                  class="delete-form"
                  data-item-name="client '{{ $c->name }}'">
              @csrf @method('delete')
              <button type="submit" 
                      class="btn delete-btn" 
                      style="background:#ef4444"
                      onclick="return confirmDeleteClient(this, '{{ $c->name }}')">Delete</button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
  <div style="margin-top:12px;">{{ $clients->links() }}</div>
  
  <script>
    function confirmDeleteClient(button, clientName) {
      const message = `⚠️ DELETE CLIENT CONFIRMATION\n\nAre you sure you want to delete client "${clientName}"?\n\n⚠️ This action cannot be undone.\n\nAll client data and associated ISQM entries will be permanently removed.`;
      return confirm(message);
    }
  </script>
</x-layouts.app>

