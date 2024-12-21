<?= $this->extend('backend/layouts/app'); ?>

<?= $this->section('content'); ?>
<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Riwayat</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="<?= base_url('/') ?>"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('/app/pegawai/unit?id='.dohash($row->id_unit_kerja)) ?>"><?= $row->nama_unit_kerja ?></a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('/app/pegawai/detail/'.dohash($row->nik)) ?>"><?= namalengkap($row->gelar_depan,$row->nama,$row->gelar_blk) ?></a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('/app/pegawai/'.dohash($row->nik).'/keluarga') ?>">Keluarga</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $row->nama_anak; ?></li>
            </ol>
        </nav>
    </div>
    <button class="btn btn-danger btn-sm ms-auto d-flex align-items-center gap-2" onClick="window.history.back()">Kembali <i class="bx bx-right-arrow-alt pe-0 me-0"></i></button>
</div>
<!--end breadcrumb-->
<div class="card border">
    <div class="card-header bg-light-primary">
        <h6><i class="bx bx-edit"></i> Edit Data Keluarga</h6>
        <?= namalengkap($row->gelar_depan,$row->nama,$row->gelar_blk) ?> :: <?= $row->nik; ?>
    </div>
    <div class="card-body px-0">
    <?= form_open(base_url('app/pegawai/'.dohash($row->nik).'/keluarga/anak/update'), 
        ["id" => "FormEdit", "data-parsley-validate" => "", "class" => "needs-validation", "novalidate" => ""],
        ["id" => dohash($row->id), "nik" => dohash($row->nik)]) ?>
        <div class="row g-3 px-4">
            <div class="col-12">
                <label for="nik_anak" class="form-label">NIK (Nomor Induk Kependudukan) <span class="text-danger">*</span></label>
                <input type="text" value="<?= $row->nik_anak; ?>" class="form-control" id="nik_anak" name="nik_anak" placeholder="Masukan NIK" required/>
            </div>
            <div class="col-12">
                <label for="nama_anak" class="form-label">Nama Anak <span class="text-danger">*</span></label>
                <input type="text" value="<?= $row->nama_anak; ?>" class="form-control" id="nama_anak" name="nama_anak" placeholder="Nama Anak" required/>
            </div>
            <div class="col-12">
                <label for="tmp_lahir" class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                <input type="text" value="<?= $row->tmp_lahir; ?>" class="form-control" id="tmp_lahir" name="tmp_lahir" placeholder="Tempat Lahir" required/>
            </div>
            <div class="col-12">
                <label for="pekerjaan">Pekerjaan <span class="text-danger">*</span></label>
                <select class="form-select" name="pekerjaan" id="pekerjaan" required>
                    <option value="">-- Pilih Pekerjaan Anak --</option>
                    <option value="Pegawai Negeri" <?= $row->pekerjaan === 'Pegawai Negeri' ? 'selected' : ''; ?>>Pegawai Negeri</option>
                    <option value="Pegawai Swasta" <?= $row->pekerjaan === 'Pegawai Swasta' ? 'selected' : ''; ?>>Pegawai Swasta</option>
                    <option value="Perangkat Desa" <?= $row->pekerjaan === 'Perangkat Desa' ? 'selected' : ''; ?>>Perangkat Desa</option>
                    <option value="Wiraswasta" <?= $row->pekerjaan === 'Wiraswasta' ? 'selected' : ''; ?>>Wiraswasta</option>
                    <option value="Honorer" <?= $row->pekerjaan === 'Honorer' ? 'selected' : ''; ?>>Honorer</option>
                    <option value="Rumah Tangga" <?= $row->pekerjaan === 'Rumah Tangga' ? 'selected' : ''; ?>>Rumah Tangga</option>
                    <option value="Pelajar" <?= $row->pekerjaan === 'Pelajar' ? 'selected' : ''; ?>>Pelajar / Mahasiswa(i)</option>
                    <option value="Belum Bekerja" <?= $row->pekerjaan === 'Belum Bekerja' ? 'selected' : ''; ?>>Belum Bekerja</option>
                </select>
            </div>
            <div class="col-6">
                <label for="tgl_lahir">Tanggal Lahir <span class="text-danger">*</span></label>
                <input type="date" value="<?= $row->tgl_lahir; ?>" name="tgl_lahir" class="form-control datepicker" id="tgl_lahir" placeholder="Tanggal Lahir" required/>
            </div>
            <div class="col-6">
                <label for="jns_kelamin">Jenis Kelamin <span class="text-danger">*</span></label>
                <select class="form-select" name="jns_kelamin" id="jns_kelamin" required>
                    <option value="">-- Pilih Jenis Kelamin Anak --</option>
                    <option value="PRIA" <?= $row->jns_kelamin === 'PRIA' ? 'selected' : ''; ?>>LAKI - LAKI</option>
                    <option value="WANITA" <?= $row->jns_kelamin === 'WANITA' ? 'selected' : ''; ?>>PEREMPUAN</option>
                </select>
            </div>
            <div class="col-12">
                <?php  
                    $ibu = db_connect()->table('riwayat_sutri')->select('sutri_ke,nama_sutri')->where("nik", $row->nik)->get()->getResult();
                ?>
                <label for="fid_sutri_ke">Nama <?= $row->jns_kelamin !== 'PRIA' ? 'Ibu' : 'Bapak'; ?> <span class="text-danger">*</span></label>
                <select class="form-select" name="fid_sutri_ke" id="fid_sutri_ke" required>
                    <option selected value="">-- Pilih <?= $row->jns_kelamin !== 'PRIA' ? 'Ibu' : 'Bapak'; ?> --</option>
                    <?php foreach ($ibu as $i): ?>
                        <option value="<?= $i->sutri_ke; ?>" <?= $row->fid_sutri_ke === $i->sutri_ke ? 'selected' : ''; ?>><?= $i->nama_sutri; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-12">
                <label for="status">Status Anak <span class="text-danger">*</span></label>
                <select class="form-select" name="status" id="status" required>
                    <option selected value="">-- Pilih Status Anak --</option>
                    <option value="KANDUNG" <?= $row->status === 'KANDUNG' ? 'selected' : ''; ?>>KANDUNG</option>
                    <option value="TIRI" <?= $row->status === 'TIRI' ? 'selected' : ''; ?>>TIRI</option>
                    <option value="ANGKAT" <?= $row->status === 'ANGKAT' ? 'selected' : ''; ?>>ANGKAT</option>
                </select>
            </div>
            <div class="col-6">
                <div class="form-check">
                    <input class="form-check-input" name="status_hidup" type="checkbox" value="YA" id="status_hidup" <?= $row->status_hidup === 'YA' ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="status_hidup">
                        Status Hidup
                    </label>
                </div>
            </div>
            <div class="col-6">
                <div class="form-check">
                    <input class="form-check-input" name="tanggungan" type="checkbox" value="YA" id="tanggungan" <?= $row->tanggungan === 'YA' ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="tanggungan">
                        Tanggungan
                    </label>
                </div>
            </div>
            <hr>
            <div class="col-12">
                <label for="no_bpjs_kesehatan" class="form-label">No. BPJS Kesehatan <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="no_bpjs_kesehatan" name="no_bpjs_kesehatan" value="<?= $row->no_bpjs_kesehatan; ?>" placeholder="Masukan nomor bpjs kesehatan" required/>
                <div id="no_bpjs_kesehatan_help" class="form-text fst-italic">Apabila tidak ada, isi dengan tanda (<b>-</b>) </div>
            </div>
            <div class="col-12">
                <div class="btn-group g-3 w-100">
                    <button type="button" class="btn btn-danger" onClick="return window.history.back()"> <i class="bx bx-x-circle"></i> Batal</button>
                    <button type="submit" class="btn btn-primary"> <i class="bx bx-save"></i> Simpan</button>
                </div>
            </div>
        </div>
    <?= form_close(); ?>
    </div>
