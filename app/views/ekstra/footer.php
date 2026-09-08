</div> 
    <!-- End of Main Content Container -->

    <!-- Footer -->
    <footer class="footer mt-auto py-3 bg-white border-top shadow-sm">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between small text-muted">
                <div>
                    <span>&copy; <?= date('Y'); ?> <strong>BKK Dosqla</strong>. All rights reserved.</span>
                </div>
                <div class="d-none d-sm-block">
                    <span class="me-3"><i class="fas fa-code-branch me-1"></i>v1.0.0</span>
                    <a href="#" class="text-muted text-decoration-none me-3">Privasi</a>
                    <a href="#" class="text-muted text-decoration-none">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Auto hide alerts after 4 seconds
            const alerts = document.querySelectorAll('.alert-dismissible');
            alerts.forEach(function (alert) {
                setTimeout(function () {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 4000);
            });

            // Toggle Sidebar script (jika menggunakan sidebar)
            const sidebarToggle = document.getElementById('sidebarToggle');
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function (event) {
                    event.preventDefault();
                    document.body.classList.toggle('sb-sidenav-toggled');
                });
            }
        });
    </script>
</body>
</html>