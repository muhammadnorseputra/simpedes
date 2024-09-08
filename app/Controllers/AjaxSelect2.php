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
        $response['csrf_token_simpedes'] = csrf_hash();

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

}

?>