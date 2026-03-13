document.addEventListener('DOMContentLoaded', () => {
    // --- Global Notification Helper (iziToast) ---
    window.showAlert = function(message, type = 'success', timeout = 5000) {
        const config = {
            message: message,
            position: 'topRight',
            timeout: timeout,
            transitionIn: 'flipInX',
            transitionOut: 'fadeOut',
            progressBarColor: 'rgba(255,255,255,0.5)',
            displayMode: 2
        };

        if (type === 'success') {
            iziToast.success({ ...config, title: window.Translations.success || 'Success', backgroundColor: '#10b981' });
        } else if (type === 'error' || type === 'danger') {
            iziToast.error({ ...config, title: window.Translations.error || 'Error', backgroundColor: '#ef4444' });
        } else if (type === 'warning') {
            iziToast.warning({ ...config, title: 'Warning', backgroundColor: '#f59e0b' });
        } else {
            iziToast.info({ ...config, title: 'Notice' });
        }
    };

    window.notify = window.showAlert;

    // --- Premium Confirm Dialog ---
    window.confirmAction = function(message, cb) {
        iziToast.question({
            timeout: 20000,
            close: false,
            overlay: true,
            displayMode: 'once',
            id: 'question',
            zindex: 9999,
            title: 'Confirm',
            message: message,
            position: 'center',
            buttons: [
                ['<button><b>YES</b></button>', function (instance, toast) {
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    if (cb) cb();
                }, true],
                ['<button>NO</button>', function (instance, toast) {
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                }],
            ]
        });
    };

    // --- AJAX Helpers ---
    const showLoading = (btn) => {
        if (!btn) return;
        btn.dataset.originalHtml = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span> ${window.Translations.saving || 'Saving...'}`;
    };

    const hideLoading = (btn) => {
        if (!btn || !btn.dataset.originalHtml) return;
        btn.innerHTML = btn.dataset.originalHtml;
        btn.disabled = false;
    };

    // Generic AJAX Action Handling (links with .ajax-action)
    document.addEventListener('click', async function(e) {
        const btn = e.target.closest('.ajax-action');
        if (!btn) return;
        
        e.preventDefault();
        const url = btn.href;
        const isDangerous = btn.classList.contains('text-danger') || url.includes('cancel') || url.includes('delete');
        
        const execute = async () => {
            const originalContent = btn.innerHTML;
            btn.innerHTML = `<span class="spinner-border spinner-border-sm me-1"></span>`;
            btn.style.pointerEvents = 'none';

            try {
                const response = await fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await response.json();
                if (data.success) {
                    window.showAlert(data.message, 'success');
                    if (data.reload !== false) setTimeout(() => window.location.reload(), 1000);
                } else {
                    window.showAlert(data.message || 'Action failed', 'error');
                    btn.innerHTML = originalContent;
                    btn.style.pointerEvents = 'auto';
                }
            } catch (error) {
                window.showAlert('Network or server error', 'error');
                btn.innerHTML = originalContent;
                btn.style.pointerEvents = 'auto';
            }
        };

        if (isDangerous) {
            window.confirmAction(window.Translations.confirm_message || 'Are you sure?', execute);
        } else {
            execute();
        }
    });

    // AJAX Form Handling
    document.querySelectorAll('.ajax-form').forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            const submitBtn = this.querySelector('button[type="submit"]');
            showLoading(submitBtn);

            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: new FormData(this),
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });

                const data = await response.json();
                if (data.success) {
                    window.showAlert(data.message, 'success');
                    const modalEl = this.closest('.modal');
                    if (modalEl) {
                        const modal = bootstrap.Modal.getInstance(modalEl);
                        if (modal) setTimeout(() => modal.hide(), 500);
                    }
                    if (data.reload !== false) {
                        setTimeout(() => window.location.reload(), 1500);
                    }
                } else {
                    window.showAlert(data.message || 'Action failed', 'error');
                }
            } catch (error) {
                window.showAlert('Network or server error', 'error');
            } finally {
                hideLoading(submitBtn);
            }
        });
    });

    // --- UI Helpers ---
    window.initTableSearch = function(inputSelector, tableSelector) {
        const input = document.querySelector(inputSelector);
        const table = document.querySelector(tableSelector);
        if (!input || !table) return;

        const tbody = table.querySelector('tbody');
        
        input.addEventListener('input', () => {
            const val = input.value.toLowerCase();
            // Re-query rows inside listener to handle dynamic changes (deletions/additions)
            // We ignore any row that has a colspan (usually an empty state row)
            const rows = Array.from(tbody.querySelectorAll('tr:not(.no-results-row)'));
            let hasVisibleRows = false;
            let actualDataRowCount = 0;

            rows.forEach(tr => {
                // Skip PHP-side empty state rows (usually have a single td with colspan)
                if (tr.cells.length === 1 && tr.cells[0].hasAttribute('colspan')) {
                    if (val === "") {
                        tr.style.display = ''; // Show PHP empty row if search is empty
                    } else {
                        tr.style.display = 'none'; // Hide it if user is searching
                    }
                    return;
                }

                actualDataRowCount++;
                const match = tr.innerText.toLowerCase().includes(val);
                tr.style.display = match ? '' : 'none';
                if (match) hasVisibleRows = true;
            });

            // Handle JS-side No Results Row
            let noResultsRow = tbody.querySelector('.no-results-row');
            
            // Only show JS-side "No matches" if we actually have data rows but none match
            // OR if the table is completely empty and search is not empty
            if (!hasVisibleRows && val !== "") {
                if (!noResultsRow) {
                    const colCount = table.querySelectorAll('thead th').length || 10;
                    noResultsRow = document.createElement('tr');
                    noResultsRow.className = 'no-results-row';
                    noResultsRow.innerHTML = `
                        <td colspan="${colCount}" class="text-center py-5">
                            <i class="bi bi-search text-muted opacity-25 display-4 d-block mb-3"></i>
                            <h5 class="text-muted fw-bold">No results matching "${val}"</h5>
                            <p class="text-muted small mb-0">Try checking for typos or use different keywords</p>
                        </td>
                    `;
                    tbody.appendChild(noResultsRow);
                } else {
                    noResultsRow.querySelector('h5').innerText = `No results matching "${val}"`;
                }
            } else if (noResultsRow) {
                noResultsRow.remove();
            }
        });
    };
});
