<?php  
namespace App\Controllers;

class AjaxSelect2 extends BaseController
{

    public function __construct() {
        $this->db = db_connect();
    }


    public function kecamatan()
    {
        $request = service('request');
        $postData = $request->getPost();

        $response = array();

        // Read new token and assign in $response['token']
        $response[csrf_token()] = csrf_hash();

        if(!isset($postData['searchTerm'])){
            // Fetch record
            $kecamatan = $this->db->table('ref_kecamatan')->orderBy('id_kecamatan', 'desc')->get();
        }else{
            $searchTerm = $postData['searchTerm'];
            // Fetch record
            $kecamatan = $this->db->table('ref_kecamatan')->like('nama_kecamatan',$searchTerm)->orderBy('id_kecamatan', 'desc')->get();
        } 
        $data = array();
        foreach($kecamatan->getResult() as $list){
            $data[] = array(
                "id" => $list->id_kecamatan,
                "text" => ucwords($list->nama_kecamatan),
            );
        }

        $response['data'] = $data;

        return $this->response->setJSON($response);

    }

    public function desa()
    {
        $request = service('request');
        $postData = $request->getPost();

        $response = array();

        // Read new token and assign in $response['token']
        $response[csrf_token()] = csrf_hash();
        $q = @$postData['searchTerm'];
        // Fetch record
        if($q === "" || empty($q)) {
            $response['data'] = [[
                "id" => 0,
                "text" => 'Silahkan ketikan kata kunci yang benar',
                'disabled' => true
            ]];
            return $this->response->setJSON($response);
        }
        // if(session()->role === 'OPERATOR' || session()->role === 'USER'):
            // $desa = $this->db->table('ref_desa')->where('id_desa', session()->id_desa)->orderBy('id_desa', 'desc')->get();
        // else:
        $desa = $this->db->table('ref_desa d')
        ->join('ref_kecamatan k', 'd.fid_kecamatan=k.id_kecamatan')
        ->like('d.nama_desa', $q)
        ->orderBy('d.id_desa', 'desc')
        ->get();
        // endif;
        if(count($desa->getResultArray()) > 0):
            $data = array();
            foreach($desa->getResult() as $list){
                $data[] = array(
                    "id" => $list->id_desa,
                    "text" => ucwords(strtolower($list->nama_desa))." - Kec. ".ucwords(strtolower($list->nama_kecamatan)),
                );
            }

            $response['data'] = $data;

            return $this->response->setJSON($response);
        endif;

        $response['data'] = [[
            "id" => 0,
            "text" => 'Data tidak ditemukan, silahkan ketikan kata kunci yang benar',
            'disabled' => true
        ]];

        return $this->response->setJSON($response);


    }

    public function unit_kerja()
    {
        $request = service('request');
        $postData = $request->getPost();

        $response = array();

        // Read new token and assign in $response['token']
        $response[csrf_token()] = csrf_hash();
        $q = @$postData['searchTerm'];
        // Fetch record
        // if($q === "" || empty($q)) {
        //     $response['data'] = [[
        //         "id" => 0,
        //         "text" => 'Silahkan ketikan kata kunci yang benar',
        //         'disabled' => true
        //     ]];
        //     return $this->response->setJSON($response);
        // }
        if(session()->role === 'OPERATOR'):
            $unor = $this->db->table('ref_unit_kerja u')
            ->join('ref_kecamatan k', 'u.kecamatan=k.id_kecamatan')
            ->where('u.aktif', 'Y')
            ->where('u.id_unit_kerja', session()->id_unit_kerja)
            ->orderBy('u.id_unit_kerja', 'desc')
            ->get();
        else:
            $unor = $this->db->table('ref_unit_kerja u')
            ->join('ref_kecamatan k', 'u.kecamatan=k.id_kecamatan')
            ->where('u.aktif', 'Y')
            ->like('u.nama_unit_kerja', $q)
            ->orderBy('u.id_unit_kerja', 'desc')
            ->get();
        endif;
        if(count($unor->getResultArray()) > 0):
            $data = array();
            foreach($unor->getResult() as $list){
                $data[] = array(
                    "id" => $list->id_unit_kerja,
                    "text" => ucwords($list->nama_unit_kerja)." - Kec. ".ucwords(strtolower($list->nama_kecamatan)),
                );
            }

            $response['data'] = $data;

            return $this->response->setJSON($response);
        endif;

        $response['data'] = [[
            "id" => 0,
            "text" => 'Data tidak ditemukan, silahkan ketikan kata kunci yang benar',
            'disabled' => true
        ]];

        return $this->response->setJSON($response);


    }

