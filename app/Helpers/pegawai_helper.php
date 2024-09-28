<?php  

use CodeIgniter\I18n\Time;

function namalengkap($gelarDepan, $nama, $gelarBelakang) {
    // Cek apakah gelar depan ada atau tidak
    $result = '';
    if (!empty($gelarDepan) && $gelarDepan !== "-" && $gelarDepan !== null) {
        $result .= $gelarDepan . ' ';
    }

    $result .= $nama;
    
    // Cek apakah gelar belakang ada atau tidak
    if (!empty($gelarBelakang) && $gelarBelakang !== "-" && $gelarDepan !== null) {
        $result .= ', ' . $gelarBelakang;
    }
    
    return $result;
}

function statusdata($data, $variant = "bg") {
    if($variant === 'bg') {
        if($data === 'ENTRI' || $data === 'ENTRI_ULANG') {
            return 'bg-secondary';
        }
        if($data === 'VERIFIKASI') { 
            return 'bg-primary';
        };
        if($data === 'AKTIF') { 
            return 'bg-success'; 
        };
        if($data === 'NON_AKTIF' || $data === 'NON_AKTIF_NIK_DITOLAK') { 
            return 'bg-danger'; 
        };
    }
}

function hitungUsia($tanggal_lahir) {
    // Ubah string tanggal lahir menjadi objek DateTime
    $tanggal_lahir = new DateTime($tanggal_lahir);
    // Ambil tanggal saat ini
    $tanggal_sekarang = new DateTime();
    
    // Hitung selisih antara tanggal lahir dan tanggal saat ini
    $selisih = $tanggal_sekarang->diff($tanggal_lahir);

    // Format hasil menjadi "XX Tahun YY Bulan"
    return $selisih->y . ' Tahun, ' . $selisih->m . ' Bulan';
}

function lamaWorkshop($jam="",$hari="",$bulan="")
{
    if($jam !== null){
        return $jam;
    }
    if($hari !== null){
        return $hari;
    }
    if($bulan !== null){
        return $bulan;
    }
    return "-";
}

function satuanWorkshop($jam="",$hari="",$bulan="") {
    if($jam !== null){
        return "Jam";
    }
    if($hari !== null){
        return "Hari";
    }
    if($bulan !== null){
        return "Bulan";
    }
    return "-";
}

function updateAt($tanggal) {
    // Membuat objek waktu dari tanggal input
    $time = Time::parse($tanggal)->subHours(1);
    
    // Mengembalikan selisih waktu relatif
    return $time->humanize();
}

function isNull($value) {
    if($value === null || $value === '') return "-";
    return $value;
}

function ucword($text) {
    return ucwords(strtolower($text));
}

?>