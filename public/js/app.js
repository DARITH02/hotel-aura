document.addEventListener('DOMContentLoaded', () => {
    // --- Global Notification Helper (iziToast) ---
    window.showAlert = function(message, type = 'success', timeout = 5000) {
        const config = {
            message: message,
            position: 'topRight',
            timeout: timeout,
            transitionIn: 'fadeInUp',
            transitionOut: 'fadeOut',
            progressBarColor: 'rgba(255,255,255,0.2)',
            displayMode: 2,
            layout: 2,
            balloon: false,
            close: true,
            theme: 'dark',
            messageSize: '16',
            messageColor: '#ffffff',
            titleColor: '#ffffff',
            iconColor: '#ffffff',
            maxWidth: 400
        };

        if (type === 'success') {
            iziToast.success({ 
                ...config, 
                title: window.Translations.success || 'Success', 
                backgroundColor: 'linear-gradient(135deg, #10b981 0%, #059669 100%)',
                icon: false
            });
        } else if (type === 'error' || type === 'danger') {
            iziToast.error({ 
                ...config, 
                title: window.Translations.error || 'Error', 
                backgroundColor: 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)',
                icon: false
            });
        } else if (type === 'warning') {
            iziToast.warning({ 
                ...config, 
                title: 'Warning', 
                backgroundColor: 'linear-gradient(135deg, #f59e0b 0%, #d97706 100%)',
                icon: false
            });
        } else {
            iziToast.info({ 
                ...config, 
                title: 'Notice',
                backgroundColor: 'linear-gradient(135deg, #3b82f6 0%, #2563eb 100%)',
                icon: false
            });
        }
    };

    window.notify = window.showAlert;

    // --- Premium Confirm Dialog ---
    window.confirmAction = function(message, cb) {
        iziToast.question({
            timeout: false,
            close: false,
            overlay: true,
            displayMode: 'once',
            id: 'question',
            zindex: 10001,
            title: window.Translations.confirm_title || 'Confirmation',
            message: message,
            position: 'center',
            backgroundColor: '#111827',
            titleColor: '#ffffff',
            messageColor: 'rgba(255,255,255,0.7)',
            icon: false,
            maxWidth: 500,
            layout: 2, // Modern layout
            drag: false,
            buttons: [
                ['<button class="izi-btn-confirm"><b>' + (window.Translations.yes_confirm || 'YES') + '</b></button>', function (instance, toast) {
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    if (cb) cb();
                }, true],
                ['<button class="izi-btn-cancel">' + (window.Translations.cancel || 'CANCEL') + '</button>', function (instance, toast) {
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                }],
            ],
            onOpening: function(instance, toast){
                const confirmBtn = toast.querySelector('.izi-btn-confirm');
                const cancelBtn = toast.querySelector('.izi-btn-cancel');
                if(confirmBtn) {
                    confirmBtn.style.background = 'linear-gradient(135deg, #c5a059 0%, #a88746 100%)';
                    confirmBtn.style.color = 'white';
                    confirmBtn.style.padding = '10px 24px';
                    confirmBtn.style.borderRadius = '50px';
                    confirmBtn.style.border = 'none';
                    confirmBtn.style.margin = '5px';
                    confirmBtn.style.fontWeight = '800';
                    confirmBtn.style.fontSize = '12px';
                }
                if(cancelBtn) {
                    cancelBtn.style.background = 'rgba(255,255,255,0.05)';
                    cancelBtn.style.color = 'rgba(255,255,255,0.6)';
                    cancelBtn.style.padding = '10px 24px';
                    cancelBtn.style.border = '1px solid rgba(255,255,255,0.1)';
                    cancelBtn.style.borderRadius = '50px';
                    cancelBtn.style.margin = '5px';
                    cancelBtn.style.fontSize = '12px';
                }
            }
        });
    };

    // --- AJAX Helpers ---
    const showLoading = (btn) => {
        if (!btn) return;
        btn.dataset.originalHtml = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span> ${window.Translations.saving || 'Processing...'}`;
    };

    const hideLoading = (btn) => {
        if (!btn || !btn.dataset.originalHtml) return;
        btn.innerHTML = btn.dataset.originalHtml;
        btn.disabled = false;
    };

    // Generic AJAX Action Handling (links with .ajax-action or .ajax-delete)
    document.addEventListener('click', async function(e) {
        const btn = e.target.closest('.ajax-action') || e.target.closest('.ajax-delete');
        if (!btn) return;
        
        e.preventDefault();
        const url = btn.href;
        const rowId = btn.dataset.rowId;
        const isDangerous = btn.classList.contains('text-danger') || btn.classList.contains('ajax-delete') || url.includes('cancel') || url.includes('delete');
        
        const execute = async () => {
            const originalContent = btn.innerHTML;
            btn.innerHTML = `<span class="spinner-border spinner-border-sm"></span>`;
            btn.classList.add('disabled');
            btn.style.pointerEvents = 'none';

            try {
                const response = await fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await response.json();
                
                if (data.success) {
                    window.showAlert(data.message, 'success');
                    
                    // Handle Row Removal (Graceful disappearance)
                    if (rowId || btn.dataset.rowId) {
                        const targetRow = document.getElementById(rowId || btn.dataset.rowId);
                        if (targetRow) {
                            targetRow.classList.add('ajax-row-removing');
                            setTimeout(() => {
                                targetRow.remove();
                                // Check if table is empty to show empty state
                                const tbody = targetRow.closest('tbody');
                                if (tbody && tbody.querySelectorAll('tr').length === 0) {
                                    window.location.reload(); 
                                }
                            }, 500);
                        } else if (data.reload !== false) {
                            setTimeout(() => window.location.reload(), 1000);
                        }
                    } else if (data.reload !== false) {
                        setTimeout(() => window.location.reload(), 800);
                    }
                } else {
                    window.showAlert(data.message || (window.Translations.action_failed || 'Action failed'), 'error');
                    btn.innerHTML = originalContent;
                    btn.classList.remove('disabled');
                    btn.style.pointerEvents = 'auto';
                }
            } catch (error) {
                window.showAlert(window.Translations.network_error || 'Network or server error', 'error');
                btn.innerHTML = originalContent;
                btn.classList.remove('disabled');
                btn.style.pointerEvents = 'auto';
            }
        };

        if (isDangerous) {
            const confirmMsg = btn.dataset.confirm || (window.Translations.confirm_message || 'Are you sure you want to proceed?');
            window.confirmAction(confirmMsg, execute);
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
                        setTimeout(() => window.location.reload(), 1000);
                    }
                } else {
                    window.showAlert(data.message || (window.Translations.action_failed || 'Action failed'), 'error');
                }
            } catch (error) {
                window.showAlert(window.Translations.network_error || 'Network or server error', 'error');
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
