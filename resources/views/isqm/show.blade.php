@php($title = 'ISQM Entry #'.$isqm->id)
@php($returnTo = request('return_to') ? urldecode(request('return_to')) : (url()->previous() && url()->previous() !== url()->current() ? url()->previous() : route('isqm.index')))
<x-layouts.app :title="$title">
  <div style="max-width:1200px;margin:0 auto;">
    <div class="topbar">
      <h2>ISQM Entry #{{ $isqm->id }}</h2>
      <div style="display:flex;gap:8px;">
        <a class="btn edit-link" 
           href="{{ route('isqm.edit', ['isqm' => $isqm, 'return_to' => $returnTo]) }}"
           onclick="return confirmAction('⚠️ EDIT ENTRY\n\nYou are about to edit entry #{{ $isqm->id }}.\n\nDo you want to continue?', 'edit')">Edit</a>
        <form style="display:inline;" 
              method="post" 
              action="{{ route('isqm.destroy', $isqm) }}" 
              class="delete-form"
              data-item-name="entry #{{ $isqm->id }}">
          @csrf @method('delete')
          <input type="hidden" name="return_to" value="{{ $returnTo }}">
          <button type="submit" 
                  class="btn delete-btn" 
                  style="background:#ef4444;"
                  onclick="return confirmDeleteEntry(this, {{ $isqm->id }})">Delete</button>
        </form>
        <a class="btn" href="{{ $returnTo }}" style="background:#64748b;">Back</a>
      </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-top:20px;">
      <div class="card" style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:16px;">
        <h3 style="margin:0 0 12px;font-size:16px;font-weight:600;">Basic Information</h3>
        <table style="width:100%;font-size:14px;">
          <tr><td style="padding:6px 0;color:#64748b;width:140px;">Area:</td><td style="padding:6px 0;"><strong>{{ str_replace('_', ' ', $isqm->area) }}</strong></td></tr>
          <tr><td style="padding:6px 0;color:#64748b;">Status:</td><td style="padding:6px 0;"><span style="padding:4px 8px;background:#e2e8f0;border-radius:6px;">{{ ucfirst($isqm->status) }}</span></td></tr>
          <tr><td style="padding:6px 0;color:#64748b;">Client:</td><td style="padding:6px 0;">{{ $isqm->client?->name ?? '—' }}</td></tr>
          <tr><td style="padding:6px 0;color:#64748b;">Owner:</td><td style="padding:6px 0;">{{ $isqm->owner?->name ?? '—' }}</td></tr>
          <tr><td style="padding:6px 0;color:#64748b;">Due Date:</td><td style="padding:6px 0;">{{ $isqm->due_date?->format('M d, Y') ?? '—' }}</td></tr>
          <tr><td style="padding:6px 0;color:#64748b;">Review Date:</td><td style="padding:6px 0;">{{ $isqm->review_date?->format('M d, Y') ?? '—' }}</td></tr>
        </table>
      </div>

      <div class="card" style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:16px;">
        <h3 style="margin:0 0 12px;font-size:16px;font-weight:600;">Risk Flags</h3>
        <div style="display:flex;flex-wrap:wrap;gap:8px;">
          @if($isqm->likelihood !== null)
            <span style="padding:4px 8px;background:{{ $isqm->likelihood ? '#fef3c7' : '#d1fae5' }};color:{{ $isqm->likelihood ? '#92400e' : '#065f46' }};border-radius:6px;font-size:12px;">
              Likelihood: {{ $isqm->likelihood ? 'Yes' : 'No' }}
            </span>
          @endif
          @if($isqm->severe)<span style="padding:4px 8px;background:#fee2e2;color:#991b1b;border-radius:6px;font-size:12px;">Severe</span>@endif
          @if($isqm->pervasive)<span style="padding:4px 8px;background:#fef3c7;color:#92400e;border-radius:6px;font-size:12px;">Pervasive</span>@endif
          @if($isqm->adverse_effect)<span style="padding:4px 8px;background:#fee2e2;color:#991b1b;border-radius:6px;font-size:12px;">Adverse Effect</span>@endif
          @if($isqm->risk_applicable !== null)
            <span style="padding:4px 8px;background:{{ $isqm->risk_applicable ? '#fee2e2' : '#d1fae5' }};color:{{ $isqm->risk_applicable ? '#991b1b' : '#065f46' }};border-radius:6px;font-size:12px;">
              Risk Applicable: {{ $isqm->risk_applicable ? 'Yes' : 'No' }}
            </span>
          @endif
          @if($isqm->entity_level)<span style="padding:4px 8px;background:#dbeafe;color:#1e40af;border-radius:6px;font-size:12px;">Entity Level</span>@endif
          @if($isqm->engagement_level)<span style="padding:4px 8px;background:#dbeafe;color:#1e40af;border-radius:6px;font-size:12px;">Engagement Level</span>@endif
          @if($isqm->objective_met)<span style="padding:4px 8px;background:#d1fae5;color:#065f46;border-radius:6px;font-size:12px;">Objective Met</span>@endif
        </div>
      </div>
    </div>

    <div class="card" style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:16px;margin-top:20px;">
      <h3 style="margin:0 0 12px;font-size:16px;font-weight:600;">Quality Objective</h3>
      <p style="margin:0;line-height:1.6;">{{ $isqm->quality_objective }}</p>
    </div>

    @if($isqm->quality_risk)
    <div class="card" style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:16px;margin-top:16px;">
      <h3 style="margin:0 0 12px;font-size:16px;font-weight:600;">Quality Risk</h3>
      <p style="margin:0;line-height:1.6;">{{ $isqm->quality_risk }}</p>
    </div>
    @endif

    @if($isqm->assessment_of_risk)
    <div class="card" style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:16px;margin-top:16px;">
      <h3 style="margin:0 0 12px;font-size:16px;font-weight:600;">Assessment of Risk</h3>
      <p style="margin:0;line-height:1.6;">{{ $isqm->assessment_of_risk }}</p>
    </div>
    @endif

    @if($isqm->response)
    <div class="card" style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:16px;margin-top:16px;">
      <h3 style="margin:0 0 12px;font-size:16px;font-weight:600;">Response</h3>
      <p style="margin:0;line-height:1.6;">{{ $isqm->response }}</p>
    </div>
    @endif

    @if($isqm->firm_implementation)
    <div class="card" style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:16px;margin-top:16px;">
      <h3 style="margin:0 0 12px;font-size:16px;font-weight:600;">Firm Implementation</h3>
      <p style="margin:0;line-height:1.6;">{{ $isqm->firm_implementation }}</p>
    </div>
    @endif

    @if($isqm->toc)
    <div class="card" style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:16px;margin-top:16px;">
      <h3 style="margin:0 0 12px;font-size:16px;font-weight:600;">TOC (Test of Control)</h3>
      <p style="margin:0;line-height:1.6;">{{ $isqm->toc }}</p>
    </div>
    @endif

    @if($isqm->findings || $isqm->root_cause || $isqm->monitoringActivity || $isqm->deficiencyType)
    <div class="card" style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:16px;margin-top:16px;">
      <h3 style="margin:0 0 12px;font-size:16px;font-weight:600;">Monitoring & Findings</h3>
      <table style="width:100%;font-size:14px;">
        @if($isqm->monitoringActivity)
        <tr><td style="padding:6px 0;color:#64748b;width:180px;">Monitoring Activity:</td><td style="padding:6px 0;">{{ $isqm->monitoringActivity->name }}</td></tr>
        @endif
        @if($isqm->findings)
        <tr><td style="padding:6px 0;color:#64748b;vertical-align:top;">Findings:</td><td style="padding:6px 0;">{{ $isqm->findings }}</td></tr>
        @endif
        @if($isqm->deficiencyType)
        <tr><td style="padding:6px 0;color:#64748b;">Deficiency Type:</td><td style="padding:6px 0;">{{ $isqm->deficiencyType->name }}</td></tr>
        @endif
        @if($isqm->root_cause)
        <tr><td style="padding:6px 0;color:#64748b;vertical-align:top;">Root Cause:</td><td style="padding:6px 0;">{{ $isqm->root_cause }}</td></tr>
        @endif
      </table>
    </div>
    @endif

    @if($isqm->remedial_actions)
    <div class="card" style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:16px;margin-top:16px;">
      <h3 style="margin:0 0 12px;font-size:16px;font-weight:600;">Remedial Actions</h3>
      <p style="margin:0;line-height:1.6;">{{ $isqm->remedial_actions }}</p>
    </div>
    @endif

    @if($isqm->attachments->count() > 0)
    <div class="card" style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:16px;margin-top:16px;">
      <h3 style="margin:0 0 12px;font-size:16px;font-weight:600;">Attachments</h3>
      <ul style="list-style:none;padding:0;margin:0;">
        @foreach($isqm->attachments as $att)
          <li style="padding:8px 0;border-bottom:1px solid #e2e8f0;display:flex;align-items:center;gap:8px;">
            <a href="{{ route('attachments.download', $att) }}" target="_blank" style="color:var(--brand-blue);text-decoration:none;flex:1;">{{ $att->filename }}</a>
            <span style="color:#64748b;font-size:12px;">({{ number_format($att->size / 1024, 2) }} KB)</span>
            <form method="POST" action="{{ route('attachments.delete', $att) }}" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this attachment? This action cannot be undone.');">
              @csrf
              @method('DELETE')
              <button type="submit" style="background:#ef4444;color:white;border:none;padding:4px 8px;border-radius:4px;cursor:pointer;font-size:12px;" title="Delete attachment">×</button>
            </form>
          </li>
        @endforeach
      </ul>
    </div>
    @endif

    <div style="margin-top:20px;padding-top:16px;border-top:1px solid #e2e8f0;color:#64748b;font-size:12px;">
      Created: {{ $isqm->created_at->format('M d, Y H:i') }} | 
      Updated: {{ $isqm->updated_at->format('M d, Y H:i') }}
    </div>
  </div>
  
  <script>
    function confirmDeleteEntry(button, entryId) {
      const message = `⚠️ DELETE ENTRY CONFIRMATION\n\nAre you sure you want to delete entry #${entryId}?\n\n⚠️ This action cannot be undone.\n\nAll entry data, attachments, and associated records will be permanently removed.`;
      return confirm(message);
    }
  </script>
</x-layouts.app>

