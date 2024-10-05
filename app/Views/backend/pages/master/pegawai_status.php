<?= $this->extend('backend/layouts/app'); ?>

<?php if($status->status === 'VERIFIKASI'): ?>
<?= $this->section('content'); ?>
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Master</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('/') ?>"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('/app/master/pegawai') ?>">Pegawai</a></li>
                    <li class="breadcrumb-item">Peremajaan Pegawai</li>
                    <li class="breadcrumb-item active" aria-current="page">Verifikasi</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="card" style="min-height: calc(100vh - 200px);">
        <div class="card-header px-4 py-3">
            <h5 class="mb-0">Tahap Verifikasi Data</h5>
        </div>
        <div class="card-body d-flex flex-column justify-content-center aling-items-center gap-3 text-center">
            <div><img src="<?= base_url('assets/images/notif/undraw_secure_login_pdn4.svg') ?>" alt="Status Verifikasi" width="300"/></div>
            <h3>Tahap Verifikasi Data</h3>
            <p>Usulan pegawai "<strong><?= namalengkap($status->gelar_depan, $status->nama, $status->gelar_blk) ?> (NIK. <?= $status->nik ?>) </strong>" dalam tahap verifikasi.</p>
        </div>
    </div>
<?= $this->endSection(); ?>
<?php elseif($status->status === 'AKTIF'): ?>
<?= $this->section('content'); ?>
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Master</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('/') ?>"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('/app/master/pegawai') ?>">Pegawai</a></li>
                    <li class="breadcrumb-item">Peremajaan Pegawai</li>
                    <li class="breadcrumb-item active" aria-current="page">Aktif</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="card" style="min-height: calc(100vh - 200px);">
        <div class="card-header px-4 py-3">
            <h5 class="mb-0">Hasil Verifikasi : <?= namalengkap($status->gelar_depan, $status->nama, $status->gelar_blk) ?></h5>
        </div>
        <div class="card-body d-flex flex-column justify-content-center aling-items-center gap-3 text-center">
            <div><img src="<?= base_url('assets/images/notif/undraw_certificate_re_yadi.svg') ?>" alt="Status Verifikasi" width="300"/></div>
            <h3>Selamat Data Kamu Valid <i class="bx bx-check-circle text-success"></i></h3>
            <p>Usulan pegawai "<strong><?= namalengkap($status->gelar_depan, $status->nama, $status->gelar_blk) ?> (NIK. <?= $status->nik ?>) </strong>" telah diverifikasi sebagai <strong> PEGAWAI AKTIF</strong>.</p>
        </div>
    </div>
<?= $this->endSection(); ?>

<?php elseif($status->status === 'NON_AKTIF'): ?>
<?= $this->section('content'); ?>
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Master</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('/') ?>"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('/app/master/pegawai') ?>">Pegawai</a></li>
                    <li class="breadcrumb-item">Peremajaan Pegawai</li>
                    <li class="breadcrumb-item active" aria-current="page">Non Aktif</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="card" style="min-height: calc(100vh - 200px);">
        <div class="card-header px-4 py-3">
            <h5 class="mb-0">Hasil Verifikasi : <?= namalengkap($status->gelar_depan, $status->nama, $status->gelar_blk) ?></h5>
        </div>
        <div class="card-body d-flex flex-column justify-content-center aling-items-center gap-3 text-center">
            <div><img src="<?= base_url('assets/images/notif/undraw_access_denied_re_awnf.svg') ?>" alt="Status Verifikasi" width="300"/></div>
            <h3>Waduh, sepertinya data tidak valid <i class="bx bx-x-circle text-danger"></i></h3>
            <p>Pegawai "<strong><?= namalengkap($status->gelar_depan, $status->nama, $status->gelar_blk) ?> (NIK. <?= $status->nik ?>) </strong>" telah diverifikasi.</p>
            <p class="border border-danger p-3"> <strong> PEGAWAI NON AKTIF</strong> <br>Catatan Verifikator : <?= $status->ket_status ?></p>
        </div>
    </div>
<?= $this->endSection(); ?>

<?php elseif($status->status === 'NON_AKTIF_NIK_DITOLAK'): ?>
<?= $this->section('content'); ?>
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Master</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('/') ?>"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('/app/master/pegawai') ?>">Pegawai</a></li>
                    <li class="breadcrumb-item">Peremajaan Pegawai</li>
                    <li class="breadcrumb-item active" aria-current="page">Non Aktif - Nomor Induk Kependudukan Ditolak</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="card" style="min-height: calc(100vh - 200px);">
        <div class="card-header px-4 py-3">
            <h5 class="mb-0">Hasil Verifikasi : <?= namalengkap($status->gelar_depan, $status->nama, $status->gelar_blk) ?></h5>
        </div>
        <div class="card-body d-flex flex-column justify-content-center aling-items-center gap-3 text-center">
            <div><img src="<?= base_url('assets/images/notif/undraw_access_denied_re_awnf.svg') ?>" alt="Status Verifikasi" width="300"/></div>
            <h3>Waduh, sepertinya data tidak valid <i class="bx bx-x-circle text-danger"></i></h3>
            <p>Pegawai "<strong><?= namalengkap($status->gelar_depan, $status->nama, $status->gelar_blk) ?> (NIK. <?= $status->nik ?>) </strong>" telah diverifikasi.</p>
            <p class="border border-danger p-3"><strong> PEGAWAI NON AKTIF ATAU NIK DITOLAK</strong> <br>Catatan Verifikator : <?= $status->ket_status ?></p>
        </div>
    </div>
<?= $this->endSection(); ?>
<?php endif; ?>