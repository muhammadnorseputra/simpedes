<?php

namespace App\Controllers;

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
}
