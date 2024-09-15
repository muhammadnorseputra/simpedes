<?php

namespace App\Controllers;

use \App\Models\UserModel;

class Auth extends BaseController
{

    public function index(): string
    {
        $config = config('SiteConfig');
        $data = [
            'config' => $config
        ];
        return view('backend/auth', $data);
    }

    public function action() {
        helper("pegawai");
        $session = session();
        $db = new UserModel();

        if($this->request->isAjax()) {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
        }

        $data = $db->where('username', $username)->first();
        if ($data) {
            $passwordHash = $data['password'];
            $verify_pass = password_verify($password, $passwordHash);
            if($verify_pass) {
                $builder = $db->builder();
                $profile = $builder->select('users.*,p.gelar_depan,p.gelar_blk,p.nama,p.email,p.photo,u.id_unit_kerja,
                u.nama_unit_kerja')
                ->join('pegawai p', 'users.nik=p.nik', 'left')
                ->join('ref_unit_kerja u', 'p.fid_unit_kerja=u.id_unit_kerja', 'left')
                ->where('users.username', $username)
                ->where('users.is_disabled', 'N')
                ->where('p.status', 'AKTIF')->get()->getFirstRow();
                // dd($profile);
                if($profile === null) {
                    $res = [
                        'status' => false,
                        'message' => 'Profile pegawai tidak ditemukan atau non aktif.',
                        'data' => []
                    ];
                    return $this->response->setJson($res);
                }

                $sessionSetData = [
                    'nik'       => $profile->nik,
                    'photo' => $profile->photo,
                    'name'     => strtolower($profile->nama),
                    'fullname'     => namalengkap($profile->gelar_depan,$profile->nama,$profile->gelar_blk),
                    'email'    => $profile->email,
                    'username'    => $profile->username,
                    'role' => $profile->role,
                    'id_unit_kerja' => $profile->id_unit_kerja,
                    'nama_unit_kerja' => $profile->nama_unit_kerja,
                    'isLogin'     => TRUE
                ];
                $session->set($sessionSetData);
                $res = [
                        'status' => true,
                        'message' => 'Login Berhasil !, mohon tunggu redirect ...',
                        'data' => [
                            'redirect' => base_url('/app/dashboard'),
                        ]
                    ];
            } else {
                $res = [
                    'status' => false,
                    'message' => 'Wrong Username & Password',
                    'data' => []
                ];
            }
        } else {
            $res = [
                'status' => false,
                'message' => 'Account Not Found',
                'data' => [
                    'username' => $username,
                ]
            ];
        }

        return $this->response->setJson($res);
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/auth');
    }
}
