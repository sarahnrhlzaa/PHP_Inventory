<?php
define('API_BASE_URL', 'http://localhost:8080/api');

function callAPI($method, $endpoint, $data = null) {
    $curl = curl_init();
    $url = API_BASE_URL . $endpoint;

    // Settingan standar
    switch ($method) {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data) curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            if ($data) curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            break;
        case "DELETE":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
            if ($data) curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            break;
        default: // GET
            if ($data) $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Accept: application/json'
    ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    
    // --- BAGIAN DEBUGGING (PENTING) ---
    $result = curl_exec($curl);
    
    // Cek apakah CURL gagal konek
    if ($result === false) {
        $error_msg = curl_error($curl);
        curl_close($curl);
        // Tampilkan error ke layar biar ketahuan
        die("<br><b>CURL Error:</b> " . $error_msg . "<br><b>URL:</b> " . $url);
    }
    
    // Cek apakah Server Balikin Error (Misal 404 atau 500)
    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    if ($http_code >= 400) {
        curl_close($curl);
        die("<br><b>HTTP Error $http_code:</b> Server menolak request ke " . $url . "<br><b>Response:</b> " . $result);
    }
    // ----------------------------------

    curl_close($curl); // Tutup koneksi (aman untuk PHP versi lama maupun baru)
    
    return json_decode($result, true);
}
?>