<?= $this->extend('layouts/main') ?>

<?= $this->section('css') ?>
<link href="<?= base_url('vendor/datatables/dataTables.bootstrap4.min.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1 class="h3 mb-2 text-gray-800">Data Barang</h1>

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

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('vendor/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('vendor/datatables/dataTables.bootstrap4.min.js') ?>"></script>
<script>
    $(document).ready(function () {
        console.log("Script DataTables Berjalan...");
        // Inisialisasi DataTable
        var table = $('#dataTable').DataTable({
            "processing": true,
            "serverSide": false, // Karena Anda menggunakan findAll()
            "ajax": {
                "url": "<?= base_url('barang/data') ?>",
                "type": "GET",
                "dataSrc": "data", // Ini HARUS sama dengan key JSON: { "data": [...] }
                "error": function (xhr, error, thrown) {
                    console.error("XHR Response: " + xhr.responseText);
                    alert("Gagal memuat data. Cek Console (F12) untuk detail.");
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
                    $('#dataTable').DataTable().ajax.reload(); // Reload tabel tanpa refresh halaman
                },
                error: function () {
                    alert("Gagal mengupdate data");
                }
            });
        });

        $('#dataTable').on('click', '.btn-delete', function () {
            const id = $(this).data('id');
            
            // Konfirmasi sederhana dengan browser confirm
            if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
                $.ajax({
                    url: "<?= base_url('barang/delete') ?>/" + id,
                    type: "POST", // Sesuai dengan route yang Anda buat
                    dataType: "JSON",
                    success: function (response) {
                        if (response.status) {
                            alert(response.message);
                            // Reload tabel otomatis tanpa refresh halaman
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
