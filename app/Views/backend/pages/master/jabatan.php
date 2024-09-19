<?= $this->extend("backend/layouts/app"); ?>

<?= $this->section('content'); ?>
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Master </div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('/') ?>"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Jabatan</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="card">
        <div class="card-body">
                <table id="example" class="table table-striped table-separate table-hover border border-3">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th class="all">Nama Jabatan</th>
                            <th>Atasan</th>
                            <th>Jenis</th>
                            <th>Gajih</th>
                            <th>Tunjangan</th>
                            <th class="all">Aksi</th>
                        </tr>
                        <tr>
                            <th>#</th>
                            <th class="filterhead"></th>
                            <th></th>
                            <th class="filterhead"></th>
                            <th class="filterhead"></th>
                            <th class="filterhead"></th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
        </div>
    </div>
<?= $this->endSection(); ?>

<?= $this->section('modal'); ?>
<!-- Modal -->
<div class="modal fade" id="exampleScrollableModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <?= form_open(base_url('app/master/jabatan'), ['class' => 'modal-content needs-validation', 'id' => 'FormTambah', 'novalidate' => '', 'autocomplete' => 'off']); ?>
            <div class="modal-header">
                <h5 class="modal-title">Tambah Master Jabatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex flex-column justify-content-start align-items-start gap-3">
                <div class="col-12">
                    <label for="nama_jabatan" class="form-label fw-bold">Nama Jabatan <span class="text-danger">*</span></label>
                    <div class="position-relative input-icon">
                        <input type="text" name="nama_jabatan" class="form-control" id="nama_jabatan" placeholder="Nama Jabatan" required>
                        <span class="position-absolute top-0 pt-2"><i class="bx bx-data"></i></span>
                    </div>
                </div>
                <div class="col-12">
                    <label for="atasan" class="form-label">Pilih Atasan <span class="text-danger">*</span></label>
                    <select class="form-select" name="atasan" id="atasan" data-placeholder="Pilih Atasan" 
                    data-allow-clear="true"
                    data-parsley-errors-container="#errorAtasan" 
                    data-parsley-error-message="Pilih Atasan"
                    required></select>
                    <div id="errorAtasan"></div>
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold">Jenis Jabatan <span class="text-danger">*</span></label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenis" id="PEMDES" value="PEMDES"
                            data-parsley-errors-container="#errorJenisJabatan" 
                            data-parsley-error-message="Pilih Jenis Jabatan"
                            required>
                            <label class="form-check-label" for="PEMDES">PEMDES</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenis" id="BPD" value="BPD" 
                            data-parsley-errors-container="#errorJenisJabatan" 
                            data-parsley-error-message="Pilih Jenis Jabatan"
                            required>
                            <label class="form-check-label" for="BPD">BPD</label>
                        </div>
                    </div>
                    <div id="errorJenisJabatan"></div>
                </div>
                <div class="row col-12">
                    <div class="col-6">
                        <label for="gaji" class="form-label fw-bold">Gaji <span class="text-danger">*</span></label>
                        <input type="text" name="gaji" class="form-control" id="gaji" 
                        data-parsley-excluded="." 
                        data-parsley-validation="number" 
                        onkeydown="return numbersonly(this, event);" 
                        onkeyup="javascript:tandaPemisahTitik(this);" 
                        placeholder="Gaji"
                        required>
                    </div>
                    <div class="col-6">
                        <label for="tunjangan" class="form-label fw-bold">Tunjangan <span class="text-danger">*</span></label>
                        <input type="text" name="tunjangan" class="form-control" id="tunjangan" 
                        data-parsley-excluded="." 
                        data-parsley-validation="number" 
                        onkeydown="return numbersonly(this, event);" 
                        onkeyup="javascript:tandaPemisahTitik(this);"   
                        placeholder="Tunjangan" 
                        required>
                    </div>
                </div>
                <div class="col-3">
                    <label for="bup" class="form-label fw-bold">Usia BUP <span class="text-danger">*</span></label>
                    <input type="number" name="bup" class="form-control" id="bup" placeholder="Usia Bup" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary"><i class="bx bx-save"></i> Simpan</button>
            </div>
        <?= form_close(); ?>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="<?= base_url("template/vertical/plugins/datatable/js/datatables.min.js") ?>" type="text/javascript"></script>
