<?php  
namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index(): string
    {
        $config = config('SiteConfig');
        $data = [
            'title' => 'Dashboard - Simpedes Kab. Balangan',
            'content' => 'backend/pages/dashboard',
            'config' => $config
        ];
        return view('backend/layouts/app', $data);
    }
}

?>