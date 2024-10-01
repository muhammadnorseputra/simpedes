<?= $this->extend('backend/layouts/app'); ?>

<?= $this->section('content'); ?>
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Master</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('/') ?>"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('/app/master/pegawai') ?>">Pegawai</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Peremajaan Pegawai</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="card">
    <div class="card-header px-4 py-3">
        <h5 class="mb-0">Formulir Peremajaan Data Pegawai</h5>
      </div>
    <?= form_open_multipart(base_url('app/master/pegawai/peremajaan'), ['id' => 'FormStepAkun', 'class' => 'needs-validation', 'novalidate' => '', 'autocomplete' => 'off']); ?>
        <div class="card-body row">
          <div class="col-md-9">
            <?php if(@$default->status === 'VERIFIKASI' && session()->get('role') === 'ADMIN'): ?>
            <div class="col-md-12 image-user" style="z-index: 10">
                <div class="alert alert-warning border-0 bg-warning alert-dismissible fade show py-2">
                    <div class="d-flex align-items-center">
                        <div class="font-35 text-dark"><i class="bx bx-info-circle"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-0 text-dark">Perhatian</h6>
                            <div class="text-dark">Data belum diverifikasi, silahkan melakukan verifikasi.</div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php if(isset($default->ket_status) && $default->ket_status !== ""): ?>
            <div class="col-md-12 image-user" style="z-index: 10">
                <div class="alert alert-info border-0 bg-info alert-dismissible fade show py-2">
                    <div class="d-flex align-items-center">
                        <div class="font-35 text-dark"><i class="bx bx-info-circle"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-0 text-dark">Catatan</h6>
                            <div class="text-dark"><?= @$default->ket_status ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <!-- Start row -->
            <div class="row mb-4 gap-md-0 gap-3 border border-2 border-danger p-2 p-md-3 mx-0 shadow rounded">
                <div class="col-md-4">
                    <div class="form-floating">
                        <?php $disableNIK = @$default->nik !== null ? "readonly" : ""; ?>
                        <input type="number" name="nik" class="form-control" id="nik" placeholder="NIK" value="<?= @$default->nik ?>" <?= $disableNIK ?> required>
                        <label for="nik">Nomor Induk Kependudukan <span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="number" name="nipd" class="form-control" id="nipd" placeholder="NIPD" value="<?= @$default->nipd ?>" required>
                        <label for="nipd">Nomor Induk Pegawai <span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="number" name="no_kk" class="form-control" id="no_kk" placeholder="NOKK" value="<?= @$default->no_kk ?>" required>
                        <label for="no_kk">Nomor Kartu Keluarga <span class="text-danger">*</span></label>
                    </div>
                </div>
            </div>
            <!---end row-->
            <!-- Start row -->
            <div class="row mb-3 gap-md-0 gap-3">
                <div class="col-md-8">
                    <div class="form-floating">
                        <input type="text" name="nama" class="form-control" id="nama" value="<?= @$default->nama ?>" placeholder="Nama" required>
                        <label for="nama">Nama Tanpa Gelar <span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                    <?php  
                    $agama = $db->table('ref_agama')->get()->getResult();
                    ?>
                    <select class="form-select" name="agama" id="agama" aria-label="Floating label select example" required>
                        <option value="">Pilih Agama</option>
                        <?php 
                            foreach($agama as $a): 
                            $defaultSelectedAgama = @$default->fid_agama === $a->id_agama ? 'selected' : '';
                            ?>
                            <option value="<?= $a->id_agama ?>" <?= $defaultSelectedAgama ?>><?= $a->nama_agama ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="agama">Agama <span class="text-danger">*</span></label>
                    </div>
                </div>
                <!-- <div class="col-md-3">
                    <div class="form-floating">
                        <input type="text" name="gelar_depan" value="<?= @$default->gelar_depan ?>" class="form-control" id="gelar_depan" placeholder="Gelar Depan" required>
                        <label for="gelar_depan">Gelar Depan <span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="text" name="gelar_blk" value="<?= @$default->gelar_blk ?>" class="form-control" id="gelar_blk" placeholder="Gelar Belakang" required>
                        <label for="gelar_blk">Gelar Belakang <span class="text-danger">*</span></label>
                    </div>
                </div> -->
            </div>
            <!---end row-->
            <!-- Start row -->
            <div class="row mb-3 gap-md-0 gap-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" name="tmp_lahir" value="<?= @$default->tmp_lahir ?>" class="form-control" id="tmp_lahir" placeholder="tmp_lahir" required>
                        <label for="tmp_lahir">Tempat Lahir <span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="date" name="tgl_lahir" value="<?= @$default->tgl_lahir ?>" class="form-control datepicker" id="tgl_lahir" placeholder="tgl_lahir" required>
                        <label for="tgl_lahir">Tanggal Lahir <span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-md-3">
                  <div class="form-floating">
                    <select class="form-select" name="jns_kelamin" id="jns_kelamin" aria-label="Floating label select example" required >
                        <option value="" <?= @$default->jns_kelamin === null ? "selected" : ""; ?>>Pilih Jenis Kelamin</option>
                        <option value="PRIA" <?= @$default->jns_kelamin === "PRIA" ? "selected" : ""; ?>>PRIA</option>
                        <option value="WANITA" <?= @$default->jns_kelamin === "WANITA" ? "selected" : ""; ?>>WANITA</option>
                    </select>
                    <label for="jns_kelamin">Jenis Kelamin <span class="text-danger">*</span></label>
                  </div>
                </div>
            </div>
            <!---end row-->
            <!-- Start row -->
            <div class="row mb-3 gap-md-0 gap-3">
              <div class="col-md-6">
                <div class="form-floating">
                  <textarea class="form-control" name="alamat" placeholder="Masukan alamat lengkap disini." id="alamat" style="height: 115px" required><?= @$default->alamat ?></textarea>
                  <label for="alamat">Alamat Lengkap / Domisili <span class="text-danger">*</span></label>
                </div>
              </div>
              <div class="col-md-6">
                <?php $disableUnitKerja = @$default->status !== "ENTRI" && isset($_GET['token']) ? "disabled" : ""; ?>
                <?= @$default->status !== "ENTRI" ? '<input name="fid_unit_kerja" value="'.@$default->fid_unit_kerja.'" type="hidden"/>' : ""; ?>
                <div class="form-floating  mb-3">
                    <select class="form-select" name="fid_unit_kerja" id="unitkerja" data-placeholder="Pilih Unit Kerja" 
                    data-parsley-errors-container="#errorunitkerja"
                    data-parsley-error-message="Tidak Boleh Kosong"
                    required
                    <?= $disableUnitKerja; ?>
                    ></select>
                    <label for="unitkerja" class="form-label">Pilih Unit kerja <span class="text-danger">*</span></label>
                    <div id="errorunitkerja"></div>
                </div>
                <div class="form-floating">
                    <select class="form-select" name="fid_keldesa" id="desa" data-placeholder="Pilih Desa" 
                    data-parsley-errors-container="#errordesa"
                    data-parsley-error-message="Tidak Boleh Kosong"
                    required></select>
                    <label for="desa" class="form-label">Pilih Desa <span class="text-danger">*</span></label>
                    <div id="errordesa"></div>
                </div>
                <!-- <div class="form-floating">
                  <?php  
                  $statkaw = $db->table('ref_status_kawin')->get()->getResult();
                  ?>
                  <select class="form-select" name="fid_status_kawin" id="status_kawin" aria-label="Floating label select example" required>
                      <option value="">Pilih Status Kawin</option>
                      <?php 
                        foreach($statkaw as $sk): 
                        $defaultSelectedStatusKawin = @$default->fid_status_kawin === $sk->id_status_kawin ? 'selected' : '';
                        ?>
                        <option value="<?= $sk->id_status_kawin ?>" <?= $defaultSelectedStatusKawin ?>><?= $sk->nama_status_kawin ?></option>
                      <?php endforeach; ?>
                  </select>
                  <label for="status_kawin">Status Kawin <span class="text-danger">*</span></label>
                </div> -->
              </div>
            </div>
            <!---end row-->
            <div class="row mb-3 gap-md-0 gap-3">
              <div class="col-md-4">
                  <div class="form-floating">
                      <input type="text" name="no_telp_rumah" value="<?= @$default->no_telp_rumah ?>" class="form-control" id="no_telp_rumah" placeholder="Nomor Telpon Rumah">
                      <label for="no_telp_rumah">Nomor Telpon Rumah</label>
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="form-floating">
                      <input type="tel" name="no_hp" value="<?= @$default->no_hp ?>" class="form-control" id="no_hp" placeholder="Nomor Handphone" required>
                      <label for="no_hp">Nomor Handphone</label>
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="form-floating">
                      <input type="email" name="email" value="<?= @$default->email ?>" class="form-control" id="email" placeholder="Email" required>
                      <label for="email">Email</label>
                  </div>
              </div>
            </div>
            <!---end row-->
            <!-- Start row -->
            <div class="row mb-3 gap-md-0 gap-3">
              <div class="col-md-4">
                  <div class="form-floating">
                      <input type="text" name="no_bpjs_kesehatan" value="<?= @$default->no_bpjs_kesehatan ?>" class="form-control" id="no_bpjs_kesehatan" placeholder="Nomor BPJS Kesehatan">
                      <label for="no_bpjs_kesehatan">Nomor BPJS Kesehatan</label>
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="form-floating">
                      <input type="text" name="no_bpjs_ketenagakerjaan" value="<?= @$default->no_bpjs_ketenagakerjaan ?>" class="form-control" id="no_bpjs_ketenagakerjaan" placeholder="Nomor BPJS Ketenaga Kerjaan">
                      <label for="no_bpjs_ketenagakerjaan">Nomor BPJS Ketenaga Kerjaan</label>
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="form-floating">
                      <input type="text" name="no_npwp" value="<?= @$default->no_npwp ?>" class="form-control" id="no_npwp" placeholder="Nomor NPWP">
                      <label for="no_npwp">Nomor NPWP</label>
                  </div>
              </div>
            </div>
            <!---end row-->
          </div>
          <div class="col-md-3 order-first">

            <div class="card shadow-none border">
                <?php if(!isset($default->photo)): ?>
                <img id="preview" src="<?= base_url('assets/images/users/default.png') ?>" class="card-img-top" alt="MyPhoto">
                <?php else: ?>
                <img id="preview" src="<?= base_url('assets/images/users/'.@$default->photo) ?>" class="card-img-top" alt="<?= @$default->nik ?>">
                <?php endif; ?>
                <div class="card-body">
                    <h6 class="card-title cursor-pointer">Upload Gambar</h6>
                    <div class="clearfix">
                        <label for="formFile" class="form-label">Pilih File (.jpg) Max: 300kb</label>
                        <?php if(!isset($default->photo)): ?>
                        <input class="form-control" name="photo" type="file" id="formFile"
                        oninput="preview.src=window.URL.createObjectURL(this.files[0])"
                        accept="image/jpg" 
                        data-parsley-max-file-size="300" 
                        data-parsley-mime-type="image/jpg"
                        data-parsley-image-dimensions="150x150"
                        required>
                        <?php else: ?>
                        <input class="form-control" name="photo" type="file" id="formFile"
                        oninput="preview.src=window.URL.createObjectURL(this.files[0])"
                        accept="image/jpg" 
                        data-parsley-max-file-size="300" 
                        data-parsley-mime-type="image/jpg"
                        data-parsley-image-dimensions="150x150">
                        <?php endif; ?>
                    </div>
                </div>
                
                <?php if(@$default->status === 'ENTRI_ULANG'): ?>
                <div class="card-footer">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-danger" onclick="KirimDataPeremajaan('<?= dohash(@$default->nik) ?>')">Kirim Data Verifikasi <i class="bx bx-mail-send"></i></button>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <?php 
            // jika status data perlu di verifikasi
            if(@$default->status === 'VERIFIKASI' || @$default->status === 'AKTIF' || @$default->status === 'NON_AKTIF' || @$default->status === 'NON_AKTIF_NIK_DITOLAK' && session()->get('role') === 'ADMIN'): 
            ?>
            <table class="table table-bordered table-responsive">
                <tbody>
                    <tr>
                        <td>Status Pegawai</td>
                        <td><?= @$default->status ?></td>
                    </tr>
                    <tr>
                        <td>Diusulkan Oleh</td>
                        <td><?= @$default->created_by ?></td>
                    </tr>
                    <tr>
                        <td>Diusulkan Pada</td>
                        <td><?= @$default->created_at ?></td>
                    </tr>
                    <tr>
                        <td>Diperbaharui Oleh</td>
                        <td><?= @$default->updated_by ?></td>
                    </tr>
                    <tr>
                        <td>Diperbaharui Pada</td>
                        <td><?= @$default->updated_at ?></td>
                    </tr>
                </tbody>
            </table>
            <div class="d-grid gap-2 mb-3">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-verifikasi">Verifikasi Data Usul Pegawai <i class="bx bx-mail-send"></i></button>
            </div>
            <?php endif; ?>
          </div>
        </div>
        <?php if(@$default->status === 'ENTRI' || @$default->status === 'ENTRI_ULANG' || !isset($default->status)): ?>
        <div class="card-body border-top d-flex justify-content-between align-items-center">
            <button type="button" class="btn btn-danger" onclick="window.location.href = '<?= base_url('/app/master/pegawai') ?>'"><i class="bx bx-left-arrow-alt"></i>  Batal</button>
            <button type="submit" class="btn btn-success"><i class="bx bx-save"></i>  Simpan Data</button>
        </div>
        <?php endif; ?>
    <?= form_close(); ?>
    </div>    

