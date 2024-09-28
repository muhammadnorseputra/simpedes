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
                <li class="breadcrumb-item active" aria-current="page">LHKPN</li>
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
                    <th>Tahun Wajib Lapor</th>
                    <th>Jabatan Wajib Lapor</th>
                    <th>Pada Unit Kerja</th>
                    <th>File Tambahan Berita Negara (TBN)</th>
                    <th>Aksi</th>
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

<?= $this->section('modal'); ?>
<!-- Offcanvas  Left-->
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasLeft" data-bs-focus="false" aria-labelledby="offcanvasLeftLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="offcanvasLeftLabel">Tambah Riwayat LHKPN</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <?= form_open(base_url('app/pegawai/'.dohash($nik).'/lhkpn/add'), ["id" => "FormAdd", "data-parsley-validate" => "", "class" => "needs-validation", "novalidate" => ""]) ?>
        <div class="row g-3 px-0">
            <div class="col-12 d-flex flex-column gap-1">
                <span>Nama Wajib Lapor</span>
                <span class="fw-bold"><?= namalengkap($row->gelar_depan,$row->nama,$row->gelar_blk) ?></span>
            </div>
            <div class="col-12">
                <label for="jenis_form" class="form-label">Jenis Form <span class="text-danger">*</span></label>
                <select class="form-select" name="jenis_form" id="jenis_form" required>
                    <option select value="">-- Pilih Jenis Form --</option>
                    <option value="A">Pertama (A)</option>
                    <option value="B">Lanjutan (B)</option>
                </select>
            </div>
            <div class="col-12">
                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                <select class="form-select" name="status" id="status" required>
                    <option select value="">-- Pilih Status Usulan --</option>
                    <option value="BARU">BARU</option>
                    <option value="PERBAIKAN">PERBAIKAN</option>
                </select>
            </div>
            <div class="col-12">
                <label  class="form-label" for="jabatan">Jabatan <span class="text-danger">*</span></label>
                <input type="text" name="jabatan" class="form-control" id="jabatan" placeholder="Nama Jabatan" required/>
            </div>
            <div class="col-12">
                <label class="form-label" for="unit_kerja">Unit Kerja <span class="text-danger">*</span></label>
                <input type="text" name="unit_kerja" class="form-control" id="unit_kerja" placeholder="Nama Unit Kerja" required/>
            </div>
            <div class="col-6">
                <label class="form-label" for="tgl_penyampaian">Tgl. Penyampaian <span class="text-danger">*</span></label>
                <input type="date" name="tgl_penyampaian" value="<?= date('Y-m-d'); ?>" class="form-control" id="tgl_penyampaian" required/>
            </div>
            <div class="col-6">
                <label class="form-label" for="tgl_lapor">Tgl. Lapor <span class="text-danger">*</span></label>
                <input type="date" name="tgl_lapor" class="form-control" id="tgl_lapor" required/>
            </div>
            <div class="col-6">
                <label class="form-label" for="tahun_wajib">Tahun Wajib <span class="text-danger">*</span></label>
                <input type="number" maxlength="4" minlength="4" name="tahun_wajib" class="form-control" id="tahun_wajib" placeholder="Tahun" required/>
            </div>
        </div>
        <hr>
        <div class="row g-3 px-0">
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
                    Upload Berkas TBN
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= form_open(base_url('app/pegawai/'.dohash($nik).'/lhkpn/upload'), 
            ["id" => "FormUpload", "data-parsley-validate" => "", "class" => "needs-validation", "novalidate" => ""],
            ["id" => "", "nik" => "", "tahun" => ""]) ?>
                <div class="ratio ratio-16x9">
                    <embed id="preview" src="https://comportcomputers.com/wp-content/uploads/2020/07/apa-itu-file-pdf.png" style="width:100%; height: 100%;" type="application/pdf" allowfullscreen>
                </div>
                <div class="input-group mt-3">
                    <input type="file" 
                    name="berkas" 
                    oninput="preview.src=window.URL.createObjectURL(this.files[0]) + '#toolbar=0&navpanes=0&scrollbar=0&page=1&zoom=FitH'"
                    accept=".pdf" 
                    data-parsley-errors-container="#errorUpload" 
                    class="form-control" 
                    id="inputGroupFile04" 
                    aria-describedby="inputGroupFileAddon04" aria-label="Upload" 
                    data-parsley-max-file-size="1024"
                    data-parsley-max-file-size-message="File ini tidak boleh lebih besar dari 1 MB"
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
<script>
    $(document).ready(function() {
        const FORM = $("form#FormAdd");
        const FORM_UPLOAD = $("form#FormUpload");
        
        const MODAL_UPLOAD = new bootstrap.Modal("#upload-berkas");
        const CANVAS_ADD = new bootstrap.Offcanvas("#offcanvasLeft", {
            backdrop: 'static',
            keyboard: false,
            scroll: false,
        });

        $("#offcanvasLeft").on('hidden.bs.offcanvas', event => {
            FORM.parsley().reset();
            FORM[0].reset();
            FORM.find("button[type='submit']").html(`<i class="bx bx-save"></i> Simpan`).prop("disabled", false);
        });

        // Form Tambah
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
                url: '<?= base_url('datatable/riwayat/lhkpn') ?>',
                method: 'POST',
                data: {
                    ['<?= csrf_token() ?>']: '<?= csrf_hash() ?>',
                    nik: '<?= $row->nik ?>'
                },
            },
            columns: [
                {data: 'no', orderable: false, searchabel: false, className: 'text-center align-middle'},
                {data: 'tahun_wajib', width: '20%', className: 'align-middle'},
                {data: 'jabatan', className: 'align-middle'},
                {data: 'unit_kerja', orderable: false, searchabel: false, className: 'align-middle'},
                {data: 'file_tbn', width: '15%', orderable: false, searchabel: false, className: 'align-middle'},
                {data: 'action', orderable: false, searchabel: false, className: 'text-center'},
            ]
        });

        datatable.on("click", "button#upload-berkas", function() {
            let _ = $(this),
            id = _.data('uid'),
            nik = _.data('nik'),
            tahun = _.data('tahun');
            MODAL_UPLOAD.show();
            FORM_UPLOAD.find("input[name='id']").val(id)
            FORM_UPLOAD.find("input[name='nik']").val(nik)
            FORM_UPLOAD.find("input[name='tahun']").val(tahun)
        })

        datatable.on("click", "button#hapus", function() {
            let _ = $(this),
            id = _.data('uid'),
            nik = _.data('nik'),
            file = _.data('file');
            $.confirm({
                title: 'Peringatan !',
                content: `Apakah anda yakin akan menghapus riwayat laporan LHKPN <span class="badge bg-light-danger text-danger">${file}</span> tersebut ?`,
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
                                `<?= base_url('app/pegawai/'.dohash($nik).'/lhkpn/delete') ?>`,
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
            window.location.href = `${origin}/app/pegawai/${id}/lhkpn/edit`;
        })
    })
</script>
<?= $this->endSection(); ?>