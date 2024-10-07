<?= $this->extend('backend/layouts/app'); ?>
<?= $this->section('content'); ?>
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Pembayaran</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('/') ?>"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('pembayaran/tunjangan') ?>">Tunjangan</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $unor->nama_unit_kerja; ?></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= bulan($request['bulan']); ?></li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="card">
        <div class="card-body">
            <div class="container">
                <h4 class="text-center mb-4">TANDA TERIMA <br> TUNJANGAN <?= $request['jenis_pegawai'] === "BPD" ? "KEDUDUKAN BPD" : "KEPALA DESA & PERANGKAT DAERAH"; ?><br>TAHUN 2024</h4>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td width="50%">
                                <p><strong>DESA / UNIT KERJA</strong> <br><?= strtoupper($unor->nama_unit_kerja); ?></p>
                            </td>
                            <td>
                                <p><strong>KECAMATAN</strong><br> <?= $unor->nama_kecamatan; ?></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p><strong>KABUPATEN</strong><br> BALANGAN</p>
                            </td>
                            <td>
                                <p><strong>BULAN</strong><br> <?= strtoupper(bulan($request['bulan'])); ?></p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="table-responsive"> 
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>NO</th>
                                <th>NAMA</th>
                                <th>JABATAN</th>
                                <th>JUMLAH BULAN</th>
                                <th>SATUAN</th>
                                <th>JUMLAH BRUTO</th>
                                <th>PPh 21</th>
                                <th>JUMLAH BERSIH</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $no=1;
                                $total_bulan = 0; 
                                $total_pph21 = 0;
                                $total_bersih = 0;
                                foreach ($pegawai as $p): 
                            ?>
                            <tr>
                                <td class="text-center"><?= $no; ?></td>
                                <td><?= namalengkap($p->gelar_depan,$p->nama,$p->gelar_blk); ?></td>
                                <td><?= $p->nama_jabatan; ?></td>
                                <td class="text-center"><?= $p->jumlah_bulan; ?></td>
                                <td><div class="d-flex justify-content-between align-items-center"><span>Rp.</span> <?= substr(number_to_currency($p->tunjangan, "IDR", "id_ID"),2); ?></div></td>
                                <td><div class="d-flex justify-content-between align-items-center"><span>Rp.</span> <?= substr(number_to_currency($p->tunjangan * $p->jumlah_bulan, "IDR", "id_ID"),2); ?></div></td>
                                <td><div class="d-flex justify-content-between align-items-center"><span>Rp.</span> <?= substr(number_to_currency($p->pph21, "IDR", "id_ID"),2); ?></div></td>
                                <td><div class="d-flex justify-content-between align-items-center"><span>Rp.</span> <?= substr(number_to_currency(($p->tunjangan * $p->jumlah_bulan) - $p->pph21, "IDR", "id_ID"),2); ?></div></td>
                            </tr>
                            <?php
                                $total_bulan += $p->jumlah_bulan; 
                                $total_pph21 += $p->pph21;
                                $total_bersih += ($p->tunjangan * $p->jumlah_bulan) - $p->pph21;
                                $no++; 
                                endforeach; ?>
                            <tr>
                                <td colspan="3" class="text-center"><strong>Jumlah</strong></td>
                                <td class="text-center"><?= $total_bulan; ?></td>
                                <td></td>
                                <td></td>
                                <td><div class="d-flex justify-content-between align-items-center"><span>Rp.</span> <?= substr(number_to_currency($total_pph21, "IDR", "id_ID"),2); ?></div></td>
                                <td><div class="d-flex justify-content-between align-items-center"><span>Rp.</span> <?= substr(number_to_currency($total_bersih, "IDR", "id_ID"),2); ?></div></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-start align-items-center">
                    <button type="button" class="btn btn-sm btn-danger" onClick="window.history.back()"><i class="bx bx-left-arrow-alt"></i> Batal</button>
                    <?php if(count($pegawai) > 0): ?>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#cetak-tunjangan" class="btn btn-sm btn-primary ms-auto"><i class="bx bx-printer"></i> Cetak Tanda Terima</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection(); ?>
