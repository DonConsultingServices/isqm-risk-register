document.addEventListener('DOMContentLoaded', () => {
    const root = document.querySelector('[data-module-root]');
    if (!root) {
        console.error('Module root element not found');
        return;
    }

    const endpoint = root.dataset.moduleEndpoint;
    const listsEndpoint = root.dataset.listsEndpoint;
    const viewUrlTemplate = root.dataset.viewUrl || '';
    const editUrlTemplate = root.dataset.editUrl || '';

    const form = root.querySelector('[data-module-form]');
    const clearButton = root.querySelector('[data-module-clear]');
    const tableBody = root.querySelector('[data-module-table]');
    const statElements = root.querySelectorAll('[data-module-stat]');
    const monitoringList = root.querySelector('[data-module-monitoring]');
    const deficiencyList = root.querySelector('[data-module-deficiency]');
    const paginationInfo = root.querySelector('[data-module-pagination-info]');
    const paginationContainer = root.querySelector('[data-module-pagination]');
    const tableWrapper = root.querySelector('.isqm-table-wrap');

    if (!endpoint) {
        console.error('Module endpoint not found in data-module-endpoint attribute');
        if (tableBody) {
            tableBody.innerHTML = '<tr><td colspan="25" style="padding:40px;text-align:center;color:#ef4444;">Error: API endpoint not configured. Please check the page configuration.</td></tr>';
        }
        return;
    }
    
    if (!form) {
        console.error('Module form not found');
        return;
    }
    
    if (!tableBody) {
        console.error('Module table body not found');
        return;
    }
    
    console.log('Module script initialized:', {
        endpoint,
        listsEndpoint,
        hasForm: !!form,
        hasTableBody: !!tableBody,
    });

    const state = {
        page: 1,
        perPage: 20,
    };

    loadLists(listsEndpoint, root);
    loadModuleData();

    form.addEventListener('submit', event => {
        event.preventDefault();
        state.page = 1;
        loadModuleData();
    });

    form.addEventListener('change', () => {
        state.page = 1;
        loadModuleData();
    });

    if (clearButton) {
        clearButton.addEventListener('click', event => {
            event.preventDefault();
            form.reset();
            state.page = 1;
            loadModuleData();
        });
    }

    if (paginationContainer) {
        paginationContainer.addEventListener('click', event => {
            const target = event.target.closest('[data-page]');
            if (!target) {
                return;
            }
            event.preventDefault();
            const page = Number(target.getAttribute('data-page'));
            if (!Number.isNaN(page) && page >= 1) {
                state.page = page;
                loadModuleData();
            }
        });
    }

    function loadModuleData() {
        const params = serializeForm(form);
        params.page = state.page.toString();
        params.per_page = state.perPage.toString();

        const query = new URLSearchParams(params).toString();

        showLoading();
        
        console.log('Loading data from:', `${endpoint}?${query}`);

        fetch(`${endpoint}?${query}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            credentials: 'same-origin',
        })
            .then(response => {
                console.log('Response status:', response.status, response.statusText);
                if (!response.ok) {
                    return response.text().then(text => {
                        console.error('Error response:', text);
                        try {
                            const err = JSON.parse(text);
                            throw new Error(err.message || `Server error: ${response.status} ${response.statusText}`);
                        } catch (e) {
                            throw new Error(`Failed to load data: ${response.status} ${response.statusText}. ${text.substring(0, 200)}`);
                        }
                    });
                }
                return response.json();
            })
            .then(payload => {
                console.log('Data loaded successfully:', payload);
                hideLoading();
                if (!payload) {
                    throw new Error('Empty response from server');
                }
                updateStats(payload.module?.stats || {});
                renderSummary(monitoringList, payload.module?.monitoring_summary || [], '#1e40af');
                renderSummary(deficiencyList, payload.module?.deficiency_summary || [], '#b45309');
                const risksData = payload.risks?.data || [];
                console.log('Rendering', risksData.length, 'risks');
                renderRisks(risksData);
                renderPagination(payload.risks?.meta || {});
            })
            .catch(error => {
                console.error('Module data load error:', error);
                hideLoading();
                showError(error.message || 'An unexpected error occurred while loading data. Please try again.');
            });
    }

    function showLoading() {
        if (tableBody) {
            const existingRows = tableBody.querySelectorAll('tr');
            const hasServerRendered = tableBody.querySelector('[data-server-rendered]');
            
            // Always show loading state, replacing any existing content
            if (existingRows.length === 0 || existingRows.length === 1 || hasServerRendered) {
                tableBody.innerHTML = '<tr><td colspan="25" style="padding:40px;text-align:center;color:#64748b;"><div style="display:inline-flex;align-items:center;gap:8px;"><div style="width:16px;height:16px;border:2px solid #cbd5e1;border-top-color:#3b82f6;border-radius:50%;animation:spin 0.6s linear infinite;"></div>Loading entries...</div></td></tr>';
            } else {
                tableBody.style.opacity = '0.5';
                tableBody.style.pointerEvents = 'none';
            }
        }
        if (form) {
            form.style.opacity = '0.6';
            form.style.pointerEvents = 'none';
        }
    }

    function hideLoading() {
        if (tableBody) {
            tableBody.style.opacity = '';
            tableBody.style.pointerEvents = '';
        }
        if (form) {
            form.style.opacity = '';
            form.style.pointerEvents = '';
        }
    }

    function showError(message) {
        if (tableBody) {
            tableBody.innerHTML = `<tr><td colspan="25" style="padding:40px;text-align:center;"><div style="color:#ef4444;background:#fee2e2;border:1px solid #fecaca;border-radius:8px;padding:16px;display:inline-block;max-width:600px;"><strong style="display:block;margin-bottom:8px;">Error loading data</strong><span>${escapeHtml(message)}</span><button type="button" onclick="location.reload()" style="margin-top:12px;padding:6px 12px;background:#ef4444;color:white;border:none;border-radius:4px;cursor:pointer;font-size:12px;">Reload Page</button></div></td></tr>`;
        }
    }

    function updateStats(stats) {
        statElements.forEach(element => {
            const key = element.getAttribute('data-module-stat');
            if (!key) {
                return;
            }
            if (Object.prototype.hasOwnProperty.call(stats, key)) {
                element.textContent = stats[key];
            } else {
                element.textContent = '0';
            }
        });
    }

    function renderSummary(listElement, items, accentColor = '#1e40af') {
        if (!listElement) {
            return;
        }

        if (!items.length) {
            listElement.innerHTML = '<li style="color:#64748b;">No data available.</li>';
            return;
        }

        listElement.innerHTML = items
            .map(item => `<li style="margin-bottom:6px;">${escapeHtml(item.name)} <span style="color:${accentColor};font-weight:600;">×${item.total}</span></li>`)
            .join('');
    }

    function getOwnerName(entry) {
        if (!entry) return '—';
        // Check if owner is an object with name property
        if (entry.owner && typeof entry.owner === 'object' && entry.owner.name) {
            return entry.owner.name;
        }
        // Fallback to owner_name if it exists
        if (entry.owner_name) {
            return entry.owner_name;
        }
        return '—';
    }

    function getClientName(entry) {
        if (!entry) return '—';
        // Check if client is an object with name property
        if (entry.client && typeof entry.client === 'object' && entry.client.name) {
            return entry.client.name;
        }
        // Fallback to client_name if it exists
        if (entry.client_name) {
            return entry.client_name;
        }
        return '—';
    }

    function renderRisks(risks) {
        if (!risks.length) {
            tableBody.innerHTML = '<tr><td colspan="25" style="padding:16px;color:#64748b;text-align:center;">No entries match the current filters.</td></tr>';
            return;
        }

        const viewTemplate = viewUrlTemplate;
        const editTemplate = editUrlTemplate;

        tableBody.innerHTML = risks
            .map(entry => {
                const reference = entry.import_source ?? `#${entry.id}`;
                const viewUrl = viewTemplate ? viewTemplate.replace(':id', entry.id) : '#';
                const editUrl = editTemplate ? editTemplate.replace(':id', entry.id) : '#';
                
                // Debug: Log entry data for first item to verify structure
                if (risks.indexOf(entry) === 0) {
                    console.log('First entry data:', {
                        entity_level: entry.entity_level,
                        engagement_level: entry.engagement_level,
                        implementation_status: entry.implementation_status,
                        status: entry.status,
                        owner: entry.owner,
                        client: entry.client,
                        owner_name: getOwnerName(entry),
                        client_name: getClientName(entry),
                        due_date: entry.due_date,
                        review_date: entry.review_date,
                        formatted_due_date: formatDate(entry.due_date, entry.status),
                        formatted_review_date: formatDate(entry.review_date),
                        full_entry: entry
                    });
                }

                return `
                    <tr style="border-bottom:1px solid #e2e8f0;">
                        <td style="padding:12px 8px;vertical-align:top;color:#475569;">${escapeHtml(reference)}</td>
                        <td style="padding:12px 8px;vertical-align:top;white-space:pre-wrap;line-height:1.5;">
                            <div style="font-weight:600;color:var(--brand-blue);margin-bottom:4px;">${escapeHtml(entry.quality_objective)}</div>
                            <div style="display:flex;gap:8px;margin-top:12px;">
                                <a href="${viewUrl}" class="btn" style="padding:6px 10px;font-size:12px;background:#64748b;">View</a>
                                <a href="${editUrl}" class="btn" style="padding:6px 10px;font-size:12px;">Edit</a>
                            </div>
                        </td>
                        <td style="padding:12px 8px;vertical-align:top;white-space:pre-wrap;line-height:1.5;">${escapeHtml(entry.quality_risk ?? '—')}</td>
                        <td style="padding:12px 8px;vertical-align:top;white-space:pre-wrap;line-height:1.5;">${escapeHtml(entry.assessment_of_risk ?? '—')}</td>
                        <td style="padding:12px 8px;vertical-align:top;">${renderPill(entry.likelihood)}</td>
                        <td style="padding:12px 8px;vertical-align:top;">${renderPill(entry.adverse_effect)}</td>
                        <td style="padding:12px 8px;vertical-align:top;">
                            <div>
                                ${renderPill(entry.risk_applicable)}
                                ${entry.risk_applicable_details ? `<div style="margin-top:8px;font-size:12px;color:#475569;white-space:pre-wrap;line-height:1.5;">${escapeHtml(entry.risk_applicable_details)}</div>` : ''}
                            </div>
                        </td>
                        <td style="padding:12px 8px;vertical-align:top;white-space:pre-wrap;line-height:1.5;">${escapeHtml(entry.response ?? '—')}</td>
                        <td style="padding:12px 8px;vertical-align:top;white-space:pre-wrap;line-height:1.5;">${escapeHtml(entry.firm_implementation ?? '—')}</td>
                        <td style="padding:12px 8px;vertical-align:top;white-space:pre-wrap;line-height:1.5;">${escapeHtml(entry.toc ?? '—')}</td>
                        <td style="padding:12px 8px;vertical-align:top;">${escapeHtml(entry.monitoring_activity ?? '—')}</td>
                        <td style="padding:12px 8px;vertical-align:top;white-space:pre-wrap;line-height:1.5;">${escapeHtml(entry.findings ?? '—')}</td>
                        <td style="padding:12px 8px;vertical-align:top;">${escapeHtml(entry.deficiency_type ?? '—')}</td>
                        <td style="padding:12px 8px;vertical-align:top;white-space:pre-wrap;line-height:1.5;">${escapeHtml(entry.root_cause ?? '—')}</td>
                        <td style="padding:12px 8px;vertical-align:top;">${renderPill(entry.severe)}</td>
                        <td style="padding:12px 8px;vertical-align:top;">${renderPill(entry.pervasive)}</td>
                        <td style="padding:12px 8px;vertical-align:top;white-space:pre-wrap;line-height:1.5;">${escapeHtml(entry.remedial_actions ?? '—')}</td>
                        <td style="padding:12px 8px;vertical-align:top;">${renderPill(entry.objective_met)}</td>
                        <td style="padding:12px 8px;vertical-align:top;">${renderPill(entry.entity_level)}</td>
                        <td style="padding:12px 8px;vertical-align:top;">${renderPill(entry.engagement_level)}</td>
                        <td style="padding:12px 8px;vertical-align:top;">${escapeHtml(formatStatus(entry.implementation_status ?? ''))}</td>
                        <td style="padding:12px 8px;vertical-align:top;">${renderStatus(entry.status ?? '')}</td>
                        <td style="padding:12px 8px;vertical-align:top;">${escapeHtml(getOwnerName(entry))}</td>
                        <td style="padding:12px 8px;vertical-align:top;">${escapeHtml(getClientName(entry))}</td>
                        <td style="padding:12px 8px;vertical-align:top;">${formatDate(entry.due_date, entry.status)}</td>
                        <td style="padding:12px 8px;vertical-align:top;">${formatDate(entry.review_date)}</td>
                    </tr>
                `;
            })
            .join('');
    }

    function renderPagination(meta) {
        if (!paginationInfo || !paginationContainer) {
            return;
        }

        const total = Number(meta.total) || 0;
        const current = Number(meta.current_page) || 1;
        const perPage = Number(meta.per_page) || state.perPage;
        const last = Number(meta.last_page) || 1;
        const start = total === 0 ? 0 : (current - 1) * perPage + 1;
        const end = total === 0 ? 0 : Math.min(total, current * perPage);

        paginationInfo.textContent = `Showing ${start} to ${end} of ${total} entries`;

        if (last <= 1) {
            paginationContainer.innerHTML = '';
            return;
        }

        const buttons = [];
        if (current > 1) {
            buttons.push(`<button type="button" class="btn" data-page="${current - 1}">Prev</button>`);
        }
        if (current < last) {
            buttons.push(`<button type="button" class="btn" data-page="${current + 1}">Next</button>`);
        }
        paginationContainer.innerHTML = buttons.join('');
    }

    function serializeForm(formElement) {
        const formData = new FormData(formElement);
        const params = {};
        for (const [key, value] of formData.entries()) {
            if (value !== null && value !== '') {
                params[key] = value;
            }
        }
        return params;
    }

    function renderPill(value) {
        // Only render pills for boolean values, ignore strings/text
        if (typeof value === 'string' && value.trim() !== '' && value !== 'true' && value !== 'false' && value !== '1' && value !== '0') {
            // If it's a non-boolean string, return it as text (shouldn't happen, but handle it)
            return escapeHtml(value);
        }
        
        let label = '—';
        let className = 'pill-na';

        if (value === true || value === 'true' || value === '1' || value === 1) {
            label = 'Yes';
            className = 'pill-yes';
        } else if (value === false || value === 'false' || value === '0' || value === 0) {
            label = 'No';
            className = 'pill-no';
        }

        return `<span class="status-pill ${className}">${label}</span>`;
    }

    function formatStatus(value) {
        // Only format strings, not booleans
        if (value === true || value === false || value === null || value === undefined) {
            return '—';
        }
        if (typeof value !== 'string') {
            return String(value);
        }
        if (!value || value.trim() === '') {
            return '—';
        }
        return String(value).replace(/_/g, ' ').replace(/\b\w/g, char => char.toUpperCase());
    }

    function formatDate(value, status = null) {
        // Handle null, undefined, empty string, or dash
        if (!value || value === '—' || value === null || value === undefined || value === '' || value === 'null' || value === 'undefined') {
            return '<span style="color:#94a3b8;">—</span>';
        }

        // Parse Y-m-d format from API (e.g., "2025-11-21")
        let date;
        const dateStr = String(value).trim();
        
        // Check if it's in Y-m-d format
        if (dateStr.match(/^\d{4}-\d{2}-\d{2}$/)) {
            // Parse as UTC to avoid timezone issues
            const [year, month, day] = dateStr.split('-').map(Number);
            date = new Date(Date.UTC(year, month - 1, day));
        } else if (dateStr.match(/^\d{4}-\d{2}-\d{2}T/)) {
            // ISO format with time
            date = new Date(dateStr);
        } else {
            // Try to parse as-is
            date = new Date(dateStr);
        }
        
        // Validate the date
        if (isNaN(date.getTime()) || !date.getTime()) {
            console.warn('Invalid date value:', value, 'type:', typeof value);
            return '<span style="color:#94a3b8;">—</span>';
        }

        // Format as "M d, Y" (e.g., "Jan 15, 2024")
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const month = months[date.getUTCMonth()];
        const day = date.getUTCDate();
        const year = date.getUTCFullYear();
        const formatted = `${month} ${day}, ${year}`;

        // Check if overdue (past date and status is not closed)
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        today.setMinutes(0, 0, 0);
        today.setSeconds(0, 0, 0);
        today.setMilliseconds(0);
        const dateOnly = new Date(date.getUTCFullYear(), date.getUTCMonth(), date.getUTCDate());
        dateOnly.setHours(0, 0, 0, 0);
        const isOverdue = dateOnly < today && status !== 'closed';

        if (isOverdue) {
            return `<span style="color:#ef4444;font-weight:600;">Overdue: ${escapeHtml(formatted)}</span>`;
        }

        return `<span>${escapeHtml(formatted)}</span>`;
    }

    function renderStatus(status) {
        if (!status) {
            return '—';
        }

        const statusMap = {
            'open': { bg: '#fef3c7', color: '#92400e', label: 'Open' },
            'monitoring': { bg: '#dbeafe', color: '#1e40af', label: 'Monitoring' },
            'closed': { bg: '#d1fae5', color: '#065f46', label: 'Closed' },
        };

        const style = statusMap[status] || { bg: '#e2e8f0', color: '#475569', label: formatStatus(status) };
        return `<span style="font-size:12px;padding:4px 8px;border-radius:12px;display:inline-block;font-weight:500;background:${style.bg};color:${style.color};">${escapeHtml(style.label)}</span>`;
    }
});

