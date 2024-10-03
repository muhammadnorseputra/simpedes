<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\I18n\Time;

class Pegawai extends BaseController
{
    use ResponseTrait;

    protected $db;

    public function __construct() {
        $this->db = db_connect();
    }

    public function index()
    {
        helper(["hash"]);
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
            ->select('p.nik,p.nipd,p.gelar_depan,p.gelar_blk,p.nama,p.photo,p.status,u.nama_unit_kerja,rj.nama_jabatan,rj.jenis')
            ->join('ref_unit_kerja u', 'p.fid_unit_kerja=u.id_unit_kerja', 'left')
            ->join('ref_jabatan rj', 'p.fid_jabatan=rj.id', 'left')
            ->where('p.fid_unit_kerja', rehash($request->getGet('id')))
            ->orderBy('p.created_at', 'desc')->get();

            $data = [
                'title' => 'Pegawai Satuan Unit Kerja',
                'pegawai' => $pegawai->getResult(),
                'unit' => @$pegawai->getRow()->nama_unit_kerja
            ];
            return view('backend/pages/pegawai/unit', $data);
        }

        $pegawai = $this->db->table('pegawai p')
            ->select('p.nik,p.nipd,p.gelar_depan,p.gelar_blk,p.nama,p.photo,p.status,u.nama_unit_kerja,rj.nama_jabatan,rj.jenis')
            ->join('ref_unit_kerja u', 'p.fid_unit_kerja=u.id_unit_kerja', 'left')
            ->join('ref_jabatan rj', 'p.fid_jabatan=rj.id', 'left')
            ->where('p.fid_unit_kerja', $session->get('id_unit_kerja'))
            ->orderBy('p.created_at', 'desc')->get();

