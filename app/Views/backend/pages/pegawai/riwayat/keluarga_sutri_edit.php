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
                <li class="breadcrumb-item active" aria-current="page"><?= $row->jns_kelamin === 'WANITA' ? 'Suami' : 'Istri' ?></li>
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
    <?= form_open(base_url('app/pegawai/'.dohash($row->nik).'/keluarga/sutri/update'), 
    ["id" => "FormEdit", "data-parsley-validate" => "", "class" => "needs-validation", "novalidate" => ""],
    ["id" => dohash($row->id), "nik" => dohash($row->nik)]) ?>
        <div class="row g-3 px-4">
            <div class="col-12">
                <label for="nama_sutri" class="form-label">Nama <?= $row->jns_kelamin === 'PRIA' ? 'Istri' : 'Suami'; ?> <span class="text-danger">*</span></label>
                <input type="text" value="<?= $row->nama_sutri; ?>" class="form-control" id="nama_sutri" name="nama_sutri" placeholder="Masukan nama tanpa gelar" required/>
            </div>
            <div class="col-12">
                <label for="tmp_lahir" class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                <input type="text" value="<?= $row->tmp_lahir; ?>" class="form-control" id="tmp_lahir" name="tmp_lahir" placeholder="Masukan tempat lahir" required/>
            </div>
            <div class="col-6">
                <label for="tgl_lahir">Tanggal Lahir <span class="text-danger">*</span></label>
                <input type="date" value="<?= $row->tgl_lahir; ?>" name="tgl_lahir" class="form-control datepicker" id="tgl_lahir" placeholder="Tanggal Lahir" required/>
            </div>
            <div class="col-6">
                <label for="pekerjaan">Pekerjaan <span class="text-danger">*</span></label>
                <select class="form-select" name="pekerjaan" id="pekerjaan" required>
                    <option value="">-- Pilih Pekerjaan --</option>
                    <option value="Pegawai Negeri" <?= $row->pekerjaan === 'Pegawai Negeri' ? 'selected' : ''; ?>>Pegawai Negeri</option>
                    <option value="Pegawai Swasta" <?= $row->pekerjaan === 'Pegawai Swasta' ? 'selected' : ''; ?>>Pegawai Swasta</option>
                    <option value="Wiraswasta" <?= $row->pekerjaan === 'Wiraswasta' ? 'selected' : ''; ?>>Wiraswasta</option>
                    <option value="Honorer" <?= $row->pekerjaan === 'Honorer' ? 'selected' : ''; ?>>Honorer</option>
                    <option value="Rumah Tangga" <?= $row->pekerjaan === 'Rumah Tangga' ? 'selected' : ''; ?>>Rumah Tangga</option>
                </select>
            </div>
            <div class="col-12">
                <label for="no_akta_nikah" class="form-label">No. Akta Nikah <span class="text-danger">*</span></label>
                <input type="text" value="<?= $row->no_akta_nikah; ?>"  class="form-control" id="no_akta_nikah" name="no_akta_nikah" placeholder="Masukan nomor akta nikah" required/>
            </div>
            <div class="col-6">
                <label for="tgl_nikah">Tanggal Nikah <span class="text-danger">*</span></label>
                <input type="date" value="<?= $row->tgl_nikah; ?>" name="tgl_nikah" class="form-control datepicker" id="tgl_nikah" placeholder="Tanggal Nikah" required/>
            </div>
            <div class="col-6">
                <label for="status_kawin">Status <span class="text-danger">*</span></label>
                <select class="form-select" name="status_kawin" id="status_kawin" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="MENIKAH" <?= $row->status_kawin === 'MENIKAH' ? 'selected' : ''; ?>>Menikah</option>
                    <option value="JANDA/DUDA" <?= $row->status_kawin === 'JANDA/DUDA' ? 'selected' : ''; ?>>Janda / Duda</option>
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
        </div>
        <hr/>
        <div class="row g-3 mb-4 px-4">
            <div class="col-12">
                <label for="nip_sutri" class="form-label">NIK <?= $row->jns_kelamin === 'PRIA' ? 'Istri' : 'Suami'; ?></label>
                <input type="text" value="<?= $row->nip_sutri; ?>" class="form-control" id="nip_sutri" name="nip_sutri" placeholder="Masukan NIK"/>
            </div>
        </div>
        <div class="row g-3 px-4">
            <div class="col-12">
                <div class="btn-group g-3 w-100">
                    <button type="button" class="btn btn-danger"  onClick="return window.history.back()"> <i class="bx bx-x-circle"></i> Batal</button>
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