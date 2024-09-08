<?= $this->extend('backend/layouts/app'); ?>

<?= $this->section('content'); ?>
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Referensi</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('/') ?>"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Satuan Unit Kerja</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Unit Kerja</th>
                            <th>Kecamatan</th>
                            <th>Status Aktif</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
<?= $this->endSection(); ?>

<?= $this->section('modal'); ?>
<!-- Modal -->
<div class="modal fade" id="exampleScrollableModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <?= form_open(base_url('app/referensi/satuan_unit_kerja'), ['class' => 'modal-content needs-validation', 'id' => 'FormTambah', 'novalidate' => '', 'autocomplete' => 'off']); ?>
            <div class="modal-header">
                <h5 class="modal-title">Tambah Referensi Unit Kerja</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex flex-column justify-content-start align-items-start gap-3">
                <div class="col-12">
                    <label for="nama_unit_kerja" class="form-label fw-bold">Nama Unit Kerja <span class="text-danger">*</span></label>
                    <div class="position-relative input-icon">
                        <input type="text" name="nama_unit_kerja" class="form-control" id="nama_unit_kerja" placeholder="Nama Unit Kerja" required>
                        <span class="position-absolute top-0 pt-2"><i class="bx bx-building"></i></span>
                    </div>
                </div>
                <div class="col-12">
                    <label for="alamat" class="form-label fw-bold">Alamat <span class="text-danger">*</span></label>
                    <div class="position-relative input-icon">
                        <textarea name="alamat" rows="4" class="form-control" id="alamat" placeholder="Masukan Alamat" autocomplete="off" 
                        data-parsley-maxlength="255"
                        maxlength="255"
                        required></textarea>
                        <span class="position-absolute top-0 pt-2"><i class="bx bx-home"></i></span>
                    </div>
                </div>
                <div class="col-12">
                    <label for="kecamatan" class="form-label">Pilih Kecamatan <span class="text-danger">*</span></label>
                    <select class="form-select" name="kecamatan" id="kecamatan" data-placeholder="Pilih Kecamatan" 
                    data-parsley-errors-container="#errorKecamatan" 
                    data-parsley-error-message="Pilih Kecamatan"
                    required></select>
                    <div id="errorKecamatan"></div>
                </div>
                <div class="col-12">
                    <label for="aktif" class="form-label fw-bold">Status Unit Kerja Aktif <span class="text-danger">*</span></label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="aktif" id="aktif" value="Y"
                            data-parsley-errors-container="#errorStatusUnitKerja" 
                            data-parsley-error-message="Pilih status unit kerja"
                            required>
                            <label class="form-check-label" for="aktif">Aktif</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="aktif" id="noaktif" value="N" 
                            data-parsley-errors-container="#errorStatusUnitKerja" 
                            data-parsley-error-message="Pilih status unit kerja"
                            required>
                            <label class="form-check-label" for="noaktif">Tidak</label>
                        </div>
                    </div>
                    <div id="errorStatusUnitKerja"></div>
                </div>
                <div class="col-12">
                    <label for="nohp" class="form-label fw-bold">Nomor Hp/Telphone <span class="text-danger">*</span></label>
                    <div class="position-relative input-icon">
                        <span class="position-absolute  top-0 pt-2"><i class="bx bx-phone"></i></span>
                        <input type="number" name="nohp" class="form-control" id="nohp" placeholder="Nomor Hp/Telphone" required>
                    </div>
                </div>
                <hr class="w-100"/>
                <div class="col-12">
                    <label for="terpencil" class="form-label fw-bold">Apakah unit kerja ini termasuk tempat terpencil ? <span class="text-danger">*</span></label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="terpencil" id="terpencil" value="YA"
                            data-parsley-errors-container="#errorTerpencil" 
                            data-parsley-error-message="Pilih status terpencil"
                            required
                            />
                            <label class="form-check-label" for="terpencil">Ya</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="terpencil" id="noterpencil" value="TIDAK"
                            data-parsley-errors-container="#errorTerpencil" 
                            data-parsley-error-message="Pilih status terpencil"
                            required
                            />
                            <label class="form-check-label" for="noterpencil">Tidak</label>
                        </div>
                    </div>
                    <div id="errorTerpencil"></div>
                </div>
                <div class="col-12">
                    <label for="map" class="form-label fw-bold">Link Google Maps <span class="text-danger">*</span></label>
                    <div class="position-relative input-icon">
                        <textarea name="map" rows="4" class="form-control" id="map" placeholder="Masukan Link Google Maps" required></textarea>
                        <span class="position-absolute top-0 pt-2"><i class="bx bx-map"></i></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="lat" class="form-label fw-bold">Lat</label>
                        <input type="text" name="lat" class="form-control" id="lat" placeholder="Latitude" readonly required>
                    </div>
                    <div class="col-6">
                        <label for="long" class="form-label fw-bold">Long</label>
                        <input type="text" name="long" class="form-control" id="long" placeholder="Longitude" readonly required>
                    </div>
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
<script src="<?= base_url("template/vertical/plugins/parsley/bootstrap-maxlength.min.js") ?>"></script>
<script type="text/javascript">
    var ModalTambah = '#exampleScrollableModal';
    var FormTambah = 'form#FormTambah';

    const modal = new bootstrap.Modal(ModalTambah, {
                keyboard: false,
                backdrop: 'static'
            });
            
    var FormValidate = $(FormTambah).parsley();


    $(FormTambah).on("submit", function(event) {
        event.preventDefault();
        let _ = $(this),
        $url = _.attr('action'),
        $method = _.attr('method'),
        $data = _.serialize();
        _.find("button[type='submit']").html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`);
        $.post(`${$url}`, $data, 'json').then((res) => {
            if (res.statusCode === 201) {
                iziToast.success({
                    message: res.message,
                    position: 'topCenter'
                });
                modal.hide()
                datatable.ajax.reload();
                _.find("button[type='submit']").html(`<i class="bx bx-save"></i> Simpan`)
                return false;
            } 
            iziToast.warning({
                message: res.message,
                position: 'topCenter'
            });
        }).fail((err) => {
            iziToast.error({
                message: err.statusText,
                position: 'topCenter'
            });
        })
    });

    // input maxlength / minlength
    $("[maxlength], [minlength]").maxlength({
		alwaysShow: true,
		threshold: 30,
		warningClass: "badge bg-success rounded-sm mt-2",
		limitReachedClass: "badge bg-danger rounded-sm mt-2",
		placement: "bottom-right-inside",
		// preText: '<i class="bi bi-arrow-up-right-circle-fill text-white me-1"></i>',
		postText: '<i class="bx bx-check-shield text-white ms-1"></i>',
	});

    // input lat, long
    $(FormTambah).find("textarea[name='map']").on("change", (event) => {
        let _ = $("textarea[name='map']");
        if(_.val() !== "") {
            var regex = new RegExp('@(.*),(.*),');
            var lat_long_match = _.val().match(regex);
            $(this).find("input[name='lat']").val(lat_long_match[1]);
            $(this).find("input[name='long']").val(lat_long_match[2]);
        }
    })

    $(ModalTambah).on('hidden.bs.modal', (event) => {
       $(FormTambah)[0].reset();
       $(FormTambah).find('select[name="kecamatan"]').val('').trigger('change');
       FormValidate.reset()
    })

    $( 'select#kecamatan' ).select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        dropdownParent: $(ModalTambah),
        ajax: { 
          url: "<?= base_url('select2/kecamatan')?>",
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

    $.fn.dataTable.ext.buttons.reload = {
        text: '<i class="bx bx-refresh"></i> Reload',
        action: function ( e, dt, node, config ) {
            dt.ajax.reload();
        },
        className: 'btn btn-info',
        
    };

    $.fn.dataTable.ext.buttons.add = {
        text: '<i class="bx bx-plus"></i> Tambah',
        action: function ( e, dt, node, config ) {
            modal.show()
        },
        className: 'btn btn-primary'
    };

    var datatable = $('table#example').DataTable({
        processing: true,
        serverSide: true,
        order: [[1, 'asc']], //this mean no init order on datatable
        layout: {
            topStart: [{
                buttons: ['add', {
                    text: '<i class="bx bx-export"></i> Export',
                    'split': ['print', 'csv']
                }]
            }],
            topEnd: [{
                search: {
                    placeholder: 'Masukan keyword ..',
                    type: 'search',
                    boundary: true
                }
            }, {
                buttons: [
                    'colvis',
                    'spacer',
                    'reload',
                ]
            }],
            bottomStart: ['info','pageLength']
        },
        buttons: [
            { extend: 'colvis', name: 'colvis', text: `<i class="bx bx-list-check"></i> Columns `}
        ],
        ajax: {
            url: '<?= base_url('datatable/satuan_unit_kerja') ?>',
            method: 'POST',
            data: {
                csrf_token_simpedes: '<?= csrf_hash() ?>'
            },
        },
        columns: [
            {data: 'id_unit_kerja'},
            {data: 'nama_unit_kerja'},
            {data: 'nama_kecamatan', orderable: false, searchable: false},
            {data: 'aktif', orderable: false, searchable: false},
            {data: 'action', orderable: false, searchable: false},
        ],
        columnDefs: [
            {target: 0, orderable: false}
        ]
    });
</script>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
function FlagFn(id, isAktif) {
    let flagIs = isAktif === 'Y' ? 'N' : 'Y';
    // CSRF Hash
    let csrfName = '<?= csrf_token() ?>'; // CSRF Token name
    let csrfHash = '<?= csrf_hash() ?>'; // CSRF hash
    $.post(
        `${origin}/app/referensi/satuan_unit_kerja`,
        { id, flag: flagIs, [csrfName]: csrfHash, '_method': 'PUT' },
        function (res) {
            if (res.status === true) {
                iziToast.success({
                    position: 'topCenter',
                    message: res.message,
                });
                datatable.ajax.reload();
                return false;
            }
            iziToast.error({
                position: 'topCenter',
                message: res.message,
            });
        },
        "json"
    ).fail((err) => {
        iziToast.error({
            message: err.statusText,
            position: 'topCenter'
        });
    });
}
function HapusFn(id) {
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
						`${origin}/app/referensi/satuan_unit_kerja`,
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
                            message: err.statusText,
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
}
</script>
<?= $this->endSection(); ?>
<?= $this->section('style'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<link rel="stylesheet" href="<?= base_url("template/vertical/plugins/datatable/css/datatables.min.css") ?>"/>
<?= $this->endSection(); ?>