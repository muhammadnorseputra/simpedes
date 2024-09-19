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
</div>
<!--end breadcrumb-->
<div class="card">
    <div class="row g-0">
            <div class="col-md-3 border-end p-3">
                <div class="sticky-top" style="top: 80px">
                    <img src="<?= base_url("assets/images/users/{$row->photo}") ?>" class="img-fluid rounded" alt="<?= namalengkap($row->gelar_depan,$row->nama,$row->gelar_blk) ?>">
                    <ul class="list-group mt-4">
                        <li class="list-group-item">
                            <div class="d-inline-flex flex-column gap-1">
                                <span class="text-secondary small text-uppercase">Usia BUP</span>
                                <span class="fw-bold">-</span>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-inline-flex flex-column gap-1">
                                <span class="text-secondary small text-uppercase">Umur</span>
                                <span class="fw-bold"><?= hitungUsia($row->tgl_lahir) ?> Tahun </span>
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
                                        <span class="fw-bold"><?= $row->nipd ?></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-inline-flex flex-column gap-1">
                                        <span class="text-secondary small text-uppercase">Gelar Depan</span>
                                        <span class="fw-bold"><?= $row->gelar_depan ?></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-inline-flex flex-column gap-1">
                                        <span class="text-secondary small text-uppercase">Gelar Belakang</span>
                                        <span class="fw-bold"><?= $row->gelar_blk ?></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="d-inline-flex flex-column gap-1">
                                        <span class="text-secondary small text-uppercase">Tempat / Tanggal Lahir</span>
                                        <span class="fw-bold"><?= $row->tmp_lahir ?> / <?= longdate_indo($row->tgl_lahir) ?></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-inline-flex flex-column gap-1">
                                        <span class="text-secondary small text-uppercase">Alamat</span>
                                        <span class="fw-bold"><?= $row->alamat ?></span>
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
                                        <span class="fw-bold"><?= ucwords(strtolower($row->jns_kelamin)) ?></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-inline-flex flex-column gap-1">
                                        <span class="text-secondary small text-uppercase">Agama</span>
                                        <span class="fw-bold"><?= ucwords(strtolower($row->nama_agama)) ?></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="d-inline-flex flex-column gap-1">
                                        <span class="text-secondary small text-uppercase">Pendidikan Terakhir</span>
                                        <span class="fw-bold">-</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-inline-flex flex-column gap-1">
                                        <span class="text-secondary small text-uppercase">Jenis Pegawai</span>
                                        <span class="fw-bold">-</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-inline-flex flex-column gap-1">
                                        <span class="text-secondary small text-uppercase">Status Kawin</span>
                                        <span class="fw-bold"><?= ucwords(strtolower($row->nama_status_kawin)) ?></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="d-inline-flex flex-column gap-1">
                                        <span class="text-secondary small text-uppercase">Email</span>
                                        <span class="fw-bold"><?= $row->email ?></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-inline-flex flex-column gap-1">
                                        <span class="text-secondary small text-uppercase">Nomor KTP</span>
                                        <span class="fw-bold"><?= $row->nik ?></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-inline-flex flex-column gap-1">
                                        <span class="text-secondary small text-uppercase">Nomor Kartu Keluarga</span>
                                        <span class="fw-bold"><?= $row->no_kk ?></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-inline-flex flex-column gap-1">
                                        <span class="text-secondary small text-uppercase">Nomor BPJS Kesehatan</span>
                                        <span class="fw-bold"><?= $row->no_bpjs_kesehatan ?></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-inline-flex flex-column gap-1">
                                        <span class="text-secondary small text-uppercase">Nomor BPJS Ketenagakerjaan</span>
                                        <span class="fw-bold"><?= $row->no_bpjs_ketenagakerjaan ?></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-inline-flex flex-column gap-1">
                                        <span class="text-secondary small text-uppercase">Nomor Handphone / Whatsapp</span>
                                        <span class="fw-bold"><?= $row->no_hp ?></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-inline-flex flex-column gap-1">
                                        <span class="text-secondary small text-uppercase">Nomor Telpon Rumah</span>
                                        <span class="fw-bold"><?= $row->no_telp_rumah ?></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="d-inline-flex flex-column gap-1">
                                        <span class="text-secondary small text-uppercase">Nomor NPWP</span>
                                        <span class="fw-bold"><?= $row->no_npwp ?></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="d-inline-flex flex-column gap-1">
                                        <span class="text-secondary small text-uppercase">Unit Kerja</span>
                                        <span class="fw-bold"><?= $row->nama_unit_kerja ?></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="d-inline-flex flex-column gap-1">
                                        <span class="text-secondary small text-uppercase">Jabatan</span>
                                        <span class="fw-bold">-</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="text-secondary">
                        Diperbaharui : <?= updateAt($row->updated_at) ?> / <?= date_indo(formatTanggal($row->updated_at)) ?>
                    </div>
                </div>
            </div>
    </div>
    <div class="card-body border-top sticky-md-bottom bg-white rounded-bottom" style="bottom: 30px">
        <div class="btn-group w-100 flex-column flex-md-row">
            <a href="#" class="btn btn-outline-primary"> <i class="bx bx-sitemap"></i> Riwayat Jabatan</a>
            <a href="#" class="btn btn-outline-primary"> <i class="lni lni-users"></i> Riwayat Keluarga</a>
            <a href="#" class="btn btn-outline-primary"> <i class="bx bx-task"></i> Riwayat LHKPN</a>
            <a href="#" class="btn btn-outline-primary"> <i class="lni lni-graduation"></i> Riwayat Pendidikan</a>
            <a href="#" class="btn btn-outline-primary"> <i class="lni lni-network"></i> Riwayat Workshop</a>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>