<?= $this->extend('backend/layouts/app'); ?>

<?= $this->section('content'); ?>
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Master</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('/') ?>"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">User Portal</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-separate table-hover border border-3">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>NIPD</th>
                            <th>Photo</th>
                            <th>Nama Lengkap / Role</th>
                            <th>Username</th>
                            <th>Unit Kerja</th>
                            <th>Aksi</th>
                        </tr>
                        <tr>
                            <th class="filterhead"></th>
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
    </div>
<?= $this->endSection(); ?>
<?= $this->section('modal'); ?>
<!-- Modal Reset Password-->
<div class="modal fade" id="reset-password" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <?= form_open(base_url('app/master/users'), ['class' => 'modal-content needs-validation', 'id' => 'FormReset', 'novalidate' => '', 'autocomplete' => 'off'], ['token' => '']); ?>
            <div class="modal-header">
                <h5 class="modal-title">Reset Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex flex-column justify-content-start align-items-start gap-3">
                <div class="col-12">
                    <label for="new_password" class="form-label fw-bold">Password Baru <span class="text-danger">*</span></label>
                    <div class="position-relative input-icon">
                        <input type="text" name="new_password" minlength="8" class="form-control" id="new_password" placeholder="Password Baru"
                        data-parsley-errors-container="#errorspannewpassinput" 
                        data-parsley-uppercase="1"
                        data-parsley-lowercase="1"
                        data-parsley-number="1"
                        data-parsley-special="1"
                        required>
                        <span class="position-absolute top-0 pt-2"><i class="bx bx-key"></i></span>
                    </div>
                    <div id="errorspannewpassinput"></div>
                </div>
                <div class="col-12">
                    <label for="retype_new_password" class="form-label fw-bold">Ulangi Password Baru <span class="text-danger">*</span></label>
                    <div class="position-relative input-icon">
                        <input type="password" name="retype_new_password" minlength="8" class="form-control" id="retype_new_password" placeholder="Ulangi Password Baru"
                        data-parsley-equalto="#new_password"
                        required>
                        <span class="position-absolute top-0 pt-2"><i class="bx bx-key"></i></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary"><i class="bx bx-save"></i> Simpan Perubahan</button>
            </div>
        <?= form_close(); ?>
    </div>