<?= $this->section('modal'); ?>
<!-- Modal Cetak Perhitungan Tunjangan-->
<div class="modal fade" id="cetak-tunjangan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <?= form_open(base_url('pembayaran/cetak'), 
        ['class' => 'modal-content needs-validation',"target"=>"_blank","data-parsley-validate" => "", 'id' => 'FormAdd', 'novalidate' => '', 'autocomplete' => 'off'],
        ['unit' => $unor->id_unit_kerja, 'bulan' => $request['bulan'], 'jns_pegawai' => $request['jenis_pegawai']]); ?>
            <div class="modal-header">
                <h5 class="modal-title">SPESIMEN</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex flex-column justify-content-start align-items-start gap-3">
                <div class="col-12">
                    <?php  
                    $ttd_kepala = db_connect()->table('pegawai p')
                    ->select('p.nama,p.nik,p.nipd,j.nama_jabatan,u.nama_unit_kerja')
                    ->join('ref_jabatan j', 'p.fid_jabatan=j.id')
                    ->join('ref_unit_kerja u', 'p.fid_unit_kerja=u.id_unit_kerja')
                    ->when([session()->role, $unor->id_unit_kerja], function($query, $role) {
                        if($role[0] === 'OPERATOR') {
                            $query->where('p.fid_unit_kerja', session()->id_unit_kerja);
                        }
                        if($role[0] === 'USER') {
                            $query->where('p.fid_unit_kerja', $role[1]);
                        }
                    })
                    ->whereIn('j.nama_jabatan', ['KETUA','WAKIL KETUA','KEPALA DESA','SEKRETARIS DESA'])
                    ->orderBy('j.id_atasan', 'asc')
                    ->get()
                    ->getResult();
                    ?>
                    <label for="approve" class="form-label fw-bold">Mengetahui/Menyetujui <span class="text-danger">*</span></label>
                    <select class="form-select" name="approve" id="approve"
                        required>
                        <option value="">-- Pilih Kepala --</option>
                        <?php foreach($ttd_kepala as $kepala): ?>
                            <option value="<?= $kepala->nik; ?>"><?= $kepala->nipd; ?> - <?= $kepala->nama; ?> - <?= $kepala->nama_jabatan; ?> - <?= $kepala->nama_unit_kerja; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12">
                    <?php  
                    $ttd_bendahara = db_connect()->table('pegawai p')
                    ->select('p.nama,p.nik,p.nipd,j.nama_jabatan,u.nama_unit_kerja')
                    ->join('ref_jabatan j', 'p.fid_jabatan=j.id')
                    ->join('ref_unit_kerja u', 'p.fid_unit_kerja=u.id_unit_kerja')
                    ->when([session()->role, $unor->id_unit_kerja], function($query, $role) {
                        if($role[0] === 'OPERATOR') {
                            $query->where('p.fid_unit_kerja', session()->id_unit_kerja);
                        }
                        if($role[0] === 'USER') {
                            $query->where('p.fid_unit_kerja', $role[1]);
                        }
                    })
                    ->whereIn('j.nama_jabatan', ['KEPALA URUSAN KEUANGAN'])
                    ->get()
                    ->getResult();
                    ?>
                    <label for="bendahara" class="form-label fw-bold">Kaur Keuangan <span class="text-danger">*</span></label>
                    <select class="form-select" name="bendahara" id="bendahara"
                        required>
                        <option value="">-- Pilih Bendahara --</option>
                        <?php foreach($ttd_bendahara as $kepala): ?>
                            <option value="<?= $kepala->nik; ?>"><?= $kepala->nipd; ?> - <?= $kepala->nama; ?> - <?= $kepala->nama_jabatan; ?> - <?= $kepala->nama_unit_kerja; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12">
                    <label for="tgl_cetak fw-bold">Tanggal Cetak <span class="text-danger">*</span></label>
                    <input type="date" name="tgl_cetak" class="form-control datepicker" value="<?= date("Y-m-d"); ?>" id="tgl_cetak" placeholder="Tanggal Cetak" required/>
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
<!-- Ex: script -->
<?= $this->section('script'); ?>
<script src="<?= base_url("template/vertical/plugins/parsley/parsley.min.js") ?>"></script>
<script src="<?= base_url("template/vertical/plugins/parsley/i18n/id.js") ?>"></script>
<script src="<?= base_url("template/vertical/plugins/parsley/default.js") ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
<?= $this->endSection(); ?>
<!-- Ex: css -->
<?= $this->section('style'); ?>
<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet" />
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    $(function(){
        $(".datepicker").flatpickr({
            altInput: true,
            altFormat: "j F Y",
            dateFormat: "Y-m-d",
            "locale": "id",
            static: true,
            monthSelectorType: 'static'
        });
    })
</script>
<?= $this->endSection(); ?>