    public function unit_kerja_list()
    {
        $request = service('request');
        $postData = $request->getPost();

        $response = array();

        // Read new token and assign in $response['token']
        $response[csrf_token()] = csrf_hash();

        if(!isset($postData['searchTerm'])){
            // Fetch record
            $unor = $this->db->table('ref_unit_kerja u')
            ->join('ref_kecamatan k', 'u.kecamatan=k.id_kecamatan')
            ->where('u.aktif', 'Y')
            ->orderBy('u.id_unit_kerja', 'desc')
            ->get();
        }else{
            $searchTerm = $postData['searchTerm'];
            // Fetch record
            $unor = $this->db->table('ref_unit_kerja u')
            ->join('ref_kecamatan k', 'u.kecamatan=k.id_kecamatan')
            ->where('u.aktif', 'Y')
            ->like('u.nama_unit_kerja', $searchTerm)
            ->orderBy('u.id_unit_kerja', 'desc')
            ->get();
        } 
        $data = array();
        foreach($unor->getResult() as $list){
            $data[] = array(
                "id" => $list->id_unit_kerja,
                "text" => ucwords(strtolower($list->nama_unit_kerja))." - Kec. ".ucwords(strtolower($list->nama_kecamatan)),
            );
        }

        $response['data'] = $data;

        return $this->response->setJSON($response);

    }

    public function atasan_type($jenis,$q)
    {
        if(empty($q)) {
            $child = $this->db->table('ref_jabatan')->where('jenis', $jenis)->orderBy('id', 'desc')->get();
        } else {
            $child = $this->db->table('ref_jabatan')->where('jenis', $jenis)->like('nama_jabatan',$q)->orderBy('id', 'asc')->get();
        };
        
        $data = [];
        foreach($child->getResult() as $list){
            $data[] = array(
                "id" => $list->id,
                "text" => strtoupper($list->nama_jabatan),
            );
        };

        return $data;
    }

    public function atasan()
    {
        $request = service('request');
        $postData = $request->getPost();

        $response = array();

        // Read new token and assign in $response['token']
        $response[csrf_token()] = csrf_hash();

        $atasan = $this->db->table('ref_jabatan')->orderBy('id', 'desc')->groupBy('jenis')->get();
        $data = array();
        foreach($atasan->getResult() as $list){
            $data[] = array(
                "id" => $list->id,
                "text" => strtoupper($list->jenis),
                "children" => $this->atasan_type($list->jenis, @$postData['searchTerm'])
            );
        }

        $response['data'] = $data;

        return $this->response->setJSON($response);

    }

