<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<h1 class="h3 mb-4 text-gray-800">Tambah Barang</h1>

<form action="<?= base_url('barang/store') ?>" method="post">
    <?= csrf_field() ?>

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

    <button class="btn btn-primary">Simpan</button>
    <a href="<?= base_url('barang') ?>" class="btn btn-secondary">Kembali</a>
</form>

<?= $this->endSection() ?>
