<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\CodeIgniter;

class SiteConfig extends BaseConfig
{
    // Site Info
    public $siteSortName = "SIMPEGDES";
    public $siteName = "Sistem Informasi Manajemen Pegawai Desa";
    public $siteDesc = "Selamat Datang pada Portal Informasi Pegawai Desa Kabupaten Balangan <br/> Layanan terpadu yang dikelola oleh Dinas Pemberdayaan Masyarakat dan Desa.";
    // App Info
    public $siteVersion = CodeIgniter::CI_VERSION;
}
