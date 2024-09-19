<?= $this->extend('backend/layouts/app'); ?>

<?= $this->section('content'); ?>
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">App</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('/') ?>"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Ganti Password</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="row">
        <div class="col-md-5">
            <div class="card">
            <?= form_open(base_url('app/master/users/ganti-password'), ['class' => 'modal-content needs-validation', 'id' => 'FormReset', 'novalidate' => '', 'autocomplete' => 'off'], ['token' => $nik]); ?>
                <div class="card-body d-flex flex-column justify-content-start align-items-start gap-3">
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
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary"><i class="bx bx-save"></i> Simpan Perubahan</button>
                </div>
            <?= form_close(); ?>
            </div>
        </div>
    </div>
<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<script src="<?= base_url("template/vertical/plugins/parsley/parsley.min.js") ?>"></script>
<script src="<?= base_url("template/vertical/plugins/parsley/i18n/id.js") ?>"></script>
<script src="<?= base_url("template/vertical/plugins/parsley/default.js") ?>"></script>
<script>
    $(document).ready(function() {
        const FORM_RESET_PASSWORD  = $("form#FormReset");
        FORM_RESET_PASSWORD.on("submit", function(e) {
            e.preventDefault();
            let _ = $(this);
            _.parsley({
                trigger: 'change'
            }).validate();

            if(_.parsley().isValid()) {
                $url = _.attr('action'),
                $method = _.attr('method'),
                $data = _.serializeArray().concat({name: "_method", value: "PUT"});
                $.post($url, $data, function(res){
                    if(res.status === true) {
                        iziToast.success({
                            timeout: 1000,
                            message: res.message,
                            position: 'topCenter',
                            onClosing: () => {
                                window.location.href = `${origin}/logout`
                            }
                        });
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
    })
</script>
<?= $this->endSection(); ?>