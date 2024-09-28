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
                <li class="breadcrumb-item active" aria-current="page">Keluarga</li>
            </ol>
        </nav>
    </div>
    <button class="btn btn-danger btn-sm ms-auto d-flex align-items-center gap-2" onClick="window.history.back()">Kembali <i class="bx bx-right-arrow-alt pe-0 me-0"></i></button>
</div>
<!--end breadcrumb-->
<div class="card">
    <div class="card-body">
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
                <i class="bx bx-home font-18 me-1"></i>
                </div>
                <div class="tab-title text-uppercase"><?= $row->jns_kelamin === 'PRIA' ? 'istri' : 'suami'; ?></div>
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
                <i class="bx bx-user-pin font-18 me-1"></i>
                </div>
                <div class="tab-title text-uppercase">anak</div>
            </div>
            </a>
        </li>
    </ul>
    <div class="tab-content py-3">
        <div
            class="tab-pane fade show active"
            id="primary"
            role="tabpanel">
            <div class="card shadow-none border">
                <div class="card-header bg-light-success text-center ">
                    <h6 class="text-uppercase"><?= $row->jns_kelamin === 'PRIA' ? 'istri' : 'suami'; ?></h6>
                    <span>Data Keluarga</span>
                </div>
                <div class="card-body">
                    <table id="table-sutri" class="table table-striped table-bordered table-hover border border-3">
                        <thead>
                            <tr>
                                <th class="align-middle text-center" data-bs-toggle="tooltip" data-bs-title="Nomor">No</th>
                                <th class="align-middle">Nama <?= $row->jns_kelamin === 'PRIA' ? 'Istri' : 'Suami'; ?></th>
                                <th class="text-center align-middle"><u>Tgl. Nikah</u><br> No. Akta Nikah</th>
                                <th class="text-center align-middle"><u>Tmp. Lahir</u><br>Tgl. Lahir</th>
                                <th class="text-center"><u>Status Kawin</u><br>Status Hidup <br> Tanggungan</th>
                                <th class="text-center align-middle"><u>Tgl. Cerai</u><br>Akta Cerai</th>
                                <th class="text-center align-middle"><u>Tgl. Meninggal</u><br>Akta Meninggal</th>
                                <th class="text-center align-middle">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div
            class="tab-pane fade"
            id="secondary"
            role="tabpanel">
            <div class="card shadow-none border">
                <div class="card-header bg-light-success text-center ">
                    <h6 class="text-uppercase">anak</h6>
                    <span>Data Keluarga</span>
                </div>
                <div class="card-body">
                    <table id="table-anak" class="table table-striped table-bordered table-hover border border-3">
                        <thead>
                            <tr>
                                <th class="align-middle text-center" data-bs-toggle="tooltip" data-bs-title="Nomor">No</th>
                                <th class="align-middle">Nama</th>
                                <th class="align-middle">Nama <?= $row->jns_kelamin === 'PRIA' ? 'Ibu' : 'Bapak'; ?></th>
                                <th class="align-middle text-center">Jenis Kelamin</th>
                                <th class="align-middle text-center"><u>Tempat Lahir</u> <br> Tgl. Lahir</th>
                                <th class="text-center"><u>Status Anak</u><br>Status Hidup <br> Tanggungan</th>
                                <th class="text-center align-middle">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    </div>
