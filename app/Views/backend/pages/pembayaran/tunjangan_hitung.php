<?= $this->extend('backend/layouts/app'); ?>

<?= $this->section('content'); ?>
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Hitung</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('/') ?>"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Tunjangan</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="card">
        <div class="card-body">
            <?php 
            $current_date = $now->now()->addHours(1);
            // Mendapatkan tanggal 15 bulan ini pukul 24:00 (sebenarnya tanggal 16 pukul 00:00)
            $start_date = $now->createFromDate($current_date->getYear(), $current_date->getMonth(), 16);
            // Mendapatkan tanggal 15 bulan depan
            $end_date = $start_date->addMonths(1);
            if ($current_date >= $start_date && $current_date < $end_date):
            ?>
            <div class="alert alert-warning" role="alert">
                <b>Perhatian !</b> 
                Perhitungan setelah 3 Hari sejak ditambahkan, akan dikunci oleh sistem atau tidak bisa dibatalkan.
            </div>
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered table-hover border border-3">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Bulan</th>      
                            <th>Desa</th>
                            <th>NIK</th>
                            <th>Nama Lengkap</th>
                            <th>Jabatan</th>
                            <th>Jumlah Bulan</th>
                            <th>Jumlah Uang</th>
                            <th>PPH21</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <?php else: ?>
            <div class="alert alert-danger" role="alert">
                <b>Perhatian !</b> <br>
                Perhitungan hanya dapat dilakukan pada <b><?= $start_date->getDay(); ?> <?= bulan($start_date->getMonth()); ?> <?= $start_date->getYear(); ?></b>.
            </div>
            <p class="text-center text-secondary opacity-50">
                <span><i class="bx bx-timer bx-lg"></i></span>
                <p class="text-center text-secondary opacity-50">
                    Periode <b class="text-danger"><?= strtoupper(bulan($current_date->getMonth())); ?></b> Belum Dibuka.
                </p>
            </p>
            <?php endif; ?>
        </div>
    </div>
<?= $this->endSection(); ?>
<?= $this->section('modal'); ?>
<!-- Modal Add Perhitungan Tunjangan-->
<div class="modal fade" id="add-tunjangan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <?= form_open(base_url('pembayaran/hitung'), ['class' => 'modal-content needs-validation', 'id' => 'FormAdd', 'novalidate' => '', 'autocomplete' => 'off'], ['nik' => '']); ?>
            <div class="modal-header">
                <h5 class="modal-title">Tambah Perhitungan Tunjangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex flex-column justify-content-start align-items-start gap-3">
                <div class="col-12">
                    <label for="pegawai" class="form-label fw-bold">Cari Pegawai <span class="text-danger">*</span></label>
                    <select class="form-select" name="pegawai" id="pegawai" multiple="multiple" data-placeholder="Cari Pegawai" 
                    data-allow-clear="true"
                    data-parsley-errors-container="#error-pegawai" 
                    data-parsley-error-message="Tidak Boleh Kosong"
                    required></select>
                    <div id="error-pegawai"></div>
                </div>
                <div class="col-12 d-none" id="preview"></div>
                <div class="col-md-12">
                    <label for="periode_bulan" class="form-label fw-bold">Pilih Periode Bulan <span class="text-danger">*</span></label>
                    <select class="form-select" name="periode_bulan" id="periode_bulan"
                        required>
                        <?php 
                        $current_date = $now->now()->addHours(1);
                        $bulan_ini = $current_date->getMonth();
                        $bulan_lalu = $current_date->addMonths(-1)->getMonth();
                        ?>
                        <option value="<?= $bulan_lalu; ?>"><?= bulan($bulan_lalu); ?></option>
                        <option value="<?= $bulan_ini; ?>" selected><?= bulan($bulan_ini); ?></option>
                    </select>
                </div>
                <div class="col-md-12">
                    <label for="periode_tahun" class="form-label fw-bold">Pilih Periode Tahun <span class="text-danger">*</span></label>
                    <select class="form-select" name="periode_tahun" id="periode_tahun"
                        required>
                        <?php 
                        $current_date = $now->now()->addHours(1);
                        $tahun_lalu = $current_date->addYears(-1)->getYear();
                        $tahun_ini = $current_date->getYear();
                        ?>
                        <option value="<?= $tahun_lalu; ?>"><?= $tahun_lalu; ?></option>
                        <option value="<?= $tahun_ini; ?>" selected><?= $tahun_ini; ?></option>
                    </select>
                </div>
                <div class="col-12">
                    <label for="jml_bulan" class="form-label fw-bold">Jumlah Bulan <span class="text-danger">*</span></label>
                    <select class="form-select" name="jml_bulan" id="jml_bulan"
                        required>
                        <?php for($i=1;$i<=12;$i++): ?>
                            <option value="<?= $i; ?>"><?= $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-6">
                    <label class="form-check-label" for="toIDR">
                        Kena Pajak PPH21
                    </label>
                    <input type="text" id="toIDR" class="form-control" min="0" value="0" name="pph21" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary"><i class="bx bx-save"></i> Simpan Data</button>
            </div>
        <?= form_close(); ?>
    </div>