</div>
<!-- Modal Add User-->
<div class="modal fade" id="add-user" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Userportal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <ul class="nav nav-tabs nav-primary" role="tablist">
                <li class="nav-item" role="presentation">
                    <a
                    class="nav-link active"
                    data-bs-toggle="tab"
                    href="#primary"
                    role="tab"
                    aria-selected="true">
                    <div class="d-flex align-items-center">
                        <div class="tab-icon">
                        <i class="bx bx-user-pin font-18 me-1"></i>
                        </div>
                        <div class="tab-title">Pegawai</div>
                    </div>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a
                    class="nav-link"
                    data-bs-toggle="tab"
                    href="#secondary"
                    role="tab"
                    aria-selected="false">
                    <div class="d-flex align-items-center">
                        <div class="tab-icon">
                        <i class="bx bx-user-plus font-18 me-1"></i>
                        </div>
                        <div class="tab-title">Manual</div>
                    </div>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a
                    class="nav-link"
                    data-bs-toggle="tab"
                    href="#info"
                    role="tab"
                    aria-selected="false">
                    <div class="d-flex align-items-center">
                        <div class="tab-icon">
                        <i class="bx bx-user font-18 me-1"></i>
                        </div>
                        <div class="tab-title">Dinas</div>
                    </div>
                    </a>
                </li>
                </ul>
                <div class="tab-content py-3">
                <div
                    class="tab-pane fade show active"
                    id="primary"
                    role="tabpanel">
                    <?= form_open(base_url('app/master/users'), ['class' => 'needs-validation', 'id' => 'FormAddUser', 'novalidate' => '', 'autocomplete' => 'off'], ['token' => '', 'is_manual' => 'TIDAK','fid_unit_kerja' => '']); ?>
                    <div class=" d-flex flex-column justify-content-start align-items-start gap-3">
                        <div class="alert alert-warning mb-0 border-0 w-100">
                            <div class="d-flex align-items-center">
                                <div class="font-24 text-dark"><i class="bx bx-info-circle"></i>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-0 text-dark">Perhatian</h6>
                                    <div class="text-dark">Pastikan NIK atau Pegawai bersatus <strong>AKTIF</strong></div>
                                </div>
                            </div>
                        </div>
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
                        <div class="col-12">
                            <label for="role" class="form-label fw-bold">Pilih Kewenangan (Role)</label>
                            <select class="form-select" name="role" id="role" aria-label="Pilih role">
                                <option value="OPERATOR" selected>OPERATOR</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="username" class="form-label fw-bold">Username <span class="text-danger">*</span></label>
                            <div class="position-relative input-icon">
                                <input type="text" name="username" class="form-control" id="username" placeholder="Username"
                                data-parsley-type="alphanum"
                                required>
                                <span class="position-absolute top-0 pt-2"><i class="bx bx-user"></i></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="password" class="form-label fw-bold">Password <span class="text-danger">*</span></label>
                            <div class="position-relative input-icon">
                                <input type="text" name="password" minlength="8" class="form-control" id="password" placeholder="Password"
                                data-parsley-errors-container="#errorPassword" 
                                data-parsley-uppercase="1"
                                data-parsley-lowercase="1"
                                data-parsley-number="1"
                                data-parsley-special="1"
                                required>
                                <span class="position-absolute top-0 pt-2"><i class="bx bx-key"></i></span>
                            </div>
                            <div id="errorPassword"></div>
                        </div>
                        <div class="input-group">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary"><i class="bx bx-save"></i> Simpan Data</button>
                        </div>
                    </div>
                    <?= form_close(); ?>
                </div>
                <div
                    class="tab-pane fade"
                    id="secondary"
                    role="tabpanel">
                    <?= form_open(base_url('app/master/users'), ['class' => 'needs-validation', 'id' => 'FormAddUserManual', 'novalidate' => '', 'autocomplete' => 'off'], ['is_manual' => 'YA']); ?>
                    <div class="d-flex flex-column justify-content-start align-items-start gap-3">
                        <div class="col-12">
                            <label for="nik" class="form-label fw-bold">Nomor Induk Kependudukan <span class="text-danger">*</span></label>
                            <div class="position-relative input-icon">
                                <input type="text" name="nik" class="form-control" id="nik" placeholder="Masukan NIK"
                                data-parsley-type="alphanum"
                                required>
                                <span class="position-absolute top-0 pt-2"><i class="bx bx-key"></i></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="nik" class="form-label fw-bold">Pilih Unit Kerja <span class="text-danger">*</span></label>
                            <select class="form-select" name="fid_unit_kerja" id="unitkerja" data-placeholder="Pilih Unit Kerja" data-parsley-errors-container="#errorUNOR" required></select>
                            <div id="errorUNOR"></div>
                        </div>
                        <div class="col-12">
                            <label for="role-manual" class="form-label fw-bold">Pilih Kewenangan (Role)</label>
                            <select class="form-select" name="role" id="role-manual" aria-label="Pilih role manual" required>
                                <option value="OPERATOR" selected>OPERATOR</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="username-manual" class="form-label fw-bold">Username <span class="text-danger">*</span></label>
                            <div class="position-relative input-icon">
                                <input type="text" name="username" class="form-control" id="username-manual" placeholder="Username"
                                data-parsley-type="alphanum"
                                required>
                                <span class="position-absolute top-0 pt-2"><i class="bx bx-user"></i></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="password-manual" class="form-label fw-bold">Password <span class="text-danger">*</span></label>
                            <div class="position-relative input-icon">
                                <input type="text" name="password" minlength="8" class="form-control" id="password-manual" placeholder="Password"
                                data-parsley-errors-container="#errorPasswordManual" 
                                data-parsley-uppercase="1"
                                data-parsley-lowercase="1"
                                data-parsley-number="1"
                                data-parsley-special="1"
                                required>
                                <span class="position-absolute top-0 pt-2"><i class="bx bx-key"></i></span>
                            </div>
                            <div id="errorPasswordManual"></div>
                        </div>
                        <div class="input-group">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary"><i class="bx bx-save"></i> Simpan Data</button>
                        </div>
                    </div>
                    <?= form_close(); ?>
                </div>
                <div
                    class="tab-pane fade"
                    id="info"
                    role="tabpanel">
                    <?= form_open(base_url('app/master/users'), ['class' => 'needs-validation', 'id' => 'FormAddUserManual', 'novalidate' => '', 'autocomplete' => 'off'], ['is_manual' => 'DINAS']); ?>
                    <div class="d-flex flex-column justify-content-start align-items-start gap-3">
                        <div class="col-12">
                            <label for="nik" class="form-label fw-bold">Nomor Induk Kependudukan <span class="text-danger">*</span></label>
                            <div class="position-relative input-icon">
                                <input type="text" name="nik" class="form-control" id="nik" placeholder="Masukan NIK"
                                data-parsley-type="alphanum"
                                required>
                                <span class="position-absolute top-0 pt-2"><i class="bx bx-key"></i></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="username-dinas" class="form-label fw-bold">Username <span class="text-danger">*</span></label>
                            <div class="position-relative input-icon">
                                <input type="text" name="username" class="form-control" id="username-dinas" placeholder="Username"
                                data-parsley-type="alphanum"
                                required>
                                <span class="position-absolute top-0 pt-2"><i class="bx bx-user"></i></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="password-dinas" class="form-label fw-bold">Password <span class="text-danger">*</span></label>
                            <div class="position-relative input-icon">
                                <input type="text" name="password" minlength="8" class="form-control" id="password-dinas" placeholder="Password"
                                data-parsley-errors-container="#errorPasswordDinas" 
                                data-parsley-uppercase="1"
                                data-parsley-lowercase="1"
                                data-parsley-number="1"
                                data-parsley-special="1"
                                required>
                                <span class="position-absolute top-0 pt-2"><i class="bx bx-key"></i></span>
                            </div>
                            <div id="errorPasswordDinas"></div>
                        </div>
                        <div class="input-group">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary"><i class="bx bx-save"></i> Simpan Data</button>
                        </div>
                    </div>
                    <?= form_close(); ?>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Setting Role User-->
