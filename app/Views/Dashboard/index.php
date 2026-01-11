<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<h1 class="h3 mb-4 text-gray-800">Dashboard</h1>

<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                    Earnings (Monthly)
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
