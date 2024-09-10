<?= $this->extend("backend/layouts/app"); ?>

<?= $this->section('content'); ?>
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Master</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('/') ?>"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?= base_url('/app/master/jabatan') ?>">Jabatan</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= ucwords(strtolower($data->nama_jabatan)) ?></li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card col-md-6">
        <div class="card-body d-flex flex-column justify-content-start align-items-start gap-3">
            <div class="col-12">
                <label for="nama_jabatan" class="form-label fw-bold">Nama Jabatan <span class="text-danger">*</span></label>
                <div class="position-relative input-icon">
                    <input type="text" name="nama_jabatan" value="<?= $data->nama_jabatan ?>" class="form-control" id="nama_jabatan" placeholder="Nama Jabatan" required>
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
                        <?= $data->jenis === 'PEMDES' ? 'checked' : '' ?>
                        data-parsley-errors-container="#errorJenisJabatan" 
                        data-parsley-error-message="Pilih Jenis Jabatan"
                        required>
                        <label class="form-check-label" for="PEMDES">PEMDES</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jenis" id="BPD" value="BPD" 
                        <?= $data->jenis === 'BPD' ? 'checked' : '' ?>
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
                    value="<?= number_format($data->gaji, 0, ",", ".") ?>"
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
                    value="<?= number_format($data->tunjangan, 0, ",", ".") ?>"
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
                <input type="number" name="bup" class="form-control" id="bup" placeholder="Usia Bup"  
                value="<?= $data->usia_bup ?>"
                required>
            </div>
        </div>
        <div class="card-footer">
            <button type="button" class="btn btn-danger" onClick="window.history.back(-1)">Batal</button>
            <button type="submit" class="btn btn-primary"><i class="bx bx-save"></i> Simpan</button>
        </div>
    </div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script src="<?= base_url("assets/js/rupiah_helper.js") ?>"></script>
<?= $this->endSection(); ?>