        $data = [
            'title' => 'Pegawai Satuan Unit Kerja',
            'pegawai' => $pegawai->getResult(),
            'unit' => session()->nama_unit_kerja
        ];
        return view('backend/pages/pegawai/unit', $data);
    }

    public function search()
    {
        helper(["hash"]);
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
        helper(["hash","tgl_indo"]);
        $uri = service('uri');
        $getNIK = $uri->getSegment(4);
        $nik = rehash($getNIK);

        $pegawai = model('PegawaiModel');
        $profile = $pegawai->getDetailPegawai($nik);
        $pendidikan_terakhir = $pegawai->getPendidikanTerakhir($nik);
        $jabatan_terakhir = $pegawai->getJabatanTerakhir($nik);
        $row = $profile->asObject()->first();
        if($row === null) {
            return throw new \CodeIgniter\Exceptions\PageNotFoundException('Pegawai tidak ditemukan atau diluar kewenangan anda');
        }
        $namalengkap = @namalengkap($row->gelar_depan, $row->nama, $row->gelar_blk);

        $data = [
            'title' => "{$namalengkap}",
            'nik' => $nik,
            'row' => $row,
            'pendidikan' => $pendidikan_terakhir,
            'jabatan' => $jabatan_terakhir
        ];

        return view("backend/pages/pegawai/profile", $data);
    }

    public function riwayat_pendidikan($id="",$paramsType="")
    {
        helper(["hash", "tgl_indo"]);
        $now = new Time('now', 'Asia/Jakarta', 'id_ID');
        $uri = service('uri');
        $getNIK = $uri->getSegment(3);
        $nik = rehash($getNIK);
        $request = $this->request;
        
        if($request->isAJAX() && $request->is("post") && $paramsType === 'add')
        {
            $data = [
                'nik' => $nik,
                'fid_tingkat' => $request->getPost('tingkat_pendidikan'),
                'fid_jurusan' => $request->getPost('jurusan_pendidikan'),
                'thn_lulus' => $request->getPost('thn_lulus'),
                'nama_sekolah' => $request->getPost('nama_sekolah'),
                'nama_kepsek' => $request->getPost('nama_kepsek'),
                'no_sttb' => $request->getPost('no_sttb'),
                'tgl_sttb' => $request->getPost('tgl_sttb'),
                'gelar_dpn' => $request->getPost('gelar_depan'),
                'gelar_blk' => $request->getPost('gelar_blk'),
                'created_at' => $now->addHours(1),
                'created_by' => session()->nik,
            ];
            $db = $this->db->table('riwayat_pendidikan')->insert($data);

            if($db)
            {
                $msg = [
                    'status' => true,
                    'message' => 'Pendidikan Berhasil Ditambahkan.'
                ];
                $this->db->table('pegawai')->where('nik', $nik)->update([
                    'gelar_depan' => $request->getPost('gelar_depan'),
                    'gelar_blk' => $request->getPost('gelar_blk')
                ]);
                return $this->respond($msg, 200);
            }

            $msg = [
                'status' => false,
                'message' => 'Pendidikan Gagal Ditambahkan.'
            ];
            
            return $this->respond($msg, 400);
        }
        
        if($request->isAJAX() && $request->is("post") && $paramsType === 'upload')
        {
            $berkas = $request->getFile('berkas');
            $berkas_id = $request->getPost('id');
            $berkas_nik = $request->getPost('nik');

            if($berkas->isValid()) {
                // upload berkas
                $filename = $berkas_id."-".$berkas_nik.".".$berkas->getClientExtension();
                $berkas->move("assets/file_pendidikan/", $filename, true);
                $data = [
                    'berkas' => $filename
                ];
                $db = $this->db->table('riwayat_pendidikan')
                ->where('id', $berkas_id)
                ->where('nik', $berkas_nik)
                ->update($data);

                if($db) {
                    $msg = [
                        'status' => true,
                        'message' => 'Berkas Berhasil Diupload.'
                    ];
                    return $this->respond($msg, 200);
                }
                $msg = [
                    'status' => false,
                    'message' => 'Berkas Gagal Diupload.'
                ];
                return $this->respond($msg, 400);
            }
            $msg = [
                'status' => false,
                'message' => 'File Invalid.'
            ];
            return $this->respond($msg, 500);
        }
        
        if($request->isAJAX() && $request->is("delete") && $paramsType === 'delete')
        {
            $delete_id = $request->getPost('id');
            $delete_nik = $request->getPost('nik');
            $filename = $request->getPost('file');

            if(file_exists("assets/file_pendidikan/".$filename)) {
                // delete file
                @unlink("assets/file_pendidikan/".$filename);
                // delete data riwayat
                $db = $this->db->table('riwayat_pendidikan')
                ->where('id', $delete_id)
                ->where('nik', $delete_nik)
                ->delete();

                // ambil riwayat pendidikan terakhir
                $rwy_pendidikan = $this->db->table('riwayat_pendidikan')
                ->select('gelar_dpn,gelar_blk')
                ->orderBy('id', 'desc')
                ->where('nik', $delete_nik)
                ->limit(1)
                ->get();
                $gd_gb = $rwy_pendidikan->getRow();
                // ambil gelar_depan dan belakang berdasarkan riwayat terakhir.
                $update = [
                    'gelar_depan' => @$gd_gb->gelar_dpn,
                    'gelar_blk' => @$gd_gb->gelar_blk
                ];

                // update gelar pegawai berdasarkan riwayat pendidikant terakhir
                $this->db->table('pegawai')->where('nik', $delete_nik)->update($update);

                $msg = [
                    'statusCode' => 200,
                    'status' => true,
                    'message' => 'Data berhasil dihapus !',
                    'data' => $db
                ];
                return $this->respond($msg, 200);
            } 
            $msg = [
                'statusCode' => 400,
                'status' => false,
                'message' => 'Data gagal dihapus !',
                'data' => []
            ];
            return $this->respond($msg, 400);
        }

        if($request->isAJAX() && $request->is("post") && $paramsType === 'update')
        {
            $update = [
                'fid_tingkat' => $request->getPost('tingkat_pendidikan'),
                'fid_jurusan' => $request->getPost('jurusan_pendidikan'),
                'thn_lulus' => $request->getPost('thn_lulus'),
                'nama_sekolah' => $request->getPost('nama_sekolah'),
                'nama_kepsek' => $request->getPost('nama_kepsek'),
                'no_sttb' => $request->getPost('no_sttb'),
                'tgl_sttb' => $request->getPost('tgl_sttb'),
                'gelar_dpn' => $request->getPost('gelar_depan'),
                'gelar_blk' => $request->getPost('gelar_blk'),
                'updated_at' => $now->addHours(1),
                'updated_by' => session()->nik
            ];
            $db = $this->db->table('riwayat_pendidikan')->where('id', rehash($request->getPost('id')))->update($update);
            if($db)
            {
                $msg = [
                    'status' => true,
                    'message' => 'Riwayat Pendidikan berhasil diperbaharui.'
                ];
                $this->db->table('pegawai')->where('nik', rehash($request->getPost('nik')))->update([
                    'gelar_depan' => $request->getPost('gelar_depan'),
                    'gelar_blk' => $request->getPost('gelar_blk')
                ]);
                return $this->respond($msg, 200);
            }
            $msg = [
                'status' => false,
                'message' => 'Riwayat Pendidikan gagal diperbaharui.'
            ];
            return $this->respond($msg, 400);
        }

        if($request->is("get") && $paramsType === 'edit')
        {
            // ambil riwayat pendidikan terakhir
            $rwy_pendidikan = model("PegawaiModel");
            $getRiwayat = $rwy_pendidikan->getPendidikanTerakhirById(rehash($id));

            $data = [
                'title' => "{$getRiwayat->nama_sekolah}",
                'row' => $getRiwayat,
            ];

            return view("backend/pages/pegawai/riwayat/pendidikan_edit", $data);
        }

        $pegawai = model('PegawaiModel');
        $profile = $pegawai->getDetailPegawai($nik);

        $row = $profile->asObject()->first();
        if($row === null) {
            return throw new \CodeIgniter\Exceptions\PageNotFoundException('Riwayat Pendidikan Pegawai tidak ditemukan');
        }

        $namalengkap = namalengkap($row->gelar_depan, $row->nama, $row->gelar_blk);
        $data = [
            'title' => "Riwayat Pendidikan - {$namalengkap}",
            'nik' => $nik,
            'row' => $row,
        ];

        return view("backend/pages/pegawai/riwayat/pendidikan", $data);
    }

    public function riwayat_jabatan($id="", $paramsType="")
    {
        helper(["hash", "tgl_indo"]);
        $now = new Time('now', 'Asia/Jakarta', 'id_ID');

        $request = $this->request;

        $pegawai = model('PegawaiModel');
        $profile = $pegawai->getDetailPegawai(rehash($id));

        if($request->isAJAX() && $request->is("post") && $paramsType === 'add')
        {
            $data = [
                'nik' => rehash($id),
                'fid_unit_kerja' => $request->getPost('unit_kerja'),
                'fid_jabatan' => $request->getPost('jabatan'),
                'tmt_mulai' => $request->getPost('tmt_mulai'),
                'tmt_selesai' => $request->getPost('tmt_selesai'),
                'tgl_pelantikan' => $request->getPost('tgl_pelantikan'),
                'pejabat_sk' => $request->getPost('pejabat_sk'),
                'no_sk' => $request->getPost('no_sk'),
                'tgl_sk' => $request->getPost('tgl_sk'),
                'created_at' => $now->addHours(1),
                'created_by' => session()->nik,
            ];
            $db = $this->db->table('riwayat_jabatan')->insert($data);

            if($db)
            {
                $msg = [
                    'status' => true,
                    'message' => 'Jabatan Berhasil Ditambahkan.'
                ];
                $this->db->table('pegawai')->where('nik', rehash($id))->update([
                    'fid_unit_kerja' => $request->getPost('unit_kerja'),
                    'fid_jabatan' => $request->getPost('jabatan'),
                ]);
                $this->db->table('users')->where('nik', rehash($id))->update([
                    'fid_unit_kerja' => $request->getPost('unit_kerja'),
                ]);
                return $this->respond($msg, 200);
            }

            $msg = [
                'status' => false,
                'message' => 'Jabatan Gagal Ditambahkan.'
            ];
            
            return $this->respond($msg, 400);
        }

        if($request->isAJAX() && $request->is("post") && $paramsType === 'upload')
        {
            $berkas = $request->getFile('berkas');
            $berkas_id = $request->getPost('id');
            $berkas_nik = $request->getPost('nik');

            if($berkas->isValid()) {
                // upload berkas
                $filename = $berkas_id."-".$berkas_nik.".".$berkas->getClientExtension();
                $berkas->move("assets/file_jabatan/", $filename, true);
                $data = [
                    'berkas' => $filename
                ];
                $db = $this->db->table('riwayat_jabatan')
                ->where('id', $berkas_id)
                ->where('nik', $berkas_nik)
                ->update($data);

                if($db) {
                    $msg = [
                        'status' => true,
                        'message' => 'Berkas Berhasil Diupload.'
                    ];
                    return $this->respond($msg, 200);
                }
                $msg = [
                    'status' => false,
                    'message' => 'Berkas Gagal Diupload.'
                ];
                return $this->respond($msg, 400);
            }
            $msg = [
                'status' => false,
                'message' => 'File Invalid.'
            ];
            return $this->respond($msg, 500);
        }

        if($request->isAJAX() && $request->is("delete") && $paramsType === 'delete')
        {
            $delete_id = $request->getPost('id');
            $delete_nik = $request->getPost('nik');
            $filename = $request->getPost('file');

            if(file_exists("assets/file_jabatan/".$filename)) {
                // delete file
                @unlink("assets/file_jabatan/".$filename);
                // delete data riwayat
                $db = $this->db->table('riwayat_jabatan')
                ->where('id', $delete_id)
                ->where('nik', $delete_nik)
                ->delete();
                // ambil riwayat jabatan terakhir
                $rwy_jabatan = $this->db->table('riwayat_jabatan')
                ->select('fid_unit_kerja,fid_jabatan')
                ->orderBy('id', 'desc')
                ->where('nik', $delete_nik)
                ->limit(1)
                ->get();
                $jabatan = $rwy_jabatan->getRow();
                // ambil referensi unit_kerja berdasarkan riwayat terakhir.
                $update = [
                    'fid_unit_kerja' => @$jabatan->fid_unit_kerja,
                    'fid_jabatan' => @$jabatan->fid_jabatan
                ];
                // update table pegawai unit_kerja berdasarkan riwayat jabatan terakhir jika pegawai pindah unit kerja
                $this->db->table('pegawai')->where('nik', $delete_nik)->update($update);
                // update table user jika pegawai pindah unit kerja maka akun akan ikut pindah berdasarkan unit kerja terakhir
                $this->db->table('users')->where('nik', $delete_nik)->update([
                    'fid_unit_kerja' => @$jabatan->fid_unit_kerja,
                ]);

                $msg = [
                    'statusCode' => 200,
                    'status' => true,
                    'message' => 'Data berhasil dihapus !',
                    'data' => $db
                ];
                return $this->respond($msg, 200);
            } 
            $msg = [
                'statusCode' => 400,
                'status' => false,
                'message' => 'Data gagal dihapus !',
                'data' => []
            ];
            return $this->respond($msg, 400);
        }

        if($request->isAJAX() && $request->is("post") && $paramsType === 'update')
        {
            $update = [
                'fid_unit_kerja' => $request->getPost('unit_kerja'),
                'fid_jabatan' => $request->getPost('jabatan'),
                'tmt_mulai' => $request->getPost('tmt_mulai'),
                'tmt_selesai' => $request->getPost('tmt_selesai'),
                'tgl_pelantikan' => $request->getPost('tgl_pelantikan'),
                'pejabat_sk' => $request->getPost('pejabat_sk'),
                'no_sk' => $request->getPost('no_sk'),
                'tgl_sk' => $request->getPost('tgl_sk'),
                'updated_at' => $now->addHours(1),
                'updated_by' => session()->nik,
            ];
            $db = $this->db->table('riwayat_jabatan')->where('id', rehash($request->getPost('id')))->update($update);
            if($db)
            {
                $msg = [
                    'status' => true,
                    'message' => 'Riwayat jabatan berhasil diperbaharui.'
                ];
                $this->db->table('pegawai')->where('nik', rehash($request->getPost('nik')))->update([
                    'fid_unit_kerja' => $request->getPost('unit_kerja'),
                    'fid_jabatan' => $request->getPost('jabatan')
                ]);
                $this->db->table('users')->where('nik', rehash($id))->update([
                    'fid_unit_kerja' => $request->getPost('unit_kerja'),
                ]);
                return $this->respond($msg, 200);
            }
            $msg = [
                'status' => false,
                'message' => 'Riwayat jabatan gagal diperbaharui.'
            ];
            return $this->respond($msg, 400);
        }

        if($request->is("get") && $paramsType === 'edit')
        {
            // ambil riwayat jabatan terakhir
            $rwy_jabatan = model("PegawaiModel");
            $getRiwayat = $rwy_jabatan->getJabatanTerakhirById(rehash($id));

            $data = [
                'title' => "{$getRiwayat->nama_jabatan}",
                // 'nik' => $nik,
                'row' => $getRiwayat,
            ];

            return view("backend/pages/pegawai/riwayat/jabatan_edit", $data);
        }

        $row = $profile->asObject()->first();
        if($row === null) {
            return throw new \CodeIgniter\Exceptions\PageNotFoundException('Riwayat Jabatan Pegawai tidak ditemukan');
        }
        $namalengkap = namalengkap($row->gelar_depan, $row->nama, $row->gelar_blk);
        $data = [
            'title' => "Riwayat Jabatan - {$namalengkap}",
            'nik' => rehash($id),
            'row' => $row,
        ];

        return view("backend/pages/pegawai/riwayat/jabatan", $data);
    }

    public function riwayat_keluarga($id="", $paramsType="", $methodType = "", $uid = "")
    {
        helper(["hash", "tgl_indo"]);
        $now = new Time('now', 'Asia/Jakarta', 'id_ID');

        $request = $this->request;

        $pegawai = model('PegawaiModel');
        $profile = $pegawai->getDetailPegawai(rehash($id));
        
        $row = $profile->asObject()->first();
        if($row === null) {
            return throw new \CodeIgniter\Exceptions\PageNotFoundException('Riwayat Keluarga Pegawai tidak ditemukan');
        }
        
        $isGender = $row->jns_kelamin === 'PRIA' ? 'Istri' : 'Suami';

        if($request->isAJAX() && $request->is("post") && $paramsType === "sutri" && $methodType = "add")
        {
            $jumlah_sutri = $this->db->table('riwayat_sutri')->where('nik', rehash($id))->countAllResults();
            $data = [
                'nik' => rehash($id),
                'nama_sutri' => $request->getPost('nama_sutri'),
                'sutri_ke' => $jumlah_sutri + 1,
                'tmp_lahir' => $request->getPost('tmp_lahir'),
                'tgl_lahir' => $request->getPost('tgl_lahir'),
                'pekerjaan' => $request->getPost('pekerjaan'),
                'no_akta_nikah' => $request->getPost('no_akta_nikah'),
                'tgl_nikah' => $request->getPost('tgl_nikah'),
                'status_kawin' => $request->getPost('status_kawin'),
                'status_hidup' => $request->getPost('status_hidup') === 'YA' ? 'YA' : 'TIDAK',
                'tanggungan' => $request->getPost('tanggungan') === 'YA' ? 'YA' : 'TIDAK',
                'nip_sutri' => $request->getPost('nip_sutri'),
                'created_at' => $now->addHours(1),
                'created_by' => session()->nik,
            ];
            $db = $this->db->table('riwayat_sutri')->insert($data);

            if($db)
            {
                $msg = [
                    'status' => true,
                    'message' => 'Data '.$isGender.' Berhasil Ditambahkan.'
                ];
                $this->db->table('pegawai')->where('nik', rehash($id))->update([
                    'fid_status_kawin' => 2, // Kawin
                ]);
                return $this->respond($msg, 200);
            }

            $msg = [
                'status' => false,
                'message' => 'Data '.$isGender.' Gagal Ditambahkan.'
            ];
            
            return $this->respond($msg, 400);
        }

        if($request->isAJAX() && $request->is("put") && $paramsType === "sutri" && $methodType = "update")
        {
            $update = [
                'nama_sutri' => $request->getPost('nama_sutri'),
                'tmp_lahir' => $request->getPost('tmp_lahir'),
                'tgl_lahir' => $request->getPost('tgl_lahir'),
                'pekerjaan' => $request->getPost('pekerjaan'),
                'no_akta_nikah' => $request->getPost('no_akta_nikah'),
                'tgl_nikah' => $request->getPost('tgl_nikah'),
                'status_kawin' => $request->getPost('status_kawin'),
                'status_hidup' => $request->getPost('status_hidup') === 'YA' ? 'YA' : 'TIDAK',
                'tanggungan' => $request->getPost('tanggungan') === 'YA' ? 'YA' : 'TIDAK',
                'nip_sutri' => $request->getPost('nip_sutri'),
                'updated_at' => $now->addHours(1),
                'updated_by' => session()->nik,
            ];
            $db = $this->db->table('riwayat_sutri')->where('id', rehash($request->getPost('id')))->update($update);
            if($db)
            {
                $msg = [
                    'status' => true,
                    'message' => 'Data keluarga berhasil diperbaharui.'
                ];
                $this->db->table('pegawai')->where('nik', rehash($id))->update([
                    'fid_status_kawin' =>  $request->getPost('status_kawin') === 'MENIKAH' ? 2 : 3, // Kawin atau Janda duda
                ]);
                return $this->respond($msg, 200);
            }
            $msg = [
                'status' => false,
                'message' => 'Data keluarga gagal diperbaharui.'
            ];
            return $this->respond($msg, 400);
        }

        if($request->isAJAX() && $request->is("put") && $paramsType === "sutri" && $methodType = "cerai")
        {
            $update = [
                'no_akta_cerai' => $request->getPost('no_akta_cerai'),
                'tgl_cerai' => $request->getPost('tgl_cerai'),
                'status_kawin' => 'JANDA/DUDA',
                'status_hidup' => $request->getPost('status_hidup') === 'YA' ? 'YA' : 'TIDAK',
                'tanggungan' => $request->getPost('tanggungan') === 'YA' ? 'YA' : 'TIDAK',
                'updated_at' => $now->addHours(1),
                'updated_by' => session()->nik,
            ];
            $db = $this->db->table('riwayat_sutri')->where('id', rehash($request->getPost('id')))->update($update);
            if($db)
            {
                $msg = [
                    'status' => true,
                    'message' => 'Data keluarga berhasil diperbaharui.'
                ];
                $this->db->table('pegawai')->where('nik', rehash($request->getPost('nik')))->update([
                    'fid_status_kawin' => 4, // Cerai
                ]);
                return $this->respond($msg, 200);
            }
            $msg = [
                'status' => false,
                'message' => 'Data keluarga gagal diperbaharui.'
            ];
            return $this->respond($msg, 400);
        }

        if($request->isAJAX() && $request->is("patch") && $paramsType === "sutri" && $methodType = "meninggal")
        {
            $update = [
                'no_akta_meninggal' => $request->getPost('no_akta_meninggal'),
                'tgl_meninggal' => $request->getPost('tgl_meninggal'),
                'status_kawin' => 'JANDA/DUDA',
                'status_hidup' => 'TIDAK',
                'tanggungan' => 'TIDAK',
                'updated_at' => $now->addHours(1),
                'updated_by' => session()->nik,
            ];
            $db = $this->db->table('riwayat_sutri')->where('id', rehash($request->getPost('id')))->update($update);
            if($db)
            {
                $msg = [
                    'status' => true,
                    'message' => 'Data keluarga berhasil diperbaharui.'
                ];
                $this->db->table('pegawai')->where('nik', rehash($request->getPost('nik')))->update([
                    'fid_status_kawin' => 3, // Janda/Duda
                ]);
                return $this->respond($msg, 200);
            }
            $msg = [
                'status' => false,
                'message' => 'Data keluarga gagal diperbaharui.'
            ];
            return $this->respond($msg, 400);
        }
        
        if($request->isAJAX() && $request->is("delete") && $paramsType === "sutri" && $methodType = "delete")
        {
            $delete_id = $request->getPost('id');
            $delete_nik = $request->getPost('nik');

            $db = $this->db->table('riwayat_sutri')->where('id', rehash($delete_id))->delete();
            if($db)
            {
                $msg = [
                    'statusCode' => 200,
                    'status' => true,
                    'message' => 'Data berhasil dihapus !',
                    'data' => $db
                ];
                // Hapus semua riwayat anak yg terkait dengan nik
                $this->db->table('riwayat_anak')->where('nik', rehash($delete_nik))->where('fid_sutri_ke', $request->getPost('sutrike'))->delete();
                // Update status menjadi belum kawin
                $this->db->table('pegawai')->where('nik', rehash($delete_nik))->update([
                    'fid_status_kawin' => 1, // Belum Kawin
                ]);
                return $this->respond($msg, 200);
            }
            $msg = [
                'statusCode' => 400,
                'status' => false,
                'message' => 'Data gagal dihapus !',
                'data' => []
            ];
            return $this->respond($msg, 400);
        }

        if($request->isAJAX() && $request->is("post") && $paramsType === "anak" && $methodType = "add")
        {
            $data = [
                'nik' => rehash($id),
                'nama_anak' => $request->getPost('nama_anak'),
                'fid_sutri_ke' => $request->getPost('fid_sutri_ke'),
                'jns_kelamin' => $request->getPost('jns_kelamin'),
                'tmp_lahir' => $request->getPost('tmp_lahir'),
                'tgl_lahir' => $request->getPost('tgl_lahir'),
                'status' => $request->getPost('status'),
                'status_hidup' => $request->getPost('status_hidup') === 'YA' ? 'YA' : 'TIDAK',
                'tanggungan' => $request->getPost('tanggungan') === 'YA' ? 'YA' : 'TIDAK',
                'created_at' => $now->addHours(1),
                'created_by' => session()->nik,
            ];
            $db = $this->db->table('riwayat_anak')->insert($data);

            if($db)
            {
                $msg = [
                    'status' => true,
                    'message' => 'Data Anak Berhasil Ditambahkan.'
                ];
                return $this->respond($msg, 200);
            }

            $msg = [
                'status' => false,
                'message' => 'Data Anak Gagal Ditambahkan.'
            ];
            
            return $this->respond($msg, 400);
        }

        if($request->isAJAX() && $request->is("put") && $paramsType === "anak" && $methodType = "update")
        {
            $update = [
                'nama_anak' => $request->getPost('nama_anak'),
                'fid_sutri_ke' => $request->getPost('fid_sutri_ke'),
                'jns_kelamin' => $request->getPost('jns_kelamin'),
                'tmp_lahir' => $request->getPost('tmp_lahir'),
                'tgl_lahir' => $request->getPost('tgl_lahir'),
                'status' => $request->getPost('status'),
                'status_hidup' => $request->getPost('status_hidup') === 'YA' ? 'YA' : 'TIDAK',
                'tanggungan' => $request->getPost('tanggungan') === 'YA' ? 'YA' : 'TIDAK',
                'updated_at' => $now->addHours(1),
                'updated_by' => session()->nik,
            ];
            $db = $this->db->table('riwayat_anak')->where('id', rehash($request->getPost('id')))->update($update);
            if($db)
            {
                $msg = [
                    'status' => true,
                    'message' => 'Data keluarga (Anak) berhasil diperbaharui.'
                ];
                return $this->respond($msg, 200);
            }
            $msg = [
                'status' => false,
                'message' => 'Data keluarga (Anak) gagal diperbaharui.'
            ];
            return $this->respond($msg, 400);
        }

        if($request->isAJAX() && $request->is("delete") && $paramsType === "anak" && $methodType = "delete")
        {
            $delete_id = $request->getPost('id');
            $delete_nik = $request->getPost('nik');

            $db = $this->db->table('riwayat_anak')->where('id', rehash($delete_id))->delete();
            if($db)
            {
                $msg = [
                    'statusCode' => 200,
                    'status' => true,
                    'message' => 'Data berhasil dihapus !',
                    'data' => $db
                ];
                return $this->respond($msg, 200);
            }
            $msg = [
                'statusCode' => 400,
                'status' => false,
                'message' => 'Data gagal dihapus !',
                'data' => []
            ];
            return $this->respond($msg, 400);
        }

        if($request->is("get") && $paramsType === 'sutri' && $methodType === "edit")
        {
            // ambil riwayat jabatan terakhir
            $rwy_workshop = model("PegawaiModel");
            $getRiwayat = $rwy_workshop->getSutriById(rehash($uid));

            $data = [
                'title' => "{$getRiwayat->nama_sutri}",
                'row' => $getRiwayat,
            ];

            return view("backend/pages/pegawai/riwayat/keluarga_sutri_edit", $data);
        }

        if($request->is("get") && $paramsType === 'anak' && $methodType === "edit")
        {
            // ambil riwayat jabatan terakhir
            $rwy_workshop = model("PegawaiModel");
            $getRiwayat = $rwy_workshop->getAnakById(rehash($uid));

            $data = [
                'title' => "{$getRiwayat->nama_anak}",
                'row' => $getRiwayat,
            ];

            return view("backend/pages/pegawai/riwayat/keluarga_anak_edit", $data);
        }

        $namalengkap = namalengkap($row->gelar_depan, $row->nama, $row->gelar_blk);
        $data = [
            'title' => "Riwayat Keluarga - {$namalengkap}",
            'nik' => rehash($id),
            'row' => $row,
        ];

        return view("backend/pages/pegawai/riwayat/keluarga", $data);
    }

    public function riwayat_workshop($id="", $paramsType="")
    {
        helper(["hash", "tgl_indo"]);
        $now = new Time('now', 'Asia/Jakarta', 'id_ID');

        $request = $this->request;

        $pegawai = model('PegawaiModel');
        $profile = $pegawai->getDetailPegawai(rehash($id));

        $row = $profile->asObject()->first();
        if($row === null) {
            return throw new \CodeIgniter\Exceptions\PageNotFoundException('Riwayat Workshop Pegawai tidak ditemukan');
        }

        if($request->isAJAX() && $request->is("post") && $paramsType === "add")
        {
            $lama_satuan_jam = $request->getPost('satuan') === "jam" ? $request->getPost('lama') : NULL;
            $lama_satuan_hari = $request->getPost('satuan') === "hari" ? $request->getPost('lama') : NULL;
            $lama_satuan_bulan = $request->getPost('satuan') === "bulan" ? $request->getPost('lama') : NULL;

            $data = [
                'nik' => rehash($id),
                'fid_jenis_workshop' => $request->getPost('fid_jenis_workshop'),
                'fid_rumpun_diklat' => $request->getPost('fid_rumpun_diklat'),
                'nama_workshop' => $request->getPost('nama_kegiatan'),
                'tahun' => $request->getPost('tahun'),
                'instansi_penyelenggara' => $request->getPost('instansi_penyelenggara'),
                'tempat' => $request->getPost('tempat'),
                'tanggal' => $request->getPost('tanggal'),
                'lama_bulan' => $lama_satuan_bulan,
                'lama_hari' => $lama_satuan_hari,
                'lama_jam' => $lama_satuan_jam,
                'pejabat_sk' => $request->getPost('pejabat_sk'),
                'no_sk' => $request->getPost('no_sk'),
                'tgl_sk' => $request->getPost('tgl_sk'),
                'created_at' => $now->addHours(1),
                'created_by' => session()->nik,
            ];
            $db = $this->db->table('riwayat_workshop')->insert($data);

            if($db)
            {
                $msg = [
                    'status' => true,
                    'message' => 'Data Workshop Berhasil Ditambahkan.'
                ];
                return $this->respond($msg, 200);
            }

            $msg = [
                'status' => false,
                'message' => 'Data Workshop Gagal Ditambahkan.'
            ];
            
            return $this->respond($msg, 400);
        }

        if($request->isAJAX() && $request->is("delete") && $paramsType = "delete")
        {
            $delete_id = $request->getPost('id');
            $delete_nik = $request->getPost('nik');

            $db = $this->db->table('riwayat_workshop')->where('no', rehash($delete_id))->delete();
            if($db)
            {
                $msg = [
                    'statusCode' => 200,
                    'status' => true,
                    'message' => 'Data berhasil dihapus !',
                    'data' => $db
                ];
                return $this->respond($msg, 200);
            }
            $msg = [
                'statusCode' => 400,
                'status' => false,
                'message' => 'Data gagal dihapus !',
                'data' => []
            ];
            return $this->respond($msg, 400);
        }

        if($request->isAJAX() && $request->is("post") && $paramsType === 'update')
        {

            $lama_satuan_jam = $request->getPost('satuan') === "jam" ? $request->getPost('lama') : NULL;
            $lama_satuan_hari = $request->getPost('satuan') === "hari" ? $request->getPost('lama') : NULL;
            $lama_satuan_bulan = $request->getPost('satuan') === "bulan" ? $request->getPost('lama') : NULL;

            $update = [
                'fid_jenis_workshop' => $request->getPost('fid_jenis_workshop'),
                'fid_rumpun_diklat' => $request->getPost('fid_rumpun_diklat'),
                'nama_workshop' => $request->getPost('nama_kegiatan'),
                'tahun' => $request->getPost('tahun'),
                'instansi_penyelenggara' => $request->getPost('instansi_penyelenggara'),
                'tempat' => $request->getPost('tempat'),
                'tanggal' => $request->getPost('tanggal'),
                'lama_bulan' => $lama_satuan_bulan,
                'lama_hari' => $lama_satuan_hari,
                'lama_jam' => $lama_satuan_jam,
                'pejabat_sk' => $request->getPost('pejabat_sk'),
                'no_sk' => $request->getPost('no_sk'),
                'tgl_sk' => $request->getPost('tgl_sk'),
                'updated_at' => $now->addHours(1),
                'updated_by' => session()->nik,
            ];
            $db = $this->db->table('riwayat_workshop')->where('no', rehash($request->getPost('id')))->update($update);
            if($db)
            {
                $msg = [
                    'status' => true,
                    'message' => 'Riwayat workshop berhasil diperbaharui.'
                ];
                return $this->respond($msg, 200);
            }
            $msg = [
                'status' => false,
                'message' => 'Riwayat workshop gagal diperbaharui.'
            ];
            return $this->respond($msg, 400);
        }

        if($request->is("get") && $paramsType === 'edit')
        {
            // ambil riwayat jabatan terakhir
            $rwy_workshop = model("PegawaiModel");
            $getRiwayat = $rwy_workshop->getWorkshopById(rehash($id));

            $data = [
                'title' => "{$getRiwayat->nama_jenis_workshop} - {$getRiwayat->nama_workshop} - {$getRiwayat->nama_rumpun_diklat}",
                'row' => $getRiwayat,
            ];

            return view("backend/pages/pegawai/riwayat/workshop_edit", $data);
        }

        $namalengkap = namalengkap($row->gelar_depan, $row->nama, $row->gelar_blk);
        $data = [
            'title' => "Riwayat Workshop - {$namalengkap}",
            'nik' => rehash($id),
            'row' => $row,
        ];

        return view("backend/pages/pegawai/riwayat/workshop", $data);
    }

    public function riwayat_lhkpn($id="", $paramsType="")
    {
        helper(["hash", "tgl_indo"]);
        $now = new Time('now', 'Asia/Jakarta', 'id_ID');

        $request = $this->request;

        $pegawai = model('PegawaiModel');
        $profile = $pegawai->getDetailPegawai(rehash($id));
        $row = $profile->asObject()->first();
        if($row === null) {
            return throw new \CodeIgniter\Exceptions\PageNotFoundException('Riwayat LHKPN Pegawai tidak ditemukan');
        }

        if($request->isAJAX() && $request->is("post") && $paramsType === "add")
        {
            $data = [
                'nik' => rehash($id),
                'tahun_wajib' => $request->getPost('tahun_wajib'),
                'tgl_lapor' => $request->getPost('tgl_lapor'),
                'tgl_penyampaian' => $request->getPost('tgl_penyampaian'),
                'jenis_form' => $request->getPost('jenis_form'),
                'status' => $request->getPost('status'),
                'jabatan' => $request->getPost('jabatan'),
                'unit_kerja' => $request->getPost('unit_kerja'),
                'created_at' => $now->addHours(1),
                'created_by' => session()->nik,
            ];
            $db = $this->db->table('riwayat_lhkpn')->insert($data);

            if($db)
            {
                $msg = [
                    'status' => true,
                    'message' => 'Data LHKPN Berhasil Ditambahkan.'
                ];
                return $this->respond($msg, 200);
            }

            $msg = [
                'status' => false,
                'message' => 'Data LHKPN Gagal Ditambahkan.'
            ];
            
            return $this->respond($msg, 400);
        }

        if($request->isAJAX() && $request->is("post") && $paramsType === 'upload')
        {
            $berkas = $request->getFile('berkas');
            $tahun = $request->getPost('tahun');
            $berkas_id = rehash($request->getPost('id'));
            $berkas_nik = rehash($request->getPost('nik'));

            if($berkas->isValid()) {
                // upload berkas
                $filename = $tahun."-".$berkas_id."-".$berkas_nik.".".$berkas->getClientExtension();
                $berkas->move("assets/file_lhkpn/", $filename, true);
                $data = [
                    'file_tbn' => $filename
                ];
                $db = $this->db->table('riwayat_lhkpn')
                ->where('id', $berkas_id)
                ->where('nik', $berkas_nik)
                ->update($data);

                if($db) {
                    $msg = [
                        'status' => true,
                        'message' => 'Berkas Berhasil Diupload.'
                    ];
                    return $this->respond($msg, 200);
                }
                $msg = [
                    'status' => false,
                    'message' => 'Berkas Gagal Diupload.'
                ];
                return $this->respond($msg, 400);
            }
            $msg = [
                'status' => false,
                'message' => 'File Invalid.'
            ];
            return $this->respond($msg, 500);
        }

        if($request->isAJAX() && $request->is("delete") && $paramsType === 'delete')
        {
            $delete_id = rehash($request->getPost('id'));
            $delete_nik = rehash($request->getPost('nik'));
            $filename = $request->getPost('file');

            if(file_exists("assets/file_lhkpn/".$filename)) {
                // delete file
                @unlink("assets/file_lhkpn/".$filename);
                // delete data riwayat
                $db = $this->db->table('riwayat_lhkpn')
                ->where('id', $delete_id)
                ->where('nik', $delete_nik)
                ->delete();

                $msg = [
                    'statusCode' => 200,
                    'status' => true,
                    'message' => 'Data berhasil dihapus !',
                    'data' => $db
                ];
                return $this->respond($msg, 200);
            } 
            $msg = [
                'statusCode' => 400,
                'status' => false,
                'message' => 'Data gagal dihapus !',
                'data' => []
            ];
            return $this->respond($msg, 400);
        }

        if($request->isAJAX() && $request->is("post") && $paramsType === 'update')
        {
            $update = [
                'tahun_wajib' => $request->getPost('tahun_wajib'),
                'tgl_lapor' => $request->getPost('tgl_lapor'),
                'tgl_penyampaian' => $request->getPost('tgl_penyampaian'),
                'jenis_form' => $request->getPost('jenis_form'),
                'status' => $request->getPost('status'),
                'jabatan' => $request->getPost('jabatan'),
                'unit_kerja' => $request->getPost('unit_kerja'),
                'updated_at' => $now->addHours(1),
                'updated_by' => session()->nik,
            ];
            $db = $this->db->table('riwayat_lhkpn')->where('id', rehash($request->getPost('id')))->update($update);
            if($db)
            {
                $msg = [
                    'status' => true,
                    'message' => 'Riwayat LHKPN berhasil diperbaharui.'
                ];
                return $this->respond($msg, 200);
            }
            $msg = [
                'status' => false,
                'message' => 'Riwayat LHKPN gagal diperbaharui.'
            ];
            return $this->respond($msg, 400);
        }

        if($request->is("get") && $paramsType === 'edit')
        {
            // ambil riwayat jabatan terakhir
            $rwy_lhkpn = model("PegawaiModel");
            $getRiwayat = $rwy_lhkpn->getLHKPNById(rehash($id));

            $data = [
                'title' => "{$getRiwayat->jabatan}",
                'row' => $getRiwayat,
            ];

            return view("backend/pages/pegawai/riwayat/lhkpn_edit", $data);
        }

        $namalengkap = namalengkap($row->gelar_depan, $row->nama, $row->gelar_blk);
        $data = [
            'title' => "Riwayat LHKPN - {$namalengkap}",
            'nik' => rehash($id),
            'row' => $row,
        ];

        return view("backend/pages/pegawai/riwayat/lhkpn", $data);
    }

    public function riwayat_tunjangan($id="", $paramsType="")
    {
        helper(["hash", "tgl_indo"]);
        $now = new Time('now', 'Asia/Jakarta', 'id_ID');

        $request = $this->request;

        $pegawai = model('PegawaiModel');
        $profile = $pegawai->getDetailPegawai(rehash($id));
        $row = $profile->asObject()->first();
        if($row === null) {
            return throw new \CodeIgniter\Exceptions\PageNotFoundException('Riwayat Tunjangan Pegawai tidak ditemukan');
        }

        $namalengkap = namalengkap($row->gelar_depan, $row->nama, $row->gelar_blk);
        $data = [
            'title' => "Riwayat Tunjangan - {$namalengkap}",
            'nik' => rehash($id),
            'row' => $row,
        ];

        return view("backend/pages/pegawai/riwayat/tunjangan", $data);
    }
    
}
