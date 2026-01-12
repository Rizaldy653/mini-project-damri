<?= $this->extend('layouts/main') ?>

<?= $this->section('css') ?>
<link href="<?= base_url('vendor/datatables/dataTables.bootstrap4.min.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Manajemen User</h1>
    <button class="btn btn-primary btn-sm shadow-sm" data-toggle="modal" data-target="#modalUser">
        <i class="fas fa-user-plus fa-sm text-white-50"></i> Tambah User
    </button>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="userTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah User Baru</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="<?= base_url('user/store') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" required placeholder="Masukkan nama...">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required placeholder="email@example.com">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required placeholder="Minimal 6 karakter">
                    </div>
                    <div class="form-group">
                        <label>Role / Hak Akses</label>
                        <select name="role_id" class="form-control" required>
                            <option value="">-- Pilih Role --</option>
                            <?php foreach($roles as $role): ?>
                                <option value="<?= $role->id ?>"><?= $role->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" type="submit">Simpan User</button>
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
        var table = $('#userTable').DataTable({
            "processing": true,
            "serverSide": false,
            "ajax": {
                "url": "<?= base_url('user/data') ?>",
                "type": "GET",
                "dataSrc": "data"
            },
            "columns": [
                { "data": "name" },
                { "data": "email" },
                { 
                    "data": "role_name",
                    "render": function(data) {
                        return `<span class="badge badge-info">${data}</span>`;
                    }
                },
                { 
                    "data": "id",
                    "render": function (data) {
                        return `
                            <button class="btn btn-sm btn-warning btn-edit" data-id="${data}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger btn-delete" data-id="${data}">
                                <i class="fas fa-trash"></i>
                            </button>
                        `;
                    }
                }
            ]
        });

        $('#userTable').on('click', '.btn-edit', function () {
            const id = $(this).data('id');
            $.ajax({
                url: "<?= base_url('user/edit') ?>/" + id,
                type: "GET",
                success: function (res) {
                    $('#edit_id').val(res.user.id);
                    $('#edit_name').val(res.user.name);
                    $('#edit_email').val(res.user.email);
                    $('#edit_role_id').val(res.role_id);
                    
                    $('#modalEdit').modal('show');
                }
            });
        });

        $('#formEdit').on('submit', function (e) {
            e.preventDefault();
            const id = $('#edit_id').val();
            $.ajax({
                url: "<?= base_url('user/update') ?>/" + id,
                type: "POST",
                data: $(this).serialize(),
                success: function (response) {
                    alert(response.message);
                    $('#modalEdit').modal('hide');
                    $('#userTable').DataTable().ajax.reload();
                },
                error: function () {
                    alert("Gagal mengupdate data user");
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
                    <h5 class="modal-title">Edit Data User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="id">
                    
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label>Role / Hak Akses</label>
                        <select name="role_id" id="edit_role_id" class="form-control" required>
                            <option value="">-- Pilih Role --</option>
                            <?php foreach($roles as $r): ?>
                                <option value="<?= $r->id ?>"><?= $r->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin ganti password">
                        <small class="text-muted">Isi minimal 6 karakter jika ingin mengganti.</small>
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