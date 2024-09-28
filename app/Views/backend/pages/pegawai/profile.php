<?= $this->extend('backend/layouts/app'); ?>
<?= $this->section('content'); ?>
<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Pegawai</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="<?= base_url('/') ?>"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('/app/pegawai/unit?id='.dohash($row->id_unit_kerja)) ?>"><?= $row->nama_unit_kerja ?></a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= namalengkap($row->gelar_depan,$row->nama,$row->gelar_blk) ?></li>
            </ol>
        </nav>
    </div>
    <a href="<?= base_url("cetak/profile/".dohash($row->nik)); ?>" target="_blank" class="btn btn-success btn-sm ms-auto d-flex align-items-center"><i class="bx bx-printer"></i> Cetak Profile</a>
</div>
<!--end breadcrumb-->
<div class="card">
    <div class="row g-0">
            <div class="col-md-3 border-end p-3">
                <div class="sticky-top" style="top: 80px">
                    <div class="text-center mx-auto">
                        <img src="<?= base_url("assets/images/users/{$row->photo}") ?>" class="img-fluid rounded" alt="<?= namalengkap($row->gelar_depan,$row->nama,$row->gelar_blk) ?>">
                    </div>
                    <ul class="list-group mt-4">
                        <li class="list-group-item">
                            <div class="d-inline-flex flex-column gap-1">
                                <span class="text-secondary small text-uppercase d-flex align-items-center gap-1">Usia BUP <i class="bx bxs-help-circle bx-xs" data-bs-toggle="tooltip" data-bs-title="Riwayat Jabatan"></i></span>
                                <span class="fw-bold"><?= isNull(@$jabatan->usia_bup); ?></span>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-inline-flex flex-column gap-1">
                                <span class="text-secondary small text-uppercase">Umur</span>
                                <span class="fw-bold"><?= hitungUsia($row->tgl_lahir) ?> </span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-inline-flex flex-column gap-1">
                                        <span class="text-secondary small text-uppercase">Nama Lengkap</span>
                                        <span class="fw-bold"><?= namalengkap($row->gelar_depan,$row->nama,$row->gelar_blk) ?></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-inline-flex flex-column gap-1">
                                        <span class="text-secondary small text-uppercase">Nomor Induk Pegawai</span>
                                        <span class="fw-bold"><?= isNull($row->nipd) ?></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-inline-flex flex-column gap-1">
                                        <span class="text-secondary small text-uppercase d-flex align-items-center gap-1">Gelar Depan<i class="bx bxs-help-circle bx-xs" data-bs-toggle="tooltip" data-bs-title="Riwayat Pendidikan"></i></span>
                                        <span class="fw-bold"><?= isNull($row->gelar_depan) ?></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-inline-flex flex-column gap-1">
                                        <span class="text-secondary small text-uppercase d-flex align-items-center gap-1">Gelar Belakang<i class="bx bxs-help-circle bx-xs" data-bs-toggle="tooltip" data-bs-title="Riwayat Pendidikan"></i></span>
                                        <span class="fw-bold"><?= isNull($row->gelar_blk) ?></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="d-inline-flex flex-column gap-1">
                                        <span class="text-secondary small text-uppercase">Tempat / Tanggal Lahir</span>
                                        <span class="fw-bold"><?= isNull($row->tmp_lahir) ?> / <?= longdate_indo($row->tgl_lahir) ?></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-inline-flex flex-column gap-1">
                                        <span class="text-secondary small text-uppercase">Alamat</span>
                                        <span class="fw-bold"><?= isNull($row->alamat) ?></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-inline-flex flex-column gap-1">
                                        <span class="text-secondary small text-uppercase">Desa</span>
                                        <span class="fw-bold"><?= ucwords(strtolower($row->nama_desa)) ?></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-inline-flex flex-column gap-1">
                                        <span class="text-secondary small text-uppercase">Jenis Kelamin</span>
                                        <span class="fw-bold"><?= ucwords(strtolower(isNull($row->jns_kelamin))) ?></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-inline-flex flex-column gap-1">
                                        <span class="text-secondary small text-uppercase">Agama</span>
                                        <span class="fw-bold"><?= ucwords(strtolower(isNull($row->nama_agama))) ?></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="d-inline-flex flex-column gap-1">
                                        <span class="text-secondary small text-uppercase d-flex align-items-center gap-1">Pendidikan Terakhir <i class="bx bxs-help-circle bx-xs" data-bs-toggle="tooltip" data-bs-title="Riwayat Pendidikan"></i></span>
                                        <?php if(!isset($pendidikan->nama_tingkat_pendidikan)): ?>
                                            <span class="fw-bold">-</span>
                                        <?php else: ?>
                                            <?php if($pendidikan->berkas !== "" && $pendidikan->berkas !== null): ?>
                                                <span class="fw-bold"><a href="<?= base_url("assets/file_pendidikan/".$pendidikan->berkas) ?>" target="_blank"><?= isNull(@$pendidikan->nama_tingkat_pendidikan) ?> - <?= ucwords(strtolower(isNull(@$pendidikan->nama_jurusan_pendidikan))) ?> (Lulus : <?= ucwords(strtolower(isNull(@$pendidikan->thn_lulus))) ?> - <?= ucwords(strtolower(isNull(@$pendidikan->nama_sekolah))) ?>)</a></span>
                                            <?php else: ?>
                                                <span class="fw-bold"><?= isNull(@$pendidikan->nama_tingkat_pendidikan) ?> - <?= ucwords(strtolower(isNull(@$pendidikan->nama_jurusan_pendidikan))) ?> (Lulus : <?= ucwords(strtolower(isNull(@$pendidikan->thn_lulus))) ?> - <?= ucwords(strtolower(isNull(@$pendidikan->nama_sekolah))) ?>)</span>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-inline-flex flex-column gap-1">
                                        <span class="text-secondary small text-uppercase d-flex align-items-center gap-1">Jenis Pegawai <i class="bx bxs-help-circle bx-xs" data-bs-toggle="tooltip" data-bs-title="Riwayat Jabatan"></i></span>
                                        <span class="fw-bold"><?= isNull(@$jabatan->jenis); ?></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-inline-flex flex-column gap-1">
                                        <span class="text-secondary small text-uppercase d-flex align-items-center gap-1">Status Kawin <i class="bx bxs-help-circle bx-xs" data-bs-toggle="tooltip" data-bs-title="Riwayat Keluarga"></i></span>
                                        <span class="fw-bold"><?= ucwords(strtolower(isNull($row->nama_status_kawin))) ?></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="d-inline-flex flex-column gap-1">
                                        <span class="text-secondary small text-uppercase">Email</span>
                                        <span class="fw-bold"><?= isNull($row->email) ?></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-inline-flex flex-column gap-1">
                                        <span class="text-secondary small text-uppercase">Nomor KTP</span>
                                        <span class="fw-bold"><?= isNull($row->nik) ?></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-inline-flex flex-column gap-1">
                                        <span class="text-secondary small text-uppercase">Nomor Kartu Keluarga</span>
                                        <span class="fw-bold"><?= isNull($row->no_kk) ?></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-inline-flex flex-column gap-1">
                                        <span class="text-secondary small text-uppercase">Nomor BPJS Kesehatan</span>
                                        <span class="fw-bold"><?= isNull($row->no_bpjs_kesehatan) ?></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-inline-flex flex-column gap-1">
                                        <span class="text-secondary small text-uppercase">Nomor BPJS Ketenagakerjaan</span>
                                        <span class="fw-bold"><?= isNull($row->no_bpjs_ketenagakerjaan) ?></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-inline-flex flex-column gap-1">
                                        <span class="text-secondary small text-uppercase">Nomor Handphone / Whatsapp</span>
                                        <span class="fw-bold"><?= isNull($row->no_hp) ?></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-inline-flex flex-column gap-1">
                                        <span class="text-secondary small text-uppercase">Nomor Telpon Rumah</span>
                                        <span class="fw-bold"><?= isNull($row->no_telp_rumah) ?></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="d-inline-flex flex-column gap-1">
                                        <span class="text-secondary small text-uppercase">Nomor NPWP</span>
                                        <span class="fw-bold"><?= isNull($row->no_npwp) ?></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="d-inline-flex flex-column gap-1">
                                        <span class="text-secondary small text-uppercase d-flex align-items-center gap-1">Unit Kerja<i class="bx bxs-help-circle bx-xs" data-bs-toggle="tooltip" data-bs-title="Riwayat Jabatan"></i></span>
                                        <span class="fw-bold"><?= isNull($row->nama_unit_kerja) ?></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-inline-flex flex-column gap-1">
                                        <span class="text-secondary small text-uppercase d-flex align-items-center gap-1">Jabatan <i class="bx bxs-help-circle bx-xs" data-bs-toggle="tooltip" data-bs-title="Riwayat Jabatan"></i></span>
                                        <?php if(!isset($jabatan->nama_jabatan)): ?>
                                            <span class="fw-bold">-</span>
                                        <?php else: ?>
                                            <?php if($jabatan->berkas !== "" && $jabatan->berkas !== null): ?>
                                                <span class="fw-bold"><a href="<?= base_url("assets/file_jabatan/".$jabatan->berkas) ?>" target="_blank"><?= isNull(ucwords(strtolower(@$jabatan->nama_jabatan))) ?></a></span>
                                            <?php else: ?>
                                                <span class="fw-bold"><?= isNull(ucwords(strtolower(@$jabatan->nama_jabatan))) ?></span>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-secondary small text-uppercase d-flex align-items-center gap-1">TMT Mulai s/d TMT Selesai <i class="bx bxs-help-circle bx-xs" data-bs-toggle="tooltip" data-bs-title="Riwayat Jabatan"></i></span>
                                    <span>
                                        <?= isNull(@date_indo(@$jabatan->tmt_mulai)); ?> <b class="text-secondary">-</b> <?= isNull(@date_indo(@$jabatan->tmt_selesai)); ?>
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="text-secondary">
                    <?php if(isNull($row->updated_at) !== "-"): ?>
                        Diperbaharui : <?= updateAt($row->updated_at) ?> / <?= date_indo(formatTanggal($row->updated_at)) ?>
                    <?php else: ?>
                        Ditambahkan : <?= updateAt($row->created_at) ?> / <?= date_indo(formatTanggal($row->created_at)) ?>
                    <?php endif; ?>
                    </div>
                </div>
            </div>
    </div>
    <div class="card-body border-top">
        <div class="btn-group w-100 flex-column flex-md-row">
            <a href="<?= base_url("app/pegawai/".dohash($row->nik)."/jabatan") ?>" class="btn btn-outline-primary"> <i class="bx bx-sitemap"></i> Riwayat Jabatan</a>
            <a href="<?= base_url("app/pegawai/".dohash($row->nik)."/keluarga") ?>" class="btn btn-outline-primary"> <i class="lni lni-users"></i> Riwayat Keluarga</a>
            <a href="<?= base_url("app/pegawai/".dohash($row->nik)."/lhkpn") ?>" class="btn btn-outline-primary"> <i class="bx bx-task"></i> Riwayat LHKPN</a>
            <a href="<?= base_url("app/pegawai/".dohash($row->nik)."/pendidikan") ?>" class="btn btn-outline-primary"> <i class="lni lni-graduation"></i> Riwayat Pendidikan</a>
            <a href="<?= base_url("app/pegawai/".dohash($row->nik)."/workshop") ?>" class="btn btn-outline-primary"> <i class="lni lni-network"></i> Riwayat Workshop</a>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>