    public function pegawai()
    {

        $request = service('request');
        $postData = $request->getPost();

        $response = array();
        // set count page
        $page = $postData['page'];
        $resultCount = 10;
        $offset = ($page - 1) * $resultCount;

        // Read new token and assign in $response['token']
        $response[csrf_token()] = csrf_hash();
        $q = @$postData['searchTerm'];
        // Fetch record
        // if($q === "" || empty($q)) {
        //     $response['data'] = [[
        //         "id" => 0,
        //         "text" => 'Silahkan ketikan kata kunci yang benar',
        //         'disabled' => true
        //     ]];
        //     return $this->response->setJSON($response);
        // }

        if(session()->role === 'OPERATOR' || session()->role === 'USER'):
        $pegawai = $this->db->table('pegawai')
            ->where('status', 'AKTIF')
            ->where('fid_unit_kerja', session()->id_unit_kerja)
            ->groupStart()
                ->like('nama', $q)
                ->orLike('nik', $q)
            ->groupEnd()
            ->orderBy('created_at', 'desc')
            ->limit($resultCount)
            ->offset($offset);
        else:
            $pegawai = $this->db->table('pegawai')
            ->where('status', 'AKTIF')
            ->groupStart()
                ->like('nama', $q)
                ->orLike('nik', $q)
            ->groupEnd()
            ->orderBy('created_at', 'desc')
            ->limit($resultCount)
            ->offset($offset);
        endif;

        if($pegawai->countAllResults() > 0):
            $data = array();
            foreach($pegawai->get()->getResult() as $list){
                $data[] = array(
                    "id" => $list->nik,
                    "text" => $list->nik." - ".namalengkap($list->gelar_depan,$list->nama,$list->gelar_blk),
                );
            }

            $count = count($data) === $resultCount ? $pegawai->countAllResults() : count($data);
            $endCount = $offset + $resultCount;
            $morePages = $count > $endCount;

            $response["pagination"] = [
                "more" => $morePages,
                "count" => $count
            ];

            $response['results'] = $data;

            return $this->response->setJSON($response);
        endif;

        $response['results'] = [[
            "id" => 0,
            "text" => 'Data tidak ditemukan, silahkan ketikan kata kunci yang benar',
            'disabled' => true
        ]];

        return $this->response->setJSON($response);
    }

    public function show_pegawai()
    {

        $nik = $this->request->getGet('nik');
        if($this->request->is('ajax')):
            $builder = $this->db->table('pegawai p')
            ->select('p.nik,p.photo,p.gelar_depan,p.gelar_blk,p.nama,p.photo,u.nama_unit_kerja,u.id_unit_kerja,j.nama_jabatan')
            ->join('ref_unit_kerja u', 'p.fid_unit_kerja=u.id_unit_kerja')
            ->join('ref_jabatan j', 'p.fid_jabatan=j.id')
            ->where('p.nik', $nik);

            if($builder->countAllResults(false) > 0) {
                $row = $builder->get()->getRow();
                $data = [
                'status' => true,
                'message' => "NIK. {$nik} Ditemukan",
                'data' => [
                        'nik' => $row->nik,
                        'photo' => base_url("assets/images/users/".$row->photo),
                        'nama' => namalengkap($row->gelar_depan, $row->nama, $row->gelar_blk),
                        'nama_jabatan' => $row->nama_jabatan,
                        'nama_unit_kerja' => $row->nama_unit_kerja,
                        'id_unit_kerja' => $row->id_unit_kerja
                    ]
                ]; 
                return $this->response->setJson($data);
            };

            $data = [
                'status' => false,
                'message' => 'NIK tidak ditemukan',
                'data' => []
            ];
            return $this->response->setJson($data);
        endif;
    }

    public function tingkat_pendidikan()
    {
        $postData = $this->request->getPost();

        $response = array();

        // Read new token and assign in $response['token']
        $response[csrf_token()] = csrf_hash();

        if(!isset($postData['searchTerm'])){
            // Fetch record
            $query = $this->db->table('ref_tingkat_pendidikan')->orderBy('id_tingkat_pendidikan', 'desc')->get();
        }else{
            $searchTerm = $postData['searchTerm'];
            // Fetch record
            $query = $this->db->table('ref_tingkat_pendidikan')->like('nama_tingkat_pendidikan',$searchTerm)
            ->orderBy('id_tingkat_pendidikan', 'desc')
            ->get();
        } 
        $data = array();
        foreach($query->getResult() as $list){
            $data[] = array(
                "id" => $list->id_tingkat_pendidikan,
                "text" => ucwords($list->nama_tingkat_pendidikan),
            );
        }

        $response['data'] = $data;

        return $this->response->setJSON($response);
    }

