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

    public function hitung()
    {
        helper(["pegawai", "hash", "tgl_indo"]);
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

            $dbcek = db_connect()->table('riwayat_tunjangan')
            ->where('nik', $request->getPost('nik'))
            ->where('bulan', date("m"))
            ->where('tahun', date('Y'))
            ->countAllResults();
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
                'bulan' => date("m"),
                'tahun' => date('Y'),
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
        ];
        return view('backend/pages/pembayaran/tunjangan_hitung', $data);
    }

    public function filter()
    {
        helper(["pegawai","number"]);
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
