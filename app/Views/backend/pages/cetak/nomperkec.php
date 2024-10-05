<?= $this->extend('backend/layouts/app'); ?>

<?= $this->section('content'); ?>
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Nominatif</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('/') ?>"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">By Kecamatan</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="row">
    <div class="col-md-4">  
        <div class="card">
            <div class="card-header p-3 pb-2 bg-light-primary">
                <div class="card-title">
                    <h5>Nominatif Per Kecamatan</h5>
                </div>
            </div>
            <div class="card-body">
                <?= form_open(base_url('nominatif/nomperkec'), ['id' => 'FormFilter', 'target' => '_blank', 'novalidate' => '', "data-parsley-validate" => ""]); ?>
                        <div class="row g-3">
                            <div class="col-12">
                                <?php  
                                $tahun = db_connect()->table('pegawai')
                                ->select('YEAR(created_at) as year')
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
                                        $selected = $thn->year === date("Y") ? "selected" : "";
                                    ?>
                                        <option value="<?= $thn->year; ?>" <?= $selected; ?>><?= $thn->year; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-12">
                                <?php  
                                $kecamatan = db_connect()->table('ref_kecamatan')->get()->getResult();
                                ?>
                                <label for="kecamatan" class="form-label fw-bold">Pilih Kecamatan <span class="text-danger">*</span></label>
                                <select class="form-select" name="kecamatan" id="kecamatan"
                                    required>
                                    <option value="">-- Pilih Kecamatan --</option>
                                    <?php 
                                        foreach($kecamatan as $k): 
                                            $selected = $k->id_kecamatan === session()->id_kecamatan ? "selected" : "";
                                    ?>
                                        <option value="<?= $k->id_kecamatan; ?>" <?= $selected; ?>><?= $k->nama_kecamatan; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="jenis" class="form-label">Pilih Jenis Pegawai <span class="text-danger">*</span></label>
                                <!-- <?php //if(session()->role === 'OPERATOR' || session()->role === 'USER'): ?>
                                    <select class="form-select" name="jenis" id="jenis" data-placeholder="Pilih Pegawai" required>
                                        <option value="">Pilih Pegawai</option>
                                        <option value="<?= session()->jenis_jabatan; ?>" selected><?= session()->jenis_jabatan; ?></option>
                                    </select>
                                <?php //else: ?> -->
                                <select class="form-select" name="jenis" id="jenis" data-placeholder="Pilih Pegawai" required>
                                    <option value="">Pilih Pegawai</option>
                                    <option value="PEMDES" <?= session()->jenis_jabatan === "PEMDES" ? 'selected' : ''; ?>>PEMDES</option>
                                    <option value="BPD" <?= session()->jenis_jabatan === "BPD" ? 'selected' : ''; ?>>BPD</option>
                                </select>
                                <!-- <?php //endif; ?> -->
                            </div>
                        </div>
                        <div class="d-grid g-3 mt-3">
                            <button type="submit" id="submit" class="btn btn-primary"><i class="bx bx-save"></i> <br> Pilih</button>
                        </div>
                <?= form_close(); ?>
            </div>
        </div>
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
<!-- ex: css -->
<?= $this->section('style'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<?= $this->endSection(); ?>