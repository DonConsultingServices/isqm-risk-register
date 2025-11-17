@php($title = 'Settings')
<x-layouts.app :title="$title">
  <div style="max-width:640px;margin:20px auto;">
    <h2>{{ $title }}</h2>
    @if (session('status'))<p>{{ session('status') }}</p>@endif
    <form method="post" action="{{ route('settings.update') }}">
      @csrf
      <label style="display:block;margin:10px 0 6px;font-weight:600;">Organisation name</label>
      <input type="text" name="org_name" value="{{ old('org_name', $org_name) }}" required style="width:100%;padding:8px;border:1px solid #d1d5db;border-radius:6px;">
      <label style="display:block;margin:10px 0 6px;font-weight:600;">Brand color</label>
      <input type="color" name="brand_color" value="{{ old('brand_color', $brand_color) }}" required>
      <div style="margin-top:12px;display:flex;gap:8px;">
        <button class="btn">Save</button>
      </div>
    </form>
  </div>
</x-layouts.app>