<script src="<?= base_url("template/vertical/plugins/parsley/parsley.min.js") ?>"></script>
<script src="<?= base_url("template/vertical/plugins/parsley/i18n/id.js") ?>"></script>
<script src="<?= base_url("template/vertical/plugins/parsley/default.js") ?>"></script>
<script src="<?= base_url("assets/js/rupiah_helper.js") ?>"></script>
<script type="text/javascript">
$(document).ready(function() {
    let ModalTambah = '#exampleScrollableModal';
    let FormTambah = 'form#FormTambah';

    const MODAL = new bootstrap.Modal(ModalTambah, {
        keyboard: false,
        backdrop: 'static'
    });

    $(FormTambah).on("submit", function(e) {
        e.preventDefault()
        let _ = $(this);
        _.parsley({
            trigger: 'change'
        }).validate();

        if(_.parsley().isValid()) {
            $url = _.attr('action'),
            $method = _.attr('method'),
            $data = _.serialize();
            _.find("button[type='submit']").html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`).prop("disabled", true);
            $.post(`${$url}`, $data, 'json').then((res) => {
                if (res.statusCode === 201) {
                    iziToast.success({
                        message: res.message,
                        position: 'topCenter'
                    });
                    MODAL.hide()
                    datatable.ajax.reload();
                    _.find("button[type='submit']").html(`<i class="bx bx-save"></i> Simpan`).prop("disabled", false)
                    return false;
                } 
                iziToast.warning({
                    message: res.message,
                    position: 'topCenter'
                });
                _.find("button[type='submit']").html(`<i class="bx bx-save"></i> Simpan`).prop("disabled", false)
            }).fail((err) => {
                iziToast.error({
                    message: err.responseJSON.message || err.statusText,
                    position: 'topCenter'
                });
                _.find("button[type='submit']").html(`<i class="bx bx-save"></i> Simpan`).prop("disabled", false)
            })
        }
    });

    $(ModalTambah).on('hidden.bs.modal', (event) => {
       $(FormTambah)[0].reset();
       $(FormTambah).find('select[name="atasan"]').val('').trigger('change');
       $(FormTambah).parsley().reset();
    })
    
    $.fn.dataTable.ext.buttons.reload = {
        text: '<i class="bx bx-refresh"></i> Refresh',
        action: function ( e, dt, node, config ) {
            dt.ajax.reload();
        },
        className: 'btn btn-secondary',
        
    };

    $.fn.dataTable.ext.buttons.add = {
        text: '<i class="bx bx-plus"></i> Tambah',
        action: function ( e, dt, node, config ) {
            MODAL.show()
        },
        className: 'btn btn-primary'
    };

    var datatable = $('table#example').DataTable({
        processing: true,
        serverSide: true,
        fixedHeader: {
            headerOffset: 60
        },
        responsive: true,
        order: [], //this mean no init order on datatable
        layout: {
            topStart: [{
                buttons: ['add']
            }],
            topEnd: [{
                buttons: [
                    'colvis',
                    'spacer',
                    {
                        text: '<i class="bx bx-export"></i> Export',
                        'split': ['print', 'csv']
                    },
                    'spacer',
                    'reload',
                ]
            }],
            bottomStart: ['info','pageLength']
        },
        ajax: {
            url: '<?= base_url('datatable/master/jabatan') ?>',
            method: 'POST',
            data: {
                ['<?= csrf_token() ?>']: '<?= csrf_hash() ?>'
            },
        },
        columns: [
            {data: 'no', orderable: false, searchable: false},
            {data: 'nama_jabatan'},
            {data: 'id_atasan', searchable: false},
            {data: 'jenis'},
            {data: 'gaji'}, 
            {data: 'tunjangan'},
            {data: 'action'}
        ],
        columnDefs: [
            {target: 0, className: 'text-center align-middle'},
            {target: [1,2,3,4,5], className: 'align-middle'},
            {target: -1, orderable: false, searchable: false, className: 'align-middle'},
        ],
        orderCellsTop: true,
        initComplete: function( settings, json ) 
        {

            var indexColumn = 0;

            this.api().columns([1,3,4,5]).every(function () 
            {
                
                var column      = this;
                var input       = document.createElement("input");
                
                $(input).attr( 'placeholder', 'Search' )
                        .attr("type", "search")
                        .addClass('form-control form-control-sm')
                        .appendTo( $('.filterhead:eq('+indexColumn+')').empty() )
                        .on('change', function () {
                            column.search($(this).val(), false, false, true).draw();
                        });

                indexColumn++;
            });
        }
    });

    $( 'select#atasan' ).select2({
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        dropdownParent: $(ModalTambah),
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

    datatable.on("click", "button#HapusFn", function(res) {
        let _ = $(this),
        id = _.data("uid");
        $.confirm({
            title: 'Hapus ?',
            content: 'Apakah anda yakin akan menghapus data tersebut ?',
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
                            `${origin}/app/master/jabatan`,
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

    datatable.on("click", "button#EditFn", function(res) {
        let _ = $(this),
        id = _.data("uid");
        window.location.href = `${origin}/app/master/jabatan/edit/${id}`
    })
});
</script>
<?= $this->endSection(); ?>

<?= $this->section('style'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<link rel="stylesheet" href="<?= base_url("template/vertical/plugins/datatable/css/datatables.min.css") ?>"/>
<?= $this->endSection(); ?>