</div>
<?= $this->endSection(); ?>
<?= $this->section('modal'); ?>
<!-- Offcanvas  Left-->
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasLeft" data-bs-focus="false" aria-labelledby="offcanvasLeftLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="offcanvasLeftLabel">Tambah <?= $row->jns_kelamin === 'PRIA' ? 'Istri' : 'Suami'; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body px-0">
        <?= form_open(base_url('app/pegawai/'.dohash($nik).'/keluarga/sutri/add'), ["id" => "FormAdd", "data-parsley-validate" => "", "class" => "needs-validation", "novalidate" => ""]) ?>
        <div class="row g-3 px-4">
            <div class="col-12">
                <label for="nama_sutri" class="form-label">Nama <?= $row->jns_kelamin === 'PRIA' ? 'Istri' : 'Suami'; ?> <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nama_sutri" name="nama_sutri" placeholder="Masukan nama tanpa gelar" required/>
            </div>
            <div class="col-12">
                <label for="tmp_lahir" class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="tmp_lahir" name="tmp_lahir" placeholder="Masukan tempat lahir" required/>
            </div>
            <div class="col-6">
                <label for="tgl_lahir">Tanggal Lahir <span class="text-danger">*</span></label>
                <input type="date" name="tgl_lahir" class="form-control datepicker" id="tgl_lahir" placeholder="Tanggal Lahir" required/>
            </div>
            <div class="col-6">
                <label for="pekerjaan">Pekerjaan <span class="text-danger">*</span></label>
                <select class="form-select" name="pekerjaan" id="pekerjaan" required>
                    <option selected value="">-- Pilih Pekerjaan --</option>
                    <option value="Pegawai Negeri">Pegawai Negeri</option>
                    <option value="Pegawai Swasta">Pegawai Swasta</option>
                    <option value="Wiraswasta">Wiraswasta</option>
                    <option value="Honorer">Honorer</option>
                    <option value="Rumah Tangga">Rumah Tangga</option>
                </select>
            </div>
            <div class="col-12">
                <label for="no_akta_nikah" class="form-label">No. Akta Nikah <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="no_akta_nikah" name="no_akta_nikah" placeholder="Masukan nomor akta nikah" required/>
            </div>
            <div class="col-6">
                <label for="tgl_nikah">Tanggal Nikah <span class="text-danger">*</span></label>
                <input type="date" name="tgl_nikah" class="form-control datepicker" id="tgl_nikah" placeholder="Tanggal Nikah" required/>
            </div>
            <div class="col-6">
                <label for="status_kawin">Status <span class="text-danger">*</span></label>
                <select class="form-select" name="status_kawin" id="status_kawin" required>
                    <option selected value="">-- Pilih Status --</option>
                    <option value="MENIKAH">Menikah</option>
                    <option value="JANDA/DUDA">Janda / Duda</option>
                </select>
            </div>
            <div class="col-6">
                <div class="form-check">
                    <input class="form-check-input" name="status_hidup" type="checkbox" value="YA" id="status_hidup" checked>
                    <label class="form-check-label" for="status_hidup">
                        Status Hidup
                    </label>
                </div>
            </div>
            <div class="col-6">
                <div class="form-check">
                    <input class="form-check-input" name="tanggungan" type="checkbox" value="YA" id="tanggungan" checked>
                    <label class="form-check-label" for="tanggungan">
                        Tanggungan
                    </label>
                </div>
            </div>
        </div>
        <hr/>
        <div class="row g-3 mb-4 px-4">
            <div class="col-12">
                <label for="nip_sutri" class="form-label">NIK <?= $row->jns_kelamin === 'PRIA' ? 'Istri' : 'Suami'; ?></label>
                <input type="text" class="form-control" id="nip_sutri" name="nip_sutri" placeholder="Masukan NIK"/>
            </div>
        </div>
        <div class="row g-3 px-4">
            <div class="col-12">
                <div class="btn-group g-3 w-100">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="offcanvas"> <i class="bx bx-x-circle"></i> Batal</button>
                    <button type="submit" class="btn btn-primary"> <i class="bx bx-save"></i> Simpan</button>
                </div>
            </div>
        </div>
        <?= form_close(); ?>
    </div>
</div>
<!-- End Offcanvas Left-->

