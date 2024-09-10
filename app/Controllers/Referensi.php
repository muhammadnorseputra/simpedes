<?php  
namespace App\Controllers;

use \Hermawan\DataTables\DataTable;

class Referensi extends BaseController
{

    public function __construct() {
        $this->db = db_connect();
    }
    
    public function agama(): string
    {
        $data = [
            'title' => 'Referensi Agama - Simpedes Kab. Balangan',
        ];
        return view('backend/pages/referensi/agama', $data);
    }

    public function kecamatan(): string
    {
        $data = [
            'title' => 'Referensi Kecamatan - Simpedes Kab. Balangan',
        ];
        return view('backend/pages/referensi/kecamatan', $data);
    }

    public function desa(): string
    {
        $data = [
            'title' => 'Referensi Desa - Simpedes Kab. Balangan',
        ];
        return view('backend/pages/referensi/desa', $data);
    }

    public function jenis_workshop(): string
    {
        $data = [
            'title' => 'Referensi Jenis Workshop - Simpedes Kab. Balangan',
        ];
        return view('backend/pages/referensi/jenis_workshop', $data);
    }

    public function tingkat_pendidikan(): string
    {
        $data = [
            'title' => 'Referensi Tingkat Pendidikan - Simpedes Kab. Balangan',
        ];
        return view('backend/pages/referensi/tingkat_pendidikan', $data);
    }

    public function jurusan_pendidikan(): string
    {
        $data = [
            'title' => 'Referensi Jurusan Pendidikan - Simpedes Kab. Balangan',
        ];
        return view('backend/pages/referensi/jurusan_pendidikan', $data);
    }

    public function rumpun_diklat(): string
    {
        $data = [
            'title' => 'Referensi Rumpun Diklat - Simpedes Kab. Balangan',
        ];
        return view('backend/pages/referensi/rumpun_diklat', $data);
    }

    public function satuan_unit_kerja($mode="",$id=""): string
    {
        if($mode === 'edit') {
            $row = $this->db->table('ref_unit_kerja')->where('id_unit_kerja', $id)->get();
            $kecamatan = $this->db->table('ref_kecamatan')->orderBy('id_kecamatan', 'desc')->get();
            $data = [
                'title' => $row->getRow()->nama_unit_kerja.' - Simpedes Kab. Balangan',
                'id' => $id,
                'row' => $row->getRow(),
                'kecamatan' => $kecamatan->getResult(),
            ];
            return view('backend/pages/referensi/satuan_unit_kerja_edit', $data);
        };

        $data = [
            'title' => 'Referensi Satuan Unit Kerja - Simpedes Kab. Balangan',
        ];
        return view('backend/pages/referensi/satuan_unit_kerja', $data);
    }

    public function simpan_satuan_unit_kerja()
    {
        $req = service('request');
        $input = $req->getPost();

        $data = [
            'nama_unit_kerja' => $input['nama_unit_kerja'],
            'aktif' => $input['aktif'],
            'alamat' => $input['alamat'],
            'kecamatan' => $input['kecamatan'],
            'telepon' => $input['nohp'],
            'terpencil' => $input['terpencil'],
            'latitude' => $input['lat'],
            'longitude' => $input['long'],
            'link_google_map' => $input['map'],
        ];

        $db = $this->db->table('ref_unit_kerja')->insert($data);
        
        if($db) {
            $msg = [
                'statusCode' => 201,
                'status' => true,
                'message' => 'Data berhasil ditambahkan !',
                'data' => $data
            ];
        } else {
            $msg = [
                'statusCode' => 400,
                'status' => false,
                'message' => 'Gagal menambahkan data !',
                'data' => []
            ];
        }

        return $this->response->setJson($msg);
    }

    public function hapus_satuan_unit_kerja()
    {

        $db = $this->db->table('ref_unit_kerja')->where('id_unit_kerja', $this->request->getPost('id'))->delete();
        
        if($db) {
            $msg = [
                'statusCode' => 200,
                'status' => true,
                'message' => 'Data berhasil dihapus !',
                'data' => $db
            ];
        } else {
            $msg = [
                'statusCode' => 400,
                'status' => false,
                'message' => 'Data gagal dihapus !',
                'data' => []
            ];
        }

        return $this->response->setJson($msg);
    }

    public function update_satuan_unit_kerja($id = "")
    {
        if($id !== "") {
            $post  = $this->request->getPost();
            $data = [
                'nama_unit_kerja' => $post['nama_unit_kerja'],
                'aktif' => $post['aktif'],
                'alamat' => $post['alamat'],
                'kecamatan' => $post['kecamatan'],
                'telepon' => $post['nohp'],
                'terpencil' => $post['terpencil'],
                'latitude' => $post['lat'],
                'longitude' => $post['long'],
                'link_google_map' => $post['map'],
            ];
            $db = $this->db->table('ref_unit_kerja')->where('id_unit_kerja', $post['id'])->update($data);
            
            if($db) {
                $msg = [
                    'statusCode' => 200,
                    'status' => true,
                    'message' => 'Data telah diperbaharui',
                    'data' => $db
                ];
            } else {
                $msg = [
                    'statusCode' => 400,
                    'status' => false,
                    'message' => 'Data gagal diperbaharui !',
                    'data' => $db
                ];
            }
    
            return $this->response->setJson($msg);
        }

        $flag = $this->request->getPost('flag');
        $flagIs = $flag === 'Y' ? 'Enabled' : 'Disabled';
        $data = [
            'aktif' => $flag
        ];
        $db = $this->db->table('ref_unit_kerja')->where('id_unit_kerja', $this->request->getPost('id'))->update($data);
        
        if($db) {
            $msg = [
                'statusCode' => 200,
                'status' => true,
                'message' => 'Flag is '.$flagIs,
                'data' => $db
            ];
        } else {
            $msg = [
                'statusCode' => 400,
                'status' => false,
                'message' => 'Data gagal diupdate !',
                'data' => []
            ];
        }

        return $this->response->setJson($msg);
    }

}

?>