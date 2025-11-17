@php($title = 'User Guide: ' . $title)
<x-layouts.app :title="$title">
  <style>
    .guide-container { max-width: 1000px; margin: 0 auto; padding: 24px; }
    .guide-header { margin-bottom: 32px; padding-bottom: 24px; border-bottom: 2px solid #e2e8f0; }
    .guide-header h1 { margin: 0 0 8px; font-size: 28px; color: #0f172a; }
    .guide-nav { display: flex; gap: 12px; margin-bottom: 24px; flex-wrap: wrap; align-items: center; }
    .guide-nav a { padding: 8px 16px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; text-decoration: none; color: #334155; font-size: 14px; transition: all 0.2s; }
    .guide-nav a:hover { background: #f0f4ff; border-color: var(--brand-blue, #2563eb); color: var(--brand-blue, #2563eb); }
    .guide-nav a.active { background: var(--brand-blue, #2563eb); border-color: var(--brand-blue, #2563eb); color: #fff; }
    
    .topic-selector { position: relative; display: inline-block; }
    .topic-selector select { padding: 8px 32px 8px 16px; background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px; color: #334155; cursor: pointer; appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23334155' d='M6 9L1 4h10z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 12px center; }
    .topic-selector select:hover { border-color: var(--brand-blue, #2563eb); }
    .topic-selector select:focus { outline: none; border-color: var(--brand-blue, #2563eb); box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); }
    
    .guide-content { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 32px; }
    .guide-content h2 { margin: 32px 0 16px; font-size: 24px; color: #1e293b; border-bottom: 2px solid #e2e8f0; padding-bottom: 8px; }
    .guide-content h2:first-child { margin-top: 0; }
    .guide-content h3 { margin: 24px 0 12px; font-size: 20px; color: #334155; }
    .guide-content p { margin: 12px 0; color: #475569; line-height: 1.8; }
    .guide-content ul, .guide-content ol { margin: 12px 0; padding-left: 24px; color: #475569; line-height: 1.8; }
    .guide-content li { margin: 8px 0; }
    .guide-content code { background: #f1f5f9; padding: 2px 6px; border-radius: 4px; font-family: monospace; font-size: 14px; color: #e11d48; }
    .guide-content pre { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 16px; overflow-x: auto; }
    .guide-content pre code { background: none; padding: 0; color: #334155; }
    
    .step-box { background: #f8fafc; border-left: 4px solid var(--brand-blue, #2563eb); padding: 16px; margin: 16px 0; border-radius: 4px; }
    .step-box h4 { margin: 0 0 8px; color: #1e293b; font-size: 16px; }
    .step-box p { margin: 4px 0; }
    
    .warning-box { background: #fef3c7; border-left: 4px solid #f59e0b; padding: 16px; margin: 16px 0; border-radius: 4px; }
    .warning-box h4 { margin: 0 0 8px; color: #92400e; font-size: 16px; }
    .warning-box p { margin: 4px 0; color: #78350f; }
    
    .info-box { background: #dbeafe; border-left: 4px solid #3b82f6; padding: 16px; margin: 16px 0; border-radius: 4px; }
    .info-box h4 { margin: 0 0 8px; color: #1e40af; font-size: 16px; }
    .info-box p { margin: 4px 0; color: #1e3a8a; }
    
    .tip-box { background: #d1fae5; border-left: 4px solid #10b981; padding: 16px; margin: 16px 0; border-radius: 4px; }
    .tip-box h4 { margin: 0 0 8px; color: #065f46; font-size: 16px; }
    .tip-box p { margin: 4px 0; color: #047857; }
    
    .back-link { margin-top: 32px; padding-top: 24px; border-top: 1px solid #e2e8f0; }
    .back-link a { display: inline-flex; align-items: center; gap: 8px; color: var(--brand-blue, #2563eb); text-decoration: none; font-weight: 500; }
    .back-link a:hover { text-decoration: underline; }
  </style>

  <div class="guide-container">
    <div class="guide-header">
      <h1>{{ $title }}</h1>
      <div class="guide-nav">
        <a href="{{ route('user-guide.index') }}">← Back to Guide</a>
        <div class="topic-selector">
          <select onchange="if(this.value) window.location.href=this.value">
            <option value="">Select a topic...</option>
            @foreach($topics as $key => $topicTitle)
              <option value="{{ route('user-guide.show', $key) }}" {{ $key === $topic ? 'selected' : '' }}>{{ $topicTitle }}</option>
            @endforeach
          </select>
        </div>
        <span style="color: #64748b; font-size: 14px;">or browse below:</span>
      </div>
      <div class="guide-nav" style="margin-top: -12px;">
        @foreach($topics as $key => $topicTitle)
          @if($key !== $topic)
            <a href="{{ route('user-guide.show', $key) }}">{{ $topicTitle }}</a>
          @else
            <a href="{{ route('user-guide.show', $key) }}" class="active">{{ $topicTitle }}</a>
          @endif
        @endforeach
      </div>
    </div>

    <div class="guide-content">
      @include("user-guide.topics.{$topic}")
    </div>

    <div class="back-link">
      <a href="{{ route('user-guide.index') }}">← Back to User Guide</a>
    </div>
  </div>
</x-layouts.app>

