@php($title = 'Risks')
<x-layouts.app :title="$title">
  <div class="topbar">
    <h2>Quality Risks</h2>
  </div>

  <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));gap:16px;margin-bottom:24px;">
    @foreach($byArea as $area)
      <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;padding:16px;">
        <div style="font-weight:600;margin-bottom:8px;">{{ $area->module_title }}</div>
        <div style="font-size:24px;font-weight:700;color:var(--brand-blue);">{{ $area->total }}</div>
        <div style="font-size:12px;color:#64748b;margin-top:8px;">
          @if($area->severe_count > 0)
            <span style="color:#991b1b;">{{ $area->severe_count }} severe</span>
          @endif
          @if($area->pervasive_count > 0)
            <span style="color:#92400e;margin-left:8px;">{{ $area->pervasive_count }} pervasive</span>
          @endif
        </div>
      </div>
    @endforeach
  </div>

  <form method="get" action="{{ route('risks.index') }}" style="display:grid;grid-template-columns:1fr 1fr 1fr auto;gap:8px;align-items:end;margin-bottom:16px;padding:12px;background:#f8fafc;border-radius:8px;">
    <div>
      <label style="display:block;margin-bottom:4px;font-size:12px;font-weight:600;color:#475569;">Area</label>
      <select name="area" style="width:100%;padding:8px;border:1px solid #d1d5db;border-radius:6px;">
        <option value="">All Areas</option>
        @foreach ($modules as $module)
          <option value="{{ $module->slug }}" @selected(request('area') === $module->slug)>{{ $module->name }}</option>
        @endforeach
      </select>
    </div>
    <div>
      <label style="display:block;margin-bottom:4px;font-size:12px;font-weight:600;color:#475569;">Filter</label>
      <select name="filter" style="width:100%;padding:8px;border:1px solid #d1d5db;border-radius:6px;">
        <option value="">All Risks</option>
        <option value="severe" @selected(request('filter') === 'severe')>Severe</option>
        <option value="pervasive" @selected(request('filter') === 'pervasive')>Pervasive</option>
        <option value="adverse" @selected(request('filter') === 'adverse')>Adverse Effect</option>
      </select>
    </div>
    <div></div>
    <div style="display:flex;gap:8px;">
      <button class="btn">Filter</button>
      <a href="{{ route('risks.index') }}" class="btn" style="background:#64748b;">Clear</a>
    </div>
  </form>

  <div style="overflow:auto;background:#fff;border:1px solid #e2e8f0;border-radius:8px;">
    <table style="width:100%;border-collapse:collapse;font-size:14px;">
      <thead>
        <tr>
          <th style="text-align:left;background:#f8fafc;position:sticky;top:0;padding:10px 8px;border-bottom:1px solid #e2e8f0;">Area</th>
          <th style="text-align:left;background:#f8fafc;position:sticky;top:0;padding:10px 8px;border-bottom:1px solid #e2e8f0;">Quality Risk</th>
          <th style="text-align:left;background:#f8fafc;position:sticky;top:0;padding:10px 8px;border-bottom:1px solid #e2e8f0;">Assessment</th>
          <th style="text-align:left;background:#f8fafc;position:sticky;top:0;padding:10px 8px;border-bottom:1px solid #e2e8f0;">Severity</th>
          <th style="text-align:left;background:#f8fafc;position:sticky;top:0;padding:10px 8px;border-bottom:1px solid #e2e8f0;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($risks as $risk)
          <tr style="transition:background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
            <td style="padding:10px 8px;border-bottom:1px solid #e2e8f0;">{{ $risk->module?->name ?? '—' }}</td>
            <td style="padding:10px 8px;border-bottom:1px solid #e2e8f0;">
              <a href="{{ route('isqm.show', $risk) }}" style="color:var(--brand-blue);text-decoration:none;">{{ Str::limit($risk->quality_risk, 80) }}</a>
            </td>
            <td style="padding:10px 8px;border-bottom:1px solid #e2e8f0;">{{ Str::limit($risk->assessment_of_risk, 60) }}</td>
            <td style="padding:10px 8px;border-bottom:1px solid #e2e8f0;">
              <div style="display:flex;gap:4px;flex-wrap:wrap;">
                @if($risk->severe)
                  <span style="padding:2px 6px;background:#fee2e2;color:#991b1b;border-radius:6px;font-size:11px;font-weight:500;">Severe</span>
                @endif
                @if($risk->pervasive)
                  <span style="padding:2px 6px;background:#fef3c7;color:#92400e;border-radius:6px;font-size:11px;font-weight:500;">Pervasive</span>
                @endif
                @if($risk->adverse_effect)
                  <span style="padding:2px 6px;background:#fee2e2;color:#991b1b;border-radius:6px;font-size:11px;font-weight:500;">Adverse</span>
                @endif
              </div>
            </td>
            <td style="padding:10px 8px;border-bottom:1px solid #e2e8f0;">
              <a href="{{ route('isqm.show', $risk) }}" class="btn" style="padding:6px 10px;font-size:12px;background:#64748b;">View</a>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" style="padding:40px;text-align:center;color:#64748b;">
              No risks found with the selected filters.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if($risks->hasPages())
    <div style="margin-top:16px;display:flex;justify-content:center;">
      {{ $risks->links() }}
    </div>
  @endif
</x-layouts.app>

