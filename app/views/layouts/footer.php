            </div>
            <!-- /Page content wrapper -->
            
            <footer class="bg-white border-top text-center py-3 text-muted w-100">
                <small>&copy; <?= date('Y') ?> Hotel Management System | Designed with Clean MVC</small>
            </footer>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izimodal/1.6.1/js/iziModal.min.js"></script>
    <script src="<?= BASE_URL ?>/js/app.js?v=<?= time() ?>"></script>
    <script>
        window.Translations = {
            success: '<?= __('success') ?>',
            error: '<?= __('error') ?>',
            are_you_sure: '<?= __('are_you_sure') ?>',
            confirm_message: '<?= __('confirm_message') ?>',
            yes_confirm: '<?= __('yes_confirm') ?>',
            cancel: '<?= __('cancel') ?>',
            deleted: '<?= __('deleted') ?>',
            action_failed: '<?= __('action_failed') ?>',
            server_error: '<?= __('server_error') ?>',
            network_error: '<?= __('network_error') ?>',
            saving: '<?= __('saving') ?>'
        };

        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.getElementById('sidebarToggle');
            const wrapper = document.getElementById('wrapper');
            
            // Toggle sidebar
            if (toggleBtn) {
                toggleBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    wrapper.classList.toggle('toggled');
                });
            }
            
            // Auto-hide on mobile initially
            if(window.innerWidth <= 768) {
                wrapper.classList.add('toggled');
            }

            // --- Custom Notifications for PHP Session Messages ---
            <?php if (isset($_SESSION['success_msg'])): ?>
                if (typeof window.showAlert === 'function') {
                    window.showAlert('<?= htmlspecialchars($_SESSION['success_msg']) ?>', 'success');
                }
                <?php unset($_SESSION['success_msg']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error_msg'])): ?>
                if (typeof window.showAlert === 'function') {
                    window.showAlert('<?= htmlspecialchars($_SESSION['error_msg']) ?>', 'error');
                }
                <?php unset($_SESSION['error_msg']); ?>
            <?php endif; ?>
        });
    </script>
</body>
</html>
