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

        $data = $db->join('pegawai', 'users.nik=pegawai.nik', 'left')
        ->groupStart()
            ->where('users.username', $username)
            ->orWhere('pegawai.nipd', $username)
        ->groupEnd()
        ->orWhere('pegawai.email', $username)
        ->first();
        if ($data) {
            $passwordHash = $data['password'];
            $verify_pass = password_verify($password, $passwordHash);
            if($verify_pass) {
                $builder = $db->builder();
                $profile = $builder->select('users.*,p.gelar_depan,p.gelar_blk,p.nama,p.email,p.photo,u.id_unit_kerja,
                u.nama_unit_kerja,rj.id as id_jabatan,rj.nama_jabatan,rj.jenis as jenis_jabatan,rd.id_desa,rd.nama_desa')
                ->join('pegawai p', 'users.nik=p.nik', 'left')
                ->join('ref_unit_kerja u', 'p.fid_unit_kerja=u.id_unit_kerja', 'left')
                ->join('ref_jabatan rj', 'p.fid_jabatan=rj.id', 'left')
                ->join('ref_desa rd', 'p.fid_keldesa=rd.id_desa', 'left')
                ->groupStart()
                    ->where('users.username', $username)
                    ->orWhere('p.nipd', $username)
                    ->orWhere('p.email', $username)
                ->groupEnd()
                ->where('users.is_disabled', 'N')
                ->where('p.status', 'AKTIF')
                ->get()
                ->getFirstRow();
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
                    'id_jabatan' => $profile->id_jabatan,
                    'jenis_jabatan' => $profile->jenis_jabatan,
                    'nama_jabatan' => $profile->nama_jabatan,
                    'id_unit_kerja' => $profile->id_unit_kerja,
                    'nama_unit_kerja' => $profile->nama_unit_kerja,
                    'id_desa' => $profile->id_desa,
                    'nama_desa' => $profile->nama_desa,
                    'isLogin'     => TRUE
                ];
                $session->set($sessionSetData);
                $res = [
                        'status' => true,
                        'message' => 'Login Berhasil !, anda akan segera dialihkan, mohon tunggu tunggu ...',
                        'data' => [
                            'redirect' => base_url('/app/dashboard'),
                        ]
                    ];
            } else {
                $res = [
                    'status' => false,
                    'message' => 'Username & Password Salah !',
                    'data' => []
                ];
            }
        } else {
            $res = [
                'status' => false,
                'message' => 'Akun Tidak Ditemukan !',
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