</div>
<?= $this->endSection(); ?>
<!-- Ex: Script -->
<?= $this->section("script"); ?>
<script src="<?= base_url("template/vertical/plugins/parsley/parsley.min.js") ?>"></script>
<script src="<?= base_url("template/vertical/plugins/parsley/i18n/id.js") ?>"></script>
<script src="<?= base_url("template/vertical/plugins/parsley/default.js") ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
<?= $this->endSection(); ?>
<!-- Ex: Css -->
<?= $this->section('style'); ?>
<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet" />
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    $(document).ready(function() {
        const FORM = $("form#FormEdit");
        const datapicker = $(".datepicker").flatpickr({
            altInput: true,
            altFormat: "j F Y",
            dateFormat: "Y-m-d",
            "locale": "id",
        });
        FORM.on("submit", function(e) {
            e.preventDefault();
            let _ = $(this),
            url = _.attr("action"),
            method = _.attr("method"),
            data = _.serializeArray().concat({name: "_method", value: "PUT"});
            if(_.parsley().isValid()) {
                $.ajax({
                    type: method,
                    url: url,
                    data: data,
                    dataType: 'json',
                    beforeSend: function() {
                        _.find("button[type='submit']").html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`).prop("disabled", true);
                    },
                    success: function(response) {
                        if(response.status === true) {
                            iziToast.success({
                                timeout: 2000,
                                message: response.message,
                                position: 'topCenter',
                                onClosing: () => {
                                    window.history.back();
                                    _.find("button[type='submit']").html(`<i class="bx bx-save"></i> Simpan`).prop("disabled", false);
                                }
                            });
                            return false;
                        }
                        iziToast.warning({
                            message: response.message,
                            position: 'topCenter',
                        })
                    },
                    error: function(err) {
                        iziToast.error({
                            title:  `Error ${err.status}`,
                            message: err.responseJSON.message || err.responseText,
                            position: 'topCenter'
                        })
                        _.find("button[type='submit']").html(`<i class="bx bx-save"></i> Simpan`).prop("disabled", false);
                    }
                })
            }
        });
    })
</script>
<?= $this->endSection(); ?>