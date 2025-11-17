@php($title = 'Compliance Now')
<x-layouts.app :title="$title">
  <style>
    .compliance-page { max-width: 1400px; margin: 0 auto; padding: 16px; }
    .compliance-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
    .compliance-header h1 { margin: 0; font-size: 28px; color: #0f172a; }
    .module-card { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px; margin-bottom: 28px; box-shadow: 0 4px 14px rgba(15, 23, 42, 0.05); }
    .module-header { display: flex; flex-direction: column; gap: 8px; margin-bottom: 20px; }
    .module-title { font-size: 22px; font-weight: 700; color: var(--brand-blue, #2563eb); }
    .module-objective { font-size: 14px; color: #475569; line-height: 1.6; background: #f8fafc; padding: 12px 16px; border-radius: 10px; border-left: 3px solid var(--brand-blue, #2563eb); }
    .risk-grid { display: grid; gap: 18px; }
    .risk-card { border: 1px solid #cbd5f5; border-radius: 10px; padding: 18px; background: #f8fbff; }
    .risk-title-row { display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; margin-bottom: 10px; }
    .risk-title { font-size: 16px; font-weight: 600; color: #1e293b; margin: 0; }
    .chip-set { display: flex; gap: 8px; flex-wrap: wrap; }
    .chip { font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: .04em; padding: 4px 10px; border-radius: 999px; }
    .chip--critical { background: #fee2e2; color: #b91c1c; }
    .chip--pervasive { background: #ede9fe; color: #5b21b6; }
    .chip--monitor { background: #dcfce7; color: #15803d; }
    .risk-sections { display: grid; gap: 14px; }
    .risk-section { display: grid; gap: 6px; }
    .risk-section strong { color: #0f172a; font-size: 13px; letter-spacing: .02em; }
    .risk-section p { margin: 0; color: #334155; font-size: 14px; line-height: 1.6; white-space: pre-wrap; }
    .empty-state { text-align: center; padding: 80px 20px; border: 2px dashed #cbd5f5; border-radius: 12px; background: #f8fafc; color: #475569; }
  </style>

  <div class="compliance-page">
    <div class="compliance-header">
      <h1>Immediate Compliance Actions</h1>
      <div style="display:flex;gap:8px;">
        <a href="{{ route('reports.export.compliance') }}" class="btn" style="background:#0f766e;">Download CSV</a>
        <a href="{{ route('isqm.index') }}" class="btn" style="background:#1e3a8a;">Back to Register</a>
      </div>
    </div>

    @if($groupedEntries->isEmpty())
      <div class="empty-state">
        <h2 style="margin:0 0 12px;">All clear for now</h2>
        <p>No outstanding ISQM responses or monitoring activities requiring action were found.</p>
      </div>
    @else
      @foreach($groupedEntries as $module => $entryGroup)
        <section class="module-card">
          <div class="module-header">
            <span class="module-title">{{ $module }}</span>
            @if(optional($entryGroup->first())->quality_objective)
              <div class="module-objective">
                <strong>Quality Objective:</strong>
                <div>{{ optional($entryGroup->first())->quality_objective }}</div>
              </div>
            @endif
          </div>

          <div class="risk-grid">
            @foreach($entryGroup as $entry)
              <article class="risk-card">
                <div class="risk-title-row">
                  <h3 class="risk-title">{{ $entry->quality_risk ?? $entry->title }}</h3>
                  <div class="chip-set">
                    @if($entry->severe)
                      <span class="chip chip--critical">Severe</span>
                    @endif
                    @if($entry->pervasive)
                      <span class="chip chip--pervasive">Pervasive</span>
                    @endif
                    @if(optional($entry->monitoringActivity)->name)
                      <span class="chip chip--monitor">{{ $entry->monitoringActivity->name }}</span>
                    @endif
                  </div>
                </div>

                <div class="risk-sections">
                  @if($entry->assessment_of_risk)
                    <div class="risk-section">
                      <strong>Why this matters</strong>
                      <p>{{ $entry->assessment_of_risk }}</p>
                    </div>
                  @endif

                  @if($entry->response)
                    <div class="risk-section">
                      <strong>Required Response</strong>
                      <p>{{ $entry->response }}</p>
                    </div>
                  @endif

                  @if($entry->firm_implementation)
                    <div class="risk-section">
                      <strong>Firm Implementation</strong>
                      <p>{{ $entry->firm_implementation }}</p>
                    </div>
                  @endif

                  @if($entry->toc)
                    <div class="risk-section">
                      <strong>Test of Controls</strong>
                      <p>{{ $entry->toc }}</p>
                    </div>
                  @endif

                  @if($entry->remedial_actions)
                    <div class="risk-section">
                      <strong>Remedial Actions</strong>
                      <p>{{ $entry->remedial_actions }}</p>
                    </div>
                  @endif

                  @if($entry->deficiencyType || $entry->findings || $entry->root_cause)
                    <div class="risk-section">
                      <strong>Monitoring Notes</strong>
                      <p>
                        @if($entry->deficiencyType)
                          <span style="display:block;"><em>Deficiency:</em> {{ $entry->deficiencyType->name }}</span>
                        @endif
                        @if($entry->findings)
                          <span style="display:block;"><em>Finding:</em> {{ $entry->findings }}</span>
                        @endif
                        @if($entry->root_cause)
                          <span style="display:block;"><em>Root Cause:</em> {{ $entry->root_cause }}</span>
                        @endif
                      </p>
                    </div>
                  @endif
                </div>
              </article>
            @endforeach
          </div>
        </section>
      @endforeach
    @endif
  </div>
</x-layouts.app>

