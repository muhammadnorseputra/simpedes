<?= $this->extend('backend/layouts/app'); ?>

<?= $this->section('content'); ?>
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title ps-2 pe-3">Referensi</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('/') ?>"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('/app/referensi/satuan_unit_kerja') ?>">Satuan Unit Kerja</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $row->nama_unit_kerja ?></li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="row ">
        <div class="col-12 col-md-10 col-lg-8 col-xl-6">
            <div class="card">
            <?= form_open(base_url('app/referensi/satuan_unit_kerja'), ['class' => 'needs-validation', 'id' => 'FormUpdate', 'novalidate' => '', 'autocomplete' => 'off']); ?>
                <div class="card-body d-flex flex-column justify-content-start align-items-start gap-3">
                    <div class="col-12">
                        <label for="nama_unit_kerja" class="form-label fw-bold">Nama Unit Kerja <span class="text-danger">*</span></label>
                        <div class="position-relative input-icon">
                            <input type="text" name="nama_unit_kerja" value="<?= $row->nama_unit_kerja ?>" class="form-control" id="nama_unit_kerja" placeholder="Nama Unit Kerja" required>
                            <span class="position-absolute top-0 pt-2"><i class="bx bx-building"></i></span>
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="alamat" class="form-label fw-bold">Alamat <span class="text-danger">*</span></label>
                        <div class="position-relative input-icon">
                            <textarea name="alamat" rows="4" class="form-control" id="alamat" placeholder="Masukan Alamat" autocomplete="off" 
                            data-parsley-maxlength="255"
                            maxlength="255"
                            required><?= $row->alamat ?></textarea>
                            <span class="position-absolute top-0 pt-2"><i class="bx bx-home"></i></span>
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="kecamatan" class="form-label">Pilih Kecamatan <span class="text-danger">*</span></label>
                        <select class="form-select" name="kecamatan" id="kecamatan" data-placeholder="Pilih Kecamatan" 
                        data-parsley-errors-container="#errorKecamatan" 
                        data-parsley-error-message="Pilih Kecamatan"
                        required>
                            <?php foreach($kecamatan as $kec): ?>
                                <option value="<?= $kec->id_kecamatan ?>"><?= ucwords($kec->nama_kecamatan) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div id="errorKecamatan"></div>
                    </div>
                    <div class="col-12">
                        <label for="aktif" class="form-label fw-bold">Status Unit Kerja Aktif <span class="text-danger">*</span></label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="aktif" id="aktif" value="Y"
                                <?= $row->aktif === 'Y' ? 'checked' : ''; ?>
                                data-parsley-errors-container="#errorStatusUnitKerja" 
                                data-parsley-error-message="Pilih status unit kerja"
                                required>
                                <label class="form-check-label" for="aktif">Aktif</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="aktif" id="noaktif" value="N" 
                                <?= $row->aktif === 'N' ? 'checked' : ''; ?>
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
                            <input type="number" name="nohp" value="<?= $row->telepon ?>" class="form-control" id="nohp" placeholder="Nomor Hp/Telphone" required>
                        </div>
                    </div>
                    <hr class="w-100"/>
                    <div class="col-12">
                        <label for="terpencil" class="form-label fw-bold">Apakah unit kerja ini termasuk tempat terpencil ? <span class="text-danger">*</span></label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="terpencil" id="terpencil" value="YA"
                                <?= $row->terpencil === 'YA' ? 'checked' : ''; ?>
                                data-parsley-errors-container="#errorTerpencil" 
                                data-parsley-error-message="Pilih status terpencil"
                                required
                                />
                                <label class="form-check-label" for="terpencil">Ya</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="terpencil" id="noterpencil" value="TIDAK"
                                <?= $row->terpencil === 'TIDAK' ? 'checked' : ''; ?>
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
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Dapatkan Lokasi Saat Ini" id="getlokasi" onclick="handleLocation()"><i class="bx bx-map"></i> Lokasi saat ini.</button>
                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Izinkan akses lokasi" id="getlokasi" onclick="getLocation()"><i class="bx bx-map"></i> Izinkan Lokasi.</button>
                        <div class="position-relative input-icon">
                            <textarea name="map" rows="4" class="form-control" id="map" placeholder="Masukan Link Google Maps" required><?= $row->link_google_map ?></textarea>
                            <span class="position-absolute top-0 pt-2"><i class="bx bx-map"></i></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label for="lat" class="form-label fw-bold">Lat</label>
                            <input type="text" name="lat" value="<?= $row->latitude ?>" class="form-control" id="lat" placeholder="Latitude" readonly required>
                        </div>
                        <div class="col-6">
                            <label for="long" class="form-label fw-bold">Long</label>
                            <input type="text" name="long" value="<?= $row->longitude ?>" class="form-control" id="long" placeholder="Longitude" readonly required>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-danger" onClick="window.history.back(-1)">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="bx bx-save"></i> Simpan</button>
                </div>
            <?= form_close() ?>
            </div>
        </div>
    </div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="<?= base_url("template/vertical/plugins/parsley/parsley.min.js") ?>"></script>
<script src="<?= base_url("template/vertical/plugins/parsley/i18n/id.js") ?>"></script>
<script src="<?= base_url("template/vertical/plugins/parsley/default.js") ?>"></script>
<script src="<?= base_url("template/vertical/plugins/parsley/bootstrap-maxlength.min.js") ?>"></script>
<script src="<?= base_url("assets/js/geolocation.js") ?>"></script>
<script>
    var FORM = $("form#FormUpdate");
    var FormValidate = FORM.parsley();

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
    FORM.find("textarea[name='map']").on("change", (event) => {
        let _ = $("textarea[name='map']");
        if(_.val() !== "") {
            var regex = new RegExp('@(.*),(.*),');
            var lat_long_match = _.val().match(regex);
            FORM.find("input[name='lat']").val(lat_long_match[1]);
            FORM.find("input[name='long']").val(lat_long_match[2]);
        }
    });
    // select2 kecamatan
    $('select#kecamatan').select2({
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' )
    }).val('<?= $row->kecamatan ?>').trigger("change");

    // handle location
    function handleLocation() {
        const loc = JSON.parse(localStorage.getItem("location"));
        if (loc) {
            FORM.find("input[name='lat']").val(loc?.lat);
            FORM.find("input[name='long']").val(loc?.long);
            FORM.find("textarea[name='map']").val(`http://www.google.com/maps/place/${loc?.lat},${loc?.long}`);
        }
    }

    // submit form
    FORM.on("submit", function(event) {
        event.preventDefault();
        // CSRF Hash
        let csrfName = '<?= csrf_token() ?>'; // CSRF Token name
        let csrfHash = '<?= csrf_hash() ?>'; // CSRF hash

        let id = '<?= $row->id_unit_kerja ?>',
        $data = $(this).serializeArray().concat({name: "_method", value: 'PATCH'}, {name: 'id', value: id});
        $.post(
            `${origin}/app/referensi/satuan_unit_kerja/${id}`, $data, function (res) {
                if (res.status === true) {
                    iziToast.success({
                        position: 'topCenter',
                        message: res.message,
                    });
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
    });
</script>
<?= $this->endSection(); ?>

<?= $this->section('style'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<?= $this->endSection(); ?>