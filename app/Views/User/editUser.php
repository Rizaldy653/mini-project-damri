<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Edit User & Permissions</h6>
    </div>
    <div class="card-body">
        <form action="<?= base_url('user/update/' . $user['id']) ?>" method="POST">
            <?= csrf_field() ?>
            <div class="row">
                <div class="col-md-6">
                    <h5>Data Profil</h5>
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="name" class="form-control" value="<?= $user['name'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="<?= $user['email'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Password (Kosongkan jika tidak diganti)</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <select name="role_id" class="form-control" required>
                            <?php foreach($roles as $r): ?>
                                <option value="<?= $r->id ?>" <?= ($r->id == $role_id) ? 'selected' : '' ?>><?= $r->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <h5>Spesifik Permissions</h5>
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>Permission</th>
                                <th>Grant</th>
                                <th>Deny</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($allPermissions as $p): ?>
                            <tr>
                                <td><?= ucwords(str_replace('_', ' ', $p->name)) ?></td>
                                <td>
                                    <input type="radio" name="permissions[<?= $p->id ?>]" value="1" 
                                    <?= in_array($p->id, $assignedPermissions) ? 'checked' : '' ?>>
                                </td>
                                <td>
                                    <input type="radio" name="permissions[<?= $p->id ?>]" value="0" 
                                    <?= !in_array($p->id, $assignedPermissions) ? 'checked' : '' ?>>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-success">Update Data</button>
            <a href="<?= base_url('user') ?>" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
<?= $this->endSection() ?>