<!-- Offcanvas Cerai-->
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasCerai" data-bs-focus="false" aria-labelledby="offcanvasCeraiLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="offcanvasCeraiLabel">Perbaharui Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body px-0">
        <?= form_open(base_url('app/pegawai/'.dohash($nik).'/keluarga/sutri/cerai'), 
        ["id" => "FormCerai", "data-parsley-validate" => "", "class" => "needs-validation", "novalidate" => ""],
        ["id" => "", "nik" => ""]) ?>
        <div class="row g-3 px-4">
            <div class="col-12">
                <label for="no_akta_cerai" class="form-label">Nomor Akta Cerai <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="no_akta_cerai" name="no_akta_cerai" placeholder="Nomor Akta Cerai" required/>
            </div>
            <div class="col-6">
                <label for="tgl_cerai">Tanggal Cerai <span class="text-danger">*</span></label>
                <input type="date" name="tgl_cerai" class="form-control datepicker" id="tgl_cerai" placeholder="Tanggal Cerai" required/>
            </div>
            <div class="clearfix my-0 py-0"></div>
            <div class="col-6">
                <div class="form-check">
                    <input class="form-check-input" name="status_hidup" type="checkbox" value="YA" id="status_hidup">
                    <label class="form-check-label" for="status_hidup">
                        Status Hidup
                    </label>
                </div>
            </div>
            <div class="col-6">
                <div class="form-check">
                    <input class="form-check-input" name="tanggungan" type="checkbox" value="YA" id="tanggungan">
                    <label class="form-check-label" for="tanggungan">
                        Tanggungan
                    </label>
                </div>
            </div>
            <div class="col-12">
                <div class="btn-group g-3 w-100">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="offcanvas"> <i class="bx bx-x-circle"></i> Batal</button>
                    <button type="submit" class="btn btn-primary"> <i class="bx bx-save"></i> Simpan</button>
                </div>
            </div>
        </div>
        <?= form_close(); ?>
    </div>
</div>
<!-- End Offcanvas Cerai-->

<!-- Offcanvas Meninggal-->
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasMeninggal" data-bs-focus="false" aria-labelledby="offcanvasMeninggalLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="offcanvasMeninggalLabel">Perbaharui Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body px-0">
        <?= form_open(base_url('app/pegawai/'.dohash($nik).'/keluarga/sutri/meninggal'), 
        ["id" => "FormMeninggal", "data-parsley-validate" => "", "class" => "needs-validation", "novalidate" => ""],
        ["id" => "", "nik" => ""]) ?>
        <div class="row g-3 px-4">
            <div class="col-12">
                <label for="no_akta_meninggal" class="form-label">Nomor Akta Meninggal <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="no_akta_meninggal" name="no_akta_meninggal" placeholder="Nomor Akta Meninggal" required/>
            </div>
            <div class="col-6">
                <label for="tgl_meninggal">Tanggal Meninggal <span class="text-danger">*</span></label>
                <input type="date" name="tgl_meninggal" class="form-control datepicker" id="tgl_meninggal" placeholder="Tanggal Meninggal" required/>
            </div>
            <div class="col-12">
                <div class="btn-group g-3 w-100">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="offcanvas"> <i class="bx bx-x-circle"></i> Batal</button>
                    <button type="submit" class="btn btn-primary"> <i class="bx bx-save"></i> Simpan</button>
                </div>
            </div>
        </div>
        <?= form_close(); ?>
    </div>
</div>
<!-- End Offcanvas Meninggal-->

