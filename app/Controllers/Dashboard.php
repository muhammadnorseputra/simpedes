<?php  
namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index(): string
    {
        $config = config('SiteConfig');
        $data = [
            'title' => 'Dashboard - Simpedes Kab. Balangan',
            'config' => $config
        ];
        return view('backend/pages/dashboard', $data);
    }
}

?>