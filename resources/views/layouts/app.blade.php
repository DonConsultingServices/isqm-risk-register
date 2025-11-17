<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $title ?? 'ISQM' }}</title>
  <style>
    :root { --brand-blue: #0f172a; }
    body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; margin: 0; }
    .layout { display: grid; grid-template-columns: 240px 1fr; min-height: 100vh; }
    .sidebar { background: #0f172a; color: #fff; padding: 16px; }
    .sidebar h1 { font-size: 18px; margin: 0 0 12px; color: #cbd5e1; font-weight: 700; }
    .nav-section { margin-top: 16px; }
    .nav-section:first-of-type { margin-top: 0; }
    .nav-section h2 { font-size: 12px; text-transform: uppercase; letter-spacing: 0.08em; color: rgba(226,232,240,0.6); margin: 16px 6px 8px; }
    .nav a { display: block; color: #cbd5e1; text-decoration: none; padding: 8px 10px; border-radius: 8px; transition: background 0.18s ease, color 0.18s ease, transform 0.18s ease; font-size: 14px; position: relative; }
    .nav a:hover:not(.active) { background: rgba(255,255,255,0.08); color: #fff; transform: translateX(4px); }
    .nav a.active { background: #10b981 !important; color: #fff !important; font-weight: 700 !important; box-shadow: 0 2px 8px rgba(16,185,129,0.3), inset 0 1px 0 rgba(255,255,255,0.1) !important; transform: translateX(6px) !important; border-left: 4px solid #059669 !important; }
    .nav a.active:hover { background: #059669 !important; }
    .nav a.active::before { content: '' !important; position:absolute; left:-10px; top:50%; transform:translateY(-50%); width:4px; height:32px; border-radius:0 4px 4px 0; background:#10b981 !important; box-shadow:0 0 8px rgba(16,185,129,0.6) !important; }
    .content { padding: 16px; }
    .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
    .btn { background: var(--brand-blue); color: #fff; border: 0; padding: 8px 12px; border-radius: 6px; cursor: pointer; text-decoration: none; }
    .btn:hover { filter: brightness(0.95); }
    .icons { display: flex; gap: 10px; }
    .icon { font-size: 14px; color: #334155; background: #e2e8f0; border-radius: 999px; padding: 6px 10px; }
  </style>
</head>
<body>
  <div class="layout">
    <aside class="sidebar">
      <h1>ISQM</h1>
      @php
        $user = auth()->user();
        $role = $user?->role;
        $canManage = in_array($role, ['admin', 'manager']);
        $navPrimary = [
            [
                'label' => 'Dashboard',
                'url' => route('dashboard'),
                'path' => 'dashboard',
                'active' => ['dashboard'],
            ],
            [
                'label' => 'ISQM Register',
                'url' => route('isqm.index'),
                'path' => 'isqm',
                'active' => ['isqm.*', 'areas.*'],
                'alsoActiveForPaths' => ['governance', 'ethical', 'acceptance', 'engagement', 'resources', 'information'],
            ],
            [
                'label' => 'Compliance Now',
                'url' => route('isqm.compliance'),
                'path' => 'isqm/compliance-now',
                'active' => ['isqm.compliance'],
            ],
            [
                'label' => 'Risks Overview',
                'url' => route('risks.index'),
                'path' => 'risks',
                'active' => ['risks.*'],
            ],
            [
                'label' => 'Reports',
                'url' => route('reports.index'),
                'path' => 'reports',
                'active' => ['reports.*'],
            ],
        ];

        if ($canManage) {
            $navPrimary[] = [
                'label' => 'Clients',
                'url' => route('clients.index'),
                'active' => ['clients.*'],
            ];
            $navPrimary[] = [
                'label' => 'Monitoring Activities',
                'url' => route('lists.monitoring.index'),
                'active' => ['lists.monitoring.*'],
            ];
            $navPrimary[] = [
                'label' => 'Deficiency Types',
                'url' => route('lists.deficiency.index'),
                'active' => ['lists.deficiency.*'],
            ];
        }

        if ($role === 'admin') {
            $navPrimary[] = [
                'label' => 'Settings',
                'url' => route('settings.edit'),
                'active' => ['settings.*'],
            ];
            $navPrimary[] = [
                'label' => 'Users',
                'url' => route('users.index'),
                'active' => ['users.*'],
            ];
        }

        $slugMap = [
            'governance' => 'governance_and_leadership',
            'ethical' => 'ethical_requirements',
            'acceptance' => 'acceptance_and_continuance',
            'engagement' => 'engagement_performance',
            'resources' => 'resources',
            'information' => 'information_and_communication',
        ];

        $moduleNav = [
            ['label' => 'Governance & Leadership', 'url' => route('areas.governance'), 'path' => 'governance', 'active' => ['areas.governance', 'isqm.create:governance', 'isqm.edit:governance', 'isqm.show:governance']],
            ['label' => 'Ethical Requirements', 'url' => route('areas.ethical'), 'path' => 'ethical', 'active' => ['areas.ethical', 'isqm.create:ethical', 'isqm.edit:ethical', 'isqm.show:ethical']],
            ['label' => 'Acceptance & Continuance', 'url' => route('areas.acceptance'), 'path' => 'acceptance', 'active' => ['areas.acceptance', 'isqm.create:acceptance', 'isqm.edit:acceptance', 'isqm.show:acceptance']],
            ['label' => 'Engagement Performance', 'url' => route('areas.engagement'), 'path' => 'engagement', 'active' => ['areas.engagement', 'isqm.create:engagement', 'isqm.edit:engagement', 'isqm.show:engagement']],
            ['label' => 'Resources', 'url' => route('areas.resources'), 'path' => 'resources', 'active' => ['areas.resources', 'isqm.create:resources', 'isqm.edit:resources', 'isqm.show:resources']],
            ['label' => 'Information & Communication', 'url' => route('areas.information'), 'path' => 'information', 'active' => ['areas.information', 'isqm.create:information', 'isqm.edit:information', 'isqm.show:information']],
        ];

        $currentUrl = url()->current();
        $currentPath = request()->path();
        $currentRouteName = request()->route()?->getName();

        $isActive = function (array $patterns, string $targetUrl, ?string $itemPath = null) use ($slugMap, $currentUrl, $currentPath, $currentRouteName) {
            // Normalize paths (remove leading/trailing slashes)
            $normalizePath = fn($p) => trim($p, '/');
            $normalizedCurrent = $normalizePath($currentPath);
            
            // Priority 1: Direct path matching (most reliable)
            if ($itemPath) {
                $normalizedItem = $normalizePath($itemPath);
                if ($normalizedCurrent === $normalizedItem || str_starts_with($normalizedCurrent, $normalizedItem . '/')) {
                    return true;
                }
            }

            // Priority 2: URL path matching
            $targetPath = parse_url($targetUrl, PHP_URL_PATH);
            $normalizedTarget = $normalizePath($targetPath);
            if ($normalizedCurrent === $normalizedTarget || $currentUrl === $targetUrl) {
                return true;
            }

            // Priority 3: Route pattern matching
            foreach ($patterns as $pattern) {
                if (str_contains($pattern, ':')) {
                    [$base, $areaKey] = explode(':', $pattern, 2);
                    if (!request()->routeIs($base)) {
                        continue;
                    }

                    $mapped = $slugMap[$areaKey] ?? null;
                    if (!$mapped) {
                        continue;
                    }

                    if ($base === 'isqm.create' && request('area') === $mapped) {
                        return true;
                    }

                    if (in_array($base, ['isqm.edit', 'isqm.show'])) {
                        $entry = request()->route('isqm');
                        if ($entry) {
                            $entryArea = $entry->area ?? str_replace('-', '_', optional($entry->module)->slug);
                            if ($entryArea === $mapped) {
                                return true;
                            }
                        }
                    }
                } else {
                    if (request()->routeIs($pattern)) {
                        return true;
                    }
                }
            }

            return false;
        };
      @endphp

      <nav class="nav">
        <div class="nav-section">
          @foreach($navPrimary as $item)
            @php
              $active = false;
              
              // Check 1: Route patterns
              foreach ($item['active'] as $pattern) {
                if (request()->routeIs($pattern)) {
                  $active = true;
                  break;
                }
              }
              
              // Check 2: Direct path match
              if (!$active && isset($item['path'])) {
                $normalizedCurrent = trim(request()->path(), '/');
                $normalizedItem = trim($item['path'], '/');
                if ($normalizedCurrent === $normalizedItem || str_starts_with($normalizedCurrent, $normalizedItem . '/')) {
                  $active = true;
                }
              }
              
              // Check 3: URL contains path
              if (!$active && isset($item['path'])) {
                if (str_contains(request()->url(), '/' . $item['path'])) {
                  $active = true;
                }
              }
              
              // Check 4: Additional paths (e.g., ISQM Register should be active on module pages)
              if (!$active && isset($item['alsoActiveForPaths'])) {
                $normalizedCurrent = trim(request()->path(), '/');
                foreach ($item['alsoActiveForPaths'] as $additionalPath) {
                  $normalizedAdditional = trim($additionalPath, '/');
                  if ($normalizedCurrent === $normalizedAdditional || str_starts_with($normalizedCurrent, $normalizedAdditional . '/')) {
                    $active = true;
                    break;
                  }
                }
              }
              
              // Check 5: Use the isActive function as final fallback
              if (!$active) {
                $active = $isActive($item['active'], $item['url'], $item['path'] ?? null);
              }
            @endphp
            <a href="{{ $item['url'] }}" 
               class="{{ $active ? 'active' : '' }}" 
               @if($active) aria-current="page" @endif
               data-item-path="{{ $item['path'] ?? '' }}"
               style="{{ $active ? 'background: #10b981 !important; color: #fff !important; font-weight: 700 !important; box-shadow: 0 2px 8px rgba(16,185,129,0.3), inset 0 1px 0 rgba(255,255,255,0.1) !important; transform: translateX(6px) !important; border-left: 4px solid #059669 !important;' : '' }}">{{ $item['label'] }}</a>
          @endforeach
        </div>

        <div class="nav-section">
          <h2>ISQM Modules</h2>
          @foreach($moduleNav as $item)
            @php
              // SIMPLEST APPROACH: Just check the path directly
              $currentPath = trim(request()->path(), '/');
              $itemPath = trim($item['path'] ?? '', '/');
              
              // Primary check: exact path match
              $active = ($currentPath === $itemPath);
              
              // Secondary check: route name match
              if (!$active) {
                $currentRoute = request()->route()?->getName();
                if ($currentRoute && in_array($currentRoute, $item['active'])) {
                  $active = true;
                }
              }
              
              // Tertiary check: route pattern match
              if (!$active) {
                foreach ($item['active'] as $pattern) {
                  if (request()->routeIs($pattern)) {
                    $active = true;
                    break;
                  }
                }
              }
            @endphp
            @php
              $currentRoute = request()->route()?->getName();
            @endphp
            <a href="{{ $item['url'] }}" 
               class="{{ $active ? 'active' : '' }}" 
               @if($active) aria-current="page" @endif
               data-active="{{ $active ? 'true' : 'false' }}"
               data-route="{{ $currentRoute ?? 'none' }}"
               data-path="{{ $currentPath }}"
               data-item-path="{{ $itemPath }}"
               style="{{ $active ? 'background: #10b981 !important; color: #fff !important; font-weight: 700 !important; box-shadow: 0 2px 8px rgba(16,185,129,0.3), inset 0 1px 0 rgba(255,255,255,0.1) !important; transform: translateX(6px) !important; border-left: 4px solid #059669 !important;' : '' }}">
              {{ $item['label'] }}
            </a>
          @endforeach
        </div>
      </nav>
    </aside>
    <main class="content">
      @if (($showDashboardTopbar ?? false) === true)
        <div class="topbar">
          <div style="font-weight:700;">{{ $heading ?? 'Dashboard' }}</div>
          <div class="icons">
            <span class="icon">Notifications</span>
            <span class="icon">Messages</span>
            <span class="icon">Profile</span>
          </div>
        </div>
      @endif
      {{ $slot }}
    </main>
  </div>
  <script>
    // FORCE active state - GUARANTEED TO WORK
    (function() {
      function applyGreenStyles(link) {
        link.style.setProperty('background', '#10b981', 'important');
        link.style.setProperty('color', '#fff', 'important');
        link.style.setProperty('font-weight', '700', 'important');
        link.style.setProperty('box-shadow', '0 2px 8px rgba(16,185,129,0.3), inset 0 1px 0 rgba(255,255,255,0.1)', 'important');
        link.style.setProperty('transform', 'translateX(6px)', 'important');
        link.style.setProperty('border-left', '4px solid #059669', 'important');
        link.style.setProperty('position', 'relative', 'important');
      }
      
      function setActive() {
        const currentPath = window.location.pathname;
        const links = document.querySelectorAll('.nav a');
        
        links.forEach((link) => {
          const href = link.getAttribute('href') || '';
          const linkText = link.textContent.trim();
          
          // Get the path from href
          let hrefPath = '';
          try {
            if (href.startsWith('http')) {
              hrefPath = new URL(href).pathname;
            } else {
              hrefPath = href.split('?')[0];
            }
          } catch(e) {
            hrefPath = href.split('?')[0];
          }
          
          // Normalize paths
          const normalizedCurrent = currentPath.replace(/^\//, '').replace(/\/$/, '');
          const normalizedHref = hrefPath.replace(/^\//, '').replace(/\/$/, '');
          
          // Check if already active (from PHP)
          const isAlreadyActive = link.classList.contains('active') || link.getAttribute('data-active') === 'true';
          
          // Check if current path matches
          const isMatch = normalizedCurrent === normalizedHref || 
                         normalizedCurrent.startsWith(normalizedHref + '/') ||
                         currentPath === hrefPath ||
                         currentPath.startsWith(hrefPath) ||
                         isAlreadyActive;
          
          if (isMatch || isAlreadyActive) {
            link.classList.add('active');
            link.setAttribute('aria-current', 'page');
            applyGreenStyles(link);
          }
        });
      }
      
      // Run immediately and multiple times
      setActive();
      if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', setActive);
      }
      setTimeout(setActive, 50);
      setTimeout(setActive, 200);
      setTimeout(setActive, 500);
      
      // Also run when page becomes visible (in case of slow loading)
      document.addEventListener('visibilitychange', function() {
        if (!document.hidden) setActive();
      });
    })();
  </script>
</body>
</html>