function loadLists(endpoint, root) {
    if (!endpoint || root.dataset.listsHydrated) {
        return;
    }

    fetch(endpoint, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        },
    })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => {
                    throw new Error(err.message || `Server error: ${response.status} ${response.statusText}`);
                }).catch(() => {
                    throw new Error(`Failed to load dropdown data: ${response.status} ${response.statusText}`);
                });
            }
            return response.json();
        })
        .then(data => {
            populateSelect(root.querySelector('select[name="f_monitoring"]'), data.monitoring_activities, { value: 'id', label: 'name', includeAll: true });
            populateSelect(root.querySelector('select[name="f_deficiency"]'), data.deficiency_types, { value: 'id', label: 'name', includeAll: true });
            populateSelect(root.querySelector('select[name="f_owner"]'), data.owners, { value: 'id', label: 'name', includeAll: true });
            populateSelect(root.querySelector('select[name="f_client"]'), data.clients, { value: 'id', label: 'name', includeAll: true });
            populateSelect(root.querySelector('select[name="status"]'), data.status_options, { value: 'value', label: 'label', includeAll: true });
            populateSelect(root.querySelector('select[name="f_impl_status"]'), data.implementation_statuses, { value: 'value', label: 'label', includeAll: true });
            root.dataset.listsHydrated = 'true';
        })
        .catch(error => {
            console.error('Failed to load filter dropdown data:', error);
            // Don't show error to user for dropdown loading - filters will just use server-side options
        });
}

function populateSelect(selectElement, options, config = {}) {
    if (!selectElement || !Array.isArray(options)) {
        return;
    }

    const valueKey = config.value || 'value';
    const labelKey = config.label || 'label';
    const includeAll = config.includeAll ?? false;
    const previous = selectElement.value;

    const optionElements = [];
    if (includeAll) {
        optionElements.push('<option value="">All</option>');
    }

    options.forEach(option => {
        const value = option[valueKey];
        const label = option[labelKey];
        optionElements.push(`<option value="${escapeHtml(value)}">${escapeHtml(label)}</option>`);
    });

    selectElement.innerHTML = optionElements.join('');

    if (previous !== undefined && previous !== null && previous !== '') {
        selectElement.value = previous;
        if (selectElement.value !== previous) {
            // fallback if previous value no longer exists
            selectElement.value = '';
        }
    }
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
