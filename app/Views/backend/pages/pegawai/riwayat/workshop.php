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
                <li class="breadcrumb-item active" aria-current="page">Workshop</li>
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
                    <th>Nama Kegiatan</th>
                    <th>Tahun</th>
                    <th class="text-center"><u>Instansi Penyelenggara</u> <br> Tempat Pelaksanaan</th>
                    <th>Lama / Tanggal</th>
                    <th>Sertifikat</th>
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
        <h5 class="offcanvas-title" id="offcanvasLeftLabel">Tambah Riwayat Workshop</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <?= form_open(base_url('app/pegawai/'.dohash($nik).'/workshop/add'), ["id" => "FormAdd", "data-parsley-validate" => "", "class" => "needs-validation", "novalidate" => ""]) ?>
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
                <input type="text" name="nama_kegiatan" class="form-control" id="nama_kegiatan" placeholder="Nama Kegiatan" required/>
            </div>
            <div class="col-6">
                <label  class="form-label" for="tahun">Tahun <span class="text-danger">*</span></label>
                <input type="number" name="tahun" class="form-control" id="tahun" placeholder="Tahun" required/>
            </div>
            <div class="col-6">
                <label  class="form-label" for="tanggal">Tanggal Pelaksanaan <span class="text-danger">*</span></label>
                <input type="date" name="tanggal" class="form-control datepicker" id="tanggal" placeholder="Tanggal Pelaksanaan" required/>
            </div>
            <div class="col-12">
                <label  class="form-label" for="instansi_penyelenggara">Instansi Penyelenggara <span class="text-danger">*</span></label>
                <input type="text" name="instansi_penyelenggara" class="form-control" id="instansi_penyelenggara" placeholder="Instansi Penyelenggara" required/>
            </div>
            <div class="col-12">
                <label  class="form-label" for="tempat">Tempat <span class="text-danger">*</span></label>
                <input type="text" name="tempat" class="form-control" id="tempat" placeholder="Tempat" required/>
            </div>
            <div class="col-6">
                <label  class="form-label" for="lama">Lama <span class="text-danger">*</span></label>
                <input type="number" name="lama" min="1" class="form-control datepicker" id="lama" placeholder="Lama" required/>
            </div>
            <div class="col-6">
                <label for="satuan" class="form-label">Satuan <span class="text-danger">*</span></label>
                <select class="form-select" name="satuan" id="satuan" required>
                    <option selected value="jam">Jam</option>
                    <option value="hari">Hari</option>
                    <option value="bulan">Bulan</option>
                </select>
            </div>
            <hr>
            <div class="col-12 mt-0">
                <label  class="form-label" for="pejabat_sk">Nama Penjabat <span class="text-danger">*</span></label>
                <input type="text" name="pejabat_sk" class="form-control" id="pejabat_sk" placeholder="Nama Penjabat" required/>
            </div>
            <div class="col-12">
                <label  class="form-label" for="no_sk">Nomor SK <span class="text-danger">*</span></label>
                <input type="text" name="no_sk" class="form-control" id="no_sk" placeholder="Nomor SK" required/>
            </div>
            <div class="col-6">
                <label  class="form-label" for="tgl_sk">Tanggal SK <span class="text-danger">*</span></label>
                <input type="date" name="tgl_sk" class="form-control datepicker" id="tgl_sk" placeholder="Tanggal SK" required/>
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
<?= $this->endSection(); ?>

<!-- Ex: script -->
<?= $this->section('script'); ?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="<?= base_url("template/vertical/plugins/parsley/parsley.min.js") ?>"></script>
<script src="<?= base_url("template/vertical/plugins/parsley/i18n/id.js") ?>"></script>
<script src="<?= base_url("template/vertical/plugins/parsley/default.js") ?>"></script>
<script src="<?= base_url("template/vertical/plugins/datatable/js/datatables.min.js") ?>" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
<?= $this->endSection(); ?>
<!-- Ex: css -->
<?= $this->section('style'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<link rel="stylesheet" href="<?= base_url("template/vertical/plugins/datatable/css/datatables.min.css") ?>"/>
<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet" />
<?= $this->endSection(); ?>
 
<!-- In: script -->
<?= $this->section('script'); ?>
<script>
    $(document).ready(function() {
        const FORM = $("form#FormAdd");

        const CANVAS_ADD = new bootstrap.Offcanvas("#offcanvasLeft", {
            backdrop: 'static',
            keyboard: false,
            scroll: false,
        });

        FORM.on("submit", function(e) 
        {
            e.preventDefault()
            const _ = $(this),
            url = _.attr("action"),
            method = _.attr("method").toUpperCase(),
            data = _.serializeArray();
            if(FORM.parsley().isValid()) {
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

        $("#offcanvasLeft").on('hidden.bs.offcanvas', event => {
            FORM.parsley().reset();
            FORM[0].reset();
            FORM.find("button[type='submit']").html(`<i class="bx bx-save"></i> Simpan`).prop("disabled", false);
            // FORM.find('select[name="fid_jenis_workshop"]').val("").trigger('change');
            // FORM.find('select[name="fid_rumpun"]').val("").trigger('change');
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
                url: '<?= base_url('datatable/riwayat/workshop') ?>',
                method: 'POST',
                data: {
                    ['<?= csrf_token() ?>']: '<?= csrf_hash() ?>',
                    nik: '<?= $row->nik ?>'
                },
            },
            columns: [
                {data: 'no_urut', orderable: false, searchabel: false, className: 'text-center'},
                {data: 'nama_workshop', className: 'text-uppercase'},
                {data: 'tahun', className: 'text-center', width: '5%'},
                {data: 'instansi_penyelenggara', orderable: false, searchabel: false},
                {data: 'tanggal', orderable: false, searchabel: false},
                {data: 'no_sk', orderable: false, searchabel: false},
                {data: 'action', orderable: false, searchabel: false, className: 'text-center'},
            ]
        });

        const JENIS_KEGIATAN = $('select[name="fid_jenis_workshop"]').select2({
            theme: "bootstrap-5",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: $( this ).data( 'placeholder' ),
            dropdownParent: $("#offcanvasLeft"),
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

        const RUMPUN_DIKLAT = $('select[name="fid_rumpun_diklat"]').select2({
            theme: "bootstrap-5",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: $( this ).data( 'placeholder' ),
            dropdownParent: $("#offcanvasLeft"),
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

        // Action
        datatable.on("click", "button#hapus", function() {
            let _ = $(this),
            id = _.data('uid'),
            nik = _.data('nik');
            $.confirm({
                title: 'Peringatan !',
                content: `Apakah anda yakin akan menghapus riwayat workshop tersebut ?`,
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
                                `<?= base_url('app/pegawai/'.dohash($nik).'/workshop/delete') ?>`,
                                { id, nik, [csrfName]: csrfHash, '_method': 'DELETE' },
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
            window.location.href = `${origin}/app/pegawai/${id}/workshop/edit`;
        })
    })
</script>
<?= $this->endSection(); ?>