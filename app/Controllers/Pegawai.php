<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;

class Pegawai extends BaseController
{
    use ResponseTrait;

    protected $db;

    public function __construct() {
        $this->db = db_connect();
    }

    public function index()
    {
        helper(["pegawai", "hash"]);
        $session = service("session");
        $request = $this->request;
        if($request->is('post') && $request->isAJAX()) {
            return $this->respond([
                'status' => true,
                'message' => 'Oke',
                'redirect' => base_url('app/pegawai/unit?id='.dohash($request->getPost('fid_unit_kerja')))
            ]);
        }

        if($request->getGet('id') !== null) {
            $pegawai = $this->db->table('pegawai p')
            ->select('p.nik,p.nipd,p.gelar_depan,p.gelar_blk,p.nama,p.photo,p.status,u.nama_unit_kerja')
            ->join('ref_unit_kerja u', 'p.fid_unit_kerja=u.id_unit_kerja')
            ->where('p.fid_unit_kerja', rehash($request->getGet('id')))
            ->orderBy('p.created_at', 'desc')->get();

            $data = [
                'title' => 'Pegawai Satuan Unit Kerja - Simpedes Kab. Balangan',
                'pegawai' => $pegawai->getResult(),
                'unit' => $pegawai->getRow()->nama_unit_kerja
            ];
            return view('backend/pages/pegawai/unit', $data);
        }

        $pegawai = $this->db->table('pegawai p')
            ->select('p.nik,p.nipd,p.gelar_depan,p.gelar_blk,p.nama,p.photo,p.status,u.nama_unit_kerja')
            ->join('ref_unit_kerja u', 'p.fid_unit_kerja=u.id_unit_kerja', 'left')
            ->where('p.fid_unit_kerja', $session->get('id_unit_kerja'))
            ->orderBy('p.created_at', 'desc')->get();

        $data = [
            'title' => 'Pegawai Satuan Unit Kerja - Simpedes Kab. Balangan',
            'pegawai' => $pegawai->getResult(),
            'unit' => session()->nama_unit_kerja
        ];
        return view('backend/pages/pegawai/unit', $data);
    }

    public function search()
    {
        helper(["pegawai", "hash"]);
        $session = session();
        $request = $this->request;
        $search = strtolower($request->getPost('search'));

        if($this->request->is('ajax')):
            $builder = $this->db->table('pegawai p')
            ->select('p.nik,p.photo,p.gelar_depan,p.gelar_blk,p.nama,p.photo,u.nama_unit_kerja,p.status')
            ->join('ref_unit_kerja u', 'p.fid_unit_kerja=u.id_unit_kerja')
            ->groupStart()
                ->like('p.nik', $search)
                ->orLike('p.nama', $search)
            ->groupEnd()
            ->when($session, function($query, $session) {
                if($session->get('role') === 'OPERATOR') {
                    $query->where('p.fid_unit_kerja', $session->get('id_unit_kerja'));
                    $query->where('p.status', 'AKTIF');
                }
            });

            if($builder->countAllResults(false) > 0 && !empty($search)) {
                $row = $builder->get()->getResult();

                $pegawai = [];
                foreach ($row as $r) {
                    $pegawai[] = [
                        'nik' => $r->nik,
                        'token' => dohash($r->nik),
                        'photo' => base_url("assets/images/users/".$r->photo),
                        'nama' => namalengkap($r->gelar_depan, $r->nama, $r->gelar_blk),
                        'nama_unit_kerja' => $r->nama_unit_kerja,
                        'status' => $r->status
                    ];
                };

                $data = [
                    'status' => true,
                    'message' => "Pegawai Keywords ({$search}) Ditemukan",
                    'data' => $pegawai
                ]; 
                return $this->respond($data, 200);
            };

            $data = [
                'status' => false,
                'message' => 'Pegawai tidak ditemukan atau Non Aktif',
                'data' => []
            ];
            return $this->respond($data, 400);
        endif;
        
    }

    public function detail()
    {
        helper(["hash","pegawai","tgl_indo"]);
        $uri = service('uri');
        $getNIK = $uri->getSegment(4);
        $nik = rehash($getNIK);

        $profile = $this->db->table('pegawai p')
        ->where('p.status', 'AKTIF')
        ->join('ref_unit_kerja u', 'p.fid_unit_kerja=u.id_unit_kerja')
        ->join('ref_agama a', 'p.fid_agama=a.id_agama')
        ->join('ref_desa d', 'p.fid_keldesa=d.id_desa')
        ->join('ref_status_kawin rsk', 'p.fid_status_kawin=rsk.id_status_kawin')
        ->where('p.nik', $nik)
        ->get();

        $row = $profile->getRow();
        $namalengkap = namalengkap($row->gelar_depan, $row->nama, $row->gelar_blk);

        $data = [
            'title' => "{$namalengkap} - Simpedes Kab. Balangan",
            'nik' => $nik,
            'row' => $row
        ];

        return view("backend/pages/pegawai/profile", $data);
    }
}
