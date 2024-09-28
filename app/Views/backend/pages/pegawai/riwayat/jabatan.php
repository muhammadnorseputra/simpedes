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
                <li class="breadcrumb-item active" aria-current="page">Jabatan</li>
            </ol>
        </nav>
    </div>
    <button class="btn btn-danger btn-sm ms-auto d-flex align-items-center gap-2" onClick="window.history.back()">Kembali <i class="bx bx-right-arrow-alt pe-0 me-0"></i></button>
</div>
<!--end breadcrumb-->
<div class="card">
    <div class="card-body">
        <table id="example" class="table table-striped table-bordered table-hover border border-3">
            <thead>
                <tr>
                    <th data-bs-toggle="tooltip" data-bs-title="Nomor">No</th>
                    <th>Jabatan / Unit Kerja</th>
                    <th>Jenis Jabatan</th>
                    <th>TMT Jabatan</th>
                    <th>Surat Keputusan</th>
                    <th>Berkas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<?= $this->endSection(); ?>
<?= $this->section('modal'); ?>
<!-- Offcanvas  Left-->
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasLeft" data-bs-focus="false" aria-labelledby="offcanvasLeftLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="offcanvasLeftLabel">Tambah Riwayat Jabatan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <?= form_open(base_url('app/pegawai/'.dohash($nik).'/jabatan/add'), ["id" => "FormAdd", "data-parsley-validate" => "", "class" => "needs-validation", "novalidate" => ""]) ?>
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
                <input type="date" name="tmt_mulai" class="form-control datepicker" id="tmt_mulai" placeholder="TMT Mulai" required/>
            </div>
            <div class="col-6">
                <label for="tmt_selesai">TMT Selesai <span class="text-danger">*</span></label>
                <input type="date" name="tmt_selesai" class="form-control datepicker" id="tmt_selesai" placeholder="TMT Selesai" required/>
            </div>
            <div class="col-12">
                <label for="pejabat_sk">Pejabat SK <span class="text-danger">*</span></label>
                <input type="text" name="pejabat_sk" class="form-control" id="pejabat_sk" placeholder="Pejabat SK" required/>
            </div>
            <div class="col-12">
                <label for="no_sk">Nomor SK <span class="text-danger">*</span></label>
                <input type="text" name="no_sk" class="form-control" id="no_sk" placeholder="Nomor SK" required/>
            </div>
            <div class="col-6">
                <label for="tgl_sk">Tanggal SK <span class="text-danger">*</span></label>
                <input type="date" name="tgl_sk" class="form-control datepicker" id="tgl_sk" placeholder="Tanggal SK" required/>
            </div>
            <div class="col-6">
                <label for="tgl_pelantikan">Tanggal Pelantikan <span class="text-danger">*</span></label>
                <input type="date" name="tgl_pelantikan" class="form-control datepicker" id="tgl_pelantikan" placeholder="Tanggal Pelantikan" required/>
            </div>
            <div class="btn-group g-3 w-100">
                <button type="button" class="btn btn-danger" data-bs-dismiss="offcanvas"> <i class="bx bx-x-circle"></i> Batal</button>
                <button type="submit" class="btn btn-primary"> <i class="bx bx-save"></i> Simpan</button>
            </div>
        </div>
        <?= form_close(); ?>
    </div>
</div>
<!-- End Offcanvas Left-->

<!-- Modal -->
<div class="modal fade" id="upload-berkas" tabindex="-1" role="dialog" aria-labelledby="modal-upload-berkas" aria-hidden="true">
<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modal-upload-berkas">
                Upload Berkas
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <?= form_open(base_url('app/pegawai/'.dohash($nik).'/jabatan/upload'), 
        ["id" => "FormUpload", "data-parsley-validate" => "", "class" => "needs-validation", "novalidate" => ""],
        ["id" => "", "nik" => ""]) ?>
            <div class="ratio ratio-16x9">
                <embed id="preview" src="https://comportcomputers.com/wp-content/uploads/2020/07/apa-itu-file-pdf.png" style="width:100%; height: 100%;" type="application/pdf" allowfullscreen>
            </div>
            <div class="input-group mt-3">
                <input type="file" name="berkas" 
                oninput="preview.src=window.URL.createObjectURL(this.files[0]) + '#toolbar=0&navpanes=0&scrollbar=0&page=1&zoom=FitH'"
                accept=".pdf" 
                data-parsley-errors-container="#errorUpload" 
                class="form-control" 
                id="inputGroupFile04" 
                aria-describedby="inputGroupFileAddon04" aria-label="Upload" 
                data-parsley-max-file-size="1024"
                data-parsley-max-file-size-message="File ini tidak boleh lebih besar dari 1 Mb"
                data-parsley-mime-type="application/pdf"
                required>
                <button class="btn btn-outline-secondary" type="submit" id="inputGroupFileAddon04"><i class="bx bx-upload"></i> Unggah</button>
            </div>
            <div id="errorUpload"></div>
        <?= form_close() ?>
        </div>
    </div>
