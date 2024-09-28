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
                <li class="breadcrumb-item"><a href="<?= base_url('/app/pegawai/'.dohash($row->nik).'/workshop') ?>">Workshop</a></li>
                <li class="breadcrumb-item active" aria-current="page"> <?= $row->nama_workshop; ?></li>
            </ol>
        </nav>
    </div>
    <button class="btn btn-danger btn-sm ms-auto d-flex align-items-center gap-2" onClick="window.history.back()">Kembali <i class="bx bx-right-arrow-alt pe-0 me-0"></i></button>
</div>
<!--end breadcrumb-->
<div class="row">
    <div class="col-md-6 mx-auto">
        
        <div class="card">
            <div class="card-header bg-light-primary">
                <h6><i class="bx bx-edit"></i> Edit Data Workshop</h6>
                <?= namalengkap($row->gelar_depan,$row->nama,$row->gelar_blk) ?> :: <?= $row->nik; ?>
            </div>
            <div class="card-body">
            <?= form_open(base_url('app/pegawai/'.dohash($row->nik).'/workshop/update'), 
            ["id" => "FormEdit", "data-parsley-validate" => "", "class" => "needs-validation", "novalidate" => ""],
            ["id" => dohash($row->no), "nik" => dohash($row->nik)]) ?>
                <div class="row g-3 px-0">
                    <div class="col-12 d-flex flex-column gap-1">
                        <span>Nama Pegawai</span>
                        <span class="fw-bold"><?= namalengkap($row->gelar_depan,$row->nama,$row->gelar_blk) ?></span>
                    </div>
                    <div class="col-12">
                        <label  class="form-label" for="fid_jenis_workshop">Jenis Kegiatan <span class="text-danger">*</span></label>
                        <select name="fid_jenis_workshop" class="form-select" aria-label="Default select example" data-placeholder="Pilih Jenis Kegiatan" data-parsley-errors-container="#errorTP" required></select>
                        <div id="errorTP"></div>
                    </div>
                    <div class="col-12">
                        <label  class="form-label" for="fid_rumpun_diklat">Rumpun Diklat <span class="text-danger">*</span></label>
                        <select name="fid_rumpun_diklat" class="form-select" aria-label="Default select example" data-placeholder="Pilih Rumpun Diklat" data-parsley-errors-container="#errorJP" required></select>
                        <div id="errorJP"></div>
                    </div>
                    <div class="col-12">
                        <label  class="form-label" for="nama_kegiatan">Nama Kegiatan <span class="text-danger">*</span></label>
                        <input type="text" name="nama_kegiatan" value="<?= $row->nama_workshop; ?>" class="form-control" id="nama_kegiatan" placeholder="Nama Kegiatan" required/>
                    </div>
                    <div class="col-6">
                        <label  class="form-label" for="tahun">Tahun <span class="text-danger">*</span></label>
                        <input type="number" name="tahun" value="<?= $row->tahun; ?>" class="form-control" id="tahun" placeholder="Tahun" required/>
                    </div>
                    <div class="col-6">
                        <label  class="form-label" for="tanggal">Tanggal Pelaksanaan <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal" value="<?= $row->tanggal; ?>" class="form-control datepicker" id="tanggal" placeholder="Tanggal Pelaksanaan" required/>
                    </div>
                    <div class="col-12">
                        <label  class="form-label" for="instansi_penyelenggara">Instansi Penyelenggara <span class="text-danger">*</span></label>
                        <input type="text" name="instansi_penyelenggara" value="<?= $row->instansi_penyelenggara; ?>" class="form-control" id="instansi_penyelenggara" placeholder="Instansi Penyelenggara" required/>
                    </div>
                    <div class="col-12">
                        <label  class="form-label" for="tempat">Tempat <span class="text-danger">*</span></label>
                        <input type="text" name="tempat" value="<?= $row->tempat; ?>" class="form-control" id="tempat" placeholder="Tempat" required/>
                    </div>
                    <div class="col-6">
                        <label  class="form-label" for="lama">Lama <span class="text-danger">*</span></label>
                        <input type="number" name="lama" value="<?= lamaWorkshop($row->lama_jam,$row->lama_hari,$row->lama_bulan); ?>" min="1" class="form-control datepicker" id="lama" placeholder="Lama" required/>
                    </div>
                    <div class="col-6">
                        <label for="satuan" class="form-label">Satuan <span class="text-danger">*</span></label>
                        <select class="form-select" name="satuan" id="satuan" required>
                            <option selected value="jam" <?= $row->lama_jam !== null ? 'selected' : ''; ?>>Jam</option>
                            <option value="hari" <?= $row->lama_hari !== null ? 'selected' : ''; ?>>Hari</option>
                            <option value="bulan" <?= $row->lama_bulan !== null ? 'selected' : ''; ?>>Bulan</option>
                        </select>
                    </div>
                    <hr>
                    <div class="col-12 mt-0">
                        <label  class="form-label" for="pejabat_sk">Nama Penjabat <span class="text-danger">*</span></label>
                        <input type="text" name="pejabat_sk" value="<?= $row->pejabat_sk; ?>" class="form-control" id="pejabat_sk" placeholder="Nama Penjabat" required/>
                    </div>
                    <div class="col-12">
                        <label  class="form-label" for="no_sk">Nomor SK <span class="text-danger">*</span></label>
                        <input type="text" name="no_sk" value="<?= $row->no_sk; ?>" class="form-control" id="no_sk" placeholder="Nomor SK" required/>
                    </div>
                    <div class="col-6">
                        <label  class="form-label" for="tgl_sk">Tanggal SK <span class="text-danger">*</span></label>
                        <input type="date" name="tgl_sk" value="<?= $row->tgl_sk; ?>" class="form-control datepicker" id="tgl_sk" placeholder="Tanggal SK" required/>
                    </div>
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
<!-- Ex: script -->
<?= $this->section('script'); ?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="<?= base_url("template/vertical/plugins/parsley/parsley.min.js") ?>"></script>
<script src="<?= base_url("template/vertical/plugins/parsley/i18n/id.js") ?>"></script>
<script src="<?= base_url("template/vertical/plugins/parsley/default.js") ?>"></script>
<?= $this->endSection(); ?>
<!-- Ex: css -->
<?= $this->section('style'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<?= $this->endSection(); ?>
 
<!-- In: script -->
<?= $this->section('script'); ?>
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
        
        const JENIS_KEGIATAN = $('select[name="fid_jenis_workshop"]').select2({
            theme: "bootstrap-5",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: $( this ).data( 'placeholder' ),
            ajax: { 
                url: "<?= base_url('select2/jenis_workshop')?>",
                type: "POST",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    // CSRF Hash
                    var csrfName = '<?= csrf_token() ?>'; // CSRF Token name
                    var csrfHash = '<?= csrf_hash() ?>'; // CSRF hash

                    return {
                        searchTerm: params.term, // search term
                        [csrfName]: csrfHash // CSRF Token
                    };
                },
                processResults: function (response) {
                    return {
                        results: response.data
                    };
                },
                cache: false
            }
        });

        let selectedJK = new Option('<?= @$row->nama_jenis_workshop ?>', '<?= @$row->id_jenis_workshop ?>', false, false);
        $( 'select[name="fid_jenis_workshop"]' ).append(selectedJK).trigger('change');

        const RUMPUN_DIKLAT = $('select[name="fid_rumpun_diklat"]').select2({
            theme: "bootstrap-5",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: $( this ).data( 'placeholder' ),
            ajax: { 
                url: "<?= base_url('select2/rumpun_diklat')?>",
                type: "POST",
                dataType: 'json',
                delay: 350,
                data: function (params) {
                    // CSRF Hash
                    var csrfName = '<?= csrf_token() ?>'; // CSRF Token name
                    var csrfHash = '<?= csrf_hash() ?>'; // CSRF hash
                    return {
                        searchTerm: params.term || "", // search term
                        page: params.page || 1,
                        [csrfName]: csrfHash, // CSRF Token
                    };
                },
                cache: true
            }
        });
        let selectedRD = new Option('<?= @$row->nama_rumpun_diklat ?>', '<?= @$row->id_rumpun_diklat ?>', false, false);
        $( 'select[name="fid_rumpun_diklat"]' ).append(selectedRD).trigger('change');
    })
</script>
<?= $this->endSection(); ?>