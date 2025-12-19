<?php
// config/config.php

define('API_BASE_URL', 'http://localhost:8080/api');

// Helper function untuk call API
function callAPI($method, $endpoint, $data = null) {
    $url = API_BASE_URL . $endpoint;
    
    $curl = curl_init();
    
    switch ($method) {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            break;
        case "DELETE":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }
    
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
    ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    
    $result = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    
    if (curl_errno($curl)) {
        $error = curl_error($curl);
        curl_close($curl);
        return [
            'status' => 0,
            'data' => ['message' => 'Connection error: ' . $error]
        ];
    }
    
    curl_close($curl);
    
    return [
        'status' => $httpCode,
        'data' => json_decode($result, true)
    ];
}

// Helper untuk extract data dari ApiResponse wrapper
function extractData($response) {
    if ($response['status'] == 200 || $response['status'] == 201) {
        // Kalau pakai ApiResponse wrapper
        if (isset($response['data']['data'])) {
            return $response['data']['data'];
        }
        return $response['data'];
    }
    return null;
}
?>