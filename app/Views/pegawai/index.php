<div class="container-fluid">
    <div class="content-header">
        <h1 class="m-0">Manajemen Pegawai</h1>
    </div>

    <div class="card">
        <div class="card-header">
            <button type="button" class="btn btn-primary" id="btn-add-pegawai">
                <i class="fa fa-plus"></i> Tambah Pegawai
            </button>
        </div>
        <div class="card-body">
            <table id="pegawaiTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIP</th>
                        <th>Nama Lengkap</th>
                        <th>Jabatan Terkini</th>
                        <th>Departemen</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- Modal untuk Form Tambah/Edit Pegawai -->
<div class="modal fade" id="pegawai-modal" aria-hidden="true">
    <div class="modal-dialog modal-xl"> <!-- Modal lebih besar -->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-title"></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Navigasi Tab -->
                <ul class="nav nav-tabs" id="pegawaiTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="data-pribadi-tab" data-bs-toggle="tab" data-bs-target="#data-pribadi" type="button" role="tab">Data Pribadi</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="riwayat-jabatan-tab" data-bs-toggle="tab" data-bs-target="#riwayat-jabatan" type="button" role="tab" disabled>Riwayat Jabatan</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="riwayat-status-tab" data-bs-toggle="tab" data-bs-target="#riwayat-status" type="button" role="tab" disabled>Riwayat Status</button>
                    </li>
                </ul>

                <!-- Konten Tab -->
                <div class="tab-content" id="pegawaiTabContent">
                    <!-- Tab Data Pribadi / Form -->
                    <div class="tab-pane fade show active" id="data-pribadi" role="tabpanel">
                        <form id="pegawaiForm" class="mt-3">
                            <input type="hidden" name="id" id="id">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Informasi Dasar</h5>
                                    <div class="mb-3">
                                        <label>NIP</label>
                                        <input type="text" name="nip" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Nama Lengkap</label>
                                        <input type="text" name="nama_lengkap" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Email Kantor</label>
                                        <input type="email" name="email_kantor" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Tanggal Bergabung</label>
                                        <input type="date" name="tanggal_bergabung" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h5>Penempatan Awal (Hanya saat tambah data)</h5>
                                    <div class="penempatan-awal-section">
                                        <div class="mb-3">
                                            <label>Jabatan</label>
                                            <select name="jabatan_id" class="form-select">
                                                <option value="">Pilih Jabatan</option>
                                                <?php foreach($jabatan as $j): ?><option value="<?= $j['id'] ?>"><?= $j['nama_jabatan'] ?></option><?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label>Departemen</label>
                                            <select name="departemen_id" class="form-select">
                                                <option value="">Pilih Departemen</option>
                                                <?php foreach($departemen as $d): ?><option value="<?= $d['id'] ?>"><?= $d['nama_departemen'] ?></option><?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label>Status Karyawan Awal</label>
                                            <select name="status_karyawan" class="form-select">
                                                <option value="Probation">Probation</option>
                                                <option value="PKWT">PKWT (Kontrak)</option>
                                                <option value="PKWTT">PKWTT (Tetap)</option>
                                                <option value="Magang">Magang</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label>Atasan Langsung</label>
                                            <select name="atasan_langsung_id" class="form-select">
                                                <option value="">Tidak Ada</option>
                                                <?php foreach($pegawai_list as $p): ?><option value="<?= $p['id'] ?>"><?= $p['nama_lengkap'] ?></option><?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Tab Riwayat Jabatan -->
                    <div class="tab-pane fade" id="riwayat-jabatan" role="tabpanel">
                        <table class="table table-sm mt-3">
                            <thead><tr><th>Tanggal Mulai</th><th>Jabatan</th><th>Departemen</th><th>Jenis</th></tr></thead>
                            <tbody id="riwayat-jabatan-body"></tbody>
                        </table>
                    </div>
                    <!-- Tab Riwayat Status -->
                    <div class="tab-pane fade" id="riwayat-status" role="tabpanel">
                       <table class="table table-sm mt-3">
                           <thead><tr><th>Tanggal Mulai</th><th>Status</th><th>Keterangan</th></tr></thead>
                           <tbody id="riwayat-status-body"></tbody>
                       </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btn-save-pegawai">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Logika JavaScript akan lebih kompleks, fokus pada inisialisasi tabel dan fungsi dasar
    $(document).ready(function() {
        var table = $('#pegawaiTable').DataTable({
            "processing": true,
            "ajax": { "url": "<?= site_url('pegawai/ajax_list') ?>", "dataSrc": "data" },
            "columns": [
                { "data": null, "render": (d,t,r,m) => m.row + 1 },
                { "data": "nip" },
                { "data": "nama_lengkap" },
                { "data": "nama_jabatan" },
                { "data": "nama_departemen" },
                { "data": "status_aktif" },
                { "data": null, "render": (d,t,r) => `<button class="btn btn-info btn-sm btn-detail" data-id="${r.id}"><i class="fas fa-eye"></i></button>` }
            ]
        });

        $('#btn-add-pegawai').on('click', function() {
            $('#pegawaiForm')[0].reset();
            $('#id').val('');
            $('#modal-title').html('Tambah Pegawai Baru');
            // Tampilkan bagian penempatan awal
            $('.penempatan-awal-section').show();
            // Nonaktifkan dan sembunyikan tab riwayat
            $('#riwayat-jabatan-tab, #riwayat-status-tab').prop('disabled', true).hide();
            $('#pegawai-modal').modal('show');
        });

        $('#pegawaiTable tbody').on('click', '.btn-detail', function() {
            var id = $(this).data('id');
            $.ajax({
                url: `<?= site_url('pegawai/ajax_detail/') ?>${id}`, type: "GET", dataType: "JSON",
                success: function(data) {
                    // Isi form data pribadi
                    $('#id').val(data.id);
                    $('[name="nip"]').val(data.nip);
                    $('[name="nama_lengkap"]').val(data.nama_lengkap);
                    // ... isi field lainnya
                    
                    // Sembunyikan bagian penempatan awal karena ini mode detail/edit
                    $('.penempatan-awal-section').hide();
                    
                    // Aktifkan dan tampilkan tab riwayat
                    $('#riwayat-jabatan-tab, #riwayat-status-tab').prop('disabled', false).show();
                    
                    // Isi tabel riwayat jabatan
                    let rjHtml = '';
                    data.riwayat_jabatan.forEach(rj => {
                        rjHtml += `<tr><td>${rj.tanggal_mulai}</td><td>${rj.nama_jabatan}</td><td>${rj.nama_departemen}</td><td>${rj.jenis_perubahan}</td></tr>`;
                    });
                    $('#riwayat-jabatan-body').html(rjHtml);
                    
                    // Isi tabel riwayat status (lakukan hal yang sama)

                    $('#modal-title').html('Detail Pegawai: ' + data.nama_lengkap);
                    $('#pegawai-modal').modal('show');
                }
            });
        });
        
        $('#btn-save-pegawai').on('click', function() {
            // Logika AJAX save
            $.ajax({
                url: "<?= site_url('pegawai/ajax_save') ?>", type: "POST", data: $('#pegawaiForm').serialize(), dataType: "JSON",
                success: (res) => {
                    if (res.status === 'success') {
                        $('#pegawai-modal').modal('hide');
                        Swal.fire('Sukses', res.message, 'success');
                        table.ajax.reload();
                    } else {
                        // Tampilkan pesan error validasi
                        let errors = Object.values(res.messages).join('<br>');
                        Swal.fire('Error Validasi', errors, 'error');
                    }
                }
            });
        });
    });
</script>