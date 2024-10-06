<?= $this->extend('backend/layouts/app'); ?>

<?= $this->section('content'); ?>
<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Pegawai</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="<?= base_url('/') ?>"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><?= $unit ?></li>
            </ol>
        </nav>
    </div>
    <button class="btn btn-success btn-sm ms-auto d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#cetak-nominatif">Cetak Nominatif <i class="bx bx-printer pe-0 me-0"></i></button>
</div>
<!--end breadcrumb-->
<div id="pegawai">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-lg-4 col-xl-3">
                            <a href="<?= base_url('app/master/pegawai/peremajaan') ?>" class="btn btn-primary mb-3 mb-lg-0"><i class='bx bxs-plus-square'></i>Tambah Pegawai Baru</a>
                        </div>
                        <div class="col-lg-8 col-xl-9">
                            <div class="row  flex-row-reverse">
                                <div class="col col-xl-4">
                                    <div class="position-relative">
                                        <input type="search" class="form-control ps-5 search" placeholder="Ketikan NIPD atau Nama pegawai"> <span class="position-absolute top-50 product-show translate-middle-y"><i class="bx bx-search"></i></span>
                                    </div>
                                </div>
                                <?php if(session()->role === 'ADMIN' || session()->role === 'USER'): ?>
                                <div class="col col-xl-6">
                                    <?= form_open(base_url("app/pegawai/unit"), ["class" => "needs-validation", "id" => "FormFilter", "novalidate" => ""]) ?>
                                        <div class="input-group">
                                            <div class="form-floating">
                                                <select class="form-select" name="fid_unit_kerja" id="unitkerja" data-placeholder="Pilih Unit Kerja" required></select>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Pilih</button>
                                        </div>
                                    <?= form_close() ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if(count($pegawai) > 0): ?>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5 product-grid list">
        <?php foreach ($pegawai as $row): ?>
        <?php 
        if($row->status === 'ENTRI' || $row->status === 'ENTRI_ULANG' || $row->status === 'VERIFIKASI' || $row->status === 'NON_AKTIF' || $row->status === 'NON_AKTIF_NIK_DITOLAK') {
            $opacity_status = 'opacity-25';
            $button_status = 'disabled';
            $icon_status = '<i class="bx bx-edit-alt"></i>';
        } else {
            $opacity_status = "";$button_status = "";$icon_status = '';
        }
        ?>
        <div class="col position-relative">
            <?php if($row->status === 'ENTRI' || $row->status === 'ENTRI_ULANG' || $row->status === 'VERIFIKASI' || $row->status === 'NON_AKTIF' || $row->status === 'NON_AKTIF_NIK_DITOLAK'): ?>
                <div class="position-absolute top-50 start-50 translate-middle z-1">
                    <a href="<?= base_url('app/master/pegawai/peremajaan?token='.dohash($row->nik)) ?>" class="btn btn-primary btn-sm">
                     <i class="bx bx-edit-alt"></i> Detail
                    </a>
                </div>
                <div class="">
                    <div class="position-absolute top-10 end-10 px-3 py-1 rounded-top rounded-end <?= statusdata($row->status) ?> text-white"> <i class="bx bx-info-circle"></i> <?= $row->status ?></div>
                </div>
            <?php endif; ?>
            <div class="card <?= $opacity_status ?>">
                <img src="<?= base_url("assets/images/users/{$row->photo}"); ?>" height="200" class="card-img-top" alt="...">
                <div class="card-body">
                    <h6 class="card-title cursor-pointer name"><?= namalengkap($row->gelar_depan,$row->nama,$row->gelar_blk); ?></h6>
                    <div class="clearfix">
                        <p class="mb-0 float-start nipd"><strong><?= $row->nama_jabatan ?? "-" ?> (<?= $row->jenis; ?>)</strong></p> <br>
                        <p class="mb-0 float-start nipd"><strong>NIPD. <?= $row->nipd ?></strong></p>
                    </div>
                    <div class="d-flex align-items-center mt-3 fs-6">
                        <div class="cursor-pointer d-grid gap-3 w-100">
                            <button onclick="window.location.href = '<?= base_url('app/pegawai/detail/'.dohash($row->nik)) ?>'" class="btn btn-outline-primary" <?= $button_status ?>>Detail Pegawai <i class="bx bx-user"></i></button>
                        </div>	
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div><!--end row-->
    <?php else: ?>
    <div class="row col mt-5">
        <p class="text-center text-secondary opacity-50">
            <span><i class="bx bx-box bx-lg"></i></span>
            <p class="text-center text-secondary opacity-50">
                Data pegawai tidak ditemukan, kosong !
            </p>
        </p>
    </div>
    <?php endif; ?>
