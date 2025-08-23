<div class="container-fluid">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Manajemen Departemen</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <button type="button" class="btn btn-primary" onclick="add_departemen()">
                <i class="fa fa-plus"></i> Tambah Departemen
            </button>
        </div>
        <div class="card-body">
            <table id="departemenTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Departemen</th>
                        <th>Divisi</th> <!-- [DIUBAH] Tambah kolom Divisi -->
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="ajax-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-title"></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="departemenForm" name="departemenForm" class="form-horizontal">
                    <input type="hidden" name="id" id="id">
                    <div class="mb-3">
                        <label for="nama_departemen" class="form-label">Nama Departemen</label>
                        <input type="text" class="form-control" id="nama_departemen" name="nama_departemen" placeholder="Masukkan Nama Departemen">
                    </div>
                    <!-- [BARU] Dropdown untuk memilih Divisi -->
                    <div class="mb-3">
                        <label for="divisi_id" class="form-label">Divisi</label>
                        <select class="form-select" name="divisi_id" id="divisi_id">
                            <option value="">-- Pilih Divisi --</option>
                            <?php foreach($divisi as $d): ?>
                            <option value="<?= $d['id'] ?>"><?= $d['nama_divisi'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btn-save" onclick="save_departemen()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    var table;

    $(document).ready(function() {
        table = $('#departemenTable').DataTable({
            "processing": true,
            "ajax": {
                "url": "<?= site_url('departemen/ajax_list') ?>",
                "type": "GET",
                "dataSrc": "data"
            },
            "columns": [
                { "data": null, "render": function (data, type, row, meta) { return meta.row + 1; }},
                { "data": "nama_departemen" },
                { "data": "nama_divisi" }, // [DIUBAH] Tampilkan nama divisi
                { "data": null, "render": function (data, type, row) {
                    return `<button class="btn btn-warning btn-sm" onclick="edit_departemen(${row.id})"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-danger btn-sm" onclick="delete_departemen(${row.id})"><i class="fas fa-trash"></i></button>`;
                }}
            ],
            "columnDefs": [ { "orderable": false, "targets": [0, 3] } ]
        });
    });

    function reload_table() {
        table.ajax.reload(null, false);
    }

    function add_departemen() {
        $('#departemenForm')[0].reset();
        $('#id').val('');
        $('#modal-title').html('Tambah Departemen');
        $('#ajax-modal').modal('show');
    }

    function save_departemen() {
        $.ajax({
            url: "<?= site_url('departemen/ajax_save') ?>",
            type: "POST", data: $('#departemenForm').serialize(), dataType: "JSON",
            success: (res) => {
                if(res.status === 'success'){
                    $('#ajax-modal').modal('hide');
                    Swal.fire('Sukses', res.message, 'success');
                    reload_table();
                } else {
                     Swal.fire('Error', 'Gagal menyimpan data. Periksa validasi.', 'error');
                }
            },
            error: () => Swal.fire('Error', 'Terjadi kesalahan pada server.', 'error')
        });
    }

    function edit_departemen(id) {
        $('#departemenForm')[0].reset();
        $.ajax({
            url: "<?= site_url('departemen/ajax_edit/') ?>" + id, type: "GET", dataType: "JSON",
            success: (data) => {
                $('[name="id"]').val(data.id);
                $('[name="nama_departemen"]').val(data.nama_departemen);
                $('[name="divisi_id"]').val(data.divisi_id); // [BARU] Set value untuk dropdown divisi
                $('#modal-title').html('Edit Departemen');
                $('#ajax-modal').modal('show');
            },
            error: () => Swal.fire('Error', 'Gagal mengambil data.', 'error')
        });
    }

    function delete_departemen(id) {
        Swal.fire({
            title: 'Anda yakin?', text: "Data ini tidak dapat dikembalikan!", icon: 'warning',
            showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('departemen/ajax_delete/') ?>" + id, type: "DELETE", dataType: "JSON",
                    success: (res) => {
                        Swal.fire('Dihapus!', res.message, 'success');
                        reload_table();
                    },
                    error: () => Swal.fire('Error', 'Gagal menghapus data.', 'error')
                });
            }
        })
    }
</script>