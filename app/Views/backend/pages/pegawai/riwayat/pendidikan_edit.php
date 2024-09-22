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
                <li class="breadcrumb-item"><a href="<?= base_url('/app/pegawai/'.dohash($row->nik).'/pendidikan') ?>">Pendidikan</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $row->nama_tingkat_pendidikan; ?> - <?= ucwords(strtolower($row->nama_jurusan_pendidikan)); ?></li>
            </ol>
        </nav>
    </div>
</div>
<!--end breadcrumb-->
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card">
            <div class="card-header bg-light-primary">
                <h6><i class="bx bx-edit"></i> Edit Data Pendidikan</h6>
                <?= namalengkap($row->gelar_depan,$row->nama,$row->gelar_blk) ?> :: <?= $row->nik; ?>
            </div>
            <div class="card-body">
            <?= form_open(base_url('app/pegawai/'.dohash($row->nik).'/pendidikan/update'), 
            ["id" => "FormEdit", "data-parsley-validate" => "", "class" => "needs-validation", "novalidate" => ""],
            ["id" => dohash($row->id), "nik" => dohash($row->nik)]) ?>
            <div class="row g-3 px-0">
                <div class="col-6">
                    <label for="gelar_depan">Gelar Depan <span class="text-danger">*</span></label>
                    <input type="text" name="gelar_depan" value="<?= $row->gelar_dpn; ?>" class="form-control" id="gelar_depan" placeholder="Gelar Depan" required/>
                </div>
                <div class="col-6">
                    <label for="gelar_blk">Gelar Belakang <span class="text-danger">*</span></label>
                    <input type="text" name="gelar_blk" value="<?= $row->gelar_blk; ?>" class="form-control" id="gelar_blk" placeholder="Gelar Belakang" required/>
                </div>
                <div class="col-12">
                    <label for="tingkat_pendidikan">Tingkat Pendidikan <span class="text-danger">*</span></label>
                    <select name="tingkat_pendidikan" class="form-select" aria-label="Default select example" data-placeholder="Pilih Tingkat Pendidikan" data-parsley-errors-container="#errorTP" required></select>
                    <div id="errorTP"></div>
                </div>
                <div class="col-12">
                    <label for="jurusan_pendidikan">Jurusan Pendidikan <span class="text-danger">*</span></label>
                    <select name="jurusan_pendidikan" class="form-select" aria-label="Default select example" data-placeholder="Pilih Jurusan Pendidikan" data-parsley-errors-container="#errorJP" required></select>
                    <div id="errorJP"></div>
                </div>
                <hr/>
                <div class="col-12 mt-0">
                    <label for="nama_sekolah">Nama Sekolah / Universitas <span class="text-danger">*</span></label>
                    <input type="text" name="nama_sekolah" value="<?= $row->nama_sekolah; ?>" class="form-control" id="nama_sekolah" placeholder="Nama Sekolah / Universitas" required/>
                </div>
                <div class="col-12">
                    <label for="nama_kepsek">Nama Kepsek/Rektor/Dekan <span class="text-danger">*</span></label>
                    <input type="text" name="nama_kepsek" value="<?= $row->nama_kepsek; ?>" class="form-control" id="nama_kepsek" placeholder="Nama Kepsek/Rektor/Dekan" required/>
                </div>
                <div class="col-12">
                    <label for="no_sttb">Nomor STTB <span class="text-danger">*</span></label>
                    <input type="text" name="no_sttb" value="<?= $row->no_sttb; ?>" class="form-control" id="no_sttb" placeholder="Nomor STTB" required/>
                </div>
                <div class="col-6">
                    <label for="tgl_sttb">Tanggal STTB <span class="text-danger">*</span></label>
                    <input type="date" name="tgl_sttb" value="<?= $row->tgl_sttb; ?>" class="form-control datepicker" id="tgl_sttb" placeholder="Tanggal STTB" required/>
                </div>
                <div class="col-6">
                    <label for="thn_lulus">Tahun Lulus <span class="text-danger">*</span></label>
                    <input type="number" name="thn_lulus" value="<?= $row->thn_lulus; ?>" class="form-control" id="thn_lulus" placeholder="Tahun Lulus" required/>
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

    const select2TingkatPendidikan = $('select[name="tingkat_pendidikan"]').select2({
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        ajax: { 
          url: "<?= base_url('select2/tingkat_pendidikan')?>",
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

    let selectedTp = new Option('<?= @$row->nama_tingkat_pendidikan ?>', '<?= @$row->id_tingkat_pendidikan ?>', false, false);
    $( 'select[name="tingkat_pendidikan"]' ).append(selectedTp).trigger('change');

    const select2JurusanPendidikan = $('select[name="jurusan_pendidikan"]').select2({
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        allowClear: true,
        maximumSelectionLength: 1,
        minimumInputLength: 2,
        maximumInputLength: 20,
        maximumResultsForSearch: 10,
        ajax: { 
          url: "<?= base_url('select2/jurusan_pendidikan')?>",
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
                id_tingkat_pendidikan: select2TingkatPendidikan.val()
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
    let selectedJp = new Option('<?= @$row->nama_jurusan_pendidikan ?>', '<?= @$row->id_jurusan_pendidikan ?>', false, false);
    $( 'select[name="jurusan_pendidikan"]' ).append(selectedJp).trigger('change');
});
</script>
<?= $this->endSection(); ?>

<?= $this->section('style'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet" />
<?= $this->endSection(); ?>