document.addEventListener('DOMContentLoaded', () => {
    const root = document.querySelector('[data-dashboard]');
    if (!root) {
        return;
    }

    const endpoint = root.getAttribute('data-endpoint');
    if (!endpoint) {
        return;
    }

    fetch(endpoint)
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to load dashboard data');
            }
            return response.json();
        })
        .then(data => {
            updateStats(root, data.stats || {});
            renderModulesTable(root, data.modules || []);
            renderModulesSummary(root, data.modules || []);
            renderRecentOpen(root, data.recent_open || []);
            renderNotifications(root, data.notifications || []);
        })
        .catch(error => {
            console.error(error);
        });
});

function updateStats(root, stats) {
    const statElements = root.querySelectorAll('[data-dashboard-stat]');
    statElements.forEach(el => {
        const key = el.getAttribute('data-dashboard-stat');
        if (key in stats) {
            el.textContent = stats[key];
        }
    });
}

function renderModulesTable(root, modules) {
    const tableBody = root.querySelector('[data-dashboard-modules-table]');
    if (!tableBody) {
        return;
    }

    if (!modules.length) {
        tableBody.innerHTML = '<tr><td colspan="5" style="padding:16px;color:#64748b;">No module data available.</td></tr>';
        return;
    }

    tableBody.innerHTML = modules.map(module => {
        const closed = module.total - module.open - module.monitoring;
        return `
            <tr>
                <td><strong>${escapeHtml(module.name)}</strong></td>
                <td><strong>${module.total}</strong></td>
                <td><span style="color:#92400e;">${module.open}</span></td>
                <td><span style="color:#1e40af;">${module.monitoring}</span></td>
                <td><span style="color:#065f46;">${closed < 0 ? 0 : closed}</span></td>
            </tr>
        `;
    }).join('');
}

function renderModulesSummary(root, modules) {
    const container = root.querySelector('[data-dashboard-modules-summary]');
    if (!container) {
        return;
    }

    if (!modules.length) {
        container.innerHTML = '<p style="color:#64748b;">No module data available.</p>';
        return;
    }

    container.innerHTML = modules.map(module => {
        const closed = module.total - module.open - module.monitoring;
        const openPercentage = module.total > 0 ? Math.round((module.open / module.total) * 100) : 0;
        return `
            <div style="padding:16px;background:#f8fafc;border-radius:8px;border-left:4px solid var(--brand-blue);">
                <div style="font-size:12px;color:#64748b;margin-bottom:8px;">${escapeHtml(module.name)}</div>
                <div style="font-size:28px;font-weight:700;color:var(--brand-blue);margin-bottom:8px;">${module.total}</div>
                <div style="display:flex;gap:12px;font-size:12px;">
                    <span style="color:#92400e;">${module.open} open</span>
                    <span style="color:#1e40af;">${module.monitoring} monitoring</span>
                    <span style="color:#065f46;">${closed < 0 ? 0 : closed} closed</span>
                </div>
                <div style="margin-top:12px;font-size:12px;color:#475569;">Severe: ${module.severe} | Pervasive: ${module.pervasive}</div>
                <div style="margin-top:8px;height:4px;background:#e2e8f0;border-radius:2px;overflow:hidden;">
                    <div style="height:100%;background:var(--brand-blue);width:${openPercentage}%;"></div>
                </div>
            </div>
        `;
    }).join('');
}

function renderRecentOpen(root, entries) {
    const table = root.querySelector('[data-dashboard-recent-table] tbody');
    if (!table) {
        return;
    }

    if (!entries.length) {
        table.innerHTML = '<tr><td colspan="4" style="padding:16px;color:#64748b;">No open items.</td></tr>';
        return;
    }

    table.innerHTML = entries.map(entry => {
        const statusClass = `badge-${escapeHtml(entry.status)}`;
        const dueLabel = entry.overdue
            ? '<span class="badge badge-overdue">Overdue</span>'
            : (entry.due_date ?? '—');
        return `
            <tr>
                <td>${escapeHtml(entry.module ?? '—')}</td>
                <td>${escapeHtml(entry.quality_objective ?? '')}</td>
                <td><span class="badge ${statusClass}">${escapeHtml(capitalize(entry.status))}</span></td>
                <td>${dueLabel}</td>
            </tr>
        `;
    }).join('');
}

function renderNotifications(root, notifications) {
    const container = root.querySelector('[data-dashboard-notifications]');
    if (!container) {
        return;
    }

    if (!notifications.length) {
        container.innerHTML = '<p style="color:#64748b;">No recent notifications.</p>';
        return;
    }

    container.innerHTML = `
        <ul style="list-style:none;padding:0;margin:0;">
            ${notifications.map(notification => `
                <li style="padding:10px 0;border-bottom:1px solid #e2e8f0;">
                    <div style="font-weight:500;">${escapeHtml(notification.title)}</div>
                    <div style="font-size:12px;color:#64748b;">${escapeHtml(notification.created_at)}</div>
                </li>
            `).join('')}
        </ul>
        <div style="margin-top:12px;">
            <a href="/notifications" class="btn">View All</a>
        </div>
    `;
}

function escapeHtml(value) {
    if (value === undefined || value === null) {
        return '';
    }
    return String(value)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

function capitalize(value) {
    if (!value) {
        return '';
    }
    return String(value).charAt(0).toUpperCase() + String(value).slice(1);
}
