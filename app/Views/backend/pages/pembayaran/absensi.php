<?= $this->extend('backend/layouts/app'); ?>

<?= $this->section('content'); ?>
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Import</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('/') ?>"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Absensi</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="card">
        <div class="card-body">
                <div class="alert alert-warning" role="alert">
                    <b>Perhatian !</b> 
                    Data Absensi setelah 3 Hari sejak ditambahkan, akan dikunci oleh sistem atau tidak bisa diperbaiki dan dibatalkan.
                </div>
                <table id="example" class="table table-striped table-bordered table-hover border border-3">
                    <thead>
                        <tr>
                            <th rowspan="2" class="text-center align-middle">No</th>
                            <th rowspan="2" class="text-center align-middle">NIK / Nama</th>
                            <th rowspan="2" class="text-center align-middle">Periode</th>
                            <th colspan="6" class="text-center bg-light-primary">DATA ABSENSI</th>
                            <th rowspan="2" class="text-center align-middle">Aksi</th>
                            <tr class="text-center">
                                <th>Hadir</th>
                                <th>Izin</th>
                                <th>Sakit</th>
                                <th data-bs-toggle="tooltip" title="Tanpa Keterangan">TK</th>
                                <th data-bs-toggle="tooltip" title="Cuti">CUTI</th>
                                <th data-bs-toggle="tooltip" title="Tugas Dinas">TUDIN</th>
                            </tr>
                        </tr>
                    </thead>
                </table>
        </div>
    </div>
<?= $this->endSection(); ?>

<!-- Ex: script -->
<?= $this->section('script'); ?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="<?= base_url("template/vertical/plugins/parsley/parsley.min.js") ?>"></script>
<script src="<?= base_url("template/vertical/plugins/parsley/i18n/id.js") ?>"></script>
<script src="<?= base_url("template/vertical/plugins/parsley/default.js") ?>"></script>
<script src="<?= base_url("template/vertical/plugins/datatable/js/datatables.min.js") ?>" type="text/javascript"></script>
<script src="<?= base_url("assets/js/rupiah_helper.js"); ?>"></script>
<?= $this->endSection(); ?>

