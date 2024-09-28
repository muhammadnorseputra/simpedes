<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use TCPDF;

class Pdf extends BaseController
{
    public function index($string)
    {   
        helper(["hash","pegawai","tgl_indo"]);

        $pdf = new TCPDF('P', 'mm', 'LEGAL', true, 'UTF-8', false);

        $uri = current_url(true);
        $NIK = $uri->getSegment(3); // NIK
        $nik = rehash($NIK);
        $pegawai = model('PegawaiModel');
        $profile = $pegawai->getDetailPegawai($nik)->getRow();
        // dd($profile);
        
        if($profile === null) {
            return throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'row' => $profile,
            'pdf' => $pdf
        ];
        $html = view('backend/pages/cetak/profile', $data);

		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('M. NOR SEPUTRA');
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
}