</div>
</div>
 <!-- End Modal -->
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="<?= base_url("template/vertical/plugins/parsley/parsley.min.js") ?>"></script>
<script src="<?= base_url("template/vertical/plugins/parsley/i18n/id.js") ?>"></script>
<script src="<?= base_url("template/vertical/plugins/parsley/default.js") ?>"></script>
<script src="<?= base_url("template/vertical/plugins/datatable/js/datatables.min.js") ?>" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
<script>
$(document).ready(function() {
    const FORM = $("form#FormAdd");
    const FORM_UPLOAD = $("form#FormUpload");
    const FORM_EDIT = $("form#FormEdit");
    const MODAL_UPLOAD = new bootstrap.Modal("#upload-berkas");

    $(".datepicker").flatpickr({
        altInput: true,
        altFormat: "j F Y",
        dateFormat: "Y-m-d",
        "locale": "id",
    });

    const CANVAS_ADD = new bootstrap.Offcanvas("#offcanvasLeft", {
        backdrop: 'static',
        keyboard: false,
        scroll: false,
    });

    // Form Tambah
    FORM.on("submit", function(e) {
        e.preventDefault();
        let _ = $(this),
        url = _.attr("action"),
        method = _.attr("method"),
        data = _.serializeArray();
        if(_.parsley().isValid()) {
            $.ajax({
                url,
                method,
                data,
                dataType: 'json',
                beforeSend: () => {
                    _.find("button[type='submit']").html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`).prop("disabled", true);
                },
                success: (response) => {
                    if(response.status === true) {
                        iziToast.success({
                            timeout: 1000,
                            title: 'Berhasil',
                            message: response.message,
                            position: 'topCenter',
                        });
                        datatable.ajax.reload();
                        CANVAS_ADD.hide()
                        return false;
                    }
                    iziToast.warning({
                        message: response.message,
                        position: 'topCenter',
                    })
                },
                error: (err) => {
                    iziToast.error({
                        title: `Error ${err.status}`,
                        message: `${err.responseJSON.message || err.statusText}`,
                        position: 'topCenter',
                    })
                    _.find("button[type='submit']").html(`<i class="bx bx-save"></i> Simpan`).prop("disabled", false);
                }
            })
        }
    })

    // Form Upload
    FORM_UPLOAD.on("submit", function(e) {
        e.preventDefault();
        let _ = $(this),
        url = _.attr("action"),
        method = _.attr("method").toUpperCase(),
        data = new FormData(this);
        if(_.parsley().isValid()) {
            $.ajax({
                url,
                method,
                data,
                processData: false,
                contentType: false,
                cache: false,
                dataType: "json",
                beforeSend: () => {
                    _.find("button[type='submit']").html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`).prop("disabled", true);
                },
                success: (res) => {
                    if (res.status === true) {
                        iziToast.success({
                            message: res.message,
                            position: 'topCenter',
                            onClosing: () => {
                                _.parsley().reset();
                            }
                        });
                        _.find("button[type='submit']").html(`<i class="bx bx-upload"></i> Unggah`).prop("disabled", false)
                        MODAL_UPLOAD.hide();
                        datatable.ajax.reload();
                        return false;
                    } 

                    iziToast.warning({
                        message: res.message,
                        position: 'topCenter'
                    });
                    _.find("button[type='submit']").html(`<i class="bx bx-upload"></i> Unggah`).prop("disabled", false)
                },
                error: (err) => {
                    iziToast.error({
                        message: err.responseJSON.message || err.statusText,
                        position: 'topCenter'
                    });
                    _.find("button[type='submit']").html(`<i class="bx bx-upload"></i> Unggah`).prop("disabled", false)
                }
            })
            
        }
    })

    $("#offcanvasLeft").on('hidden.bs.offcanvas', event => {
        FORM.parsley().reset();
        FORM[0].reset();
        FORM.find("button[type='submit']").html(`<i class="bx bx-save"></i> Simpan`).prop("disabled", false);
    });

    $.fn.dataTable.ext.buttons.add = {
        text: '<i class="bx bx-plus"></i> Tambah',
        action: function ( e, dt, node, config ) {  
            CANVAS_ADD.show();
        },
        className: 'btn btn-primary'
    };

    let datatable  = $('table#example').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        order: [], //this mean no init order on datatable
        layout: {
            topStart: [{
                buttons: ['add']
            }],
            bottomStart: ['info','pageLength']
        },
        ajax: {
            url: '<?= base_url('datatable/riwayat/jabatan') ?>',
            method: 'POST',
            data: {
                ['<?= csrf_token() ?>']: '<?= csrf_hash() ?>',
                nik: '<?= $row->nik ?>'
            },
        },
        columns: [
            {data: 'no', orderable: false, searchabel: false, className: 'text-center'},
            {data: 'nama_jabatan'},
            {data: 'jenis'},
            {data: 'tmt_mulai'},
            {data: 'no_sk'},
            {data: 'berkas', orderable: false, searchabel: false, className: 'text-center'},
            {data: 'action', orderable: false, searchabel: false, className: 'text-center'},
        ]
    });

    const UNIT_KERJA = $('select[name="unit_kerja"]').select2({
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        dropdownParent: $("#offcanvasLeft"),
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

    const JABATAN = $('select[name="jabatan"]').select2({
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        dropdownParent: $("#offcanvasLeft"),
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

    datatable.on("click", "button#upload-berkas", function() {
        let _ = $(this),
        id = _.data('uid'),
        nik = _.data('nik');
        MODAL_UPLOAD.show();
        FORM_UPLOAD.find("input[name='id']").val(id)
        FORM_UPLOAD.find("input[name='nik']").val(nik)
    })
    datatable.on("click", "button#hapus", function() {
        let _ = $(this),
        id = _.data('uid'),
        nik = _.data('nik'),
        file = _.data('file');
        $.confirm({
            title: 'Peringatan !',
            content: `Apakah anda yakin akan menghapus riwayat jabatan <span class="badge bg-light-danger text-danger">${file}</span> tersebut ?`,
            type: 'red',
            theme: 'material',
            buttons: {
                hapus: {
                    text: '<i class="bx bx-trash-alt"></i> Hapus',
                    btnClass: 'btn-lg btn-danger',
                    action: function () {
                        // CSRF Hash
                        let csrfName = '<?= csrf_token() ?>'; // CSRF Token name
                        let csrfHash = '<?= csrf_hash() ?>'; // CSRF hash
                        $.post(
                            `<?= base_url('app/pegawai/'.dohash($nik).'/jabatan/delete') ?>`,
                            { id, nik, file, [csrfName]: csrfHash, '_method': 'DELETE' },
                            function (res) {
                                if (res.status === true) {
                                    iziToast.success({
                                        position: 'topCenter',
                                        message: res.message,
                                    });
                                    datatable.ajax.reload();
                                }
                            },
                            "json"
                        ).fail((err) => {
                            iziToast.error({
                                message: err.responseJSON.message || err.statusText,
                                position: 'topCenter'
                            });
                        });
                    }
                },
                batal: {
                    text: '<i class="bx bx-x"></i> Batal',
                    action: function() {
                        return;
                    }
                },
            }
        });
    })
    datatable.on("click", "button#edit", function() {
        let _ = $(this),
        id = _.data('uid'),
        nik = _.data('nik');
        window.location.href = `${origin}/app/pegawai/${id}/jabatan/edit`;
    })
})
</script>
<?= $this->endSection(); ?>
<?= $this->section('style'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<link rel="stylesheet" href="<?= base_url("template/vertical/plugins/datatable/css/datatables.min.css") ?>"/>
<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet" />
<?= $this->endSection(); ?>