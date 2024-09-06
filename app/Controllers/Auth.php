<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;

class Auth extends BaseController
{
    use ResponseTrait;

    public function index(): string
    {
        $config = config('SiteConfig');
        $data = [
            'config' => $config
        ];
        return view('backend/auth', $data);
    }

    public function action() {
        $session = session();
        $db = new \App\Models\UserModel();

        if($this->request->isAjax()) {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
        }

        $data = $db->where('username', $username)->first();
        if ($data) {
            $passwordHash = $data['password'];
            $verify_pass = password_verify($password, $passwordHash);
            if($verify_pass){
                $sessionSetData = [
                    'id'       => $data['id'],
                    'name'     => $data['nama_lengkap'],
                    'email'    => $data['email'],
                    'username'    => $data['username'],
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
