@php($title = 'Import ISQM Excel')
<x-layouts.app :title="$title">
  <div class="wrap" style="max-width:720px; margin:24px auto; padding:0 12px;">
    <h2>Import ISQM Excel</h2>
    <form method="post" action="{{ route('isqm.import') }}" enctype="multipart/form-data">
      @csrf
      <label>Select file (.xlsx)</label>
      <input type="file" name="file" accept=".xlsx,.xls" required>
      <div style="margin-top:12px; display:flex; gap:8px;">
        <a href="{{ route('isqm.index') }}">Cancel</a>
        <button class="btn">Upload</button>
      </div>
    </form>
  </div>
</x-layouts.app>


