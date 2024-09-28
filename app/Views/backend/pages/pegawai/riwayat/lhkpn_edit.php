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
                <li class="breadcrumb-item"><a href="<?= base_url('/app/pegawai/'.dohash($row->nik)."/lhkpn") ?>">LHKPN</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $row->jabatan; ?> - <?= $row->tahun_wajib; ?></li>
            </ol>
        </nav>
    </div>
    <button class="btn btn-danger btn-sm ms-auto d-flex align-items-center gap-2" onClick="window.history.back()">Kembali <i class="bx bx-right-arrow-alt pe-0 me-0"></i></button>
</div>
<!--end breadcrumb-->
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card border">
            <div class="card-header bg-light-primary">
                <h6><i class="bx bx-edit"></i> Edit Data LHKPN</h6>
                <?= namalengkap($row->gelar_depan,$row->nama,$row->gelar_blk) ?> :: <?= $row->nik; ?>
            </div>
            <div class="card-body">
            <?= form_open(base_url('app/pegawai/'.dohash($row->nik).'/lhkpn/update'), 
            ["id" => "FormEdit", "data-parsley-validate" => "", "class" => "needs-validation", "novalidate" => ""],
            ["id" => dohash($row->id), "nik" => dohash($row->nik)]) ?>
            <div class="row g-3 px-0">
                <div class="col-12 d-flex flex-column gap-1">
                    <span>Nama Wajib Lapor</span>
                    <span class="fw-bold"><?= namalengkap($row->gelar_depan,$row->nama,$row->gelar_blk) ?></span>
                </div>
                <div class="col-12">
                    <label for="jenis_form" class="form-label">Jenis Form <span class="text-danger">*</span></label>
                    <select class="form-select" name="jenis_form" id="jenis_form" required>
                        <option value="">-- Pilih Jenis Form --</option>
                        <option value="A" <?= $row->jenis_form === 'A' ? 'selected' : ''; ?>>Pertama (A)</option>
                        <option value="B" <?= $row->jenis_form === 'B' ? 'selected' : ''; ?>>Lanjutan (B)</option>
                    </select>
                </div>
                <div class="col-12">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-select" name="status" id="status" required>
                        <option value="">-- Pilih Status Usulan --</option>
                        <option value="BARU" <?= $row->status === 'BARU' ? 'selected' : ''; ?>>BARU</option>
                        <option value="PERBAIKAN" <?= $row->status === 'PERBAIKAN' ? 'selected' : ''; ?>>PERBAIKAN</option>
                    </select>
                </div>
                <div class="col-12">
                    <label  class="form-label" for="jabatan">Jabatan <span class="text-danger">*</span></label>
                    <input type="text" name="jabatan" value="<?= $row->jabatan; ?>" class="form-control" id="jabatan" placeholder="Nama Jabatan" required/>
                </div>
                <div class="col-12">
                    <label class="form-label" for="unit_kerja">Unit Kerja <span class="text-danger">*</span></label>
                    <input type="text" name="unit_kerja" value="<?= $row->unit_kerja; ?>" class="form-control" id="unit_kerja" placeholder="Nama Unit Kerja" required/>
                </div>
                <div class="col-6">
                    <label class="form-label" for="tgl_penyampaian">Tgl. Penyampaian <span class="text-danger">*</span></label>
                    <input type="date" name="tgl_penyampaian" value="<?= $row->tgl_penyampaian; ?>" class="form-control" id="tgl_penyampaian" required/>
                </div>
                <div class="col-6">
                    <label class="form-label" for="tgl_lapor">Tgl. Lapor <span class="text-danger">*</span></label>
                    <input type="date" name="tgl_lapor" value="<?= $row->tgl_lapor; ?>" class="form-control" id="tgl_lapor" required/>
                </div>
                <div class="col-6">
                    <label class="form-label" for="tahun_wajib">Tahun Wajib <span class="text-danger">*</span></label>
                    <input type="number" maxlength="4" minlength="4" name="tahun_wajib" value="<?= $row->tahun_wajib; ?>" class="form-control" id="tahun_wajib" placeholder="Tahun" required/>
                </div>
            </div>
            <hr>
            <div class="row g-3 px-0">
                <div class="btn-group g-3 w-100">
                    <button type="button" class="btn btn-danger"  onClick="return window.history.back()"> <i class="bx bx-x-circle"></i> Batal</button>
                    <button type="submit" class="btn btn-primary"> <i class="bx bx-save"></i> Simpan</button>
                </div>
            </div>
            <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script src="<?= base_url("template/vertical/plugins/parsley/parsley.min.js") ?>"></script>
<script src="<?= base_url("template/vertical/plugins/parsley/i18n/id.js") ?>"></script>
<script src="<?= base_url("template/vertical/plugins/parsley/default.js") ?>"></script>
<script>
    $(document).ready(function() {
        const FORM = $("form#FormEdit");

        FORM.on("submit", function(e) {
            e.preventDefault();
            let _ = $(this),
            url = _.attr("action"),
            method = _.attr("method"),
            data = _.serializeArray();
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