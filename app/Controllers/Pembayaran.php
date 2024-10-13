<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class Pembayaran extends BaseController
{
    public function tunjangan()
    {
        helper(["tgl_indo"]);

        $data = [
            'title' => 'Pembayaran Tunjangan',
        ];
        return view('backend/pages/pembayaran/tunjangan', $data);
    }

    public function absensi()
    {
        helper(["tgl_indo","hash"]);
        $now = new Time('now', 'Asia/Jakarta', 'id_ID');

        $request = $this->request;
        if($request->isAJAX() && $request->is("post")) 
        {

            $dbcek = db_connect()->table('riwayat_absensi')
            ->where('nik', $request->getPost('nik'))
            ->groupStart()
                ->where('bulan', $now->getMonth())
                ->where('tahun', $now->getYear())
            ->groupEnd()
            ->countAllResults(false);

            if($dbcek > 0)
            {
                $msg = [
                    'status' => false,
                    'message' => 'Absensi sudah pernah ditambahkan pada periode yang sama !'
                ];
                return $this->response->setJSON($msg);
            }

            $data = [
                'nik' => $request->getPost('nik'),
                'bulan' => $now->getMonth(),
                'tahun' => $now->getYear(),
                'hadir' => $request->getPost('hadir'),
                'izin' => $request->getPost('izin'),
                'sakit' => $request->getPost('sakit'),
                'tk' => $request->getPost('tk'),
                'cuti' => $request->getPost('cuti'),
                'tudin' => $request->getPost('tudin'),
                'created_at' => $now->addHours(1),
                'created_by' => session()->nik,
            ];

            $db = db_connect()->table('riwayat_absensi')->insert($data);
            if($db) {
                $msg = [
                    'status' => true,
                    'message' => 'Import Absensi <b>'.$request->getPost('nik').'</b> Berhasil.',
                ];
                return $this->response->setJSON($msg);
            }
            $msg = [
                'status' => false,
                'message' => 'Import Absensi Gagal.'
            ];
            return $this->response->setJSON($msg);
        }
        if($request->isAJAX() && $request->is("delete")) 
        {
            $delete_id = rehash($request->getPost('id'));

            $db = db_connect()->table('riwayat_absensi')
            ->where('id', $delete_id)
            ->delete();
            if($db):
                $msg = [
                    'statusCode' => 200,
                    'status' => true,
                    'message' => 'Absensi berhasil dihapus !',
                ];
                return $this->response->setJSON($msg);
            endif;
            
            $msg = [
                'statusCode' => 400,
                'status' => false,
                'message' => 'Absensi gagal dihapus !',
            ];
            return $this->response->setJSON($msg);
        }
        if($request->isAJAX() && $request->is("put"))
        {
            $update = [
                'hadir' => $request->getPost('hadir'),
                'izin' => $request->getPost('izin'),
                'sakit' => $request->getPost('sakit'),
                'tk' => $request->getPost('tk'),
                'cuti' => $request->getPost('cuti'),
                'tudin' => $request->getPost('tudin'),
                'updated_at' => $now->addHours(1),
                'updated_by' => session()->nik,
            ];
            $db = db_connect()->table('riwayat_absensi')->where('id', rehash($request->getPost('id')))->update($update);
            if($db)
            {
                $msg = [
                    'status' => true,
                    'message' => 'Data absensi berhasil diperbaharui.'
                ];
                return $this->response->setJSON($msg);
            }
            $msg = [
                'status' => false,
                'message' => 'Data absensi gagal diperbaharui.'
            ];
            return $this->response->setJSON($msg);
        }
        $data = [
            'title' => 'Import Absensi',
            'now' => $now
        ];
        return view('backend/pages/pembayaran/absensi', $data);
    }

    public function hitung()
    {
        helper(["hash", "tgl_indo"]);
        $now = new Time('now', 'Asia/Jakarta', 'id_ID');

        $request = $this->request;
        if($request->isAJAX() && $request->is("post")) 
        {
            $pegawai = db_connect()->table('pegawai p')
            ->join('ref_jabatan j', 'p.fid_jabatan=j.id')
            ->join('ref_unit_kerja u', 'p.fid_unit_kerja=u.id_unit_kerja')
            ->join('ref_desa d', 'p.fid_keldesa=d.id_desa')
            ->join('ref_kecamatan k', 'd.fid_kecamatan=k.id_kecamatan')
            ->where('p.nik', $request->getPost('nik'))
            ->get()
            ->getRow();
            
            // cek absensi 
            $cek_absensi = db_connect()->table('riwayat_absensi')
            ->where('nik', $request->getPost('nik'))
            ->groupStart()
                ->where('bulan', $request->getPost('periode_bulan'))
                ->where('tahun', $request->getPost('periode_tahun'))
            ->groupEnd()
            ->countAllResults(false);
            if($cek_absensi === 0)
            {
                $msg = [
                    'status' => false,
                    'message' => "Absensi Periode <b>".bulan($request->getPost('periode_bulan'))."</b> Belum Diimport."
                ];
                return $this->response->setJSON($msg);
            }

            $dbcek = db_connect()->table('riwayat_tunjangan')
            ->where('nik', $request->getPost('nik'))
            ->groupStart()
            ->where('bulan', $request->getPost('periode_bulan'))
            ->where('tahun', $request->getPost('periode_tahun'))
            ->groupEnd()
            ->countAllResults(false);
            if($dbcek > 0)
            {
                $msg = [
                    'status' => false,
                    'message' => 'Pegawai sudah pernah ditambahkan pada periode yang sama !'
                ];
                return $this->response->setJSON($msg);
            }
            // Rumus
            $jumlah_uang = ($pegawai->tunjangan * $request->getPost('jml_bulan')) - $request->getPost('pph21');

            $data = [
                'nik' => $pegawai->nik,
                'nama_unit_kerja' => strtoupper($pegawai->nama_unit_kerja),
                'nama_kecamatan' => strtoupper($pegawai->nama_kecamatan),
                'nama_desa' => $pegawai->nama_desa,
                'nama_jabatan' => $pegawai->nama_jabatan,
                'jenis_pegawai' => $pegawai->jenis,
                'bulan' => $request->getPost('periode_bulan'),
                'tahun' => $request->getPost('periode_tahun'),
                'jumlah_bulan' => $request->getPost('jml_bulan'),
                'jumlah_uang' => $jumlah_uang,
                'pph21' => str_replace(".", "", $request->getPost('pph21')),
                'created_at' => $now->addHours(1),
                'created_by' => session()->nik,
            ];

            $db = db_connect()->table('riwayat_tunjangan')->insert($data);
            if($db) {
                $msg = [
                    'status' => true,
                    'message' => 'Perhitungan Tunjangan Pegawai Berhasil Ditambahkan.'
                ];
                return $this->response->setJSON($msg);
            }
            $msg = [
                'status' => false,
                'message' => 'Pegawai Gagal Ditambahkan.'
            ];
            return $this->response->setJSON($msg);
        }
        if($request->isAJAX() && $request->is("delete")) 
        {
            $delete_id = rehash($request->getPost('id'));

            $db = db_connect()->table('riwayat_tunjangan')
            ->where('id', $delete_id)
            ->delete();
            if($db):
                $msg = [
                    'statusCode' => 200,
                    'status' => true,
                    'message' => 'Perhitungan berhasil dihapus !',
                ];
                return $this->response->setJSON($msg);
            endif;
            
            $msg = [
                'statusCode' => 400,
                'status' => false,
                'message' => 'Perhitungan gagal dihapus !',
            ];
            return $this->response->setJSON($msg);
        }
        
        $data = [
            'title' => 'Hitung Tunjangan',
            'now' => $now->addHours(1)
        ];
        return view('backend/pages/pembayaran/tunjangan_hitung', $data);
    }

    public function filter()
    {
        helper(["number"]);
        $request = $this->request;
        $id_unit_kerja = $request->getPost('unit');
        $bulan = $request->getPost('bulan');
        $jenis_pegawai = $request->getPost('jns_pegawai');

        helper(["tgl_indo"]);
        $unor = db_connect()->table('ref_unit_kerja u')
        ->join('ref_kecamatan k', 'u.kecamatan=k.id_kecamatan')
        ->where('u.id_unit_kerja', $id_unit_kerja)
        ->get()
        ->getRow();
        $pegawai = db_connect()->table('riwayat_tunjangan rt')
        ->join('pegawai p', 'rt.nik=p.nik')
        ->join('ref_jabatan rj', 'p.fid_jabatan=rj.id')
        ->where('p.fid_unit_kerja', $unor->id_unit_kerja)
        ->where('rt.jenis_pegawai', $jenis_pegawai)
        ->where('rt.bulan', $bulan)
        ->get()
        ->getResult();

        $data = [
            'title' => 'Review Tunjangan',
            'unor' => $unor,
            'pegawai' => $pegawai,
            'request' => [
                'id_unit_kerja' => $id_unit_kerja,
                'bulan' => $bulan,
                'jenis_pegawai' => $jenis_pegawai
            ]
        ];
        return view('backend/pages/pembayaran/tunjangan_review', $data);
    }
}
