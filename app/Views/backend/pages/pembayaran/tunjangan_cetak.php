<?php  

use CodeIgniter\I18n\Time;
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    // Helper function to format currency in a single cell
    private function currencyCell($w, $h, $amount, $border=0, $ln=0, $align='', $fill=false, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M') {
        $formattedAmount = number_format($amount, 0, ',', '.');
        $this->Cell($w, $h, '', $border, $ln, $align, $fill, $link, $stretch, $ignore_min_height, $calign, $valign);
        $this->SetX($this->GetX() - $w);
        $this->Cell(10, $h, 'Rp.', 0, 0, 'L', 0, '', 0, false, 'T', 'M');
        $this->Cell($w - 10, $h, $formattedAmount, 0, $ln, 'R', 0, '', 0, false, 'T', 'M');
    }

    public function Content($data,$unor,$req)
    {
        // Add logo
        $logoPath = FCPATH . 'assets/images/app/logo.png'; // Adjust this path to your logo file
        $this->Image($logoPath, 16, 10, 12, 15, 'PNG', '', 'T', false, 100, '', false, false, 0, false, false, false);
        // HEADER
        $this->SetFont("DejaVuSans", "B", 10);
        // Calculate the width of the page excluding margins
        $pageWidth = $this->getPageWidth() - $this->getMargins()['left'] - $this->getMargins()['right'];
        
        // Set X to the right of the logo
        $this->SetX(35);
        
        $this->Cell($pageWidth - 25, 5, 'TANDA TERIMA', 0, 1, 'C', 0, '', 0, false, 'T', 'M');
        $this->SetX(35);
        $this->Cell($pageWidth - 25, 5, $req['jns_pegawai'] == "BPD" ? "TUNJANGAN KEDUDUKAN BPD" : "TUNJANGAN KEPALA DESA & PERANGKAT DAERAH", 0, 1, 'C', 0, '', 0, false, 'T', 'M');
        $this->SetX(35);
        $this->Cell($pageWidth - 25, 5, 'TAHUN '.date("Y"), 0, 1, 'C', 0, '', 0, false, 'T', 'M');
        // INFO
        $infoY = 30;
        $this->SetY($infoY);
        $this->SetFont("DejaVuSans", "B", 8);
        $this->Cell(30, 5, 'DESA', 0, 0, 'L', 0, '', 0, false, 'T', 'M');
        $this->Cell(0, 5, ': '.strtoupper($unor->nama_unit_kerja), 0, 1, 'L', 0, '', 0, false, 'T', 'M');
        $this->Cell(30, 5, 'KECAMATAN', 0, 0, 'L', 0, '', 0, false, 'T', 'M');
        $this->Cell(0, 5, ': '.$unor->nama_kecamatan, 0, 1, 'L', 0, '', 0, false, 'T', 'M');
        $this->Cell(30, 5, 'KABUPATEN', 0, 0, 'L', 0, '', 0, false, 'T', 'M');
        $this->Cell(0, 5, ': BALANGAN', 0, 1, 'L', 0, '', 0, false, 'T', 'M');
        $this->Cell(30, 5, 'BULAN', 0, 0, 'L', 0, '', 0, false, 'T', 'M');
        $this->Cell(0, 5, ': '.strtoupper(bulan($req['bulan'])), 0, 1, 'L', 0, '', 0, false, 'T', 'M');
        // TABLE
        $tableY = 25;
        $this->SetY($infoY+$tableY);
        $this->SetFillColor(230,230,230); // Grey;
        $this->Cell(10, 10, 'NO', 1, 0, 'C', 1, '', 0, false, 'T', 'M');
        $this->Cell(60, 10, 'NAMA', 1, 0, 'C', 1, '', 0, false, 'T', 'M');
        $this->Cell(60, 10, 'JABATAN', 1, 0, 'C', 1, '', 0, false, 'T', 'M');
        $this->Cell(30, 10, 'JUMLAH BULAN', 1, 0, 'C', 1, '', 0, false, 'T', 'M');
        $this->Cell(30, 10, 'SATUAN', 1, 0, 'C', 1, '', 0, false, 'T', 'M');
        $this->Cell(30, 10, 'JUMLAH BRUTO', 1, 0, 'C', 1, '', 0, false, 'T', 'M');
        $this->Cell(30, 10, 'PPh 21', 1, 0, 'C', 1, '', 0, false, 'T', 'M');
        $this->Cell(30, 10, 'JUMLAH BERSIH', 1, 0, 'C', 1, '', 0, false, 'T', 'M');
        $this->Cell(50, 10, 'TANDA TANGAN', 1, 1, 'C', 1, '', 0, false, 'T', 'M');
        // TABLE BODY
        $this->SetFont("DejaVuSans", "N", 8);
        $no = 1;
        $maxline = 1;
        $total_bulan = 0; 
        $total_pph21 = 0;
        $total_bersih = 0;
        foreach ($data as $pegawai) {
            $maxline = $maxline % 14;
            if($maxline == 0) {
                $this->AddPage();
                $tableY = 10;
                $this->SetY($tableY);
                $this->SetFillColor(230,230,230); // Grey;
                $this->Cell(10, 10, 'NO', 1, 0, 'C', 1, '', 0, false, 'T', 'M');
                $this->Cell(60, 10, 'NAMA', 1, 0, 'C', 1, '', 0, false, 'T', 'M');
                $this->Cell(60, 10, 'JABATAN', 1, 0, 'C', 1, '', 0, false, 'T', 'M');
                $this->Cell(30, 10, 'JUMLAH BULAN', 1, 0, 'C', 1, '', 0, false, 'T', 'M');
                $this->Cell(30, 10, 'SATUAN', 1, 0, 'C', 1, '', 0, false, 'T', 'M');
                $this->Cell(30, 10, 'JUMLAH BRUTO', 1, 0, 'C', 1, '', 0, false, 'T', 'M');
                $this->Cell(30, 10, 'PPh 21', 1, 0, 'C', 1, '', 0, false, 'T', 'M');
                $this->Cell(30, 10, 'JUMLAH BERSIH', 1, 0, 'C', 1, '', 0, false, 'T', 'M');
                $this->Cell(50, 10, 'TANDA TANGAN', 1, 1, 'C', 1, '', 0, false, 'T', 'M');
            }
            $this->SetFont("DejaVuSans", "N", 8);
            $this->Cell(10, 10, $no, 1, 0, 'C', 0, '', 0, false, 'T', 'M');
            $this->Cell(60, 10, $pegawai->nama, 1, 0, 'L', 0, '', 0, false, 'T', 'M');
            $this->Cell(60, 10, ucwords(strtolower($pegawai->nama_jabatan)), 1, 0, 'L', 0, '', 0, false, 'T', 'M');
            $this->Cell(30, 10, $pegawai->jumlah_bulan, 1, 0, 'C', 0, '', 0, false, 'T', 'M');
            $this->currencyCell(30, 10, $pegawai->tunjangan, 1);
            $this->currencyCell(30, 10, $pegawai->tunjangan * $pegawai->jumlah_bulan, 1);
            $this->currencyCell(30, 10, $pegawai->pph21, 1);
            $this->currencyCell(30, 10, ($pegawai->tunjangan * $pegawai->jumlah_bulan) - $pegawai->pph21, 1);
            if($no % 2) {
                $this->SetFont("DejaVuSans", "B", 8);
                $this->Cell(50, 10, "$no.", 1, 1, 'L', 0, '', 0, false, 'T', 'M');
            } else {
                $this->SetFont("DejaVuSans", "B", 8);
                $this->Cell(50, 10, "$no.", 1, 1, 'C', 0, '', 0, false, 'T', 'M');
            }
            $no++;
            $tableY++;
            $maxline++;
            $total_bulan += $pegawai->jumlah_bulan; 
            $total_pph21 += $pegawai->pph21;
            $total_bersih += ($pegawai->tunjangan * $pegawai->jumlah_bulan) - $pegawai->pph21;
        }
        // TABLE FOOTER
        $this->SetFont("DejaVuSans", "B", 8);
        $this->Cell(130, 10, "Jumlah", 1, 0, 'C', 0, '', 0, false, 'T', 'M');
        $this->Cell(30, 10, $total_bulan, 1, 0, 'C', 0, '', 0, false, 'T', 'M');
        $this->Cell(30, 10, "", 1, 0, 'C', 0, '', 0, false, 'T', 'M');
        $this->Cell(30, 10, "", 1, 0, 'C', 0, '', 0, false, 'T', 'M');
        $this->currencyCell(30, 10, $total_pph21, 1);
        $this->currencyCell(30, 10, $total_bersih, 1);
        $this->SetFillColor(230,230,230); // Grey;
        $this->Cell(50, 10, "", 1, 1, 'C', true, '', 0, "", 'T', 'M');

        // Store the Y position after the table
        $afterTableY = $this->GetY();

        // TTD Mengetahui
        $mengetahui = db_connect()->table('pegawai p')
        ->select('p.gelar_depan,p.nama,p.gelar_blk,p.nipd,j.nama_jabatan')
        ->join('ref_jabatan j', 'p.fid_jabatan=j.id')
        ->where('p.nik', $req['approve'])
        ->get()
        ->getRow();

        // Calculate remaining space
        $pageHeight = $this->getPageHeight();
        $marginBottom = 10; // Adjust as needed
        $signatureHeight = 50; // Adjust based on your signature box height

        // Check if there's enough space for signatures
        if (($pageHeight - $afterTableY - $marginBottom) < $signatureHeight) {
            $this->AddPage();
            $afterTableY = $this->GetY();
        }

        $this->SetFont("DejaVuSans", "N", 9);
        $ttdY = $afterTableY + 5; // Add some space after the table
        $ttdX = 40;
        $this->SetY($ttdY);
        $this->SetX($ttdX);
        $this->Cell(80, 5, "Mengetahui/Menyetujui", 0, 1, 'C', 0, '', 0, false, 'T', 'M');
        $this->SetX($ttdX);
        $this->Cell(80, 3, ucwords(strtolower($mengetahui->nama_jabatan)), 0, 1, 'C', 0, '', 0, false, 'T', 'M');
        $this->SetY($this->GetY() + 15);
        $this->SetX($ttdX);
        $this->Cell(80, 5, namalengkap($mengetahui->gelar_depan,$mengetahui->nama,$mengetahui->gelar_blk), 0, 1, 'C', 0, '', 0, false, 'T', 'M');
        $this->SetX($ttdX);
        $this->Cell(80, 3, "NIPD. ".$mengetahui->nipd, 0, 1, 'C', 0, '', 0, false, 'T', 'M');

        // BENDAHARA
        $bendahara = db_connect()->table('pegawai p')
        ->select('p.gelar_depan,p.nama,p.gelar_blk,p.nipd,j.nama_jabatan')
        ->join('ref_jabatan j', 'p.fid_jabatan=j.id')
        ->where('p.nik', $req['bendahara'])
        ->get()
        ->getRow();
        $this->SetY($ttdY);
        $this->SetX($ttdX + 200);
        $this->Cell(80, 5, "Balangan, ".date_indo($req['tgl_cetak']), 0, 1, 'C', 0, '', 0, false, 'T', 'M');
        $this->SetX($ttdX + 200);
        $this->Cell(80, 3, ucwords(strtolower($bendahara->nama_jabatan)), 0, 1, 'C', 0, '', 0, false, 'T', 'M');
        $this->SetY($this->GetY() + 15);
        $this->SetX($ttdX + 200);
        $this->Cell(80, 5, namalengkap($bendahara->gelar_depan,$bendahara->nama,$bendahara->gelar_blk), 0, 1, 'C', 0, '', 0, false, 'T', 'M');
        $this->SetX($ttdX + 200);
        $this->Cell(80, 3, "NIPD. ".$bendahara->nipd, 0, 1, 'C', 0, '', 0, false, 'T', 'M');
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
        $this->Cell(130, 10, 'Copyright ::: '.config('SiteConfig')->siteSortName." | Dicetak oleh : ".session()->fullname." / ".date_indo(date("Y-m-d"))." ".substr($now->addHours(1),10), 0, false, 'L', 0, '', 0, false, 'T', 'M');
        $this->setX(-32);
        // $this->SetTextColor(245,245,245);
        $this->Cell(20, 10, 'Halaman '.$this->getAliasNumPage().' / '.$this->getAliasNbPages(), 0, 1, 'L', 0, '', 0, false, 'T', 'M');
    }
}

// create new PDF document
$pdf = new MYPDF("LANDSCAPE", "MM", "LEGAL", true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('M. NOR SEPUTRA');
$pdf->SetTitle($unor->nama_unit_kerja." - Tunjangan - ".bulan($req['bulan'])." ".$tahun);
$pdf->SetSubject($unor->nama_unit_kerja." - Tunjangan");
$pdf->SetKeywords('Tunjangan,'.$unor->nama_unit_kerja);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(0);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 0);
// add a page
$pdf->setPrintHeader(FALSE);
$pdf->AddPage();
$pdf->Content($data,$unor,$req);
// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output($unor->nama_kecamatan." - ".$unor->nama_unit_kerja." - Tunjangan - ".bulan($req['bulan'])." ".$tahun.".pdf", 'I');

//============================================================+
// END OF FILE
//============================================================+
?>