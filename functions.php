<?php

// Function to get IP location using ipstack
function getIpLocation($ip, $apiKey) {
    // Initialize cURL session
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, "http://api.ipstack.com/{$ip}?access_key={$apiKey}");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // Execute cURL session and get the response
    $response = curl_exec($ch);

    // Close cURL session
    curl_close($ch);

    // Decode the JSON response
    $data = json_decode($response, true);

    // Get city from the response
    $city = isset($data['city']) ? $data['city'] : 'Unknown';

    return $city;
}
?>
