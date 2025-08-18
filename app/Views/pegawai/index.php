<div class="container-fluid">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Manajemen Pegawai</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="card">
        <div class="card-header">
            <button type="button" class="btn btn-primary" onclick="add_new()">
                <i class="fa fa-plus"></i> Tambah Data
            </button>
        </div>
        <div class="card-body">
            <table id="pegawaiTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIP</th>
                        <th>Nama Lengkap</th>
                        <th>Departemen</th>
                        <th>Jabatan</th>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-title"></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="pegawaiForm" name="pegawaiForm" class="form-horizontal">
                    <input type="hidden" name="id" id="id">
                    <div class="mb-3">
                        <label for="nip" class="form-label">NIP</label>
                        <input type="text" class="form-control" id="nip" name="nip" placeholder="Masukkan NIP">
                    </div>
                    <div class="mb-3">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan Nama Lengkap">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email">
                    </div>
                     <div class="mb-3">
                        <label for="no_telp" class="form-label">No. Telepon</label>
                        <input type="text" class="form-control" id="no_telp" name="no_telp" placeholder="Masukkan Nomor Telepon">
                    </div>
                    <div class="mb-3">
                        <label for="departemen_id" class="form-label">Departemen</label>
                        <select class="form-control" name="departemen_id" id="departemen_id">
                            <option value="">Pilih Departemen</option>
                            <?php foreach($departemen as $d): ?>
                            <option value="<?= $d['id'] ?>"><?= $d['nama_departemen'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jabatan_id" class="form-label">Jabatan</label>
                         <select class="form-control" name="jabatan_id" id="jabatan_id">
                            <option value="">Pilih Jabatan</option>
                            <?php foreach($jabatan as $j): ?>
                            <option value="<?= $j['id'] ?>"><?= $j['nama_jabatan'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btn-save" onclick="save()">Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- End Bootstrap Modal -->

<script>
    var table;

    $(document).ready(function() {
        // Inisialisasi DataTables
        table = $('#pegawaiTable').DataTable({
            "processing": true,
            "serverSide": false, // Kita gunakan client-side karena datanya sudah di-load semua
            "ajax": {
                "url": "<?= site_url('pegawai/ajax_list') ?>",
                "type": "GET",
                "dataSrc": "data"
            },
            "columns": [
                { "data": null, "render": function (data, type, row, meta) { return meta.row + 1; }},
                { "data": "nip" },
                { "data": "nama_lengkap" },
                { "data": "nama_departemen" },
                { "data": "nama_jabatan" },
                { "data": null, "render": function (data, type, row) {
                    return `<button class="btn btn-warning btn-sm" onclick="edit_data(${row.id})"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-danger btn-sm" onclick="delete_data(${row.id})"><i class="fas fa-trash"></i></button>`;
                }}
            ]
        });
    });

    function reload_table() {
        table.ajax.reload(null, false);
    }

    function add_new() {
        $('#pegawaiForm')[0].reset();
        $('#modal-title').html('Tambah Pegawai');
        $('#ajax-modal').modal('show');
    }

    function save() {
        $.ajax({
            url: "<?= site_url('pegawai/ajax_save') ?>",
            type: "POST",
            data: $('#pegawaiForm').serialize(),
            dataType: "JSON",
            success: function(res) {
                if(res.status === 'success'){
                    $('#ajax-modal').modal('hide');
                    Swal.fire('Sukses', res.message, 'success');
                    reload_table();
                } else {
                     // Handle validation errors here
                }
            },
            error: function(xhr) {
                 Swal.fire('Error', 'Gagal menyimpan data.', 'error');
            }
        });
    }

    function edit_data(id) {
        $('#pegawaiForm')[0].reset();
        $.ajax({
            url: "<?= site_url('pegawai/ajax_edit/') ?>" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('[name="id"]').val(data.id);
                $('[name="nip"]').val(data.nip);
                $('[name="nama_lengkap"]').val(data.nama_lengkap);
                $('[name="email"]').val(data.email);
                $('[name="no_telp"]').val(data.no_telp);
                $('[name="alamat"]').val(data.alamat);
                $('[name="departemen_id"]').val(data.departemen_id);
                $('[name="jabatan_id"]').val(data.jabatan_id);
                
                $('#modal-title').html('Edit Pegawai');
                $('#ajax-modal').modal('show');
            },
            error: function() {
                Swal.fire('Error', 'Gagal mengambil data.', 'error');
            }
        });
    }

    function delete_data(id) {
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
                    url: "<?= site_url('pegawai/ajax_delete/') ?>" + id,
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