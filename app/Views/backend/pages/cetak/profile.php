<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pegawai Negeri Sipil</title>
    <style>
        /* Reset and base styles */
        * {
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        h1, h2, h3, h4, h5 {
            margin: 0;
        }
        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #808080;
            padding: 10px;
        }
        table.no-border {
            border: none;
        }
        table.no-border > th, table.no-border > td {
            border: none;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .section-header {
            background-color: #f2fffc;
            font-weight: bold;
            text-align: center;
        }
        .section-sub-header {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }
        .signature {
            text-align: right;
            margin-left: 100mm;
        }

        /* Utility classes */
        /* Margin and Padding */
        .m-0 { margin: 0 !important; }
        .m-1 { margin: 0.25mm !important; }
        .m-2 { margin: 0.5mm !important; }
        .m-3 { margin: 1mm !important; }
        .m-4 { margin: 1.5mm !important; }
        .m-5 { margin: 3mm !important; }

        .mt-0 { margin-top: 0 !important; }
        .mt-1 { margin-top: 0.25mm !important; }
        .mt-2 { margin-top: 0.5mm !important; }
        .mt-3 { margin-top: 1mm !important; }
        .mt-4 { margin-top: 1.5mm !important; }
        .mt-5 { margin-top: 3mm !important; }

        .mb-0 { margin-bottom: 0 !important; }
        .mb-1 { margin-bottom: 0.25mm !important; }
        .mb-2 { margin-bottom: 0.5mm !important; }
        .mb-3 { margin-bottom: 1mm !important; }
        .mb-4 { margin-bottom: 1.5mm !important; }
        .mb-5 { margin-bottom: 3mm !important; }

        .p-0 { padding: 0 !important; }
        .p-1 { padding: 0.25mm !important; }
        .p-2 { padding: 0.5mm !important; }
        .p-3 { padding: 1mm !important; }
        .p-4 { padding: 1.5mm !important; }
        .p-5 { padding: 3mm !important; }

        /* Text alignment */
        .text-left { text-align: left !important; }
        .text-center { text-align: center !important; }
        .text-right { text-align: right !important; }

        /* New Vertical Alignment Utilities */
        .align-baseline { vertical-align: baseline !important; }
        .align-top { vertical-align: top !important; }
        .align-middle { vertical-align: middle !important; }
        .align-bottom { vertical-align: bottom !important; }
        .align-text-top { vertical-align: text-top !important; }
        .align-text-bottom { vertical-align: text-bottom !important; }

        /* Additional utilities for flex items */
        .align-self-start { align-self: flex-start !important; }
        .align-self-center { align-self: center !important; }
        .align-self-end { align-self: flex-end !important; }
        .align-self-baseline { align-self: baseline !important; }
        .align-self-stretch { align-self: stretch !important; }

        /* Font weight */
        .font-weight-normal { font-weight: normal !important; }
        .font-weight-bold { font-weight: bold !important; }

        /* Display */
        .d-none { display: none !important; }
        .d-inline { display: inline !important; }
        .d-inline-block { display: inline-block !important; }
        .d-block { display: block !important; }

        /* Flexbox */
        .d-flex { display: flex !important; }
        .flex-row { flex-direction: row !important; }
        .flex-column { flex-direction: column !important; }
        .justify-content-start { justify-content: flex-start !important; }
        .justify-content-center { justify-content: center !important; }
        .justify-content-end { justify-content: flex-end !important; }
        .align-items-start { align-items: flex-start !important; }
        .align-items-center { align-items: center !important; }
        .align-items-end { align-items: flex-end !important; }

        /* Width and Height */
        .w-100 { width: 100% !important; }
        .h-100 { height: 100% !important; }

        /* Background and Text colors */
        .bg-light { background-color: #f8f9fa !important; }
        .bg-dark { background-color: #343a40 !important; }
        .text-muted { color: #6c757d !important; }

    </style>
</head>
<body>
    <br/>
    <table>
        <tr>
            <td width="80%" class="text-center">
                <div class="text-center m-0 p-0">
                    <img src="/assets/images/app/logo.png" width="30" alt="Logo Balangan">
                    <br class="m-0 p-0">
                    <span class="font-weight-bold">PROFIL PEGAWAI</span>
                    <br class="m-0 p-0"> 
                    <span class="font-weight-bold"><?= strtoupper($row->nama_desa); ?> KABUPATEN BALANGAN </span>
                    <div class="text-center p-0 m-0 text-muted"><?= $row->alamat; ?></div>
                </div>
            </td>
            <td width="20%" class="text-center">
                <img src="/assets/images/users/<?= $row->photo; ?>" width="100" height="100" alt="<?= $row->nama; ?>">
            </td>
        </tr>
    </table>
    
    <table>
        <tr class="section-header">
            <td colspan="4">DATA PRIBADI</td>
        </tr>
        <tr>
            <td>NIPD</td>
            <td>: <?= $row->nipd; ?></td>
            <td width="10%">NIK</td>
            <td width="auto">: <?= $row->nik; ?></td>
        </tr>
        <tr>
            <td>Nama</td>
            <td colspan="3" width="75%">: <?= $row->nama; ?></td>
        </tr>
        <tr>
            <td>Gelar Depan</td>
            <td>: <?= isNull(@$row->gelar_depan); ?></td>
            <td width="20%">Gelar Belakang</td>
            <td width="auto">: <?= isNull(@$row->gelar_blk); ?></td>
        </tr>
        <tr>
            <td>Tempat, Tanggal Lahir</td>
            <td colspan="3" width="75%">: <?= $row->tmp_lahir; ?>, <?= date_indo($row->tgl_lahir); ?></td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td colspan="3">: <?= ucword($row->jns_kelamin); ?></td>
        </tr>
        <tr>
            <td>Agama</td>
            <td colspan="3">: <?= ucword($row->nama_agama); ?></td>
        </tr>
        <tr>
            <td>Status Perkawinan</td>
            <td colspan="3">: <?= ucword($row->nama_status_kawin); ?></td>
        </tr>
        <?php  
        $jabatan = db_connect()->table('riwayat_jabatan')
        ->join('ref_jabatan', 'riwayat_jabatan.fid_jabatan=ref_jabatan.id', 'left')
        ->where('fid_jabatan', $row->fid_jabatan)
        ->limit(1)
        ->orderBy('riwayat_jabatan.id', 'DESC')
        ->get()
        ->getRow();
        ?>
        <tr>
            <td>Jabatan Terakhir (**)</td>
            <td colspan="3">: <?= ucword(isNull(@$jabatan->nama_jabatan)); ?> / <?= isNull(@$jabatan->jenis); ?></td>
        </tr>
        <tr>
            <td>TMT Mulai</td>
            <td>: <?= @date_indo($jabatan->tmt_mulai); ?></td>
            <td width="15%">TMT Selesai</td>
            <td width="auto">: <?= @date_indo($jabatan->tmt_selesai); ?></td>
        </tr>
        <tr>
            <td>No. Telp/HP</td>
            <td colspan="3" width="auto">: <?= isNull($row->no_hp); ?></td>
        </tr>
        <tr>
            <td>Email</td>
            <td colspan="3">: <?= isNull($row->email); ?></td>
        </tr>
        <tr>
            <td>No. Telpon Rumah</td>
            <td colspan="3">: <?= isNull($row->no_telp_rumah); ?></td>
        </tr>
        <tr>
            <td>No. BPJS Kesehatan</td>
            <td colspan="3">: <?= isNull($row->no_bpjs_kesehatan); ?></td>
        </tr>
        <tr>
            <td width="30%">No. BPJS Ketenagakerjaan</td>
            <td colspan="3">: <?= isNull($row->no_bpjs_ketenagakerjaan); ?></td>
        </tr>
        <tr>
            <td width="25%">Npwp</td>
            <td colspan="3">: <?= isNull($row->no_npwp); ?></td>
        </tr>
        <tr>
            <td>Alamat Rumah</td>
            <td colspan="3">: <?= ucword(isNull($row->alamat)); ?></td>
        </tr>
    </table>
    
    <?php  
    $keluarga = db_connect()->table('riwayat_sutri')
    ->where('nik', $row->nik)
    ->orderBy('id', 'DESC')
    ->limit(1)
    ->get()
    ->getRow();
    ?>
    <?php if($keluarga !== null): ?>
    <table>
        <thead>
            <tr class="section-header">
                <th colspan="3">KETERANGAN KELUARGA</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td width="25%">Nomor Kartu Keluarga</td>
                <td colspan="2" width="75%">: <?= $row->no_kk; ?></td>
            </tr>
            <tr>
                <td>Nama <?= $row->jns_kelamin === "PRIA" ? "Istri" : "Suami"; ?></td>
                <td>: <?= $keluarga->nama_sutri; ?></td>
                <td width="10%" class="text-right">Status</td>
                <td>: <?= isNull(ucword($keluarga->status_kawin)); ?></td>
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td colspan="2" width="75%">: <?= $keluarga->pekerjaan; ?></td>
            </tr>
            <tr>
                <td>NIPD <?= $row->jns_kelamin === "PRIA" ? "Istri" : "Suami"; ?></td>
                <td colspan="2" width="75%">: <?= isNull($keluarga->nip_sutri); ?></td>
            </tr>
            <tr>
                <td>Status Hidup</td>
                <td width="25%">: <?= isNull(ucword($keluarga->status_hidup)); ?></td>
                <td width="25%" class="text-right">Status Tanggungan</td>
                <td>: <?= isNull(ucword($keluarga->tanggungan)); ?></td>
            </tr>
        </tbody>
    </table>
    <?php endif; ?>

    <?php  
    $sutri = db_connect()->table('riwayat_sutri')->select('nik,nip_sutri,sutri_ke')->where('nik', $row->nik)->get()->getRow();

    $rwy_anak = db_connect()->table('riwayat_anak ra')
    ->select('ra.id,ra.nik,ra.nama_anak,ra.fid_sutri_ke,ra.jns_kelamin,ra.tmp_lahir,ra.tgl_lahir,ra.status,ra.status_hidup,ra.tanggungan,rs.nama_sutri')
    ->join('riwayat_sutri rs', 'ra.fid_sutri_ke=rs.sutri_ke', 'left')
    ->where('rs.nik', $row->nik)
    ->groupStart()
        ->where('ra.nik', @$sutri->nip_sutri)
        ->orWhere('ra.nik', @$sutri->nik)
    ->groupEnd()
    ->get()
    ->getResult();
    // dd($rwy_anak)
    ?>
    <?php if(count($rwy_anak) !== 0): ?>
    <table>
        <thead>
            <tr class="section-header">
                <td colspan="4">RIWAYAT ANAK</td>
            </tr>
        </thead>
        <tbody>
            <tr class="section-sub-header">
                <th width="5%">No.</th>
                <th>Nama Lengkap</th>
                <th>Nama <?= $row->jns_kelamin === "PRIA" ? "Ibu" : "Bapak"; ?></th>
                <th>Jenis Kelamin</th>
                <th>Status Anak</th>
            </tr>
            <?php $no=1; foreach ($rwy_anak as $a): ?>
            <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td><?= isNull(ucword($a->nama_anak)); ?></td>
                <td><?= isNull(ucword($a->nama_sutri)); ?></td>
                <td><?= isNull(ucword($a->jns_kelamin)); ?></td>
                <td><?= isNull(ucword($a->status)); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
    <?php  
    $rwy_pendidikan = db_connect()->table('riwayat_pendidikan rp')
    ->select('rp.nama_sekolah,rp.thn_lulus,rp.berkas,tp.nama_tingkat_pendidikan,jp.nama_jurusan_pendidikan')
    ->join('ref_tingkat_pendidikan tp', 'rp.fid_tingkat=tp.id_tingkat_pendidikan')
    ->join('ref_jurusan_pendidikan jp', 'rp.fid_jurusan=jp.id_jurusan_pendidikan')
    ->where('rp.nik', $row->nik)
    ->orderBy('rp.thn_lulus,tp.nama_tingkat_pendidikan', 'desc')
    ->get()
    ->getResult();
    ?>
    <?php if(count($rwy_pendidikan) !== 0): ?>
    <table>
        <tr class="section-header">
            <td colspan="4">RIWAYAT PENDIDIKAN</td>
        </tr>
        <tr class="section-sub-header">
            <th width="5%" class="align-self-center">No.</th>
            <th width="10%">Tahun Lulus</th>
            <th width="10%">Jenjang</th>
            <th width="35%">Jurusan</th>
            <th width="40%">Institusi Pendidikan</th>
        </tr>
        <?php $no=1; foreach ($rwy_pendidikan as $p): ?>
        <tr>
            <td class="text-center"><?= $no++; ?></td>
            <td class="text-center"><?= $p->thn_lulus; ?></td>
            <td class="text-center"><?= $p->nama_tingkat_pendidikan; ?></td>
            <td><?= isNull(ucword($p->nama_jurusan_pendidikan)); ?></td>
            <td><?= $p->nama_sekolah; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    <?php  
    $rwy_jabatan = db_connect()->table('riwayat_jabatan rj')
    ->select('rj.id, rj.nik, rj.tmt_mulai, rj.tmt_selesai, rj.tgl_pelantikan, rj.pejabat_sk, rj.tgl_sk, rj.no_sk, rj.berkas, 
    u.nama_unit_kerja, ref_jab.nama_jabatan, ref_jab.jenis, ref_jab.usia_bup')
    ->join('ref_jabatan ref_jab', 'rj.fid_jabatan=ref_jab.id')
    ->join('ref_unit_kerja u', 'rj.fid_unit_kerja=u.id_unit_kerja')
    ->where('rj.nik', $row->nik)
    ->orderBy('rj.created_at', 'desc')
    ->get()
    ->getResult();
    ?>
    <?php if(count($rwy_jabatan) !== 0): ?>
    <table>
        <thead>
            <tr class="section-header">
                <td colspan="4">RIWAYAT JABATAN</td>
            </tr>
        </thead>
        <tbody>
            <tr class="section-sub-header">
                <th width="5%">No.</th>
                <th>Jabatan</th>
                <th width="15%">Jenis</th>
                <th>TMT</th>
                <th>Unit Kerja</th>
            </tr>
            <?php $no=1; foreach ($rwy_jabatan as $j): ?>
            <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td><?= isNull(ucword($j->nama_jabatan)); ?></td>
                <td class="text-center"><?= isNull($j->jenis); ?></td>
                <td class="text-center"><?= isNull(date_indo($j->tmt_mulai)); ?></td>
                <td><?= isNull($j->nama_unit_kerja); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
    <?php  
    $ttd = model("PegawaiModel");
    ?>
    <table class="no-border">
        <tr>
            <td></td>
            <td class="text-center">
            <?php if($row->jenis === 'BPD'): ?>
            <div> 
                <?php $kabpd = $ttd->getDetailPegawaiByJabatanId(8)->getRow(); ?>
                Paringin, <?= date_indo(date('Y-m-d')); ?>
                <br>
                Mengesahkan, <br> <span class="font-weight-bold">KETUA BPD</span>
                <p></p>
                <u class="font-weight-bold"><?= namalengkap($kabpd->gelar_depan,$kabpd->nama,$kabpd->gelar_blk); ?></u> <br/>
                NIPD. <?= $kabpd->nipd; ?>
            </div>
            <?php else: ?>
            <div>
            <?php $kades = $ttd->getDetailPegawaiByJabatanId(1)->getRow(); ?>
                Paringin, <?= date_indo(date('Y-m-d')); ?>
                <br>
                Mengesahkan, <br><span class="font-weight-bold"> KEPALA DESA</span>
                <p></p>
                <u class="font-weight-bold"><?= namalengkap(@$kades->gelar_depan,@$kades->nama,@$kades->gelar_blk); ?></u>
                <br>
                NIPD. <?= isNull(@$kades->nipd); ?>
            </div>
            <?php endif; ?>
            </td>
        </tr>
    </table>
    
</body>
</html>