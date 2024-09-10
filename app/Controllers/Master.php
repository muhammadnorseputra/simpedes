<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Master extends BaseController
{
    public function jabatan($paramsId = "")
    {
        $request = $this->request;

        if($paramsId !== "" && $request->is("get")) {
            $db = db_connect()->table('ref_jabatan')->where('id', $paramsId)->get();
            $data = [
                'row' => count($db->getResultArray()),
                'data' => $db->getRow(),
                'title' => 'Master Jabatan '.$paramsId.' - Simpedes Kab. Balangan',
            ];
            return view('backend/pages/master/jabatan_edit', $data);
        }

        if($request->is("post")) {
            $input = $request->getPost();
            $data = [
                'nama_jabatan' => $input['nama_jabatan'],
                'id_atasan' => $input['atasan'],
                'jenis' => $input['jenis'],
                'gaji' => str_replace(".", "", $input['gaji']),
                'tunjangan' => str_replace(".", "", $input['tunjangan']),
                'usia_bup' => str_replace(".", "", $input['bup']),
            ];
    
            $db = db_connect()->table('ref_jabatan')->insert($data);
            
            if($db) {
                $msg = [
                    'statusCode' => 201,
                    'status' => $data,
                    'message' => 'Data berhasil ditambahkan !',
                ];
            } else {
                $msg = [
                    'statusCode' => 400,
                    'status' => $data,
                    'message' => 'Gagal menambahkan data !',
                ];
            }
    
            return $this->response->setJson($msg);
        }

        if($request->is("delete")) {
            $id = $request->getPost('id');
            $db = db_connect()->table('ref_jabatan')->delete(['id' => $id]);

            if($db) {
                $msg = [
                    'statusCode' => 201,
                    'status' => $db,
                    'message' => 'Data berhasil dihapus !',
                ];
            } else {
                $msg = [
                    'statusCode' => 400,
                    'status' => $db,
                    'message' => 'Gagal menghapus data !',
                ];
            }
    
            return $this->response->setJson($msg);
        }

        $data = [
            'title' => 'Master Jabatan - Simpedes Kab. Balangan',
        ];
        return view('backend/pages/master/jabatan', $data);
    }

    public function pegawai()
    {
        $data = [
            'title' => 'Master Pegawai - Simpedes Kab. Balangan',
        ];
        return view('backend/pages/master/pegawai', $data);
    }
}
