<div class="container-fluid">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Manajemen Jabatan</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="card">
        <div class="card-header">
            <button type="button" class="btn btn-primary" onclick="add_jabatan()">
                <i class="fa fa-plus"></i> Tambah Jabatan
            </button>
        </div>
        <div class="card-body">
            <table id="JabatanTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Jabatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bootstrap Modal -->
<div class="modal fade" id="ajax-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-title"></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="JabatanForm" name="JabatanForm" class="form-horizontal">
                    <input type="hidden" name="id" id="id">
                    <div class="mb-3">
                        <label for="nama_jabatan" class="form-label">Nama Jabatan</label>
                        <input type="text" class="form-control" id="nama_jabatan" name="nama_jabatan" placeholder="Masukkan Nama Jabatan">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btn-save" onclick="save_jabatan()">Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- End Bootstrap Modal -->

<script>
    var table;

    $(document).ready(function() {
        // Inisialisasi DataTables
        table = $('#JabatanTable').DataTable({
            "processing": true,
            "ajax": {
                "url": "<?= site_url('jabatan/ajax_list') ?>",
                "type": "GET",
                "dataSrc": "data"
            },
            "columns": [
                { "data": null, "render": function (data, type, row, meta) { return meta.row + 1; }},
                { "data": "nama_jabatan" },
                { "data": null, "render": function (data, type, row) {
                    return `<button class="btn btn-warning btn-sm" onclick="edit_jabatan(${row.id})"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-danger btn-sm" onclick="delete_jabatan(${row.id})"><i class="fas fa-trash"></i></button>`;
                }}
            ],
            "columnDefs": [ { "orderable": false, "targets": [0, 2] } ] // No dan Aksi tidak bisa di-sort
        });
    });

    function reload_table() {
        table.ajax.reload(null, false);
    }

    function add_jabatan() {
        $('#JabatanForm')[0].reset();
        $('#id').val(''); // Pastikan ID kosong
        $('#modal-title').html('Tambah Jabatan');
        $('#ajax-modal').modal('show');
    }

    function save_jabatan() {
        $.ajax({
            url: "<?= site_url('jabatan/ajax_save') ?>",
            type: "POST",
            data: $('#JabatanForm').serialize(),
            dataType: "JSON",
            success: function(res) {
                if(res.status === 'success'){
                    $('#ajax-modal').modal('hide');
                    Swal.fire('Sukses', res.message, 'success');
                    reload_table();
                } else {
                     Swal.fire('Error', 'Gagal menyimpan data. Periksa validasi.', 'error');
                }
            },
            error: function(xhr) {
                 Swal.fire('Error', 'Terjadi kesalahan pada server.', 'error');
            }
        });
    }

    function edit_jabatan(id) {
        $('#JabatanForm')[0].reset();
        $.ajax({
            url: "<?= site_url('jabatan/ajax_edit/') ?>" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('[name="id"]').val(data.id);
                $('[name="nama_jabatan"]').val(data.nama_jabatan);
                $('#modal-title').html('Edit Jabatan');
                $('#ajax-modal').modal('show');
            },
            error: function() {
                Swal.fire('Error', 'Gagal mengambil data.', 'error');
            }
        });
    }

    function delete_jabatan(id) {
        Swal.fire({
            title: 'Anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('jabatan/ajax_delete/') ?>" + id,
                    type: "DELETE",
                    dataType: "JSON",
                    success: function(res) {
                        Swal.fire('Dihapus!', res.message, 'success');
                        reload_table();
                    },
                    error: function() {
                        Swal.fire('Error', 'Gagal menghapus data.', 'error');
                    }
                });
            }
        })
    }
</script>