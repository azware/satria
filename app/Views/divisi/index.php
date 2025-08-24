<div class="container-fluid">
    <!-- Header Halaman -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Manajemen Divisi</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Konten Utama -->
    <div class="card">
        <div class="card-header">
            <button type="button" class="btn btn-primary" onclick="add_divisi()">
                <i class="fa fa-plus"></i> Tambah Divisi
            </button>
        </div>
        <div class="card-body">
            <table id="divisiTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th>Nama Divisi</th>
                        <th>Deskripsi</th>
                        <th style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal untuk Form Tambah/Edit -->
<div class="modal fade" id="ajax-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-title"></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="divisiForm" name="divisiForm" class="form-horizontal">
                    <input type="hidden" name="id" id="id">
                    <div class="mb-3">
                        <label for="nama_divisi" class="form-label">Nama Divisi</label>
                        <input type="text" class="form-control" id="nama_divisi" name="nama_divisi" placeholder="Masukkan Nama Divisi" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Masukkan Deskripsi (Opsional)"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btn-save" onclick="save_divisi()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript Khusus Halaman Ini -->
<script>
    var table;

    $(document).ready(function() {
        // Inisialisasi DataTables
        table = $('#divisiTable').DataTable({
            "processing": true,
            "ajax": {
                "url": "<?= site_url('divisi/ajax_list') ?>",
                "type": "GET",
                "dataSrc": "data"
            },
            "columns": [
                { "data": null, "render": (data, type, row, meta) => meta.row + 1 },
                { "data": "nama_divisi" },
                { "data": "deskripsi" },
                { "data": null, "render": (data, type, row) => {
                    return `<button class="btn btn-warning btn-sm me-1" onclick="edit_divisi(${row.id})"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-danger btn-sm" onclick="delete_divisi(${row.id})"><i class="fas fa-trash"></i></button>`;
                }}
            ],
            "columnDefs": [ { "orderable": false, "targets": [0, 3] } ]
        });
    });

    function reload_table() {
        table.ajax.reload(null, false);
    }

    function add_divisi() {
        $('#divisiForm')[0].reset();
        $('#id').val('');
        $('#modal-title').html('Tambah Divisi');
        $('#ajax-modal').modal('show');
    }

    function save_divisi() {
        $.ajax({
            url: "<?= site_url('divisi/ajax_save') ?>", type: "POST", data: $('#divisiForm').serialize(), dataType: "JSON",
            success: (res) => {
                if (res.status === 'success') {
                    $('#ajax-modal').modal('hide');
                    Swal.fire('Sukses', res.message, 'success');
                    reload_table();
                } else {
                    Swal.fire('Error', 'Gagal menyimpan data. Pastikan nama divisi unik.', 'error');
                }
            },
            error: () => Swal.fire('Error', 'Terjadi kesalahan pada server.', 'error')
        });
    }

    function edit_divisi(id) {
        $('#divisiForm')[0].reset();
        $.ajax({
            url: "<?= site_url('divisi/ajax_edit/') ?>" + id, type: "GET", dataType: "JSON",
            success: (data) => {
                $('[name="id"]').val(data.id);
                $('[name="nama_divisi"]').val(data.nama_divisi);
                $('[name="deskripsi"]').val(data.deskripsi);
                $('#modal-title').html('Edit Divisi');
                $('#ajax-modal').modal('show');
            },
            error: () => Swal.fire('Error', 'Gagal mengambil data.', 'error')
        });
    }

    function delete_divisi(id) {
        Swal.fire({
            title: 'Anda yakin?', text: "Menghapus divisi akan membuat departemen di bawahnya tidak terasosiasi.", icon: 'warning',
            showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('divisi/ajax_delete/') ?>" + id, type: "DELETE", dataType: "JSON",
                    success: (res) => {
                        Swal.fire('Dihapus!', res.message, 'success');
                        reload_table();
                    },
                    error: () => Swal.fire('Error', 'Gagal menghapus data.', 'error')
                });
            }
        });
    }
</script>