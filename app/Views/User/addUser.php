<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah User Baru</h1>
    <a href="<?= base_url('user') ?>" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali ke Senarai
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Tambah User</h6>
            </div>
            <div class="card-body">
                <?php if (session()->getFlashdata('errors')) : ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                <li><?= $error ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('user/store') ?>" method="POST">
                    <?= csrf_field() ?>
                    
                    <div class="form-group">
                        <label for="name">username</label>
                        <input type="text" name="name" id="name" class="form-control <?= session('errors.name') ? 'is-invalid' : '' ?>" 
                               value="<?= old('name') ?>" placeholder="Username" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>" 
                               value="<?= old('email') ?>" placeholder="contoh@mail.com" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?>" 
                                       placeholder="Minimum  character" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="role_id">Role</label>
                                <select name="role_id" id="role_id" class="form-control <?= session('errors.role_id') ? 'is-invalid' : '' ?>" required>
                                    <option value="">-- Pilih Role --</option>
                                    <?php foreach ($roles as $role) : ?>
                                        <option value="<?= $role->id ?>" <?= old('role_id') == $role->id ? 'selected' : '' ?>>
                                            <?= esc($role->name) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="form-group text-right">
                        <button type="reset" class="btn btn-light">Reset</button>
                        <button type="submit" class="btn btn-primary px-4">Simpan User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>