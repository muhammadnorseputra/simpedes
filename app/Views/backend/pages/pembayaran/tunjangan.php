<?= $this->extend('backend/layouts/app'); ?>

<?= $this->section('content'); ?>
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Pembayaran</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('/') ?>"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tunjangan</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="card">
        <div class="card-body">
            <?= form_open(base_url('pembayaran/tunjangan/filter'), ['id' => 'FormFilter', 'novalidate' => '', "data-parsley-validate" => ""]); ?>
                <div class="row g-3">
                    <div class="col-4">
                        <label for="unit" class="form-label">Pilih Desa / Unit Kerja <span class="text-danger">*</span></label>
                        <select class="form-select" name="unit" id="unit" data-placeholder="Pilih Unit Kerja" 
                        data-parsley-errors-container="#errroUnit"
                        data-parsley-error-message="Tidak Boleh Kosong"
                        required></select>
                        <div id="errroUnit"></div>
                    </div>
                    <div class="col-2">
                        <label for="bulan" class="form-label">Pilih Bulan <span class="text-danger">*</span></label>
                        <select class="form-select" name="bulan" id="bulan" data-placeholder="Pilih bulan" required>
                            <option value="">Pilih Bulan</option>
                            <?php foreach (listBulan() as $key => $value): ?>
                                <?php $selected = $key === (int) date("m") ? 'selected' : '' ?>
                                <option value="<?= $key; ?>" <?=  $selected; ?>><?= $value; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-2">
                        <label for="jns_pegawai" class="form-label">Pilih Jenis Pegawai <span class="text-danger">*</span></label>
                        <select class="form-select" name="jns_pegawai" id="jns_pegawai" data-placeholder="Pilih Pegawai" required>
                            <option value="">Pilih Pegawai</option>
                            <?php if(session()->jenis_jabatan !== null || session()->role === 'ADMIN' || session()->role === 'USER'): ?>
                            <option value="PEMDES" <?= session()->jenis_jabatan === "PEMDES" ? 'selected' : ''; ?>>PEMDES</option>
                            <option value="BPD" <?= session()->jenis_jabatan === "BPD" ? 'selected' : ''; ?>>BPD</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-2 d-flex justify-content-start aling-items-center">
                        <button type="submit" id="submit" class="btn btn-primary"><i class="bx bx-save"></i> <br> Pilih</button>
                    </div>
                </div>
            <?= form_close(); ?>
        </div>
    </div>
<?= $this->endSection(); ?>
<!-- ex: parsley -->
<?= $this->section('script'); ?>
<script src="<?= base_url("template/vertical/plugins/parsley/parsley.min.js") ?>"></script>
<script src="<?= base_url("template/vertical/plugins/parsley/i18n/id.js") ?>"></script>
<script src="<?= base_url("template/vertical/plugins/parsley/default.js") ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    $(function() {
        // options kelurahan / desa
        $( 'select#unit' ).select2( {
            theme: "bootstrap-5",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: $( this ).data( 'placeholder' ),
            minimumInputLength: <?= session()->role === "ADMIN" ? 3 : 0 ?>,
            minimumResultsForSearch: 5,
            dropdownParent: $("body"),
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
<?= $this->section('style'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<?= $this->endSection(); ?>