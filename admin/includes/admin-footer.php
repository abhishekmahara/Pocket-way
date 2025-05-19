</div> <!-- Close container-fluid from header -->

<footer class="footer mt-auto py-3" style="background-color: #007B7F;">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-4">
                <div class="d-flex align-items-center">
                    <img src="../../assets/img/logoo.png" alt="Logo" style="height: 40px; margin-right: 10px;">
                    <div class="text-white">
                        <p class="mb-0">Pocket-way Admin</p>
                        <small class="text-white-50">Version 1.0</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <p class="text-white mb-0">&copy; <?php echo date('Y'); ?> Pocket-way. All rights reserved.</p>
            </div>
           
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<script>
    // Initialize DataTables
    $(document).ready(function() {
        $('.datatable').DataTable({
            "pageLength": 25,
            "responsive": true
        });

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Auto hide alerts after 5 seconds
        $('.alert').delay(5000).fadeOut(500);
    });
</script>
</body>
</html>