<?= $this->endSection(); ?>

<!-- ex: parsley -->
<?= $this->section('script'); ?>
<script src="<?= base_url("template/vertical/plugins/parsley/parsley.min.js") ?>"></script>
<script src="<?= base_url("template/vertical/plugins/parsley/i18n/id.js") ?>"></script>
<script src="<?= base_url("template/vertical/plugins/parsley/default.js") ?>"></script>
<?= $this->endSection(); ?>

<?php 
// jika status data perlu di verifikasi
if(@$default->status === 'VERIFIKASI' || @$default->status === 'AKTIF' || @$default->status === 'NON_AKTIF' || @$default->status === 'NON_AKTIF_NIK_DITOLAK'): 
?>
<?= $this->section('modal'); ?>
<!-- Modal -->
<div class="modal fade" id="modal-verifikasi" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-body">
                <div class="card shadow-none">
                <?= form_open(base_url('app/master/pegawai/peremajaan'), ['class' => 'modal-content needs-validation', 'id' => 'FormVerifikasi', 'novalidate' => '', 'autocomplete' => 'off'], ['token' => dohash(@$default->nik)]); ?>
                    <div class="card-header px-4 py-3 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Hasil Verifikasi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="card-body">
                        <div class="form-floating mb-3">
                            <select class="form-select" name="status" id="status_verifikasi" aria-label="Floating label select example" required>
                                <option value="">Pilih Status Verifikasi</option>
                                <option value="ENTRI" <?= @$default->status === 'ENTRI' ? 'selected' : ''; ?>>ENTRI</option>
                                <option value="ENTRI_ULANG" <?= @$default->status === 'ENTRI_ULANG' ? 'selected' : ''; ?>>ENTRI ULANG</option>
                                <option value="AKTIF" <?= @$default->status === 'AKTIF' ? 'selected' : ''; ?>>AKTIF</option>
                                <option value="NON_AKTIF" <?= @$default->status === 'NON_AKTIF' ? 'selected' : ''; ?>>NON AKTIF</option>
                                <option value="NON_AKTIF_NIK_DITOLAK" <?= @$default->status === 'NON_AKTIF_NIK_DITOLAK' ? 'selected' : ''; ?>>NON AKTIF - NIK DITOLAK</option>
                            </select>
                            <label for="status_verifikasi">Status Verif <span class="text-danger">*</span></label>
                        </div>
                        <div class="form-floating">
                            <textarea class="form-control" name="ket_status" placeholder="Masukan keterangan status disini." id="ket_status" style="height: 130px"><?= @$default->ket_status ?></textarea>
                            <label for="ket_status">Keterangan (Opsional)</label>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Simpan Hasil Verifikasi</button>
                        </div>
                    </div>
                <?= form_close() ?>
            </div>
        </div>
        <?= form_close(); ?>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>

    let FORM_STEP_AKUN = $("form#FormStepAkun");
    let MODAL_VERIF = $("#modal-verifikasi");
    let FORM_VERIF_AKUN = $("form#FormVerifikasi");

    MODAL_VERIF.on('hidden.bs.modal', (event) => {
       FORM_VERIF_AKUN[0].reset();
       FORM_VERIF_AKUN.parsley().reset();
    })

    FORM_STEP_AKUN.find("input,select,textarea").not("select#status_verifikasi, textarea#ket_status, input[name='<?= csrf_token() ?>']").prop("disabled", true);

    FORM_VERIF_AKUN.on("submit", function(e) {
        e.preventDefault()
        let _ = $(this);
        _.parsley({
            trigger: 'change'
        }).validate();

        if(_.parsley().isValid()) {
            $url = _.attr('action'),
            $method = _.attr('method');
            $data = _.serializeArray().concat({ name: "_method", value: "PATCH" });
            $.ajax({
                url: $url,
                method: "POST",
                data: $data,
                cache: false,
                dataType: "json",
                beforeSend: () => {
                    _.find("button[type='submit']").html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`).prop("disabled", true);
                },
                success: (res) => {
                    if (res.statusCode === 200) {
                        iziToast.success({
                            message: res.message,
                            position: 'topCenter',
                            onClosing: () => {
                            _.parsley().reset();
                            window.location.href = res.redirect;
                            }
                        });
                        _.find("button[type='submit']").html(`Simpan Hasil Verifikasi`).prop("disabled", false)
                        return false;
                    } 

                    iziToast.warning({
                        message: res.message,
                        position: 'topCenter'
                    });
                    _.find("button[type='submit']").html(`Simpan Hasil Verifikasi`).prop("disabled", false)
                },
                error: (err) => {
                    iziToast.error({
                        message: err.statusText,
                        position: 'topCenter'
                    });
                    _.find("button[type='submit']").html(`Simpan Hasil Verifikasi`).prop("disabled", false)
                }
            })
        }
    });

</script>
<?= $this->endSection(); ?>
<?php 
endif; 
?>

<?= $this->section('script'); ?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
$(document).ready(function() {
  
  let FORM_STEP_AKUN = $("form#FormStepAkun");

  $(".datepicker").flatpickr({
    dateFormat: "Y-m-d",
  });

  FORM_STEP_AKUN.on("submit", function(e) {
        e.preventDefault()
        let _ = $(this);
        _.parsley({
            trigger: 'change'
        }).validate();

        if(_.parsley().isValid()) {
            $url = _.attr('action'),
            $method = _.attr('method');

            $.ajax({
                url: $url,
                method: $method,
                data: new FormData(this),
                processData: false,
                contentType: false,
                cache: false,
                dataType: "json",
                beforeSend: () => {
                    _.find("button[type='submit']").html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`).prop("disabled", true);
                },
                success: (res) => {
                    if (res.statusCode === 201) {
                        iziToast.success({
                            message: res.message,
                            position: 'topCenter',
                            onClosing: () => {
                                _.parsley().reset();
                                window.location.href = res.redirect;
                            }
                        });
                        _.find("button[type='submit']").html(`<i class="bx bx-save"></i>  Simpan`).prop("disabled", false)
                        return false;
                    } 

                    if (res.statusCode === 200) {
                        iziToast.success({
                            message: res.message,
                            position: 'topCenter',
                            onClosing: () => {
                            _.parsley().reset();
                            window.location.reload();
                            }
                        });
                        _.find("button[type='submit']").html(`<i class="bx bx-save"></i>  Simpan`).prop("disabled", false)
                        return false;
                    } 

                    iziToast.warning({
                        message: res.message,
                        position: 'topCenter'
                    });
                    _.find("button[type='submit']").html(`<i class="bx bx-save"></i>  Simpan`).prop("disabled", false)
                },
                error: (err) => {
                    iziToast.error({
                        message: err.responseJSON.message || err.statusText,
                        position: 'topCenter'
                    });
                    _.find("button[type='submit']").html(`<i class="bx bx-save"></i>  Simpan`).prop("disabled", false)
                }
            })
        }
    });

    // options kelurahan / desa
    $( 'select#desa' ).select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        selectionCssClass: 'select2--large',
        dropdownCssClass: 'select2--large',
        minimumInputLength: 4,
        allowClear: true,
        ajax: { 
          url: "<?= base_url('select2/desa')?>",
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

    let defaultDesaOption = new Option('<?= @$desa->getFirstRow()->nama_desa ?>', '<?= @$desa->getFirstRow()->id_desa ?>', false, false);
    $( 'select#desa' ).append(defaultDesaOption).trigger('change');

    // options unit kerja
    $( 'select#unitkerja' ).select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        selectionCssClass: 'select2--large',
        dropdownCssClass: 'select2--large',
        minimumInputLength: 4,
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
    let defaultUnitKerjaOption = new Option('<?= @$unit_kerja->getFirstRow()->nama_unit_kerja ?>', '<?= @$unit_kerja->getFirstRow()->id_unit_kerja ?>', false, false);
    $( 'select#unitkerja' ).append(defaultUnitKerjaOption).trigger('change');

});

// kirim data untuk verifikasi admin
function KirimDataPeremajaan(token) {
    $.confirm({
		title: 'Verifikasi & Validasi',
		content: 'Apakah anda yakin akan data tersebut sudah valid ?',
		type: 'orange',
		theme: 'material',
		buttons: {
			yakin: {
				text: '<i class="bx bx-check"></i> Yakin',
				btnClass: 'btn-lg btn-success',
				action: function () {
                    // CSRF Hash
                    var csrfName = '<?= csrf_token() ?>'; // CSRF Token name
                    var csrfHash = '<?= csrf_hash() ?>'; // CSRF hash

                    $data = {
                        token,
                        [csrfName]: csrfHash,
                        _method: 'PUT'
                    };
                    $.post(`${origin}/app/master/pegawai/peremajaan`, $data,
						function (res) {
							if (res.statusCode === 200) {
								iziToast.success({
									position: 'topCenter',
									message: res.message,
                                    onClosing: () => {
                                        window.location.reload()
                                    }
								});
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
                            position: 'topCenter',
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
<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet" />
<style>
    .image-user {
        position: sticky;
        top: 70px; 
    }
    
    @media only screen and (max-width: 320px) {
        .image-user {top: 0}
    }
</style>
<?= $this->endSection(); ?>