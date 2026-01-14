<?= $this->extend('layouts/main') ?>

<?= $this->section('css') ?>
<link href="<?= base_url('vendor/datatables/dataTables.bootstrap4.min.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Barang</h1>
    <button class="btn btn-primary btn-sm shadow-sm" data-toggle="modal" data-target="#modalBarang">
        <i class="fas fa-user-plus fa-sm text-white-50"></i> Tambah Barang
    </button>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <table class="table table-bordered" id="dataTable">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div class="modal fade" id="modalBarang" tabindex="-1" role="dialog" aria-labelledby="modalBarangLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="modalBarangLabel">Tambah Barang Baru</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form id="formTambahBarang">
                <?= csrf_field() ?>

                <div class="modal-body">

                    <div id="errorBarang" class="alert alert-danger d-none"></div>

                    <div class="form-group">
                        <label>Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Harga</label>
                        <input type="number" name="harga" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Stok</label>
                        <input type="number" name="stok" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <input type="number" name="status" class="form-control" required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" type="submit">Simpan Barang</button>
                </div>
            </form>

        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('vendor/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('vendor/datatables/dataTables.bootstrap4.min.js') ?>"></script>
<script>
    $(document).ready(function () {
        console.log("Script DataTables Berjalan...");
        var table = $('#dataTable').DataTable({
            "processing": true,
            "serverSide": false,
            "ajax": {
                "url": "<?= base_url('barang/data') ?>",
                "type": "GET",
                "dataSrc": "data",
                "error": function (xhr, error, thrown) {
                    console.error("XHR Response: " + xhr.responseText);
                    alert("Gagal memuat data.");
                }
            },
            "columns": [
                { "data": "nama_barang" },
                { "data": "harga" },
                { "data": "stok" },
                { 
                    data: 'id',
                    render: function (data, type, row) {
                        return `
                        <button class="btn btn-sm btn-warning btn-edit" data-id="${data}">Edit</button>
                        <button class="btn btn-sm btn-danger btn-delete" data-id="${data}"><i class="fas fa-trash"></i> Hapus</button>
                        `;
                    }
                }
            ]
        });

        $('#dataTable').on('click', '.btn-edit', function () {
            const id = $(this).data('id');
            $.ajax({
                url: "<?= base_url('barang/edit') ?>/" + id,
                type: "GET",
                success: function (response) {
                    if (response.status) {
                        $('#edit_id').val(response.data.id);
                        $('#edit_nama').val(response.data.nama_barang);
                        $('#edit_harga').val(response.data.harga);
                        $('#edit_stok').val(response.data.stok);
                        $('#modalEdit').modal('show');
                    }
                }
            });
        });

        $('#formEdit').on('submit', function (e) {
            e.preventDefault();
            const id = $('#edit_id').val();
            $.ajax({
                url: "<?= base_url('barang/update') ?>/" + id,
                type: "POST",
                data: $(this).serialize(),
                success: function (response) {
                    alert(response.message);
                    $('#modalEdit').modal('hide');
                    $('#dataTable').DataTable().ajax.reload();
                },
                error: function () {
                    alert("Gagal mengupdate data");
                }
            });
        });

        $('#dataTable').on('click', '.btn-delete', function () {
            const id = $(this).data('id');

            if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
                $.ajax({
                    url: "<?= base_url('barang/delete') ?>/" + id,
                    type: "POST",
                    dataType: "JSON",
                    success: function (response) {
                        if (response.status) {
                            alert(response.message);
                            $('#dataTable').DataTable().ajax.reload();
                        } else {
                            alert("Gagal menghapus: " + response.message);
                        }
                    },
                    error: function (xhr) {
                        alert("Terjadi kesalahan pada server.");
                        console.error(xhr.responseText);
                    }
                });
            }
        });

        $('#formTambahBarang').on('submit', function (e) {
            e.preventDefault();

            $('#errorBarang').addClass('d-none').html('');

            $.ajax({
                url: "<?= base_url('barang/store') ?>",
                type: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                success: function (res) {

                    if (res.status) {
                        $('#modalBarang').modal('hide');
                        $('#formTambahBarang')[0].reset();

                        $('#dataTable').DataTable().ajax.reload(null, false);

                        alert(res.message);
                    } else {
                        let errors = '<ul>';
                        $.each(res.errors, function (key, value) {
                            errors += `<li>${value}</li>`;
                        });
                        errors += '</ul>';

                        $('#errorBarang')
                            .removeClass('d-none')
                            .html(errors);
                    }
                },
                error: function (xhr) {
                    alert('Terjadi kesalahan pada server');
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>

<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="formEdit">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="form-group">
                        <label>Nama Barang</label>
                        <input type="text" class="form-control" id="edit_nama" name="nama_barang" required>
                    </div>
                    <div class="form-group">
                        <label>Harga</label>
                        <input type="number" class="form-control" id="edit_harga" name="harga" required>
                    </div>
                    <div class="form-group">
                        <label>Stok</label>
                        <input type="number" class="form-control" id="edit_stok" name="stok" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
