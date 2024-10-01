<?php  
namespace App\Controllers;

class Dashboard extends BaseController
{
    protected $db;

    public function __construct() {
        $this->db = db_connect();
    }

    private function trendsPegawaiByGender($jns_kelamin)
    {
        $db = $this->db->table('pegawai')->where('jns_kelamin', $jns_kelamin)->where('status', 'AKTIF');
        return $db->countAllResults();
    }

    private function trendsPegawaiByUsia()
    {
        $builder = $this->db->table('pegawai');

        // Mengelompokkan pegawai berdasarkan kelompok usia
        $builder->select("CASE
                    WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 18 AND 25 THEN '18-25'
                    WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 26 AND 30 THEN '26-30'
                    WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 31 AND 35 THEN '31-35'
                    WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 36 AND 40 THEN '36-40'
                    WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 41 AND 45 THEN '41-45'
                    WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 46 AND 50 THEN '46-50'
                    WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 51 AND 55 THEN '51-55'
                    WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 56 AND 60 THEN '56-60'
                    END AS kelompok_usia, COUNT(*) AS jumlah")
        ->groupBy('kelompok_usia')
        ->where('status', 'AKTIF')
        ->having('kelompok_usia IS NOT NULL');
        
        $query = $builder->get();
        $data = $query->getResultArray();
        return $data;
    }

    private function trendsPegawaiByTingkatPendidikan()
    {
        // Query to get the latest row for each employee's education, with related education levels
        $builder = $this->db->table('riwayat_pendidikan rp');
        $builder->select('tp.nama_tingkat_pendidikan AS tingkat, COUNT(rp.id) AS jumlah');
        $builder->join('ref_tingkat_pendidikan tp', 'rp.fid_tingkat = tp.id_tingkat_pendidikan');
        $builder->groupBy('rp.nik');
        $builder->orderBy('rp.created_at', 'DESC');

        $query = $builder->get();
        $data = $query->getResultArray();

        // Return data as JSON
        return $data;
    }

    private function trendsPegawaiByAgama()
    {
        $builder = $this->db->table('pegawai');
        $builder->select('ref_agama.nama_agama, COUNT(*) as total');
        $builder->join('ref_agama', 'pegawai.fid_agama = ref_agama.id_agama');
        $builder->where('pegawai.status', 'AKTIF');
        $builder->groupBy('ref_agama.nama_agama');
        $query = $builder->get();
        $data = $query->getResultArray();
        return $data;
    }

    private function trendsPegawaiByStatusKawin()
    {
        $builder = $this->db->table('pegawai p');
        $builder->select('sk.nama_status_kawin, COUNT(*) as total');
        $builder->join('ref_status_kawin sk', 'p.fid_status_kawin = sk.id_status_kawin', 'left');
        $builder->where('p.status', 'AKTIF');
        $builder->groupBy('sk.nama_status_kawin');
        $query = $builder->get();
        $data = $query->getResultArray();
        return $data;
    }

    private function trendsPegawaiByJenis()
    {
        $builder = $this->db->table('pegawai p');
        $builder->select('j.jenis, COUNT(*) as total');
        $builder->join('ref_jabatan j', 'p.fid_jabatan = j.id');
        $builder->where('p.status', 'AKTIF');
        $builder->groupBy('j.jenis');
        $query = $builder->get();
        $data = $query->getResultArray();
        return $data;
    }

    private function trendsTunjanganBulanan()
    {
        helper(["tgl_indo"]);

        $builder = $this->db->table('riwayat_tunjangan');
        $builder->select('bulan');
        $builder->selectSum('jumlah_uang');
        $builder->where('tahun', date("Y"));
        $builder->groupBy('bulan');
        $query = $builder->get();
        $result = $query->getResult();
        $data = [];
        foreach ($result as $query) {
            $data[] = [
                'bulan' => bulan($query->bulan),
                'jumlah_uang' => $query->jumlah_uang
            ];
        }
        return $data;
    }

    private function locationMaps()
    {
        $tbl = $this->db->table('ref_unit_kerja')->select('latitude,longitude,nama_unit_kerja')->get();
        return $tbl->getResultArray();
    }

    public function index(): string
    {
        helper(['number']);
        
        $total_pegawai_bpd_aktif = $this->db->table('pegawai p')
        ->join('ref_jabatan j', 'p.fid_jabatan=j.id')
        ->where('p.status', 'AKTIF')
        ->where('j.jenis', 'BPD');

        $total_pegawai_pemdes_aktif = $this->db->table('pegawai p')
        ->join('ref_jabatan j', 'p.fid_jabatan=j.id')
        ->where('p.status', 'AKTIF')
        ->where('j.jenis', 'PEMDES');

        $total_pegawai_non_aktif = $this->db->table('pegawai p')
        ->join('ref_jabatan j', 'p.fid_jabatan=j.id')
        ->where('p.status !=', 'AKTIF');

        $total_pengeluaran_tunjangan_tahunan = $this->db->table('riwayat_tunjangan')
        ->selectSum('jumlah_uang')
        ->where('tahun', date('Y'))
        ->get()
        ->getRow()->jumlah_uang;

        $total_unit_kerja_aktif = $this->db->table('ref_unit_kerja')->where('aktif', 'Y');
        $total_desa = $this->db->table('ref_desa');
        $total_userportal = $this->db->table('users');

        $config = config('SiteConfig');
        $data = [
            'title' => 'Dashboard',
            'config' => $config,
            'total_pegawai_bpd_aktif' => $total_pegawai_bpd_aktif->countAllResults(),
            'total_pegawai_pemdes_aktif' => $total_pegawai_pemdes_aktif->countAllResults(),
            'total_pegawai_non_aktif' => $total_pegawai_non_aktif->countAllResults(),
            'total_unit_kerja_aktif' => $total_unit_kerja_aktif->countAllResults(),
            'total_desa' => $total_desa->countAll(),
            'total_userportal' => $total_userportal->countAll(),
            'total_pengeluaran_tunjangan_tahunan' => $total_pengeluaran_tunjangan_tahunan,
            'charts' => [
                'gender_pria' => $this->trendsPegawaiByGender('PRIA'),
                'gender_wanita' => $this->trendsPegawaiByGender('WANITA'),
                'usia' => $this->trendsPegawaiByUsia(),
                'tingkat_pendidikan' => $this->trendsPegawaiByTingkatPendidikan(),
                'agama' => $this->trendsPegawaiByAgama(),
                'status_kawin' => $this->trendsPegawaiByStatusKawin(),
                'lokasi' => $this->locationMaps(),
                'jenis_pegawai' => $this->trendsPegawaiByJenis(),
                'tunjangan' => $this->trendsTunjanganBulanan()
            ]
        ];
        return view('backend/pages/dashboard', $data);
    }
}

?>