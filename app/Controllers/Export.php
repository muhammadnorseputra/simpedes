<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Export extends BaseController
{
    public function excel()
    {   
        $pegawai = model('PegawaiModel');
        $data = $pegawai->select('p.*,j.nama_jabatan,u.nama_unit_kerja,a.nama_agama,d.nama_desa as desa_domisili,sk.nama_status_kawin')
        ->join('ref_jabatan j', 'fid_jabatan=j.id', 'left')
        ->join('ref_unit_kerja u', 'fid_unit_kerja=u.id_unit_kerja', 'left')
        ->join('ref_agama a', 'fid_agama=a.id_agama', 'left')
        ->join('ref_desa d', 'fid_keldesa=d.id_desa', 'left')
        ->join('ref_status_kawin sk', 'fid_status_kawin=sk.id_status_kawin', 'left')
        ->findAll();
        // dd($data);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->setActiveSheetIndex(0);
        $sheet->setCellValue('A1', 'NO')
        ->setCellValue('B1', 'NIK')
        ->setCellValue('C1', 'NO. KK')
        ->setCellValue('D1', 'NIPD')
        ->setCellValue('E1', 'NAMA')
        ->setCellValue('F1', 'GELAR DEPAN')
        ->setCellValue('G1', 'GELAR BELAKANG')
        ->setCellValue('H1', 'TEMPAT LAHIR')
        ->setCellValue('I1', 'TANGGAL LAHIR')
        ->setCellValue('J1', 'JENIS KELAMIN')
        ->setCellValue('K1', 'JABATAN')
        ->setCellValue('L1', 'UNIT KERJA')
        ->setCellValue('M1', 'AGAMA')
        ->setCellValue('N1', 'ALAMAT')
        ->setCellValue('O1', 'DESA DOMISILI')
        ->setCellValue('P1', 'NO. TELP RUMAH')
        ->setCellValue('Q1', 'NO. HP')
        ->setCellValue('R1', 'EMAIL')
        ->setCellValue('S1', 'STATUS KAWIN')
        ->setCellValue('T1', 'NO. BPJS KESEHATAN')
        ->setCellValue('U1', 'NO. BPJS KETENAGA KERJAAN')
        ->setCellValue('V1', 'NO. NPWP')
        ->setCellValue('W1', 'STATUS DATA')
        ->setCellValue('X1', 'KETERANGAN');

        // options
        $sheet->getDefaultColumnDimension()->setAutoSize(true);
        $sheet->setAutoFilter('A1:X1');
        $sheet->getStyle('A1:X1')->applyFromArray([
            'font' => ['bold' => true]
        ]);

        $protection = $sheet->getProtection();
        $allowed = $protection->verify(date('d-m-Y'));

        if ($allowed === false) {
            return throw new Exception('Incorrect password');
        } 

        $column = 2;
        $no=1;
        foreach ($data as $peg) {
            $sheet->setCellValue('A' . $column, $no)
                ->setCellValue('B' . $column, "'".$peg['nik'])
                ->setCellValue('C' . $column, "'".$peg['no_kk'])
                ->setCellValue('D' . $column, "'".$peg['nipd'])
                ->setCellValue('E' . $column, $peg['nama'])
                ->setCellValue('F' . $column, $peg['gelar_depan'])
                ->setCellValue('G' . $column, $peg['gelar_blk'])
                ->setCellValue('H' . $column, $peg['tmp_lahir'])
                ->setCellValue('I' . $column, $peg['tgl_lahir'])
                ->setCellValue('J' . $column, $peg['jns_kelamin'])
                ->setCellValue('K' . $column, $peg['nama_jabatan'])
                ->setCellValue('L' . $column, $peg['nama_unit_kerja'])
                ->setCellValue('M' . $column, $peg['nama_agama'])
                ->setCellValue('N' . $column, $peg['alamat'])
                ->setCellValue('O' . $column, $peg['desa_domisili'])
                ->setCellValue('P' . $column, $peg['no_telp_rumah'])
                ->setCellValue('Q' . $column, $peg['no_hp'])
                ->setCellValue('R' . $column, $peg['email'])
                ->setCellValue('S' . $column, $peg['nama_status_kawin'])
                ->setCellValue('T' . $column, $peg['no_bpjs_kesehatan'])
                ->setCellValue('U' . $column, $peg['no_bpjs_ketenagakerjaan'])
                ->setCellValue('P' . $column, $peg['no_npwp'])
                ->setCellValue('W' . $column, $peg['status'])
                ->setCellValue('X' . $column, $peg['ket_status']);
            $no++;
            $column++;
        }
        $writer = new Xlsx($spreadsheet);
        $filename = date('Y-m-d-His'). '-DATA-PEGAWAI';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');

    }
}