</div>
<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="<?= base_url("template/vertical/plugins/parsley/parsley.min.js") ?>"></script>
<script src="<?= base_url("template/vertical/plugins/parsley/i18n/id.js") ?>"></script>
<script src="<?= base_url("template/vertical/plugins/parsley/default.js") ?>"></script>
<script src="<?= base_url("template/vertical/plugins/datatable/js/datatables.min.js") ?>" type="text/javascript"></script>
<script src="<?= base_url("assets/js/rupiah_helper.js"); ?>"></script>
<script type="text/javascript">
$(document).ready(function() {
    const FORM = $("form#FormAdd");
    const MODAL_ADD = new bootstrap.Modal("#add-tunjangan", {
        keyboard: false,
        backdrop: 'static'
    });

    $("#add-tunjangan").on('hidden.bs.modal', (event) => {
       FORM[0].reset();
       FORM.find('select[name="pegawai"]').val('').trigger('change');
       FORM.parsley().reset();
    })

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
            MODAL_ADD.show();
        },
        className: 'btn btn-primary'
    };

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
                buttons: ['reload']
            }],
        },
        ajax: {
            url: '<?= base_url('datatable/tunjangan/hitung') ?>',
            method: 'POST',
            data: {
                ['<?= csrf_token() ?>']: '<?= csrf_hash() ?>',
                id: <?= session()->id_unit_kerja ? session()->id_unit_kerja : 0; ?>,
            },
        },
        columns: [
            {data: 'no', orderable: false, searchabel: false, className: 'text-center'},
            {data: 'bulan'},
            {data: 'nama_desa', orderable: false},
            {data: 'nik'},
            {data: 'nama'},
            {data: 'nama_jabatan'},
            {data: 'jumlah_bulan', orderable: false, searchabel: false},
            {data: 'jumlah_uang', orderable: false, searchabel: false},
            {data: 'pph21', orderable: false, searchabel: false},
            {data: 'action', orderable: false, searchabel: false, className: 'text-center'}
        ]
    });

    // Cari Pegawai
    const select2 = $( 'select#pegawai' ).select2({
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        dropdownParent: $("#add-tunjangan"),
        tags: true,
        maximumSelectionLength: 1,
        minimumInputLength: 4,
        maximumInputLength: 20,
        minimumResultsForSearch: 10,
        createTag: function (params) {
            // Don't offset to create a tag if there is no @ symbol
            if (params.term.indexOf('@') === -1) {
            // Return null to disable tag creation
            return null;
            }

            return {
                id: params.term,
                text: params.term
            }
        },
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
                searchTerm: params.term, // search term
                [csrfName]: csrfHash // CSRF Token
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

    select2.on("change", function(el) {
        let nik = el.target.value;
        let preview = $("#add-tunjangan").find("div#preview").removeClass("d-none");
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
                    <hr/>
                `)
            }).fail((err) => {
                preview.addClass('text-danger').html( err.responseJSON.message || err.statusText )
            })
            return false;
        }
    });

    datatable.on("click", "button#hapus", function(res) {
        let _ = $(this),
        id = _.data("uid");
        $.confirm({
            title: 'Hapus ?',
            content: 'Apakah anda yakin akan menghapus perhitungan tersebut ?',
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
                            `${origin}/pembayaran/hitung`,
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
});
</script>
<?= $this->endSection(); ?>

<?= $this->section('style'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<link rel="stylesheet" href="<?= base_url("template/vertical/plugins/datatable/css/datatables.min.css") ?>"/>
<?= $this->endSection(); ?>