<div class="modal fade" id="set-role" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <?= form_open(base_url('app/master/users/set-role'), ['class' => 'modal-content needs-validation', 'id' => 'FormSetRole', 'novalidate' => '', 'autocomplete' => 'off'], ['token' => '']); ?>
            <div class="modal-header">
                <h5 class="modal-title">Setting Kewenangan Userportal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex flex-column justify-content-start align-items-start gap-3">
                <div class="col-12 d-none" id="preview"></div>
                <div class="col-12">
                    <label for="role">Pilih Kewenangan (Role)</label>
                    <select class="form-select" name="role" id="role" aria-label="Pilih role" required>
                        <option value="">Pilih Role</option>
                        <option value="ADMIN">ADMIN</option>
                        <option value="USER">USER</option>
                        <option value="OPERATOR" selected>OPERATOR</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary"><i class="bx bx-save"></i> Simpan Perubahan</button>
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
<script type="text/javascript">
$(document).ready(function() {
    const FORM_RESET_PASSWORD  = $("form#FormReset");
    const FORM_ADD_USER  = $("form#FormAddUser");
    const FORM_ADD_USER_MANUAL  = $("form#FormAddUserManual");
    const FORM_SET_ROLE  = $("form#FormSetRole");

    const MODAL_RESET_PASSWORD = new bootstrap.Modal("#reset-password", {
        keyboard: false,
        backdrop: 'static'
    });
    const MODAL_ADD_USER = new bootstrap.Modal("#add-user", {
        keyboard: false,
        backdrop: 'static'
    });
    const MODAL_SET_ROLE = new bootstrap.Modal("#set-role", {
        keyboard: false,
        backdrop: 'static'
    });


    FORM_ADD_USER.on("submit", function(e) {
        e.preventDefault();
        let _ = $(this);
        _.parsley({
            trigger: 'change'
        }).validate();
        if(_.parsley().isValid()) {
            $url = _.attr('action'),
            $method = _.attr('method'),
            $data = _.serializeArray();
            $.post(`${origin}/app/master/users`, $data, function(res) {
                if(res.status === true) {
                    iziToast.success({
                        message: res.message,
                        position: 'topCenter',
                    });
                    datatable.ajax.reload();
                    MODAL_ADD_USER.hide();
                    return false;
                }
                iziToast.warning({
                    message: res.message,
                    position: 'topCenter',
                });
            }, 'json').fail((err) => {
                iziToast.error({
                    message: err.responseJSON.message || err.statusText,
                    position: 'topCenter',
                });
            });
        }
    })
    FORM_ADD_USER_MANUAL.on("submit", function(e) {
        e.preventDefault();
        let _ = $(this);
        _.parsley({
            trigger: 'change'
        }).validate();
        if(_.parsley().isValid()) {
            $url = _.attr('action'),
            $method = _.attr('method'),
            $data = _.serializeArray();
            $.post(`${origin}/app/master/users`, $data, function(res) {
                if(res.status === true) {
                    iziToast.success({
                        message: res.message,
                        position: 'topCenter',
                    });
                    datatable.ajax.reload();
                    MODAL_ADD_USER.hide();
                    return false;
                }
                iziToast.warning({
                    message: res.message,
                    position: 'topCenter',
                });
            }, 'json').fail((err) => {
                iziToast.error({
                    message: err.responseJSON.message || err.statusText,
                    position: 'topCenter',
                });
            });
        }
    })
    FORM_RESET_PASSWORD.on("submit", function(e) {
        e.preventDefault();
        let _ = $(this);
        _.parsley({
            trigger: 'change'
        }).validate();

        if(_.parsley().isValid()) {
            $url = _.attr('action'),
            $method = _.attr('method'),
            $data = _.serializeArray().concat({name: "_method", value: "PATCH"});
            $.post(`${origin}/app/master/users`, $data, function(res){
                if(res.status === true) {
                    iziToast.success({
                        message: res.message,
                        position: 'topCenter',
                    });
                    datatable.ajax.reload();
                    MODAL_RESET_PASSWORD.hide();
                    return false;
                }
                ziToast.warning({
                    message: res.message,
                    position: 'topCenter',
                });
            }, 'json').fail((err) => {
                iziToast.error({
                    message: err.responseJSON.message || err.statusText,
                    position: 'topCenter',
                });
            });
        }
    })
    FORM_SET_ROLE.on("submit", function(e) {
        e.preventDefault();
        let _ = $(this);
        _.parsley({
            trigger: 'change'
        }).validate();

        if(_.parsley().isValid()) {
            // CSRF Hash
            let csrfName = '<?= csrf_token() ?>'; // CSRF Token name
            let csrfHash = '<?= csrf_hash() ?>'; // CSRF hash
            let role = _.find("select[name='role']").val();
            let token = _.find("input[name='token']").val();
            let data = {
                [csrfName]: csrfHash,
                _method: 'PUT',
                role,
                token,
            };
            $.post(_.attr('action'), data, function(res){
                if(res.status === true) {
                    iziToast.success({
                        message: res.message,
                        position: 'topCenter',
                    });
                    MODAL_SET_ROLE.hide();
                    return datatable.ajax.reload();
                }
            }, 'json').fail((err) => {
                    iziToast.error({
                        message: err.responseJSON.message || err.statusText,
                        position: 'topCenter',
                    });
                });
        }
    })

    $("#reset-password").on('hidden.bs.modal', (event) => {
       FORM_RESET_PASSWORD[0].reset();
       FORM_RESET_PASSWORD.parsley().reset();
    })
    $("#add-user").on('hidden.bs.modal', (event) => {
       FORM_ADD_USER[0].reset();
       FORM_ADD_USER.find('select[name="pegawai"]').val('').trigger('change');
       FORM_ADD_USER.parsley().reset();

       FORM_ADD_USER_MANUAL[0].reset();
       FORM_ADD_USER_MANUAL.find('select[name="fid_unit_kerja"]').val('').trigger('change');
       FORM_ADD_USER_MANUAL.parsley().reset();
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
            MODAL_ADD_USER.show();
        },
        className: 'btn btn-primary'
    };

    var datatable = $('table#example').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        order: [[0, 'desc']], //this mean no init order on datatable
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
            url: '<?= base_url('datatable/master/users') ?>',
            method: 'POST',
            data: {
                ['<?= csrf_token() ?>']: '<?= csrf_hash() ?>'
            },
        },
        columns: [
            {data: 'nik', orderable: true},
            {data: 'nipd', orderable: true},
            {data: 'photo', width: '5%', className: 'text-center align-middle', orderable: false, searchable: false},
            {data: 'nama',  className: 'align-middle'},
            {data: 'username',  className: 'align-middle'},
            {data: 'nama_unit_kerja', orderable: false},
            {data: 'action', width: '10%',orderable: false, searchable: false}
        ],
        createdRow: function(row, data, dataIndex){
            if(data.is_disabled ===  'Y'){
                $('td',row).addClass('bg-danger text-white');
            }
        },
        orderCellsTop: true,
        initComplete: function( settings, json ) 
        {

            var indexColumn = 0;

            this.api().columns([0,1,3,4,5]).every(function () 
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

    datatable.on("click", "button#DisabledFn", function() {
        let _ = $(this),
        is_disabled = _.data('status'),
        token = _.data('uid');
        let change = is_disabled === 'Y' ? 'N' : 'Y';
        // CSRF Hash
        let csrfName = '<?= csrf_token() ?>'; // CSRF Token name
        let csrfHash = '<?= csrf_hash() ?>'; // CSRF hash

        let data = {
            [csrfName]: csrfHash,
            _method: 'PUT',
            status: change,
            token,
        };
        $.post(`${origin}/app/master/users/status-active`, data, function(res){
            if(res.status === true) {
                return datatable.ajax.reload();
            }
        }, 'json').fail((err) => {
                iziToast.error({
                    message: err.responseJSON.message || err.statusText,
                    position: 'topCenter',
                });
            });
    })

    datatable.on("click", "button#SetRoleFn", function() {
        let _ = $(this),
        token = _.data('uid'),
        role = _.data('rolenow');
        MODAL_SET_ROLE.show();
        FORM_SET_ROLE.find("input[name='token']").val(token);
        FORM_SET_ROLE.find("select[name='role']").val(role);
        let preview = $("#set-role").find("div#preview").removeClass("d-none");
        preview.html('');
        if(token !== '') {
            preview.html('Loading ...');
            $.getJSON(`${origin}/select2/pegawai`, { nik: token }, function(res) {
                const { photo, nama, nama_unit_kerja } = res.data;
                preview.html(`
                    <div class="d-flex flex-row justify-content-start align-items-center gap-3">
                        <img src="${photo}" class="user-img" alt="${nama}">
                        <div class="d-inline-flex flex-column justify-content-start align-items-start">
                            <span class="fw-bold">${nama}</span>
                            <span>${nama_unit_kerja}</span>
                        </div>
                    </div>  
                    <hr/>
                `)
            }).fail((err) => {
                preview.addClass('text-danger').html( err.responseJSON.message || err.statusText )
            })
            return false;
        }
    })

    datatable.on("click", "button#EditFn", function() {
        let _ = $(this),
        token = _.data('uid');
        FORM_RESET_PASSWORD.find('input[name="token"]').val(token);
        MODAL_RESET_PASSWORD.show();
    });

    const select2 = $( 'select#pegawai' ).select2({
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        dropdownParent: $("#add-user"),
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
        let preview = $("#add-user").find("div#preview").removeClass("d-none");
        FORM_ADD_USER.find("input[name='token']").val(nik);
        preview.html('');
        if(nik !== '') {
            preview.html('Loading ...');
            $.getJSON(`${origin}/select2/pegawai`, { nik }, function(res) {
                const { photo, nama, nama_unit_kerja, id_unit_kerja } = res.data;
                FORM_ADD_USER.find("input[name='fid_unit_kerja']").val(id_unit_kerja);
                preview.html(`
                    <div class="d-flex flex-row justify-content-start align-items-center gap-3">
                        <img src="${photo}" class="user-img" alt="${nama}">
                        <div class="d-inline-flex flex-column justify-content-start align-items-start">
                            <span class="fw-bold">${nama}</span>
                            <span>${nama_unit_kerja}</span>
                        </div>
                    </div>  
                    <hr/>
                `)
            }).fail((err) => {
                preview.addClass('text-danger').html( err.responseJSON.message || err.statusText )
            })
            return false;
        }
    })
    
    // options unit kerja
    let unit_kerja = $( 'select#unitkerja' ).select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        allowClear: true,
        // minimumInputLength: 2,
        minimumResultsForSearch: 10,
        dropdownParent: $("#add-user"),
        ajax: { 
          url: "<?= base_url('select2/unit_kerja_list')?>",
          type: "POST",
          dataType: 'json',
          delay: 450,
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
});
</script>
<?= $this->endSection(); ?>

<?= $this->section('style'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<link rel="stylesheet" href="<?= base_url("template/vertical/plugins/datatable/css/datatables.min.css") ?>"/>
<?= $this->endSection(); ?>