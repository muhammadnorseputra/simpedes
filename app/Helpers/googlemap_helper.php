<?php
function extractAddressFromGoogleMapsURL($url) {
    // Parse URL to get query and path segments
    $parsed_url = parse_url($url);
    
    if (!isset($parsed_url['path'])) {
        return "URL tidak valid.";
    }

    // Mengambil segmen 'place' yang menunjukkan nama tempat
    $path_segments = explode('/', $parsed_url['path']);
    
    // Cek apakah ada segmen 'place'
    $place_index = array_search('place', $path_segments);
    if ($place_index !== false && isset($path_segments[$place_index + 1])) {
        // Mengambil segmen berikutnya sebagai alamat
        $address = urldecode($path_segments[$place_index + 1]);
        return $address;
    }

    return "Alamat tidak ditemukan.";
}
?>
