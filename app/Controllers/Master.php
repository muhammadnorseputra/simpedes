<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\I18n\Time;
use CodeIgniter\API\ResponseTrait;

class Master extends BaseController
{
    use ResponseTrait;

    protected $db;

    public function __construct() {
        $this->db = db_connect();
    }

    public function jabatan($paramsId = "")
    {
        $request = $this->request;
        if($paramsId !== "" && $request->is("get")) {
            $db = $this->db->table('ref_jabatan')->where('id', $paramsId)->get();
            
            if(count($db->getResultArray()) === 0) {
                return throw PageNotFoundException::forPageNotFound();
            }

            $atasanId = $this->db->table('ref_jabatan')
            ->select('id,nama_jabatan')
            ->where('id', $db->getRow()->id_atasan)
            ->get();
            $data = [
                'row' => count($db->getResultArray()),
                'data' => $db->getRow(),
                'title' => 'Master Jabatan '.$paramsId,
                'getAtasan' => $atasanId->getFirstRow()
            ];

            

            return view('backend/pages/master/jabatan_edit', $data);
        }

        if($request->is("put") && $request->is("ajax")) {
            $input = $request->getPost();
            $data = [
                'nama_jabatan' => $input['nama_jabatan'],
                'id_atasan' => $input['atasan'],
                'jenis' => $input['jenis'],
                'gaji' => str_replace(".", "", $input['gaji']),
                'tunjangan' => str_replace(".", "", $input['tunjangan']),
                'usia_bup' => str_replace(".", "", $input['bup']),
            ];

            $db = $this->db->table('ref_jabatan')->where('id', $input['_id'])->update($data);
            
            if($db) {
                $msg = [
                    'statusCode' => 201,
                    'status' => $data,
                    'message' => 'Data berhasil diperbaharui !',
                ];
            } else {
                $msg = [
                    'statusCode' => 400,
                    'status' => $data,
                    'message' => 'Gagal menambahkan diperbaharui !',
                ];
            }
    
            return $this->response->setJson($msg);
        }

        if($request->is("post") && $request->is("ajax")) {
            $input = $request->getPost();
            $data = [
                'nama_jabatan' => $input['nama_jabatan'],
                'id_atasan' => $input['atasan'],
                'jenis' => $input['jenis'],
                'gaji' => str_replace(".", "", $input['gaji']),
                'tunjangan' => str_replace(".", "", $input['tunjangan']),
                'usia_bup' => str_replace(".", "", $input['bup']),
            ];
    
            $query = $this->db->table('ref_jabatan')->insert($data);
            
            if($query) {
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

        if($request->is("delete") && $request->is("ajax")) {
            $id = $request->getPost('id');
            $db = $this->db->table('ref_jabatan')->delete(['id' => $id]);

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
            'title' => 'Master Jabatan ',
        ];
        return view('backend/pages/master/jabatan', $data);
    }

    public function pegawai($paramsType = "")
    {
        helper(["hash"]);
        $session = session();
        // $image = service('image', 'imagick');

        $now = new Time('now', 'Asia/Jakarta', 'id_ID');

        $request = $this->request;

        if($paramsType === 'peremajaan' && $paramsType !== "") {
            
            $defaultData = $this->db->table('pegawai')->where('nik', rehash($request->getGet('token')))->get(); 
                            
            if($request->is("post") && $request->is("ajax")) {
                $ceknik = $this->db->table('pegawai')->where('nik', $request->getPost('nik'))->get();
                $imageFile = $request->getFile('photo');
                $ktpFile = $request->getFile('photo_ktp');

                // jika data sudah ada dan status ENTRI_ULANG
                if(count($ceknik->getResult()) > 0 && $ceknik->getRow()->status === 'ENTRI_ULANG') {
                    // upload photo
                    $updatePhotoNewName = $request->getPost('nik').".".$imageFile->getClientExtension();
                    if($imageFile->isValid() === true) {
                        $imageFile->move("assets/images/users", $updatePhotoNewName, true);
                    }
                    // upload KTP
                    $updateNewNameKtp = $request->getPost('nik').".".$ktpFile->getClientExtension();
                    if($ktpFile->isValid() === true) {
                        $ktpFile->move("assets/file_ktp/", $updateNewNameKtp, true);
                    }
                    
                    // jika data sudah ada
                    $update = [
                        'no_kk' => $request->getPost('no_kk'),
                        'nipd' => $request->getPost('nipd'),
                        'nama' => strtoupper($request->getPost('nama')),
                        // 'gelar_depan' => $request->getPost('gelar_depan'),
                        // 'gelar_blk' => $request->getPost('gelar_blk'),
                        'tmp_lahir' => $request->getPost('tmp_lahir'),
                        'tgl_lahir' => $request->getPost('tgl_lahir'),
                        'jns_kelamin' => $request->getPost('jns_kelamin'),
                        'fid_unit_kerja' => $request->getPost('fid_unit_kerja'),
                        'fid_agama' => $request->getPost('agama'),
                        'alamat' => $request->getPost('alamat'),
                        'fid_keldesa' => $request->getPost('fid_keldesa'),
                        'no_telp_rumah' => $request->getPost('no_telp_rumah'),
                        'no_hp' => $request->getPost('no_hp'),
                        'email' => strtolower($request->getPost('email')),
                        // 'fid_status_kawin' => $request->getPost('fid_status_kawin'),
                        'no_bpjs_kesehatan' => $request->getPost('no_bpjs_kesehatan'),
                        'no_bpjs_ketenagakerjaan' => $request->getPost('no_bpjs_ketenagakerjaan'),
                        'no_npwp' => $request->getPost('no_npwp'),
                        'photo' => $updatePhotoNewName,
                        'photo_ktp' => $updateNewNameKtp,
                        'status' => 'VERIFIKASI',
                        'updated_at' => $now->addHours(1),
                        'updated_by' => session()->get('nik')
                    ];

                    if($imageFile->hasMoved() === false) {
                        unset($update["photo"]);
                    }

                    if($ktpFile->hasMoved() === false) {
                        unset($update["photo_ktp"]);
                    }

                    $SaveUpdate = $this->db->table('pegawai')->where('nik', $request->getPost('nik'))->update($update);

                    if($SaveUpdate) {
                        $msg = [
                            'statusCode' => 200,
                            'status' => $SaveUpdate,
                            'message' => 'Data berhasil diperbaharui !',
                        ];
                    } else {
                        $msg = [
                            'statusCode' => 500,
                            'status' => $SaveUpdate,
                            'message' => 'Gagal gagal diperbaharui !',
                        ];
                    }
                    return $this->response->setJson($msg);
                    // var_dump($imageFile->hasMoved());die();
                }

                if(count($ceknik->getResult()) > 0 && $ceknik->getRow()->status !== 'ENTRI_ULANG') {
                    $msg = [
                        'statusCode' => 500,
                        'status' => false,
                        'message' => 'NIK atau Pegawai sudah terdaftar !',
                        'data' => count($ceknik->getResult())
                    ];
                    return $this->response->setJson($msg);
                }

                // upload photo
                $newName = $request->getPost('nik').".".$imageFile->getClientExtension();
                $imageFile->move("assets/images/users/", $newName, true);
                // upload KTP
                $newNameKtp = $request->getPost('nik').".".$ktpFile->getClientExtension();
                $ktpFile->move("assets/file_ktp/", $newNameKtp, true);

                $akun = [
                    'nik' => $request->getPost('nik'),
                    'no_kk' => $request->getPost('no_kk'),
                    'nipd' => $request->getPost('nipd'),
                    'nama' => strtoupper($request->getPost('nama')),
                    // 'gelar_depan' => $request->getPost('gelar_depan'),
                    // 'gelar_blk' => $request->getPost('gelar_blk'),
                    'tmp_lahir' => $request->getPost('tmp_lahir'),
                    'tgl_lahir' => $request->getPost('tgl_lahir'),
                    'jns_kelamin' => $request->getPost('jns_kelamin'),
                    'fid_unit_kerja' => $request->getPost('fid_unit_kerja'),
                    'fid_agama' => $request->getPost('agama'),
                    'alamat' => $request->getPost('alamat'),
                    'fid_keldesa' => $request->getPost('fid_keldesa'),
                    'no_telp_rumah' => $request->getPost('no_telp_rumah'),
                    'no_hp' => $request->getPost('no_hp'),
                    'email' => strtolower($request->getPost('email')),
                    // 'fid_status_kawin' => $request->getPost('fid_status_kawin'),
                    'no_bpjs_kesehatan' => $request->getPost('no_bpjs_kesehatan'),
                    'no_bpjs_ketenagakerjaan' => $request->getPost('no_bpjs_ketenagakerjaan'),
                    'no_npwp' => $request->getPost('no_npwp'),
                    'photo' => $newName,
                    'photo_ktp' => $newNameKtp,
                    'status' => 'VERIFIKASI',
                    'created_at' => $now->addHours(1),
                    'created_by' => session()->get('nik') 
                ];
                $save = $this->db->table('pegawai')->insert($akun);
                if($save) {
                    $msg = [
                        'statusCode' => 201,
                        'status' => true,
                        'message' => 'Data berhasil ditambahkan !',
                        'redirect' => base_url("/app/master/pegawai/peremajaan?token=".dohash($request->getPost('nik')))
                    ];
                } else {
                    $msg = [
                        'statusCode' => 500,
                        'status' => fales,
                        'message' => 'Gagal gagal ditambahkan !',
                        'redirect' => false
                    ];
                }
                return $this->response->setJson($msg);
            }

            if($request->is("put") && $request->is("ajax")) {
                $nik = $request->getPost('token');
                $update = [
                    'status' => 'VERIFIKASI'
                ];
                $db = $this->db->table('pegawai')->where('nik', rehash($nik))->update($update);
                if($db) {
                    $msg = [
                        'statusCode' => 200,
                        'status' => $db,
                        'message' => 'Data usulan berhasil dikirim !',
                    ];
                    return $this->response->setJson($msg);
                } 

                $msg = [
                    'statusCode' => 500,
                    'status' => $db,
                    'message' => 'Data usulan gagal dikirim !',
                ];
                return $this->response->setJson($msg);
            }

            if($request->is("patch") && $request->is("ajax")) {

                $nik = $request->getPost('token');
                $update = [
                    'status' => $request->getPost('status'),
                    'ket_status' => $request->getPost('ket_status')
                ];
                $db = $this->db->table('pegawai')->where('nik', rehash($nik))->update($update);
                if($db) {
                    $msg = [
                        'statusCode' => 200,
                        'status' => $db,
                        'message' => 'Data usulan berhasil diverifikasi !',
                        'redirect' => base_url('app/master/pegawai')
                    ];
                } else {
                    $msg = [
                        'statusCode' => 500,
                        'status' => $db,
                        'message' => 'Data usulan gagal diverifikasi !',
                        'redirect' => false
                    ];
                }
                return $this->response->setJson($msg);
            }

            $defaultDesa = $this->db->table('ref_desa')->where('id_desa', @$defaultData->getFirstRow()->fid_keldesa)->get();
            $defaultUnitKerja = $this->db->table('ref_unit_kerja')->where('id_unit_kerja', @$defaultData->getFirstRow()->fid_unit_kerja)->get();
            
            // jika status data verifikasi
            if(@$defaultData->getRow()->status !== 'ENTRI_ULANG' 
            && @$defaultData->getRow()->status !== 'ENTRI' 
            && $session->get('role') !== 'ADMIN'
            && $session->get('role') !== 'USER'
            && isset($defaultData->getRow()->status)):
                $data = [
                    'title' => 'Verifikasi Usulan Pegawai',
                    'status' => @$defaultData->getRow()
                ];
                return view('backend/pages/master/pegawai_status', $data);
            endif;
            // jika halaman tambah pegawai
            $data = [
                'title' => 'Master Tambah Pegawai',
                'default' => $defaultData->getRow(),
                'db' => $this->db,
                'desa' => $defaultDesa,
                'unit_kerja' => $defaultUnitKerja
            ];
            return view('backend/pages/master/pegawai_add', $data);
        };

        if(session()->role === 'OPERATOR') {
            return redirect()->to('app/pegawai/unit');
        }

        $data = [
            'title' => 'Master Pegawai',
        ];
        return view('backend/pages/master/pegawai', $data);
    }

    public function users($paramsType = "") {
        helper("hash");

        $request = $this->request;
        if($request->is('put') && $request->is('ajax') && $paramsType === 'status-active') {
            $data = [
                'is_disabled' => $request->getPost('status')
            ];
            $db = $this->db->table('users')->where('nik', $request->getPost('token'))->update($data);
            if($db)
            {
                $msg = [
                    'status' => true,
                    'message' => 'User diperbaharui',
                ];
                return $this->respond($msg, 200);
            }
            return $this->failNotFound('User not disabled');
        }

        if($request->is('put') && $request->is('ajax') && $paramsType === 'set-role') {
            $data = [
                'role' => $request->getPost('role')
            ];
            $db = $this->db->table('users')->where('nik', $request->getPost('token'))->update($data);
            if($db)
            {
                $msg = [
                    'status' => true,
                    'message' => 'Role user diperbaharui',
                ];
                return $this->respond($msg, 200);
            }
            return $this->failNotFound('User not disabled');
        }

        if($request->is('patch') && $request->is('ajax')) {
            $data = [
                'password' => password_hash($request->getPost('retype_new_password'), PASSWORD_DEFAULT)
            ];
            $db = $this->db->table('users')->where('nik', $request->getPost('token'))->update($data);
            if($db)
            {
                $msg = [
                    'status' => true,
                    'message' => 'Password telah diperbaharui',
                ];
                return $this->respond($msg, 200);
            }
            $msg = [
                'status' => false,
                'message' => 'Password gagal diperbaharui',
            ];
            return $this->respond($msg, 400);
        }
        
        if($request->is('put') && $request->is('ajax') && $paramsType === 'ganti-password') {
            $data = [
                'password' => password_hash($request->getPost('retype_new_password'), PASSWORD_DEFAULT)
            ];
            $db = $this->db->table('users')->where('nik', rehash($request->getPost('token')))->update($data);
            if($db)
            {
                $msg = [
                    'status' => true,
                    'message' => 'Password telah diperbaharui',
                ];
                return $this->respond($msg, 200);
            }
            $msg = [
                'status' => false,
                'message' => 'Password gagal diperbaharui',
            ];
            return $this->respond($msg, 400);
        }

        if($request->is('post') && $request->is('ajax')) {
            // ENTRI MANUAL
            if($request->getPost('is_manual') === 'YA')
            {
                $data = [
                    'nik' => $request->getPost('nik'),
                    'role' => $request->getPost('role'),
                    'username' => $request->getPost('username'),
                    'password' => password_hash($request->getPost('password'), PASSWORD_DEFAULT),
                    'fid_unit_kerja' => $request->getPost('fid_unit_kerja'),
                    'created_by' => session()->name
                ];
                $created = $this->db->table('users')->insert($data);
                if($created) {
                    $msg = [
                        'status' => true,
                        'message' => 'Userportal (Manual) Berhasil Ditambahkan',
                        'data' => $data
                    ];
                    return $this->respond($msg, 201);
                }
    
                $msg = [
                    'status' => false,
                    'message' => 'Userportal (Manual) gagal ditambahkan',
                    'data' => $data
                ];
                return $this->respond($msg, 400);
            }
            // ENTRI MANUAL DINAS
            if($request->getPost('is_manual') === 'DINAS')
            {
                $data = [
                    'nik' => $request->getPost('nik'),
                    'role' => 'USER',
                    'username' => $request->getPost('username'),
                    'password' => password_hash($request->getPost('password'), PASSWORD_DEFAULT),
                    'fid_unit_kerja' => 0,
                    'created_by' => session()->name
                ];
                $created = $this->db->table('users')->insert($data);
                if($created) {
                    $msg = [
                        'status' => true,
                        'message' => 'Userportal (Dinas) Berhasil Ditambahkan',
                        'data' => $data
                    ];
                    return $this->respond($msg, 201);
                }
    
                $msg = [
                    'status' => false,
                    'message' => 'Userportal (Dinas) gagal ditambahkan',
                    'data' => $data
                ];
                return $this->respond($msg, 400);
            }
            // ENTRI BY PEGAWAI
            $data = [
                'nik' => $request->getPost('token'),
                'role' => $request->getPost('role'),
                'username' => $request->getPost('username'),
                'password' => password_hash($request->getPost('password'), PASSWORD_DEFAULT),
                'fid_unit_kerja' => $request->getPost('fid_unit_kerja'),
                'created_by' => session()->name
            ];
            $created = $this->db->table('users')->insert($data);
            if($created) {
                $msg = [
                    'status' => true,
                    'message' => 'Userportal Berhasil Ditambahkan',
                    'data' => $data
                ];
                return $this->respond($msg, 201);
            }

            $msg = [
                'status' => false,
                'message' => 'Userportal gagal ditambahkan',
                'data' => $data
            ];
            return $this->respond($msg, 400);

        }

        if($request->is('get') && $paramsType === 'ganti-password')
        {
            $data = [
                'title' => 'Ganti Password ',
                'nik' => dohash(session()->nik)
            ];
            return view('backend/pages/master/ganti_password', $data);
        }

        $data = [
            'title' => 'Userportal '
        ];
        return view('backend/pages/master/users', $data);
    }
}
