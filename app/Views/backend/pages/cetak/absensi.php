<?php  
use CodeIgniter\I18n\Time;
class MYPDF extends TCPDF {
    public function Header(){
        $this->SetFont("DejaVuSans", "N", 8);
        $this->cell(0,5,"Rekap Absensi Per Unit Kerja",0,0,'L',0); 
        $this->cell(0,5,"Dicetak oleh ".(session()->get('fullname') ? session()->get('fullname') : session()->get('username'))." (NIK. ".session()->nik.") pada ".date_indo(date("Y-m-d"))."",0,0,'R',0); 
        //buat garis horizontal
        $this->Line(PDF_MARGIN_LEFT,$this->GetY()+5,$this->getPageWidth()-PDF_MARGIN_LEFT,$this->GetY()+ 5);  
    }

    public function Content($req,$unor,$rekap)
    {
        $logoPath = FCPATH . 'assets/images/app/logo.png'; // Adjust this path to your logo file
        $this->Image($logoPath, PDF_MARGIN_LEFT, 15, 10, 12, 'PNG', '', 'T', false, 100, '', false, false, 0, false, false, false);
        // Header
        $this->setY(15);
        $this->SetFont("DejaVuSans", "B", 10);
        $this->setX(PDF_MARGIN_LEFT + 12);
        $this->Cell(0, 5, 'REKAP ABSENSI '.strtoupper(bulan($req['bulan'])).' '.date("Y"), 0, 1, 'L', 0, '', 0, false, 'T', 'M');
        $this->setX(PDF_MARGIN_LEFT + 12);
        $this->Cell(100, 5, strtoupper(substr_replace($unor->nama_unit_kerja,".",4,0)), 0, 0, 'L', 0, '', 0, false, 'T', 'M');
        // Table
        $this->setY($this->getY()+10);
        $this->SetFont("DejaVuSans", "B", 8);
        $this->SetLineStyle(array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0,0,0)));
        $this->Cell(10, 13, 'NO', 1, 0, 'C', 0, '', 0, false, 'T', 'M');
        $this->Cell(40, 13, 'NIK', 1, 0, 'C', 0, '', 0, false, 'T', 'M');
        $this->Cell(60, 13, 'NAMA LENGKAP', 1, 0, 'C', 0, '', 0, false, 'T', 'M');
        $this->SetFillColor(144, 238, 144); // Grey;
        $this->Cell(0, 8, 'DATA ABSENSI', 1, 1, 'C', 1, '', 0, false, 'T', 'M');
        $this->setX(125);
        $this->Cell(30, 5, 'HADIR', 1, 0, 'C', 0, '', 0, false, 'T', 'M');
        $this->Cell(30, 5, 'IZIN', 1, 0, 'C', 0, '', 0, false, 'T', 'M');
        $this->Cell(30, 5, 'SAKIT', 1, 0, 'C', 0, '', 0, false, 'T', 'M');
        $this->Cell(50, 5, 'TANPA KETERANGAN', 1, 0, 'C', 0, '', 0, false, 'T', 'M');
        $this->Cell(30, 5, 'CUTI', 1, 0, 'C', 0, '', 0, false, 'T', 'M');
        $this->Cell(0, 5, 'TUGAS DINAS', 1, 1, 'C', 0, '', 0, false, 'T', 'M');
        // TABLE BODY
        $this->SetFont("DejaVuSans", "N", 8);
        $no = 1;
        $maxline = 1;
        if(count($rekap) === 0) {
            $this->SetFillColor(255, 255, 255); // Grey;
            return $this->Cell(0, 10, 'DATA TIDAK DITEMUKAN', 1, 0, 'C', 1, '', 0, false, 'T', 'M');
        }

        foreach ($rekap as $row) {
            $maxline = $maxline % 16;
            if($maxline == 0) {
                $this->AddPage();
                $logoPath = FCPATH . 'assets/images/app/logo.png'; // Adjust this path to your logo file
                $this->Image($logoPath, PDF_MARGIN_LEFT, 15, 10, 12, 'PNG', '', 'T', false, 100, '', false, false, 0, false, false, false);
                // Header
                $this->setY(15);
                $this->SetFont("DejaVuSans", "B", 10);
                $this->setX(PDF_MARGIN_LEFT + 12);
                $this->Cell(0, 5, 'REKAP ABSENSI '.strtoupper(bulan($req['bulan'])).' '.date("Y"), 0, 1, 'L', 0, '', 0, false, 'T', 'M');
                $this->setX(PDF_MARGIN_LEFT + 12);
                $this->Cell(100, 5, strtoupper(substr_replace($unor->nama_unit_kerja,".",4,0)), 0, 0, 'L', 0, '', 0, false, 'T', 'M');
                // Table
                $this->setY($this->getY()+10);
                $this->SetFont("DejaVuSans", "B", 8);
                $this->SetLineStyle(array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0,0,0)));
                $this->Cell(10, 13, 'NO', 1, 0, 'C', 0, '', 0, false, 'T', 'M');
                $this->Cell(40, 13, 'NIK', 1, 0, 'C', 0, '', 0, false, 'T', 'M');
                $this->Cell(60, 13, 'NAMA LENGKAP', 1, 0, 'C', 0, '', 0, false, 'T', 'M');
                $this->SetFillColor(144, 238, 144); // Grey;
                $this->Cell(0, 8, 'DATA ABSENSI', 1, 1, 'C', 1, '', 0, false, 'T', 'M');
                $this->setX(125);
                $this->Cell(30, 5, 'HADIR', 1, 0, 'C', 0, '', 0, false, 'T', 'M');
                $this->Cell(30, 5, 'IZIN', 1, 0, 'C', 0, '', 0, false, 'T', 'M');
                $this->Cell(30, 5, 'SAKIT', 1, 0, 'C', 0, '', 0, false, 'T', 'M');
                $this->Cell(50, 5, 'TANPA KETERANGAN', 1, 0, 'C', 0, '', 0, false, 'T', 'M');
                $this->Cell(30, 5, 'CUTI', 1, 0, 'C', 0, '', 0, false, 'T', 'M');
                $this->Cell(0, 5, 'TUGAS DINAS', 1, 1, 'C', 0, '', 0, false, 'T', 'M');
            }

            $this->SetFont("DejaVuSans", "N", 8);
            $this->SetFillColor(255, 255, 255); // Grey;
            $this->MultiCell(10, 10, "$no.", 1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
            $this->MultiCell(40, 10, $row->nik, 1, 'L', 1, 0, '', '', true, 0, false, true, 10, 'M');
            $this->MultiCell(60, 10, namalengkap($row->gelar_depan,$row->nama,$row->gelar_blk), 1, 'L', 1, 0, '', '', true, 0, false, true, 10, 'M');
            $this->MultiCell(30, 10, $row->hadir, 1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
            $this->MultiCell(30, 10, $row->izin, 1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
            $this->MultiCell(30, 10, $row->sakit, 1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
            $this->MultiCell(50, 10, $row->tk, 1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
            $this->MultiCell(30, 10, $row->cuti, 1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
            $this->MultiCell(0, 10, $row->tudin, 1, 'C', 1, 1, '', '', true, 0, false, true, 10, 'M');
            $no++;
            $maxline++;
        }
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        $this->Line(PDF_MARGIN_LEFT, $this->getY(), $this->getPageWidth()-PDF_MARGIN_LEFT, $this->getY());
        // Set font
        $this->SetFont('helvetica', 'N', 8);
        // Page number
        $now = new Time('now', 'Asia/Jakarta', 'id_ID');
        $this->Cell(130, 10, 'Copyright ::: '.config('SiteConfig')->siteSortName.' | Waktu Server'.(substr($now->addHours(1),10)), 0, false, 'L', 0, '', 0, false, 'T', 'M');
        $this->setX(-32);
        // $this->SetTextColor(245,245,245);
        $this->Cell(20, 10, 'Halaman '.$this->getAliasNumPage().' / '.$this->getAliasNbPages(), 0, 1, 'L', 0, '', 0, false, 'T', 'M');
    }
}
// create new PDF document
$pdf = new MYPDF("LANDSCAPE", "MM", "LEGAL", true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor(config('SiteConfig')->siteSortName);
$pdf->SetTitle("Rekap Absensi ".bulan($req['bulan'])." ".date("Y")." - ".$unor->nama_unit_kerja);
$pdf->SetSubject("Rekap Absensi ".bulan($req['bulan'])." ".date("Y")." - ".$unor->nama_unit_kerja);
$pdf->SetKeywords("Rekap Absensi ".bulan($req['bulan'])." ".date("Y")." - ".$unor->nama_unit_kerja);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(0);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 0);
// add a page
$pdf->setPrintHeader(TRUE);
$pdf->setPrintFooter(TRUE);
$pdf->AddPage();
$pdf->Content($req,$unor,$rekap);
// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output("Rekap Absensi ".bulan($req['bulan'])." - ".$unor->nama_unit_kerja.".pdf", 'I');
?>