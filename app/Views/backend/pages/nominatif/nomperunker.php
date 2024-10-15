<?php  
class MYPDF extends TCPDF {
    public function Header(){
        $this->SetFont("DejaVuSans", "N", 8);
        $this->cell(0,5,"Daftar Nominatif Pegawai per Unit Kerja ",0,0,'L',0); 
        $this->cell(0,5,"Dicetak oleh ".session()->fullname." (NIK. ".session()->nik.") pada ".date_indo(date("Y-m-d"))."",0,0,'R',0); 
        //buat garis horizontal
        $this->Line(PDF_MARGIN_LEFT,$this->GetY()+5,$this->getPageWidth()-PDF_MARGIN_LEFT,$this->GetY()+ 5);  
    }

    public function Content($req,$pegawai,$unor)
    {

        $logoPath = FCPATH . 'assets/images/app/logo.png'; // Adjust this path to your logo file
        $this->Image($logoPath, PDF_MARGIN_LEFT, 15, 10, 12, 'PNG', '', 'T', false, 100, '', false, false, 0, false, false, false);
        // Header
        $this->setY(15);
        $this->SetFont("DejaVuSans", "B", 10);
        $this->setX(PDF_MARGIN_LEFT + 12);
        $this->Cell(0, 5, 'DAFTAR NOMINATIF PEGAWAI', 0, 1, 'L', 0, '', 0, false, 'T', 'M');
        $this->setX(PDF_MARGIN_LEFT + 12);
        $this->Cell(100, 5, strtoupper($unor->nama_unit_kerja), 0, 0, 'L', 0, '', 0, false, 'T', 'M');
        $this->setY(14);
        $this->SetFont("DejaVuSans", "B", 12);
        $this->Cell(0, 5, $req['jenis'], 0, 1, 'R', 0, '', 0, false, 'T', 'M');
        $this->Cell(0, 5, $req['tahun'], 0, 0, 'R', 0, '', 0, false, 'T', 'M');
        // Table
        $this->setY($this->getY()+10);
        $this->SetFont("DejaVuSans", "B", 8);
        $this->SetFillColor(144, 238, 144); // Grey;
        $this->SetLineStyle(array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0,0,0)));
        $this->Cell(10, 10, 'NO', 1, 0, 'C', 1, '', 0, false, 'T', 'M');
        $this->Cell(80, 10, 'NAMA LENGKAP', 1, 0, 'C', 1, '', 0, false, 'T', 'M');
        $this->Cell(30, 10, "JNS KELAMIN", 1, 0, 'C', 1, '', 0, false, 'T', 'M');
        $this->Cell(90, 10, 'JABATAN', 1, 0, 'C', 1, '', 0, false, 'T', 'M');
        // $this->Cell(30, 10, 'GAJI', 1, 0, 'C', 1, '', 0, false, 'T', 'M');
        // $this->Cell(30, 10, 'TUNJANGAN', 1, 0, 'C', 1, '', 0, false, 'T', 'M');
        $this->Cell(30, 10, 'PENDIDIKAN', 1, 0, 'C', 1, '', 0, false, 'T', 'M');
        $this->Cell(30, 10, 'USIA', 1, 0, 'C', 1, '', 0, false, 'T', 'M');
        $this->Cell(0, 10, 'TTL', 1, 1, 'C', 1, '', 0, false, 'T', 'M');
        // TABLE BODY
        $this->SetFont("DejaVuSans", "N", 8);
        $no = 1;
        $maxline = 1;
        if(count($pegawai) === 0) {
            $this->SetFillColor(255, 255, 255); // Grey;
            return $this->Cell(0, 10, 'DATA TIDAK DITEMUKAN', 1, 0, 'C', 1, '', 0, false, 'T', 'M');
        }
        foreach ($pegawai as $row) {
            $maxline = $maxline % 17;
            if($maxline == 0) {
                $this->AddPage();
                // Header
                $logoPath = FCPATH . 'assets/images/app/logo.png'; // Adjust this path to your logo file
                $this->Image($logoPath, PDF_MARGIN_LEFT, 15, 10, 12, 'PNG', '', 'T', false, 100, '', false, false, 0, false, false, false);
                // Header
                $this->setY(15);
                $this->SetFont("DejaVuSans", "B", 10);
                $this->setX(PDF_MARGIN_LEFT + 12);
                $this->Cell(0, 5, 'DAFTAR NOMINATIF PEGAWAI', 0, 1, 'L', 0, '', 0, false, 'T', 'M');
                $this->setX(PDF_MARGIN_LEFT + 12);
                $this->Cell(100, 5, strtoupper($unor->nama_unit_kerja), 0, 0, 'L', 0, '', 0, false, 'T', 'M');
                $this->setY(14);
                $this->SetFont("DejaVuSans", "B", 12);
                $this->Cell(0, 5, $req['jenis'], 0, 1, 'R', 0, '', 0, false, 'T', 'M');
                $this->Cell(0, 5, $req['tahun'], 0, 0, 'R', 0, '', 0, false, 'T', 'M');
                // Table
                $this->setY($this->getY()+10);
                $this->SetFont("DejaVuSans", "B", 8);
                $this->SetFillColor(144, 238, 144); // Grey;
                $this->SetLineStyle(array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0,0,0)));
                $this->Cell(10, 10, 'NO', 1, 0, 'C', 1, '', 0, false, 'T', 'M');
                $this->Cell(80, 10, 'NAMA LENGKAP', 1, 0, 'C', 1, '', 0, false, 'T', 'M');
                $this->Cell(30, 10, "JNS KELAMIN", 1, 0, 'C', 1, '', 0, false, 'T', 'M');
                $this->Cell(90, 10, 'JABATAN', 1, 0, 'C', 1, '', 0, false, 'T', 'M');
                // $this->Cell(30, 10, 'GAJI', 1, 0, 'C', 1, '', 0, false, 'T', 'M');
                // $this->Cell(30, 10, 'TUNJANGAN', 1, 0, 'C', 1, '', 0, false, 'T', 'M');
                $this->Cell(30, 10, 'PENDIDIKAN', 1, 0, 'C', 1, '', 0, false, 'T', 'M');
                $this->Cell(30, 10, 'USIA', 1, 0, 'C', 1, '', 0, false, 'T', 'M');
                $this->Cell(0, 10, 'TTL', 1, 1, 'C', 1, '', 0, false, 'T', 'M');
            }

            $this->SetFont("DejaVuSans", "N", 8);
            $this->SetFillColor(255, 255, 255); // Grey;
            // $this->Cell(10, 10, "$no.", 1, 0, 'C', 1, '', 0, false, 'T', 'M');
            // $this->Cell(80, 10, namalengkap($row->gelar_depan,$row->nama,$row->gelar_blk), 1, 0, 'L', 1, '', 0, false, 'T', 'M');
            // $this->Cell(30, 10, $row->jns_kelamin, 1, 0, 'C', 1, '', 0, false, 'T', 'M');
            // $this->Cell(90, 10, $row->nama_jabatan, 1, 0, 'L', 1, '', 0, false, 'T', 'M');
            // // $this->Cell(30, 10, isNull(number_to_currency($row->gaji, "IDR", "id_ID")), 1, 0, 'R', 1, '', 0, false, 'T', 'M');
            // // $this->Cell(30, 10, isNull(number_to_currency($row->tunjangan, "IDR", "id_ID")), 1, 0, 'R', 1, '', 0, false, 'T', 'M');
            // $this->Cell(30, 10, $row->nama_tingkat_pendidikan, 1, 0, 'C', 1, '', 0, false, 'T', 'M');
            // $this->Cell(30, 10, hitungUsia($row->tgl_lahir), 1, 0, 'C', 1, '', 0, false, 'T', 'M');
            // $this->Cell(0, 10, $row->tmp_lahir.", ".date_indo($row->tgl_lahir), 1, 1, 'L', 1, '', 0, false, 'T', 'M');
            $this->MultiCell(10, 10, "$no.", 1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
            $this->MultiCell(80, 10, namalengkap($row->gelar_depan,$row->nama,$row->gelar_blk), 1, 'L', 1, 0, '', '', true, 0, false, true, 10, 'M');
            $this->MultiCell(30, 10, $row->jns_kelamin, 1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
            $this->MultiCell(90, 10, $row->nama_jabatan, 1, 'L', 1, 0, '', '', true, 0, false, true, 10, 'M');
            $this->MultiCell(30, 10, $row->nama_tingkat_pendidikan, 1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
            $this->MultiCell(30, 10, hitungUsia($row->tgl_lahir), 1, 'J', 1, 0, '', '', true, 0, false, true, 10, 'M');
            $this->MultiCell(0, 10, $row->tmp_lahir.", ".date_indo($row->tgl_lahir), 1, 'L', 1, 1, '', '', true, 0, false, true, 10, 'M');
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
        $this->Cell(130, 10, 'Copyright ::: '.config('SiteConfig')->siteSortName, 0, false, 'L', 0, '', 0, false, 'T', 'M');
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
$pdf->SetTitle("Nominatif Pegawai - ".$unor->nama_unit_kerja." ".$req['tahun']);
$pdf->SetSubject("Nominatif Pegawai - ".$unor->nama_unit_kerja." ".$req['tahun']);
$pdf->SetKeywords("Nominatif Pegawai - ".$unor->nama_unit_kerja." ".$req['tahun']);

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
$pdf->Content($req,$pegawai,$unor);
// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output("Nominatif Pegawai - ".$unor->nama_unit_kerja." ".$req['tahun'].".pdf", 'I');
?>