</div>
<?= $this->endSection(); ?>

<?= $this->section('modal'); ?>
<!-- Modal Cetak Perhitungan Tunjangan-->
<div class="modal fade" id="cetak-nominatif" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <?= form_open(base_url('nominatif/cetak'), 
        ['class' => 'modal-content needs-validation',"target"=>"_blank", "data-parsley-validate" => "", 'id' => 'FormAdd', 'novalidate' => '', 'autocomplete' => 'off'],
        ['id_unit_kerja' => isset($_GET['id']) ? $_GET['id'] : dohash(session()->id_unit_kerja)]); ?>
            <div class="modal-header">
                <h5 class="modal-title">CETAK NOMINATIF</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex flex-column justify-content-start align-items-start gap-3">
                <div class="col-12">
                    <?php  
                    $tahun = db_connect()->table('pegawai')
                    ->select('YEAR(created_at) as year')
                    ->where('fid_unit_kerja', isset($_GET['id']) ? rehash($_GET['id']) : session()->id_unit_kerja)
                    ->groupBy('year')
                    ->get()
                    ->getResult();
                    ?>
                    <label for="tahun" class="form-label fw-bold">Pilih Tahun <span class="text-danger">*</span></label>
                    <select class="form-select" name="tahun" id="tahun"
                        required>
                        <option value="">-- Pilih Tahun --</option>
                        <?php 
                            foreach($tahun as $k => $thn): 
                        ?>
                            <option value="<?= $thn->year; ?>"><?= $thn->year; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12">
                <label for="jenis" class="form-label fw-bold">Pilih Jenis Pegawai <span class="text-danger">*</span></label>
                    <select class="form-select" name="jenis" id="jenis"
                        required>
                        <option value="">-- Pilih Jenis --</option>
                        <?php if(count($tahun) > 0): ?>
                        <option value="BPD">BPD</option>
                        <option value="PEMDES">PEMDES</option>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary"><i class="bx bx-printer"></i> CETAK</button>
            </div>
        <?= form_close(); ?>
    </div>
</div>
<?= $this->endSection(); ?>

<!-- Load list.js ketika data ada -->
<?php if(count($pegawai) > 0): ?>
<?= $this->section('script'); ?>
<script src="//cdnjs.cloudflare.com/ajax/libs/list.js/2.3.1/list.min.js"></script>
<script>
$(document).ready(function() {
    // Filter Search
    var options = {
        valueNames: [ 'name', 'nipd' ]
    };

    var pegawai = new List('pegawai', options);
})
</script>
<?= $this->endSection(); ?>
<?php endif; ?>

<?= $this->section('script'); ?>
<script src="<?= base_url("template/vertical/plugins/parsley/parsley.min.js") ?>"></script>
<script src="<?= base_url("template/vertical/plugins/parsley/i18n/id.js") ?>"></script>
<script src="<?= base_url("template/vertical/plugins/parsley/default.js") ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    // Form
    $("form#FormFilter").on("submit", function(e) {
        e.preventDefault();
        let _ = $(this)
        $url = _.attr('action'),
        $data = _.serialize(),
        $method = _.attr('method');
        if (!this.checkValidity()) {
            e.preventDefault()
            e.stopPropagation()
        }
        this.classList.add('was-validated');

        $.ajax({
            url: $url,
            method: $method,
            data: $data,
            success: function(data) {
                if(data.status === true)
                {
                    window.location.href = data.redirect;
                }
            },
            error: function(err) {
                iziToast.error({
                    title: 'Error',
                    message: err.responseJSON.message || err.statusText,
                    position: 'topCenter'
                })
            }
        });
    });
    // options unit kerja
    $( 'select#unitkerja' ).select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        allowClear: true,
        // minimumInputLength: 2,
        minimumResultsForSearch: 10,
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
})
</script>
<?= $this->endSection(); ?>

<?= $this->section('style'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<?= $this->endSection(); ?>