<!-- Ex: css -->
<?= $this->section('style'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<link rel="stylesheet" href="<?= base_url("template/vertical/plugins/datatable/css/datatables.min.css") ?>"/>
<?= $this->endSection(); ?>

<!-- Ex: Modal -->
<?= $this->section('modal'); ?>
<!-- Modal Add Import Absensi -->
<div class="modal fade" id="add-absensi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <?= form_open(base_url('pembayaran/absensi'), ['class' => 'modal-content needs-validation', 'data-parsley-validate' => '', 'id' => 'FormAdd', 'novalidate' => '', 'autocomplete' => 'off'], ['nik' => '']); ?>
            <div class="modal-header">
                <h5 class="modal-title">Import Absensi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex flex-column justify-content-start align-items-start gap-3">
                <div class="col-12">
                <div class="alert alert-info" role="alert">
                    Periode import saat ini <b><?= strtoupper(bulan($now->getMonth())); ?> <?= $now->getYear(); ?></b>
                </div>
                </div>
                <div class="col-12">
                    <label for="pegawai" class="form-label fw-bold">Cari Pegawai <span class="text-danger">*</span></label>
                    <select class="form-select" name="pegawai" id="pegawai" data-placeholder="Cari Pegawai" 
                    data-allow-clear="true"
                    data-parsley-errors-container="#error-pegawai" 
                    data-parsley-error-message="Tidak Boleh Kosong"
                    required></select>
                    <div id="error-pegawai"></div>
                </div>
                <div class="col-12 d-none" id="preview"></div>
                <div class="row">
                    <div class="col-4">
                        <label class="form-label" for="hadir">
                            Hadir <span class="text-danger">*</span>
                        </label>
                        <input type="number" id="hadir" class="form-control" min="0" value="0" name="hadir" required>
                    </div>
                    <div class="col-4">
                        <label class="form-label" for="izin">
                            Izin <span class="text-danger">*</span>
                        </label>
                        <input type="number" id="izin" class="form-control" min="0" value="0" name="izin" required>
                    </div>
                    <div class="col-4">
                        <label class="form-label" for="sakit">
                            Sakit <span class="text-danger">*</span>
                        </label>
                        <input type="number" id="sakit" class="form-control" min="0" value="0" name="sakit" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <label class="form-label" for="tk">
                            Tanpa Keterangan <span class="text-danger">*</span>
                        </label>
                        <input type="number" id="tk" class="form-control" min="0" value="0" name="tk" required>
                    </div>
                    <div class="col-4">
                        <label class="form-label" for="cuti">
                            Cuti <span class="text-danger">*</span>
                        </label>
                        <input type="number" id="cuti" class="form-control" min="0" value="0" name="cuti" required>
                    </div>
                    <div class="col-4">
                        <label class="form-label" for="tudin">
                            Tugas Dinas <span class="text-danger">*</span>
                        </label>
                        <input type="number" id="tudin" class="form-control" min="0" value="0" name="tudin" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary"><i class="bx bx-save"></i> Simpan Data</button>
            </div>
        <?= form_close(); ?>
    </div>
</div>

<!-- Modal Perbaikan Absensi -->
<div class="modal fade" id="edit-absensi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <?= form_open(base_url('pembayaran/absensi'), ['class' => 'modal-content needs-validation', 'data-parsley-validate' => '', 'id' => 'FormEdit', 'novalidate' => '', 'autocomplete' => 'off'], ['nik' => '','id' => '']); ?>
            <div class="modal-header">
                <h5 class="modal-title">Perbaikan Absensi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex flex-column justify-content-start align-items-start gap-3">
                <div class="col-12 d-none" id="preview"></div>
                <div class="row">
                    <div class="col-4">
                        <label class="form-label" for="hadir">
                            Hadir <span class="text-danger">*</span>
                        </label>
                        <input type="number" id="hadir" class="form-control" min="0" value="0" name="hadir" required>
                    </div>
                    <div class="col-4">
                        <label class="form-label" for="izin">
                            Izin <span class="text-danger">*</span>
                        </label>
                        <input type="number" id="izin" class="form-control" min="0" value="0" name="izin" required>
                    </div>
                    <div class="col-4">
                        <label class="form-label" for="sakit">
                            Sakit <span class="text-danger">*</span>
                        </label>
                        <input type="number" id="sakit" class="form-control" min="0" value="0" name="sakit" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <label class="form-label" for="tk">
                            Tanpa Keterangan <span class="text-danger">*</span>
                        </label>
                        <input type="number" id="tk" class="form-control" min="0" value="0" name="tk" required>
                    </div>
                    <div class="col-4">
                        <label class="form-label" for="cuti">
                            Cuti <span class="text-danger">*</span>
                        </label>
                        <input type="number" id="cuti" class="form-control" min="0" value="0" name="cuti" required>
                    </div>
                    <div class="col-4">
                        <label class="form-label" for="tudin">
                            Tugas Dinas <span class="text-danger">*</span>
                        </label>
                        <input type="number" id="tudin" class="form-control" min="0" value="0" name="tudin" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary"><i class="bx bx-save"></i> Simpan Data</button>
            </div>
        <?= form_close(); ?>
    </div>
</div>

<!-- Modal Cetak Absensi -->
<div class="modal fade" id="cetak-absensi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <?= form_open(base_url('cetak/absensi'), ['class' => 'modal-content needs-validation', 'target' => '_blank', 'data-parsley-validate' => '', 'id' => 'FormCetak', 'novalidate' => '', 'autocomplete' => 'off']); ?>
            <div class="modal-header">
                <h5 class="modal-title">Pilih Unit & Periode</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex flex-column justify-content-start align-items-start gap-3">
                <div class="col-12">
                    <label for="unit" class="form-label">Pilih Desa / Unit Kerja <span class="text-danger">*</span></label>
                    <select class="form-select" name="unit" id="unit" data-placeholder="Pilih Unit Kerja" 
                    data-parsley-errors-container="#errroUnit"
                    data-parsley-error-message="Tidak Boleh Kosong"
                    required></select>
                    <div id="errroUnit"></div>
                </div>
                <div class="col-12">
                    <div class="list-group">
                        <?php foreach (listBulan() as $key => $value): 
                            $check = $now->getMonth() == $key ? "checked" : "";    
                        ?>
                        <label class="list-group-item">
                            <input class="form-check-input me-1" type="radio" name="bulan" value="<?= $key; ?>" <?= $check; ?>>
                            <?= $value; ?>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary"><i class="bx bx-printer"></i> Cetak Rekap</button>
            </div>
        <?= form_close(); ?>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    $(function() {
        const FORM = $("form#FormAdd");
        const FORM_EDIT = $("form#FormEdit");
        const MODAL_ADD = new bootstrap.Modal("#add-absensi", {
            keyboard: false,
            backdrop: 'static'
        });
        const MODAL_EDIT = new bootstrap.Modal("#edit-absensi", {
            keyboard: false,
            backdrop: 'static'
        });

        const MODAL_CETAK = new bootstrap.Modal("#cetak-absensi", {
            keyboard: false,
            backdrop: 'static'
        });

        FORM.on("submit", function(e) {
            e.preventDefault();
            let _ = $(this);
            _.parsley({
                trigger: 'change'
            }).validate();
            if(_.parsley().isValid()) {
                $url = _.attr('action'),
                $method = _.attr('method'),
                $data = _.serializeArray();
                _.find("button[type='submit']").html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`).prop("disabled", true);
                $.post($url, $data, function(res) {
                    if(res.status === true) {
                        iziToast.success({
                            message: res.message,
                            position: 'topCenter',
                        });
                        datatable.ajax.reload();
                        MODAL_ADD.hide();
                        _.find("button[type='submit']").html(`<i class="bx bx-save"></i> Simpan Data`).prop("disabled", false);
                        return false;
                    }
                    iziToast.warning({
                        message: res.message,
                        position: 'topCenter',
                    });
                    _.find("button[type='submit']").html(`<i class="bx bx-save"></i> Simpan Data`).prop("disabled", false);
                }, 'json').fail((err) => {
                    iziToast.error({
                        message: err.responseJSON.message || err.statusText,
                        position: 'topCenter',
                    });
                    _.find("button[type='submit']").html(`<i class="bx bx-save"></i> Simpan Data`).prop("disabled", false);
                });
            }
        })

        // Form Perbaiki absen
        FORM_EDIT.on("submit", function(e) {
            e.preventDefault();
            let _ = $(this),
            url = _.attr("action"),
            method = _.attr("method"),
            data = _.serializeArray().concat({name: "_method", value: "PUT"});
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
                                message: response.message,
                                position: 'topCenter',
                            });
                            datatable.ajax.reload();
                            MODAL_EDIT.hide()
                            _.find("button[type='submit']").html(`<i class="bx bx-save"></i> Simpan`).prop("disabled", false);
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

        $("#add-absensi,#edit-absensi").on('hidden.bs.modal', (event) => {
            FORM[0].reset();
            FORM.find('select[name="pegawai"]').val('').trigger('change');
            FORM.parsley().reset();
            FORM.find("div#preview").addClass("d-none");
        })

        $.fn.dataTable.ext.buttons.reload = {
            text: '<i class="bx bx-refresh"></i> Refresh',
            action: function ( e, dt, node, config ) {
                dt.ajax.reload();
            },
            className: 'btn btn-secondary',
        };

        $.fn.dataTable.ext.buttons.print = {
            text: '<i class="bx bx-printer"></i> Cetak',
            action: function ( e, dt, node, config ) {
                MODAL_CETAK.show()
            },
            className: 'btn btn-success',
        };

        $.fn.dataTable.ext.buttons.add = {
            text: '<i class="bx bx-plus"></i> Tambah',
            action: function ( e, dt, node, config ) {  
                MODAL_ADD.show();
            },
            className: 'btn btn-primary'
        };
        
        // table absensi
        let datatable = $('table#example').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            lengthChange: false,
            paging: false,
            info: false,
            responsive: true,
            order: [], //this mean no init order on datatable
            layout: {
                topStart: [{
                    buttons: ['add']
                }],
                topEnd: [{
                    buttons: ['reload','print']
                }],
            },
            ajax: {
                url: '<?= base_url('datatable/tunjangan/absensi') ?>',
                method: 'POST',
                data: {
                    ['<?= csrf_token() ?>']: '<?= csrf_hash() ?>',
                    id: <?= session()->id_unit_kerja ? session()->id_unit_kerja : 0; ?>,
                },
            },
            columns: [
                {data: 'no', width: '5%', orderable: false, searchabel: false, className: 'text-center'},
                {data: 'nik', width: '15%'},
                {data: 'bulan', width: '15%'},
                {data: 'hadir', width: '10%', orderable: false, searchabel: false, className: 'text-center'},
                {data: 'izin', width: '10%', orderable: false, searchabel: false, className: 'text-center'},
                {data: 'sakit', width: '10%', orderable: false, searchabel: false, className: 'text-center'},
                {data: 'tk', width: '10%', orderable: false, searchabel: false, className: 'text-center'},
                {data: 'cuti', width: '10%', orderable: false, searchabel: false, className: 'text-center'},
                {data: 'tudin', width: '10%', orderable: false, searchabel: false, className: 'text-center'},
                {data: 'action', width: '10%', orderable: false, searchabel: false, className: 'text-center'}
            ]
        });

        // hapus absensi
        datatable.on("click", "button#hapus", function(res) {
            let _ = $(this),
            id = _.data("uid");
            $.confirm({
                title: 'Hapus ?',
                content: 'Apakah anda yakin akan menghapus absensi tersebut.',
                type: 'orange',
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
                                `${origin}/pembayaran/absensi`,
                                { id, [csrfName]: csrfHash, '_method': 'DELETE' },
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
        });

        // perbaiki absensi
        datatable.on("click", "button#edit", function() {
            let _ = $(this),
            id = _.data('uid'),
            row = _.data('detail');
            MODAL_EDIT.show();
            let preview = FORM_EDIT.find("div#preview").removeClass("d-none");
            preview.html(`
            <p class="border border-primary p-3 rounded d-flex flex-row justify-content-start align-items-start gap-4">
                <span>NIK <br> <b>${row?.nik ?? "-"}</b></span>
                <span>NAMA <br> <b>${row?.nama ?? "-"}</b></span>
            </p>
            `)

            FORM_EDIT.find("input[name='id']").val(id)
            FORM_EDIT.find("input[name='nik']").val(row.nik)
            FORM_EDIT.find("input[name='hadir']").val(row.hadir)
            FORM_EDIT.find("input[name='izin']").val(row.izin)
            FORM_EDIT.find("input[name='sakit']").val(row.sakit)
            FORM_EDIT.find("input[name='tk']").val(row.tk)
            FORM_EDIT.find("input[name='cuti']").val(row.cuti)
            FORM_EDIT.find("input[name='tudin']").val(row.tudin)
        })  

        // Cari Pegawai
        const select2 = $( 'select#pegawai' ).select2({
            theme: "bootstrap-5",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: $( this ).data( 'placeholder' ),
            dropdownParent: $("#add-absensi"),
            maximumInputLength: 20,
            // minimumResultsForSearch: 10,
            ajax: { 
                url: "<?= base_url('select2/pegawai')?>",
                type: "POST",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    // CSRF Hash
                    var csrfName = '<?= csrf_token() ?>'; // CSRF Token name
                    var csrfHash = '<?= csrf_hash() ?>'; // CSRF hash

                    return {
                        searchTerm: params.term || "", // search term
                        page: params.page || 1,
                        [csrfName]: csrfHash // CSRF Token
                    };
                },
                processResults: function (response) {
                    return {
                        results: response.data
                    };
                },
                cache: true
            }
        });

        // Preview Pegawai
        select2.on("change", function(el) {
            let nik = el.target.value;
            let preview = $("#add-absensi").find("div#preview").removeClass("d-none");
            FORM.find("input[name='nik']").val(nik);
            preview.html('');
            if(nik !== '') {
                preview.html('Loading ...');
                $.getJSON(`${origin}/select2/pegawai`, { nik }, function(res) {
                    const { photo, nama, nama_unit_kerja, nama_jabatan } = res.data;
                    preview.html(`
                        <div class="d-flex flex-row justify-content-start align-items-start gap-3">
                            <img src="${photo}" class="user-img rounded" alt="${nama}">
                            <div class="d-inline-flex flex-column justify-content-start align-items-start">
                                <span class="fw-bold">${nama}</span>
                                <span>${nama_unit_kerja}</span>
                                <span class="text-info">${nama_jabatan ?? "-"}</span>
                            </div>
                        </div>  
                    `)
                }).fail((err) => {
                    preview.addClass('text-danger').html( err.responseJSON.message || err.statusText )
                })
                return false;
            }
        });

        // Cetak by unit kerja
        $( 'select#unit' ).select2( {
            theme: "bootstrap-5",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: $( this ).data( 'placeholder' ),
            minimumResultsForSearch: 15,
            dropdownParent: $("#cetak-absensi"),
            allowClear: true,
            ajax: { 
            url: "<?= base_url('select2/unit_kerja')?>",
                type: "POST",
                dataType: 'json',
                delay: 350,
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
        let SELECTED_UNOR = new Option('<?= @session()->nama_unit_kerja ?>', '<?= @session()->id_unit_kerja ?>', false, false);
        $( 'select[name="unit"]' ).append(SELECTED_UNOR).trigger('change');
    }); 
</script>
<?= $this->endSection(); ?>