<!-- Offcanvas Tambah Anak-->
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasAnak" data-bs-focus="false" aria-labelledby="offcanvasAnakLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="offcanvasAnakLabel">Tambah Data Anak</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body px-0">
        <?= form_open(base_url('app/pegawai/'.dohash($nik).'/keluarga/anak/add'), 
        ["id" => "FormAddAnak", "data-parsley-validate" => "", "class" => "needs-validation", "novalidate" => ""],
        ["id" => "", "nik" => ""]) ?>
        <div class="row g-3 px-4">
            <div class="col-12">
                <label for="nama_anak" class="form-label">Nama Anak <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nama_anak" name="nama_anak" placeholder="Nama Anak" required/>
            </div>
            <div class="col-12">
                <label for="tmp_lahir" class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="tmp_lahir" name="tmp_lahir" placeholder="Tempat Lahir" required/>
            </div>
            <div class="col-6">
                <label for="tgl_lahir">Tanggal Lahir <span class="text-danger">*</span></label>
                <input type="date" name="tgl_lahir" class="form-control datepicker" id="tgl_lahir" placeholder="Tanggal Lahir" required/>
            </div>
            <div class="col-6">
                <label for="jns_kelamin">Jenis Kelamin <span class="text-danger">*</span></label>
                <select class="form-select" name="jns_kelamin" id="jns_kelamin" required>
                    <option selected value="">-- Pilih Jenis Kelamin Anak --</option>
                    <option value="PRIA">LAKI - LAKI</option>
                    <option value="WANITA">PEREMPUAN</option>
                </select>
            </div>
            <div class="col-12">
                <?php  
                    $ibu = db_connect()->table('riwayat_sutri')->select('sutri_ke,nama_sutri')->where("nik", $nik)->get()->getResult();
                ?>
                <label for="fid_sutri_ke">Nama <?= $row->jns_kelamin === 'PRIA' ? 'Ibu' : 'Bapak'; ?> <span class="text-danger">*</span></label>
                <select class="form-select" name="fid_sutri_ke" id="fid_sutri_ke" required>
                    <option selected value="">-- Pilih <?= $row->jns_kelamin === 'PRIA' ? 'Ibu' : 'Bapak'; ?> --</option>
                    <?php foreach ($ibu as $i): ?>
                        <option value="<?= $i->sutri_ke; ?>"><?= $i->nama_sutri; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-12">
                <label for="status">Status Anak <span class="text-danger">*</span></label>
                <select class="form-select" name="status" id="status" required>
                    <option selected value="">-- Pilih Status Anak --</option>
                    <option value="KANDUNG">KANDUNG</option>
                    <option value="TIRI">TIRI</option>
                    <option value="ANGKAT">ANGKAT</option>
                </select>
            </div>
            <div class="col-6">
                <div class="form-check">
                    <input class="form-check-input" name="status_hidup" type="checkbox" value="YA" id="status_hidup" checked>
                    <label class="form-check-label" for="status_hidup">
                        Status Hidup
                    </label>
                </div>
            </div>
            <div class="col-6">
                <div class="form-check">
                    <input class="form-check-input" name="tanggungan" type="checkbox" value="YA" id="tanggungan" checked>
                    <label class="form-check-label" for="tanggungan">
                        Tanggungan
                    </label>
                </div>
            </div>
            <div class="col-12">
                <div class="btn-group g-3 w-100">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="offcanvas"> <i class="bx bx-x-circle"></i> Batal</button>
                    <button type="submit" class="btn btn-primary"> <i class="bx bx-save"></i> Simpan</button>
                </div>
            </div>
        </div>
        <?= form_close(); ?>
    </div>
