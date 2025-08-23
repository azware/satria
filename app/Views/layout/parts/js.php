<!-- REQUIRED SCRIPTS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.28/dist/sweetalert2.all.min.js"></script>

<!-- Global variables for JavaScript -->
<script>
    const SATRIA_GLOBALS = {
        // Gunakan site_url('/') untuk memastikan ada trailing slash
        siteUrl: '<?= site_url('/') ?>'
    };
</script>

<!-- Custom App Script -->
<script src="<?= base_url('assets/js/app.js?v=1.9') ?>"></script>