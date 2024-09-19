<?php  

use CodeIgniter\I18n\Time;

function namalengkap($gelarDepan, $nama, $gelarBelakang) {
    // Cek apakah gelar depan ada atau tidak
    $result = '';
    if (!empty($gelarDepan) && $gelarDepan !== "-") {
        $result .= $gelarDepan . ' ';
    }

    $result .= $nama;
    
    // Cek apakah gelar belakang ada atau tidak
    if (!empty($gelarBelakang) && $gelarBelakang !== "-") {
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

function hitungUsia($tanggalLahir) {
    // Membuat objek DateTime dari tanggal lahir
    $tglLahir = new DateTime($tanggalLahir);
    
    // Membuat objek DateTime untuk tanggal saat ini
    $sekarang = new DateTime();
    
    // Menghitung selisih antara tanggal sekarang dan tanggal lahir
    $selisih = $sekarang->diff($tglLahir);
    
    // Mengembalikan usia dalam tahun
    return $selisih->y;
}


function updateAt($tanggal) {
    // Membuat objek waktu dari tanggal input
    $time = Time::parse($tanggal)->subHours(1);
    
    // Mengembalikan selisih waktu relatif
    return $time->humanize();
}

?>