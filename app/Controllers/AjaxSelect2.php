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

        $desa = $this->db->table('ref_desa')->like('nama_desa', $q)->orderBy('id_desa', 'desc')->get();
        
        if(count($desa->getResultArray()) > 0):
            $data = array();
            foreach($desa->getResult() as $list){
                $data[] = array(
                    "id" => $list->id_desa,
                    "text" => ucwords($list->nama_desa),
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
        if($q === "" || empty($q)) {
            $response['data'] = [[
                "id" => 0,
                "text" => 'Silahkan ketikan kata kunci yang benar',
                'disabled' => true
            ]];
            return $this->response->setJSON($response);
        }

        $desa = $this->db->table('ref_unit_kerja')->where('aktif', 'Y')->like('nama_unit_kerja', $q)->orderBy('id_unit_kerja', 'desc')->get();
        
        if(count($desa->getResultArray()) > 0):
            $data = array();
            foreach($desa->getResult() as $list){
                $data[] = array(
                    "id" => $list->id_unit_kerja,
                    "text" => ucwords($list->nama_unit_kerja),
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
        helper("pegawai");

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

        $pegawai = $this->db->table('pegawai')->like('nama', $q)->orLike('nik', $q)->where('status', 'AKTIF')->orderBy('created_at', 'desc')->get();
        
        if(count($pegawai->getResultArray()) > 0):
            $data = array();
            foreach($pegawai->getResult() as $list){
                $data[] = array(
                    "id" => $list->nik,
                    "text" => $list->nik." (".namalengkap($list->gelar_depan,$list->nama,$list->gelar_blk).")",
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

    public function show_pegawai()
    {
        helper("pegawai");

        $nik = $this->request->getGet('nik');
        if($this->request->is('ajax')):
        $builder = $this->db->table('pegawai p')
        ->select('p.nik,p.photo,p.gelar_depan,p.gelar_blk,p.nama,p.photo,u.nama_unit_kerja')
        ->join('ref_unit_kerja u', 'p.fid_unit_kerja=u.id_unit_kerja')
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
                    'nama_unit_kerja' => $row->nama_unit_kerja
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

}

?>