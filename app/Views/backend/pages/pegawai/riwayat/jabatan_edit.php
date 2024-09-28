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
                <li class="breadcrumb-item"><a href="<?= base_url('/app/pegawai/'.dohash($row->nik).'/jabatan') ?>">Jabatan</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= ucwords(strtolower($row->nama_jabatan)); ?> - <?= ucwords(strtolower($row->nama_unit_kerja)); ?></li>
            </ol>
        </nav>
    </div>
</div>
<!--end breadcrumb-->
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card border">
            <div class="card-header bg-light-primary">
                <h6><i class="bx bx-edit"></i> Edit Data Jabatan</h6>
                <?= namalengkap($row->gelar_depan,$row->nama,$row->gelar_blk) ?> :: <?= $row->nik; ?>
            </div>
            <div class="card-body">
            <?= form_open(base_url('app/pegawai/'.dohash($row->nik).'/jabatan/update'), 
            ["id" => "FormEdit", "data-parsley-validate" => "", "class" => "needs-validation", "novalidate" => ""],
            ["id" => dohash($row->id), "nik" => dohash($row->nik)]) ?>
            <div class="row g-3 px-0">
                <div class="col-12">
                    <label for="unit_kerja">Unit Kerja <span class="text-danger">*</span></label>
                    <select name="unit_kerja" class="form-select" aria-label="Default select example" data-placeholder="Pilih Unit Kerja" data-parsley-errors-container="#errorUnitKerja" required></select>
                    <div id="errorUnitKerja"></div>
                </div>
                <div class="col-12">
                    <label for="jabatan">Jabatan <span class="text-danger">*</span></label>
                    <select name="jabatan" class="form-select" aria-label="Default select example" data-placeholder="Pilih Jabatan" data-parsley-errors-container="#errorJabatan" required></select>
                    <div id="errorJabatan"></div>
                </div>
                <div class="col-6">
                    <label for="tmt_mulai">TMT Mulai <span class="text-danger">*</span></label>
                    <input type="date" name="tmt_mulai" value="<?= $row->tmt_mulai; ?>" class="form-control datepicker" id="tmt_mulai" placeholder="TMT Mulai" required/>
                </div>
                <div class="col-6">
                    <label for="tmt_selesai">TMT Selesai <span class="text-danger">*</span></label>
                    <input type="date" name="tmt_selesai" value="<?= $row->tmt_selesai; ?>" class="form-control datepicker" id="tmt_selesai" placeholder="TMT Selesai" required/>
                </div>
                <div class="col-12">
                    <label for="pejabat_sk">Pejabat SK <span class="text-danger">*</span></label>
                    <input type="text" name="pejabat_sk" value="<?= $row->pejabat_sk; ?>" class="form-control" id="pejabat_sk" placeholder="Pejabat SK" required/>
                </div>
                <div class="col-12">
                    <label for="no_sk">Nomor SK <span class="text-danger">*</span></label>
                    <input type="text" name="no_sk" value="<?= $row->no_sk; ?>" class="form-control" id="no_sk" placeholder="Nomor SK" required/>
                </div>
                <div class="col-6">
                    <label for="tgl_sk">Tanggal SK <span class="text-danger">*</span></label>
                    <input type="date" name="tgl_sk" value="<?= $row->tgl_sk; ?>" class="form-control datepicker" id="tgl_sk" placeholder="Tanggal SK" required/>
                </div>
                <div class="col-6">
                    <label for="tgl_pelantikan">Tanggal Pelantikan <span class="text-danger">*</span></label>
                    <input type="date" name="tgl_pelantikan" value="<?= $row->tgl_pelantikan; ?>" class="form-control datepicker" id="tgl_pelantikan" placeholder="Tanggal Pelantikan" required/>
                </div>
                <div class="btn-group g-3 w-100">
                    <button type="button" class="btn btn-danger" onClick="return window.history.back()"> <i class="bx bx-x-circle"></i> Batal</button>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="<?= base_url("template/vertical/plugins/parsley/parsley.min.js") ?>"></script>
<script src="<?= base_url("template/vertical/plugins/parsley/i18n/id.js") ?>"></script>
<script src="<?= base_url("template/vertical/plugins/parsley/default.js") ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    const FORM = $("form#FormEdit");
    
    $(".datepicker").flatpickr({
        altInput: true,
        altFormat: "j F Y",
        dateFormat: "Y-m-d",
        "locale": "id"
    });

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

    const UNIT_KERJA = $('select[name="unit_kerja"]').select2({
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        ajax: { 
          url: "<?= base_url('select2/unit_kerja')?>",
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

    let selectedUnitKerja = new Option('<?= @$row->nama_unit_kerja ?>', '<?= @$row->id_unit_kerja ?>', false, false);
    $( 'select[name="unit_kerja"]' ).append(selectedUnitKerja).trigger('change');

    const JABATAN = $('select[name="jabatan"]').select2({
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        allowClear: true,
        maximumSelectionLength: 1,
        minimumInputLength: 2,
        maximumInputLength: 20,
        maximumResultsForSearch: 10,
        ajax: { 
          url: "<?= base_url('select2/atasan_jabatan')?>",
          type: "POST",
          dataType: 'json',
          delay: 250,
          data: function (params) {
             // CSRF Hash
             var csrfName = '<?= csrf_token() ?>'; // CSRF Token name
             var csrfHash = '<?= csrf_hash() ?>'; // CSRF hash

             return {
                searchTerm: params.term, // search term
                [csrfName]: csrfHash, // CSRF Token,
             };
          },
          escapeMarkup: function (markup) {
            return markup;
            },
          processResults: function (response) {
             return {
                results: response.data
             };
          },
          cache: false
        }
    });

    let selectedJabatan = new Option('<?= @$row->nama_jabatan ?>', '<?= @$row->id_jabatan ?>', false, false);
    $( 'select[name="jabatan"]' ).append(selectedJabatan).trigger('change');
});
</script>
<?= $this->endSection(); ?>

<?= $this->section('style'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet" />
<?= $this->endSection(); ?>