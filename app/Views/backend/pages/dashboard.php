<?= $this->extend('backend/layouts/app'); ?>

<?= $this->section('content'); ?>
Selamat Datang <?= session()->get('name') ?>

<?= $this->endSection(); ?>