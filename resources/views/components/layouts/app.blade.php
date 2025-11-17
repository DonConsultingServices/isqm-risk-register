<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $title ?? 'ISQM' }}</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <style>
    :root { --brand-blue: {{ \App\Models\Setting::get('brand_color', '#0f172a') }}; }
    html, body { height: 100%; }
    body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; margin: 0; background: #f1f5f9; }
    .layout { display: grid; grid-template-columns: 240px 1fr; height: 100vh; overflow: hidden; transition: grid-template-columns 0.25s ease; }
    .layout.collapsed { grid-template-columns: 0 1fr; }
    .sidebar { background: #0f172a; color: #fff; padding: 16px; position: sticky; top: 0; height: 100vh; overflow-y: auto; display: flex; flex-direction: column; transition: transform 0.25s ease, opacity 0.25s ease; }
    .layout.collapsed .sidebar { transform: translateX(-100%); opacity: 0; pointer-events: none; }
    .sidebar h1 { font-size: 18px; margin: 0 0 12px; color: #cbd5e1; font-weight: 700; }
    .nav a { display: block; color: #cbd5e1; text-decoration: none; padding: 8px 6px; border-radius: 6px; transition: all 0.2s; position: relative; }
    .nav a:hover { background: rgba(255,255,255,0.08); color: #fff; }
    .nav a.active { background: #10b981 !important; color: #fff !important; font-weight: 700 !important; box-shadow: 0 2px 8px rgba(16,185,129,0.3), inset 0 1px 0 rgba(255,255,255,0.1) !important; transform: translateX(6px) !important; border-left: 4px solid #059669 !important; }
    .nav a.active:hover { background: #059669 !important; }
    .content { display: flex; flex-direction: column; height: 100vh; background: #f1f5f9; }
    .content-inner { flex: 1; overflow-y: auto; overflow-x: hidden; padding: 16px; }
    .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
    .btn { background: var(--brand-blue); color: #fff; border: 0; padding: 8px 12px; border-radius: 6px; cursor: pointer; text-decoration: none; }
    .btn:hover { filter: brightness(0.95); }
    .icons { display: flex; gap: 10px; align-items: center; }
    .icon { font-size: 14px; color: #334155; background: #e2e8f0; border-radius: 999px; padding: 6px 12px; transition: all 0.2s; display: inline-flex; align-items: center; border: none; cursor: pointer; }
    .topbar-link { text-decoration: none !important; color: #334155 !important; }
    .topbar-link:hover { background: #cbd5e1 !important; color: #1e293b !important; transform: translateY(-1px); box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    .topbar-profile { font-weight: 600; background: #dbeafe !important; color: #1e40af !important; }
    .topbar-profile:hover { background: #bfdbfe !important; color: #1e3a8a !important; }
    .topbar-logout { font-weight: 500; }
    .topbar-logout:hover { background: #fee2e2 !important; color: #991b1b !important; }
    .notification-badge { background: #ef4444 !important; color: #fff !important; border-radius: 999px; padding: 2px 6px; font-size: 11px; margin-left: 4px; font-weight: 600; }
    .sidebar-toggle { background: transparent; border: 0; color: #0f172a; display: inline-flex; align-items: center; gap: 8px; cursor: pointer; padding: 6px 0 14px; font-size: 16px; font-weight: 600; }
    .sidebar-toggle span { font-size: 14px; text-transform: uppercase; letter-spacing: 0.02em; color: #475569; }
    .layout.collapsed .sidebar-toggle { color: #0f172a; }
    .layout.collapsed .sidebar-toggle span { display: none; }
    
    /* Dropdown styles */
    .nav-dropdown { margin-top: 8px; }
    .nav-dropdown-toggle { display: flex; align-items: center; justify-content: space-between; color: #cbd5e1; text-decoration: none; padding: 8px 6px; border-radius: 6px; cursor: pointer; font-size: 14px; }
    .nav-dropdown-toggle:hover { background: rgba(255,255,255,0.08); color: #fff; }
    .nav-dropdown-toggle.active { background: #10b981; color: #fff; font-weight: 600; }
    .nav-dropdown-toggle::after { content: '▼'; font-size: 10px; transition: transform 0.2s; }
    .nav-dropdown-toggle.open::after { transform: rotate(180deg); }
    .nav-dropdown-menu { max-height: 0; overflow: hidden; transition: max-height 0.3s ease; }
    .nav-dropdown-menu.open { max-height: 500px; }
    .nav-dropdown-menu a { padding-left: 20px; font-size: 13px; }
    .nav-dropdown-menu a.active { background: #10b981; color: #fff; font-weight: 600; }
    
    @media (max-width: 1024px) {
      .layout { grid-template-columns: 0 1fr; }
      .layout:not(.collapsed) { grid-template-columns: 240px 1fr; }
    }
  </style>
</head>
<body>
  <div class="layout">
    <aside id="sidebar" class="sidebar">
      <h1>ISQM</h1>
      <nav class="nav">
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
        
        <a href="{{ route('isqm.index') }}" class="{{ request()->routeIs('isqm.*') ? 'active' : '' }}">Register</a>
        
        <div class="nav-dropdown">
          <div class="nav-dropdown-toggle {{ request()->routeIs('areas.*') ? 'active open' : '' }}" onclick="toggleDropdown(this)">
            ISQM Areas
          </div>
          <div class="nav-dropdown-menu {{ request()->routeIs('areas.*') ? 'open' : '' }}">
            <a href="{{ route('areas.governance') }}" class="{{ request()->routeIs('areas.governance') ? 'active' : '' }}">Governance & Leadership</a>
            <a href="{{ route('areas.ethical') }}" class="{{ request()->routeIs('areas.ethical') ? 'active' : '' }}">Ethical Requirements</a>
            <a href="{{ route('areas.acceptance') }}" class="{{ request()->routeIs('areas.acceptance') ? 'active' : '' }}">Acceptance & Continuance</a>
            <a href="{{ route('areas.engagement') }}" class="{{ request()->routeIs('areas.engagement') ? 'active' : '' }}">Engagement Performance</a>
            <a href="{{ route('areas.resources') }}" class="{{ request()->routeIs('areas.resources') ? 'active' : '' }}">Resources</a>
            <a href="{{ route('areas.information') }}" class="{{ request()->routeIs('areas.information') ? 'active' : '' }}">Information & Communication</a>
          </div>
        </div>
        
        <div class="nav-dropdown">
          <div class="nav-dropdown-toggle {{ request()->routeIs('clients.*') || request()->routeIs('risks.*') || request()->routeIs('reports.*') || request()->routeIs('activity-logs.*') || request()->routeIs('users.*') || request()->routeIs('settings.*') || request()->routeIs('lists.*') ? 'active open' : '' }}" onclick="toggleDropdown(this)">
            Management
          </div>
          <div class="nav-dropdown-menu {{ request()->routeIs('clients.*') || request()->routeIs('risks.*') || request()->routeIs('reports.*') || request()->routeIs('activity-logs.*') || request()->routeIs('users.*') || request()->routeIs('settings.*') || request()->routeIs('lists.*') ? 'open' : '' }}">
            <a href="{{ route('clients.index') }}" class="{{ request()->routeIs('clients.*') ? 'active' : '' }}">Clients</a>
            <a href="{{ route('risks.index') }}" class="{{ request()->routeIs('risks.*') ? 'active' : '' }}">Risks</a>
            <a href="{{ route('reports.index') }}" class="{{ request()->routeIs('reports.*') ? 'active' : '' }}">Reports</a>
            @auth
              @if(in_array(auth()->user()->role, ['admin', 'manager']))
                <a href="{{ route('activity-logs.index') }}" class="{{ request()->routeIs('activity-logs.*') ? 'active' : '' }}">Activity Logs</a>
                <a href="{{ route('lists.monitoring.index') }}" class="{{ request()->routeIs('lists.monitoring.*') ? 'active' : '' }}">Monitoring Activities</a>
                <a href="{{ route('lists.deficiency.index') }}" class="{{ request()->routeIs('lists.deficiency.*') ? 'active' : '' }}">Deficiency Types</a>
              @endif
              @if(auth()->user()->role === 'admin')
                <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">Users</a>
                <a href="{{ route('settings.edit') }}" class="{{ request()->routeIs('settings.*') ? 'active' : '' }}">Settings</a>
              @endif
            @endauth
          </div>
        </div>
        
        <a href="{{ route('user-guide.index') }}" class="{{ request()->routeIs('user-guide.*') ? 'active' : '' }}">📚 User Guide</a>
      </nav>
    </aside>
    <main class="content">
      <div class="content-inner">
        <button type="button" id="sidebarToggle" class="sidebar-toggle" aria-controls="sidebar" aria-expanded="true">
          &#9776;
          <span>Toggle Menu</span>
        </button>
        @if (($showDashboardTopbar ?? false) === true)
          <div class="topbar">
            <div style="font-weight:700;">{{ $heading ?? 'Dashboard' }}</div>
            <div class="icons">
              <a href="{{ route('notifications.index') }}" class="icon topbar-link">
                🔔 Notifications
                @auth
                  @if(auth()->user()->unreadNotifications()->count() > 0)
                    <span class="notification-badge">{{ auth()->user()->unreadNotifications()->count() }}</span>
                  @endif
                @endauth
              </a>
              <a href="{{ route('profile.show') }}" class="icon topbar-link topbar-profile" title="View Profile">
                👤 {{ auth()->user()->name ?? 'Profile' }}
              </a>
              @auth
                <form method="post" action="{{ route('logout') }}" style="display:inline;">
                  @csrf
                  <button type="submit" class="icon topbar-logout" title="Logout">🚪 Logout</button>
                </form>
              @endauth
            </div>
          </div>
        @endif
        @auth
          {{ $slot }}
        @else
          <div style="text-align:center;padding:40px;">
            <h2>Please log in to continue</h2>
            <a href="{{ route('login') }}" class="btn">Login</a>
          </div>
        @endauth
      </div>
      <x-footer />
    </main>
  </div>
  <script>
    (function() {
      const layout = document.querySelector('.layout');
      const toggle = document.getElementById('sidebarToggle');
      if (!layout || !toggle) { return; }

      const restore = localStorage.getItem('sidebarCollapsed');
      if (restore === '1') {
        layout.classList.add('collapsed');
        toggle.setAttribute('aria-expanded', 'false');
      }

      toggle.addEventListener('click', function() {
        const collapsed = layout.classList.toggle('collapsed');
        toggle.setAttribute('aria-expanded', collapsed ? 'false' : 'true');
        localStorage.setItem('sidebarCollapsed', collapsed ? '1' : '0');
      });
    })();
    
    function toggleDropdown(toggle) {
      const dropdown = toggle.closest('.nav-dropdown');
      const menu = dropdown.querySelector('.nav-dropdown-menu');
      const isOpen = menu.classList.contains('open');
      
      // Close all other dropdowns
      document.querySelectorAll('.nav-dropdown-menu').forEach(m => {
        if (m !== menu) m.classList.remove('open');
      });
      document.querySelectorAll('.nav-dropdown-toggle').forEach(t => {
        if (t !== toggle) t.classList.remove('open');
      });
      
      // Toggle current dropdown
      if (isOpen) {
        menu.classList.remove('open');
        toggle.classList.remove('open');
      } else {
        menu.classList.add('open');
        toggle.classList.add('open');
      }
    }
    
    // Auto-open dropdown if any child is active
    document.addEventListener('DOMContentLoaded', function() {
      document.querySelectorAll('.nav-dropdown-menu a.active').forEach(activeLink => {
        const dropdown = activeLink.closest('.nav-dropdown');
        const toggle = dropdown.querySelector('.nav-dropdown-toggle');
        const menu = dropdown.querySelector('.nav-dropdown-menu');
        toggle.classList.add('open');
        menu.classList.add('open');
      });
      
      // Ensure active states are applied to Dashboard and Register
      function applyActiveStates() {
        const currentPath = window.location.pathname;
        const links = document.querySelectorAll('.nav > a');
        
        links.forEach(link => {
          const href = link.getAttribute('href') || '';
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
          
          const normalizedCurrent = currentPath.replace(/^\//, '').replace(/\/$/, '');
          const normalizedHref = hrefPath.replace(/^\//, '').replace(/\/$/, '');
          
          const isMatch = normalizedCurrent === normalizedHref || 
                         normalizedCurrent.startsWith(normalizedHref + '/') ||
                         currentPath === hrefPath ||
                         currentPath.startsWith(hrefPath);
          
          if (isMatch) {
            link.classList.add('active');
            link.setAttribute('aria-current', 'page');
          } else {
            link.classList.remove('active');
            link.removeAttribute('aria-current');
          }
        });
      }
      
      applyActiveStates();
      setTimeout(applyActiveStates, 100);
      setTimeout(applyActiveStates, 300);
    });
    
    // Confirmation dialogs for delete and edit actions
    window.confirmAction = function(message, actionType = 'delete') {
      const typeMessages = {
        delete: 'Are you sure you want to delete this item? This action cannot be undone.',
        edit: 'You are about to edit this item. Do you want to continue?',
        update: 'Are you sure you want to update this item?',
        create: 'Do you want to create a new item?',
        save: 'Do you want to save these changes?',
        cancel: 'Are you sure you want to cancel? Any unsaved changes will be lost.',
        bulk: 'Are you sure you want to perform this action on the selected items?'
      };
      
      const defaultMessage = typeMessages[actionType] || message || 'Are you sure you want to proceed?';
      const finalMessage = message || defaultMessage;
      
      return confirm(finalMessage);
    };
    
    // Auto-apply confirmation to all delete/edit forms and links
    document.addEventListener('DOMContentLoaded', function() {
      // Add confirmation to all delete forms
      document.querySelectorAll('form[method="post"] button[type="submit"]').forEach(button => {
        const form = button.closest('form');
        if (form && form.querySelector('input[name="_method"][value="delete"]')) {
          form.addEventListener('submit', function(e) {
            const itemName = button.textContent.trim() || 'this item';
            const message = `⚠️ DELETE CONFIRMATION\n\nAre you sure you want to delete ${itemName}?\n\nThis action cannot be undone.`;
            if (!confirm(message)) {
              e.preventDefault();
              return false;
            }
          });
        }
      });
      
      // Add confirmation to edit links (optional - can be enabled)
      document.querySelectorAll('a[href*="/edit"]').forEach(link => {
        // Only add if the link has a data-confirm attribute
        if (link.hasAttribute('data-confirm-edit')) {
          link.addEventListener('click', function(e) {
            const message = link.getAttribute('data-confirm-edit') || '⚠️ EDIT CONFIRMATION\n\nYou are about to edit this item. Do you want to continue?';
            if (!confirm(message)) {
              e.preventDefault();
              return false;
            }
          });
        }
      });
      
      // Add confirmation to bulk actions
      document.querySelectorAll('form[id*="bulk"], form[onsubmit*="confirm"]').forEach(form => {
        form.addEventListener('submit', function(e) {
          if (form.onsubmit) {
            // Let existing onsubmit handle it
            return;
          }
          const action = form.querySelector('select[name="action"]');
          if (action && action.value === 'delete') {
            const count = form.querySelector('input[name="ids"]')?.value;
            const message = `⚠️ BULK DELETE CONFIRMATION\n\nAre you sure you want to delete ${count ? JSON.parse(count).length : 'selected'} item(s)?\n\nThis action cannot be undone.`;
            if (!confirm(message)) {
              e.preventDefault();
              return false;
            }
          }
        });
      });
    });
  </script>
</body>
</html>