    public function jurusan_pendidikan()
    {
        $request = service('request');
        $postData = $request->getPost();

        $response = array();

        // Read new token and assign in $response['token']
        $response[csrf_token()] = csrf_hash();
        $q = @$postData['searchTerm'];
        // Fetch record
        if(empty($postData['id_tingkat_pendidikan'])) {
            $response['data'] = [[
                "id" => 0,
                "text" => 'Silahkan pilih tingkat pendidikan',
                'disabled' => true
            ]];
            return $this->response->setJSON($response);
        }
        
        if($q === "" || empty($q)) {
            $response['data'] = [[
                "id" => 0,
                "text" => 'Silahkan ketikan kata kunci yang benar',
                'disabled' => true
            ]];
            return $this->response->setJSON($response);
        }

        $db = $this->db->table('ref_jurusan_pendidikan')
        ->like('nama_jurusan_pendidikan', $q)
        ->where('fid_tingkat_pendidikan', $postData['id_tingkat_pendidikan'])
        ->orderBy('id_jurusan_pendidikan', 'desc')->get();
        
        if(count($db->getResultArray()) > 0):
            $data = array();
            foreach($db->getResult() as $list){
                $data[] = array(
                    "id" => $list->id_jurusan_pendidikan,
                    "text" => $list->nama_jurusan_pendidikan,
                );
            }

            $response['data'] = $data;

            return $this->response->setJSON($response);
        endif;

        $response['data'] = [[
            "id" => 0,
            "text" => 'Data tidak ditemukan, silahkan ketikan kata kunci yang benar',
            'disabled' => true
        ]];

        return $this->response->setJSON($response);
    }

    public function jenis_workshop()
    {
        $postData = $this->request->getPost();

        $response = array();

        // Read new token and assign in $response['token']
        $response[csrf_token()] = csrf_hash();

        if(!isset($postData['searchTerm'])){
            // Fetch record
            $query = $this->db->table('ref_jenis_workshop')->orderBy('id_jenis_workshop', 'desc')->get();
        }else{
            $searchTerm = $postData['searchTerm'];
            // Fetch record
            $query = $this->db->table('ref_jenis_workshop')->like('nama_jenis_workshop',$searchTerm)
            ->orderBy('id_jenis_workshop', 'desc')
            ->get();
        } 
        $data = array();
        foreach($query->getResult() as $list){
            $data[] = array(
                "id" => $list->id_jenis_workshop,
                "text" => ucwords($list->nama_jenis_workshop),
            );
        }

        $response['data'] = $data;

        return $this->response->setJSON($response);
    }

    public function rumpun_diklat()
    {
        $postData = $this->request->getPost();

        $response = array();

        $page = $postData['page'];
        $resultCount = 10;
        $offset = ($page - 1) * $resultCount;

        // Read new token and assign in $response['token']
        $response[csrf_token()] = csrf_hash();
        $searchTerm = $postData['searchTerm'];
        // Fetch record
        $query = $this->db->table('ref_rumpun_diklat')
        ->like('nama_rumpun_diklat', $searchTerm)
        ->orderBy('id_rumpun_diklat', 'desc')
        ->limit($resultCount)
        ->offset($offset);

        $data = array();
        foreach($query->get()->getResult() as $list){
            $data[] = array(
                "id" => $list->id_rumpun_diklat,
                "text" => ucwords($list->nama_rumpun_diklat)
            );
        }

        $count = count($data) === $resultCount ? $query->countAllResults() : count($data);
        $endCount = $offset + $resultCount;
        $morePages = $count > $endCount;

        $response["pagination"] = [
            "more" => $morePages,
            "count" => $count
        ];

        $response['results'] = $data;

        return $this->response->setJSON($response);
    }
}

?>