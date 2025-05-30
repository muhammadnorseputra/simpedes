<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;
use TCPDF;

class Pdf extends BaseController
{
    public function index($string)
    {   
        helper(["hash","tgl_indo"]);

        $pdf = new TCPDF('P', 'mm', 'LEGAL', true, 'UTF-8', false);

        $uri = current_url(true);
        $NIK = $uri->getSegment(3); // NIK
        $nik = rehash($NIK);
        $pegawai = model('PegawaiModel');
        $profile = $pegawai->getDetailPegawai($nik)->asObject()->first();
        // dd($profile);
        
        if($profile === null) {
            return throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Pegawai tidak ditemukan');
        }

        $data = [
            'row' => $profile,
            'pdf' => $pdf
        ];
        $html = view('backend/pages/cetak/profile', $data);

		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor(config('SiteConfig')->siteSortName);
		$pdf->SetTitle("PROFILE PEGAWAI - {$profile->nama}");
		$pdf->SetSubject("Profile Pegawai {$profile->nama}");

		$pdf->setPrintHeader(FALSE);
		$pdf->setPrintFooter(FALSE);
        $pdf->setMargins(10, 0, 10);
        $pdf->setHeaderMargin(0);
        $pdf->setFooterMargin(0);

		$pdf->addPage();
        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, 0);
		// output the HTML content
		$pdf->writeHTML($html, true, false, true, false, '');
		//line ini penting
		$this->response->setContentType('application/pdf');
		//Close and output PDF document
		$pdf->Output("PROFILE-{$profile->nik}-{$profile->nama}.pdf", 'I');
    }

    public function absensi()
    {
        helper(["number","tgl_indo","time","hash"]);
        $now = new Time('now', 'Asia/Jakarta', 'id_ID');
        $req = $this->request;

        $unor = db_connect()->table('ref_unit_kerja u')
        ->join('ref_kecamatan k', 'u.kecamatan=k.id_kecamatan')
        ->where('u.id_unit_kerja', $req->getPost('unit'))
        ->get()
        ->getRow();

        $rekap = db_connect()->table('riwayat_absensi a')
        ->select('a.id,a.nik,a.bulan,a.tahun,a.hadir,a.izin,a.sakit,a.tk,a.cuti,a.tudin,a.created_at,p.nama,p.gelar_depan,p.gelar_blk,u.nama_unit_kerja')
        ->join('pegawai p', 'a.nik=p.nik')
        ->join('ref_unit_kerja u', 'p.fid_unit_kerja=u.id_unit_kerja')
        ->where('a.bulan', $req->getPost('bulan'))
        ->where('a.tahun', $now->getYear()) // Tahun Ini
        ->where('p.fid_unit_kerja', $req->getPost('unit'))
        ->get();

        $data = [
            'title' => 'Rekap Absensi',
            'req' => $req->getPost(),
            'unor' => $unor,
            'rekap' => $rekap->getResult()
        ];
        //line ini penting
		$this->response->setContentType('application/pdf');
        return view('backend/pages/cetak/absensi', $data);
    }

    public function cetak_tt_tunjangan()
    {
        helper(["number","tgl_indo","time"]);
        $req = $this->request;

        $id_unit_kerja = $req->getPost('unit');
        $bulan = $req->getPost('bulan');
        $jenis_pegawai = $req->getPost('jns_pegawai');

        $unor = db_connect()->table('ref_unit_kerja u')
        ->join('ref_kecamatan k', 'u.kecamatan=k.id_kecamatan')
        ->where('u.id_unit_kerja', $id_unit_kerja)
        ->get()
        ->getRow();

        $pegawai = db_connect()->table('riwayat_tunjangan rt')
        ->join('pegawai p', 'rt.nik=p.nik')
        ->join('ref_jabatan rj', 'p.fid_jabatan=rj.id')
        ->where('p.fid_unit_kerja', $unor->id_unit_kerja)
        ->where('rt.jenis_pegawai', $jenis_pegawai)
        ->where('rt.bulan', $bulan)
        ->get()
        ->getResult();

        $data = [
            'title' => 'Cetak Tanda Terima',
            'req' => $req->getPost(),
            'data' => $pegawai,
            'unor' => $unor,
            'tahun' => date("Y")
        ];
		//line ini penting
		$this->response->setContentType('application/pdf');
        return view('backend/pages/pembayaran/tunjangan_cetak', $data);

    }

    public function cetak_nomperunker()
    {
        helper(["number","tgl_indo","time","hash"]);
        $req = $this->request;

        $unor = db_connect()->table('ref_unit_kerja u')
        ->join('ref_kecamatan k', 'u.kecamatan=k.id_kecamatan')
        ->where('u.id_unit_kerja', rehash($req->getPost('id_unit_kerja')))
        ->get()
        ->getRow();

        $pegawai = db_connect()->table('pegawai p')
        ->select('p.gelar_depan,p.gelar_blk,p.nama,p.jns_kelamin,p.tmp_lahir,p.tgl_lahir,
        u.nama_unit_kerja,j.nama_jabatan,j.gaji,j.tunjangan')
        ->select("(SELECT rtp.nama_tingkat_pendidikan 
                    FROM riwayat_pendidikan as rp 
                    LEFT JOIN ref_tingkat_pendidikan as rtp ON rp.fid_tingkat=rtp.id_tingkat_pendidikan WHERE rp.nik=p.nik 
                    ORDER BY id DESC
                    LIMIT 1) as nama_tingkat_pendidikan", false) 
        ->join('ref_unit_kerja u', 'p.fid_unit_kerja=u.id_unit_kerja')
        ->join('ref_jabatan j', 'p.fid_jabatan=j.id')
        ->where('p.fid_unit_kerja', rehash($req->getPost('id_unit_kerja')))
        ->where('YEAR(p.created_at)', $req->getPost('tahun'))
        ->where('j.jenis', $req->getPost('jenis'))
        ->get()
        ->getResult();

        $data = [
            'title' => 'Nominatif',
            'req' => $req->getPost(),
            'pegawai' => $pegawai,
            'unor' => $unor
        ];
        //line ini penting
		$this->response->setContentType('application/pdf');
        return view('backend/pages/nominatif/nomperunker', $data);
    }

    public function cetak_nomperkec()
    {
        helper(["number","tgl_indo","time","hash"]);
        $request = $this->request;
        if($request->is("post"))
        {
            $tahun = $request->getPost('tahun');
            $kecamatanId = $request->getPost('kecamatan');
            $jns_pegawai = $request->getPost('jenis');

            $kecamatan = db_connect()->table('ref_kecamatan k')
            ->where('k.id_kecamatan', $kecamatanId)
            ->get()
            ->getRow();
            
            $pegawai = db_connect()->table('pegawai p')
            ->select('p.gelar_depan,p.gelar_blk,p.nama,p.jns_kelamin,p.tmp_lahir,p.tgl_lahir,
            u.nama_unit_kerja,j.nama_jabatan,j.gaji,j.tunjangan,d.nama_desa')
            ->select("(SELECT rtp.nama_tingkat_pendidikan 
                        FROM riwayat_pendidikan as rp 
                        LEFT JOIN ref_tingkat_pendidikan as rtp ON rp.fid_tingkat=rtp.id_tingkat_pendidikan WHERE rp.nik=p.nik 
                        ORDER BY id DESC
                        LIMIT 1) as nama_tingkat_pendidikan", false) 
            ->join('ref_unit_kerja u', 'p.fid_unit_kerja=u.id_unit_kerja', 'left')
            ->join('ref_jabatan j', 'p.fid_jabatan=j.id', 'left')
            ->join('ref_desa d', 'p.fid_keldesa=d.id_desa', 'left')
            ->where('u.kecamatan', $kecamatanId)
            ->where('YEAR(p.created_at)', $tahun)
            ->where('j.jenis', $jns_pegawai)
            ->get()
            ->getResult();
            
            $data = [
                'title' => 'Nominatif',
                'req' => $request->getPost(),
                'pegawai' => $pegawai,
                'kecamatan' => $kecamatan
            ];
            //line ini penting
            $this->response->setContentType('application/pdf');
            return view('backend/pages/nominatif/nomperkec', $data);
        }

        $data = [
            'title' => 'Nominatif Per Kecamatan',
        ];
        return view('backend/pages/cetak/nomperkec', $data);
    }
}
