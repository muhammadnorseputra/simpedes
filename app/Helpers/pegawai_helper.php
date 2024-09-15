<?php  
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
?>