</div>
<!-- End Offcanvas Tambah Anak-->
<?= $this->endSection(); ?>
<!-- Ex: Script -->
<?= $this->section("script"); ?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="<?= base_url("template/vertical/plugins/parsley/parsley.min.js") ?>"></script>
<script src="<?= base_url("template/vertical/plugins/parsley/i18n/id.js") ?>"></script>
<script src="<?= base_url("template/vertical/plugins/parsley/default.js") ?>"></script>
<script src="<?= base_url("template/vertical/plugins/datatable/js/datatables.min.js") ?>" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
<?= $this->endSection(); ?>
<!-- Ex: Css -->
<?= $this->section('style'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<link rel="stylesheet" href="<?= base_url("template/vertical/plugins/datatable/css/datatables.min.css") ?>"/>
<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet" />
<?= $this->endSection(); ?>

<!-- Datatable Sutri -->
<?= $this->section('script'); ?>
<script>
    $(document).ready(function() {
        const FORM = $("form#FormAdd");
        const FORM_CERAI = $("form#FormCerai");
        const FORM_MENINGGAL = $("form#FormMeninggal");

        const datapicker = $(".datepicker").flatpickr({
            altInput: true,
            altFormat: "j F Y",
            dateFormat: "Y-m-d",
            "locale": "id",
            static: true
        });

        const CANVAS_ADD = new bootstrap.Offcanvas("#offcanvasLeft", {
            backdrop: 'static',
            keyboard: false,
            scroll: false,
        });

        const CANVAS_CERAI = new bootstrap.Offcanvas("#offcanvasCerai", {
            backdrop: 'static',
            keyboard: false,
            scroll: false,
        });

        const CANVAS_MENINGGAL = new bootstrap.Offcanvas("#offcanvasMeninggal", {
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

        // Form Cerai
        FORM_CERAI.on("submit", function(e) {
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
                                timeout: 1000,
                                title: 'Berhasil',
                                message: response.message,
                                position: 'topCenter',
                            });
                            datatable.ajax.reload();
                            CANVAS_CERAI.hide()
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

        // Form Meninggal
        FORM_MENINGGAL.on("submit", function(e) {
            e.preventDefault();
            let _ = $(this),
            url = _.attr("action"),
            method = _.attr("method"),
            data = _.serializeArray().concat({name: "_method", value: "PATCH"});
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
                            CANVAS_MENINGGAL.hide()
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
        });

        $("#offcanvasCerai").on('hidden.bs.offcanvas', event => {
            FORM_CERAI.parsley().reset();
            FORM_CERAI[0].reset();
            FORM_CERAI.find("button[type='submit']").html(`<i class="bx bx-save"></i> Simpan`).prop("disabled", false);
        });

        $("#offcanvasMeninggal").on('hidden.bs.offcanvas', event => {
            FORM_MENINGGAL.parsley().reset();
            FORM_MENINGGAL[0].reset();
            FORM_MENINGGAL.find("button[type='submit']").html(`<i class="bx bx-save"></i> Simpan`).prop("disabled", false);
        });

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
                CANVAS_ADD.show();
            },
            className: 'btn btn-primary'
        };

        let datatable  = $('table#table-sutri').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            searching: false,
            order: [], //this mean no init order on datatable
            layout: {
                topStart: [{
                    buttons: ['add']
                }],
                topEnd: [{
                    buttons: ['reload']
                }],
                bottomStart: ['info','pageLength']
            },
            ajax: {
                url: '<?= base_url('datatable/riwayat/keluarga/sutri') ?>',
                method: 'POST',
                data: {
                    ['<?= csrf_token() ?>']: '<?= csrf_hash() ?>',
                    nik: '<?= $row->nik ?>'
                },
            },
            columns: [
                {data: 'no', orderable: false, searchabel: false, className: 'text-center'},
                {data: 'nama_sutri'},
                {data: 'tgl_nikah', orderable: false, searchabel: false},
                {data: 'tmp_lahir', orderable: false, searchabel: false},
                {data: 'status_kawin', orderable: false, searchabel: false},
                {data: 'tgl_cerai', orderable: false, searchabel: false},
                {data: 'tgl_meninggal', orderable: false, searchabel: false},
                {data: 'action', orderable: false, searchabel: false, className: 'text-center'},
            ]
        });

        datatable.on("click", "button#status-cerai", function() {
            let _ = $(this),
            id = _.data('uid'),
            nik = _.data('nik'),
            row = _.data('detail');

            CANVAS_CERAI.show();
            FORM_CERAI.find("input[name='id']").val(id)
            FORM_CERAI.find("input[name='nik']").val(nik)
            FORM_CERAI.find("input[name='no_akta_cerai']").val(row.no_akta_cerai);
            datapicker[2].setDate(row.tgl_cerai, false)
            if(row.status_hidup === "YA") {
                FORM_CERAI.find("input[name='status_hidup']").prop("checked", true);
            }
            if(row.tanggungan === "YA") {
                FORM_CERAI.find("input[name='tanggungan']").prop("checked", true);
            }
        })

        datatable.on("click", "button#status-meninggal", function() {
            let _ = $(this),
            id = _.data('uid'),
            nik = _.data('nik'),
            row = _.data('detail');

            CANVAS_MENINGGAL.show();
            FORM_MENINGGAL.find("input[name='id']").val(id)
            FORM_MENINGGAL.find("input[name='nik']").val(nik)
            FORM_MENINGGAL.find("input[name='no_akta_meninggal']").val(row.no_akta_meninggal);
            datapicker[3].setDate(row.tgl_meninggal, false)
        })  
        
        datatable.on("click", "button#hapus", function() {
            let _ = $(this),
            id = _.data('uid'),
            nik = _.data('nik'),
            sutrike = _.data('sutrike');
            $.confirm({
                title: 'Peringatan !',
                content: `Apakah anda yakin akan menghapus riwayat keluarga tersebut ? semua data anak (jika ada) yang terkait akan ikut terhapus secara permanent`,
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
                                `${origin}/app/pegawai/${nik}/keluarga/sutri/delete`,
                                { id, nik, sutrike, [csrfName]: csrfHash, '_method': 'DELETE' },
                                function (res) {
                                    if (res.status === true) {
                                        iziToast.success({
                                            position: 'topCenter',
                                            message: res.message,
                                        });
                                        datatable.ajax.reload();
                                        return false;
                                    }
                                    iziToast.warning({
                                        position: 'topCenter',
                                        message: res.message,
                                    });
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
            window.location.href = `${origin}/app/pegawai/${nik}/keluarga/sutri/edit/${id}`;
        })
    })
</script>
<?= $this->endSection(); ?>

<!-- Datatable Anak -->
<?= $this->section('script'); ?>
<script>
    $(document).ready(function() {
        const FORM = $("form#FormAddAnak");
        const CANVAS_ADD = new bootstrap.Offcanvas("#offcanvasAnak", {
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

        $("#offcanvasAnak").on('hidden.bs.offcanvas', event => {
            FORM.parsley().reset();
            FORM[0].reset();
            FORM.find("button[type='submit']").html(`<i class="bx bx-save"></i> Simpan`).prop("disabled", false);
        });

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
                CANVAS_ADD.show();
            },
            className: 'btn btn-primary'
        };

        let datatable  = $('table#table-anak').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            searching: false,
            order: [], //this mean no init order on datatable
            layout: {
                topStart: [{
                    buttons: ['add']
                }],
                topEnd: [{
                    buttons: ['reload']
                }],
                bottomStart: ['info','pageLength']
            },
            ajax: {
                url: '<?= base_url('datatable/riwayat/keluarga/anak') ?>',
                method: 'POST',
                data: {
                    ['<?= csrf_token() ?>']: '<?= csrf_hash() ?>',
                    nik: '<?= $row->nik ?>'
                },
            },
            columns: [
                {data: 'no', orderable: false, searchabel: false, className: 'text-center'},
                {data: 'nama_anak'},
                {data: 'fid_sutri_ke', orderable: false, searchabel: false},
                {data: 'jns_kelamin', orderable: false, searchabel: false},
                {data: 'tmp_lahir', orderable: false, searchabel: false},
                {data: 'status', orderable: false, searchabel: false},
                {data: 'action', orderable: false, searchabel: false, className: 'text-center'},
            ]
        });

        datatable.on("click", "button#hapus", function() {
            let _ = $(this),
            id = _.data('uid'),
            nik = _.data('nik');
            $.confirm({
                title: 'Peringatan !',
                content: `Apakah anda yakin akan menghapus data anak tersebut ?`,
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
                                `${origin}/app/pegawai/${nik}/keluarga/anak/delete`,
                                { id, nik, [csrfName]: csrfHash, '_method': 'DELETE' },
                                function (res) {
                                    if (res.status === true) {
                                        iziToast.success({
                                            position: 'topCenter',
                                            message: res.message,
                                        });
                                        datatable.ajax.reload();
                                        return false;
                                    }
                                    iziToast.warning({
                                        position: 'topCenter',
                                        message: res.message,
                                    });
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
            window.location.href = `${origin}/app/pegawai/${nik}/keluarga/anak/edit/${id}`;
        })
    })
</script>
<?= $this->endSection(); ?>